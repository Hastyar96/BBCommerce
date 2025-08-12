<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandLang extends Model
{
    protected $fillable = ['brand_id', 'language_id', 'name','description'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
