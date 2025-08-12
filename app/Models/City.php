<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name'];

    public function subcities()
    {
        return $this->hasMany(SubCity::class);
    }

    public function langs()
    {
        return $this->hasMany(CityLang::class);
    }

}
