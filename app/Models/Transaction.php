<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   protected $fillable = [
        'note',
        //'transaction_type',
        'office_id',
        'transaction_number',
        'taxi_id',
        'taxi_garawatawa',
        'who_loan',
        'payment_method',
        'total_price',
        'paid_amount',
        'discount',
        'unpaid_amount',
        'currency_id',
        'exchange_rate',
        'transaction_type_id',
        'transaction_date',
        'who_transaction',
        'transaction_by',
        'user_id',
        'forwarded_by',
        'is_forwarded',
        'forwarded_accept',
        'forwarded_at',
        'accept_forwarded_at',
        'forwarded_note',
        'order_status',
        'order_note',
        'order_first_change_status_date',
        'adderess',

        'original_transaction_id',

        'is_paid',
        'paid_at',
        'payment_reference',
    ];

     public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method', 'id');
    }
    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }



}
