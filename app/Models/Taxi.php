<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxi extends Model
{
    protected $fillable=[
        'name',
        'office_id',
        'tablo',
        'xawan_name',
        'phone',
    ];
}
