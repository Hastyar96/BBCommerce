<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcity extends Model
{
    protected $fillable = ['name', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function langs()
    {
        return $this->hasMany(SubcityLang::class);
    }
    public function offices()
    {
        return $this->belongsToMany(Office::class, 'office_subcities');
    }


}
