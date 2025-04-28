<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taste extends Model
{
    protected $fillable =
    [
        'name',
        'is_active',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function translations()
    {
        return $this->hasMany(TasteLang::class);
    }
}
