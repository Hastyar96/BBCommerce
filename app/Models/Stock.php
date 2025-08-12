<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'taste_id',
        'office_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function taste()
    {
        return $this->belongsTo(Taste::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
