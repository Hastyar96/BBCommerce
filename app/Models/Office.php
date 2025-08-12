<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = ['name', 'address', 'phone','lat','long'];

    public function subcities()
    {
        return $this->belongsToMany(Subcity::class, 'office_subcities');
    }

    public function langs()
    {
        return $this->hasMany(OfficeLang::class);
    }
}
