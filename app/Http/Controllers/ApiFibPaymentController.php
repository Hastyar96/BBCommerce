<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Transaction;
use App\Models\Payment;

class ApiFibPaymentController extends Controller
{
    // Get fresh access token
    public function getAccessToken()
    {
        $response = Http::asForm()->post(env('FIB_TOKEN_URL'), [
            'grant_type' => 'client_credentials',
            'client_id' => env('FIB_CLIENT_ID'),
            'client_secret' => env('FIB_CLIENT_SECRET'),
        ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new Exception('Error getting access token: ' . $response->body());
    }

    // Create Payment
    public function createPayment(Request $request)
    {
        // Validate request
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'transaction_id' => 'required|exists:transactions,id',
        ]);

        // Retrieve transaction with currency relationship
        $transaction = Transaction::findOrFail($request->transaction_id);

        // Verify transaction type (assuming 1 is pending)
        if ($transaction->transaction_type_id !== 1) {
            return response()->json(['error' => 'Invalid transaction type for payment processing'], 400);
        }

        try {
            // Get access token
            $token = $this->getAccessToken();

            // Prepare payment data for FIB API
            $paymentData = [
                'monetaryValue' => [
                    'amount' => (float) $request->amount,
                    'currency' => 'IQD',
                ],
                'statusCallbackUrl' => config('app.url') . '/api/payment-updates',
                'redirectUri' => "myapp://payment-redirect?transactionId={$transaction->id}",
                'description' => $request->description ?? 'Payment for transaction #' . $transaction->transaction_number,
                'expiresIn' => 'PT15M',
            ];

            // Make API call
            $response = Http::withToken($token)
                ->post('https://fib.stage.fib.iq/protected/v1/payments', $paymentData);

            if ($response->successful()) {
                $data = $response->json();

                // Save payment to payments table
                Payment::create([
                    'transaction_id' => $transaction->id,
                    'payment_method_id' => 2,
                    'amount' => $request->amount,
                    'status' => 'pending',
                    'paid_at' => null,
                    'reference' => $data['paymentId'],
                    'note' => $request->description ?? 'Payment via FIB',
                ]);

                // Return response matching the API structure
                return response()->json([
                    'message' => 'Payment created successfully',
                    'paymentId' => $data['paymentId'],
                    'readableCode' => $data['readableCode'] ?? null,
                    'qrCode' => $data['qrCode'] ?? null,
                    'validUntil' => $data['validUntil'] ?? null,
                    'personalAppLink' => $data['personalAppLink'] ?? null,
                    'businessAppLink' => $data['businessAppLink'] ?? null,
                    'corporateAppLink' => $data['corporateAppLink'] ?? null,
                    'redirectUrl' => $paymentData['redirectUri'],
                ]);
            }

            // Log API error
            Log::error('FIB API Error', [
                'status' => $response->status(),
                'request' => $paymentData,
                'response' => $response->json()['error'] ?? $response->body(),
            ]);

            return response()->json([
                'error' => 'Failed to create payment',
                'details' => $response->json()['error'] ?? $response->body(),
            ], $response->status());
        } catch (Exception $e) {
            // Log exception
            Log::error('FIB Payment Creation Error', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'error' => 'Failed to create payment',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    // Webhook: Handle payment status update from FIB
    public function handlePaymentUpdate(Request $request)
    {
        $data = $request->all();
        Log::info('FIB Payment Callback Received:', $data);

        // FIB لە callback 'id' دەنێرێت نەک 'paymentId'
        $paymentId = $data['id'] ?? null;
        $status = $data['status'] ?? null;

        if (!$paymentId || !$status) {
            Log::warning('Invalid callback data:', $data);
            return response()->json(['error' => 'Invalid callback data'], 406);
        }

        $payment = Payment::where('reference', $paymentId)->first();

        if (!$payment) {
            Log::warning('Payment not found:', ['paymentId' => $paymentId]);
            return response()->json(['error' => 'Payment not found'], 406);
        }

        // نوێکردنەوەی دۆخی پارەدان
        $payment->update(['status' => strtolower($status)]);

        if ($status === 'PAID') {
            $payment->update(['paid_at' => now()]);
            $payment->transaction->update(['transaction_type_id' => 2]);
        } elseif (in_array($status, ['DECLINED', 'REFUNDED', 'FAILED', 'EXPIRED'])) {
            $payment->update(['paid_at' => null]);
            $payment->transaction->update(['transaction_type_id' => 1]);
        }

        Log::info('Payment status updated:', [
            'paymentId' => $paymentId,
            'status' => $status,
            'transaction_id' => $payment->transaction_id
        ]);

        return response()->json(['message' => 'Payment update processed'], 202);
    }

    // Check Payment Status (polling)
    public function checkPaymentStatus(Request $request, $paymentId)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->get("https://fib.stage.fib.iq/protected/v1/payments/{$paymentId}");

            if ($response->successful()) {
                $data = $response->json();

                $payment = Payment::where('reference', $paymentId)->first();
                if ($payment) {
                    if (($data['status'] ?? null) === 'PAID') {
                        $payment->update(['paid_at' => now()]);
                        $payment->update(['status'=> 'paid']);
                        $payment->transaction->update(['transaction_type_id' => 2]);
                    }
                }

                return response()->json($data);
            }

            return response()->json([
                'error' => 'Failed to check payment status: ' . $response->body()
            ], $response->status());

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Exception: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Cancel Payment
    public function cancelPayment(Request $request, $paymentId)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->post("https://fib.stage.fib.iq/protected/v1/payments/{$paymentId}/cancel");

            if ($response->successful()) {
                $payment = Payment::where('reference', $paymentId)->first();
                if ($payment) {
                    $payment->update(['paid_at' => null]);
                  $payment->update(['status'=> 'cancel']);
                    $payment->transaction->update(['transaction_type_id' => 7]); // canceled
                }

                return response()->json([
                    'message' => 'Payment canceled successfully',
                    'data' => $response->json()
                ]);
            }

            return response()->json([
                'error' => 'Failed to cancel payment: ' . $response->body()
            ], $response->status());

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Exception: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Refund Payment
    public function refundPayment(Request $request, $paymentId)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->post("https://fib.stage.fib.iq/protected/v1/payments/{$paymentId}/refund");

            if ($response->successful()) {
                $payment = Payment::where('reference', $paymentId)->first();
                if ($payment) {
                    $payment->update(['paid_at' => null]);
                    $payment->update(['status'=> 'refund']);
                    $payment->transaction->update(['transaction_type_id' => 8]); // refunded
                }

                return response()->json([
                    'message' => 'Payment refunded successfully',
                    'data' => $response->json()
                ]);
            }

            return response()->json([
                'error' => 'Failed to refund payment: ' . $response->body()
            ], $response->status());

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Exception: ' . $e->getMessage(),
            ], 500);
        }
    }
}
