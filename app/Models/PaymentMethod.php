<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
     protected $fillable = [
        'name',   // ناوی جۆری پارەدان
        'code',   // کۆدی یەکتای پارەدان
    ];

    /**
     * ئەگەر ئەو ماودەلە پەیوەندی بە transactions هەبێت
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'payment_method');
    }
}
