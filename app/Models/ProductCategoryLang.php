<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryLang extends Model
{
    protected $fillable = [
        'product_category_id',
        'language_id',
        'name',
        'description',
    ];
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
