<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $fillable=[
        'image'
    ];
    public function langs()
    {
        return $this->hasMany(TagLang::class, 'tag_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags');
    }

}
