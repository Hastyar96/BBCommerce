<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'brand_id',
        'category_id',
        'size_type', //1 for size forward 2 for size json / 3 no size
        'size',  //json
        'status',
        'for_gift',
        'for_sell',
        'for_buy',
        'buy_price',
        'note',
        'best_sale',
        'serving_g',
        'is_actibe',
    ];

    // Product.php

    public function langs()
    {
        return $this->hasMany(ProductLang::class);
    }
    public function lang($langId)
    {
        return $this->langs()->where('language_id', $langId)->first();
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }


    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'goal_products', 'product_id', 'goal_id');
    }
    public function tastes()
    {
        return $this->belongsToMany(Taste::class, 'product_tastes');
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function price()
    {
         return $this->hasMany(ProductPrice::class);
    }
    public function priceIn($currencyId)
    {
        return $this->price()->where('currency_id', $currencyId)->first()?->price ?? 0;
    }
    public function activePrice()
    {
        return $this->hasOne(ProductPrice::class)->where('is_active', 1)->latest('id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function isFavoritedBy($userId)
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
