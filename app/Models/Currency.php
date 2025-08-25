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

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'currency_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'currency_id');
    }

    public function getActiveCurrencies()
    {
        return self::where('is_active', true)->get();
    }
}
