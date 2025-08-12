<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'taste_id',
        'currency_id',
        'office_id',
        'quantity',
        'price_per_unit',
        'discount',
        'total_price',
        'note',
        'is_gift',
        'buy_price',
        'price_single',
        'wholesale_price',
        'created_at',
        'updated_at',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function taste()
    {
        return $this->belongsTo(Taste::class, 'taste_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
