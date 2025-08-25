<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'payment_method_id',
        'amount',
        'paid_at',
        'status',       // pending, paid, failed
        'reference',
        'note',
    ];

    protected $dates = ['paid_at'];

    // Relations
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    // Scope for ordered payments (timeline)
    public function scopeOrdered($query)
    {
        return $query->orderByRaw('COALESCE(paid_at, created_at) ASC');
    }
}
