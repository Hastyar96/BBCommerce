<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'price',
        'currency_id',
         'is_active', // 1 for active, 0 for inactive
       // 'office_ids', // JSON array of office IDs
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
