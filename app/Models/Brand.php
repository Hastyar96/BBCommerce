<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['logo'];
    public function langs()
    {
        return $this->hasMany(BrandLang::class);
    }

    public function lang($langId)
    {
        return $this->langs()->where('language_id', $langId)->first();
    }
}
