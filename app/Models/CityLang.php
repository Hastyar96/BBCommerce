<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityLang extends Model
{
    protected $fillable = ['city_id', 'lang_id', 'name'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function lang()
    {
        return $this->belongsTo(Language::class, 'lang_id', 'id');
    }
}
