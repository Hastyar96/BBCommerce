<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeSubcity extends Model
{
    protected $fillable = [
        'office_id',
        'subcity_id',
        'created_by',
        'updated_by',
    ];
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
    public function subcity()
    {
        return $this->belongsTo(Subcity::class, 'subcity_id');
    }

}
