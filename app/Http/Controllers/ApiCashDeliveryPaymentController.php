<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Payment;

class ApiCashDeliveryPaymentController extends Controller
{
    // Cash on Delivery Payment
    public function CashOnDelivery(Request $request)
    {
        $transaction = Transaction::find($request->transaction_id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Check if transaction is "new/pending"
        if ($transaction->transaction_type_id != 1) {
            return response()->json(['error' => 'Invalid transaction type'], 400);
        }

        // Create a pending COD payment
        $payment = Payment::create([
            'transaction_id'    => $transaction->id,
            'payment_method_id' => 5, // cash
            'amount'            => $transaction->total_price,
            'status'            => 'pending', // COD not yet received
            'reference'         => 'COD-' . uniqid(),
            'note'              => 'Cash on Delivery',
        ]);

        // Optional: Update transaction type to "COD initiated"
        $transaction->transaction_type_id = 2; // 2 = COD initiated / awaiting payment
        $transaction->save();

        return response()->json([
            'message'     => 'Cash on Delivery payment created and pending',
            'transaction' => $transaction,
            'payment'     => $payment
        ]);
    }

    // Mark payment as received (called when cash is collected)
    public function markPaymentReceived(Request $request)
    {
        $transaction = Transaction::find($request->transaction_id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $payment = $transaction->payments()
            ->where('status', 'pending')
            ->first();

        if (!$payment) {
            return response()->json(['error' => 'No pending payment found'], 404);
        }

        // Mark payment as paid
        $payment->status = 'paid';
        $payment->paid_at = now();
        $payment->save();

        // Update transaction as paid
        $transaction->is_paid = true;
        $transaction->paid_at = now();
        $transaction->transaction_type_id = 3; // 3 = Paid / Completed
        $transaction->save();

        return response()->json([
            'message'     => 'Cash received, transaction completed',
            'transaction' => $transaction,
            'payment'     => $payment
        ]);
    }

    // Get Transaction Summary
    public function transactionSummary($transaction_id)
    {
        $transaction = Transaction::with('payments.ordered')->find($transaction_id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        return response()->json([
            'transaction' => $transaction,
            'total_paid'  => $transaction->totalPaid(),
            'unpaid'      => $transaction->unpaidAmount(),
            'payments'    => $transaction->payments()->ordered()->get(),
        ]);
    }
}
