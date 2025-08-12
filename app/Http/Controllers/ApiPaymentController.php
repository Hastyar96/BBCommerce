<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ApiPaymentController extends Controller
{
    // Get fresh access token (no caching due to 60s expiry)
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
        $request->validate([
            'amount' => 'required|integer|min:1',
            'currency' => 'required|string|in:IQD',  // Extend currencies if supported
            'description' => 'nullable|string|max:255',
            'transaction_id' => 'required|exists:transactions,id'
        ]);

        $transaction = \App\Models\Transaction::find($request->transaction_id);

        if ($transaction->transaction_type_id != 1) {
            return response()->json([
                'error' => 'Invalid transaction type',
            ], 400);
        }

        $token = $this->getAccessToken();

        $paymentData = [
            'monetaryValue' => [
                'amount' => (int) $request->input('amount'),
                'currency' => $request->input('currency', 'IQD'),
            ],
            'statusCallbackUrl' => url('api/payment-updates'),
            'description' => $request->input('description', 'Payment'),
            'expiresIn' => 'PT15M',
        ];

        $response = Http::withToken($token)
            ->post('https://fib.stage.fib.iq/protected/v1/payments', $paymentData);

        if ($response->successful()) {
            $data = $response->json();

            $transaction->payment_reference = $data['paymentId'];
            $transaction->save();

            return response()->json([
                'message' => 'Payment created successfully',
                'paymentId' => $data['paymentId'],
                'personalAppLink' => $data['personalAppLink'] ?? null,
                'data' => $data,
            ]);
        }

        return response()->json([
            'error' => 'Failed to create payment: ' . $response->body(),
        ], $response->status());
    }




    // Webhook to handle payment status update from FIB
    public function handlePaymentUpdate(Request $request)
    {
        $data = $request->all();

        Log::info('Payment update received:', $data);

        $paymentId = $data['paymentId'] ?? null;
        $status = $data['status'] ?? null;

        if ($paymentId && $status) {
            $transaction = \App\Models\Transaction::where('payment_reference', $paymentId)->first();

            if ($transaction) {
                if ($status === 'PAID') {
                    $transaction->transaction_type_id = 2; // Your paid type id
                    $transaction->is_paid = true;
                    $transaction->paid_at = now();
                    $transaction->save();
                } elseif (in_array($status, ['DECLINED', 'REFUNDED'])) {
                    // Update as per your app logic
                    $transaction->is_paid = false;
                    $transaction->save();
                }
            }
        }

        return response()->json(['message' => 'Payment update processed']);
    }

    // Check Payment Status (for polling)
    public function checkPaymentStatus(Request $request, $paymentId)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->get("https://fib.stage.fib.iq/protected/v1/payments/{$paymentId}");

            if ($response->successful()) {
                $data = $response->json();  // <-- Add this line to assign response JSON to $data

                // Optional: update your transaction status here
                $transaction = \App\Models\Transaction::where('payment_reference', $paymentId)->first();
                if ($transaction) {
                    $status = $data['status'] ?? null;
                    if ($status === 'PAID') {
                        $transaction->transaction_type_id = 2;
                        $transaction->is_paid = true;
                        $transaction->paid_at = now();
                        $transaction->save();
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


    // Cancel Payment (Decline unpaid payment)
    public function cancelPayment(Request $request, $paymentId)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->post("https://fib.stage.fib.iq/protected/v1/payments/{$paymentId}/cancel");

            if ($response->successful()) {
                $transaction = \App\Models\Transaction::where('payment_reference', $paymentId)->first();
                if ($transaction) {
                    $transaction->is_paid = false;
                    $transaction->transaction_type_id = 7; // canceled type
                    $transaction->save();
                }

                return response()->json([
                    'message' => 'Payment canceled successfully',
                    'data' => $response->json()
                ]);
            }

            return response()->json([
                'error' => 'Failed to cancel payment: ' . $response->body()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Exception: ' . $e->getMessage(),
            ], 500);
        }
    }



    // Refund Payment (only if PAID)
    public function refundPayment(Request $request, $paymentId)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->post("https://fib.stage.fib.iq/protected/v1/payments/{$paymentId}/refund");

            if ($response->successful()) {
                // Optional: update transaction in DB
                $transaction = \App\Models\Transaction::where('payment_reference', $paymentId)->first();
                if ($transaction) {
                    $transaction->is_paid = false;
                    $transaction->transaction_type_id = 8; // example: refunded type
                    $transaction->save();
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
