<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLang extends Model
{
    protected $fillable = [
        'product_id',
        'language_id',
        'name',
        'description',
        'suited_for',
        'recommended_use'
    ];
     public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
