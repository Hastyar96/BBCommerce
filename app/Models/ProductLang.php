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
    ];
}
