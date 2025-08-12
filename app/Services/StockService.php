<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\Transaction;

class StockService
{
    public function updateStockForTransaction(Transaction $transaction)
    {
        foreach ($transaction->items as $transactionItem) {

            $stock = Stock::firstOrCreate(
                [
                    'product_id' => $transactionItem->product_id,
                    'taste_id'   => $transactionItem->taste_id,
                    'office_id'  => $transaction->office_id,
                ],
                ['quantity' => 0]
            );

            $transactionType = $transaction->transactionType;

            if ($transactionType->increase) {
                $stock->quantity += $transactionItem->quantity;
            } elseif ($transactionType->decrease) {
                if ($stock->quantity < $transactionItem->quantity) {
                    throw new \Exception("کۆگای پێویست بەردەست نییە بۆ ئەم بەرهەمە و تامە لە لقی دیاریکراو");
                }
                $stock->quantity -= $transactionItem->quantity;
            }

            $stock->save();
        }
    }
}
