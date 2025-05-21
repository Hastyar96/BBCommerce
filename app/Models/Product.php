<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'image',
        'brand_id',
        'category_id',
        'goal_id',
        'tag_id',
        'size_type', //1 for size forward 2 for size json / 3 no size
        'size',  //json
        'status',
        'for_gift',
        'for_sell',
        'for_buy',
        'buy_price',
        'note',
    ];

    // Product.php

    public function langs()
    {
        return $this->hasMany(ProductLang::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


}
