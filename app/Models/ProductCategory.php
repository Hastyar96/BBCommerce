<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'image',
    ];

    public function langs()
    {
        return $this->hasMany(ProductCategoryLang::class , 'product_category_id'); // or respective Lang model
    }
}
 