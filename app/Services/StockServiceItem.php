<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\TransactionItem;
use App\Models\Transaction;

class StockServiceItem
{
    public function updateStockForTransaction($transactionItem)
    {
        $officeId=Transaction::find('id',$transactionItem->transaction_id);
        // وەرگرتن یان دروستکردنی کۆگای بەرهەم بەپێی تام و لق
        $stock = Stock::firstOrCreate(
            [
                'product_id' => $transactionItem->product_id,
                'taste_id' => $transactionItem->taste_id,
                'office_id' => $officeId,
            ],
            ['quantity' => 0]
        );

        $transaction = $transactionItem->transaction;
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
