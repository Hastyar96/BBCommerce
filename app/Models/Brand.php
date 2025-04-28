<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function langs()
    {
        return $this->hasMany(BrandLang::class); // or respective Lang model
    }
}
