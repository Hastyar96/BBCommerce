<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'exchange_rate',
        'is_active',
    ];

    public function getActiveCurrencies()
    {
        return self::where('is_active', true)->get();
    }



}
