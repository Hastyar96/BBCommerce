<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderLang extends Model
{
    protected $fillable = [
        'slider_id',
        'image',
        'language_id',
        'title',
        'description',
    ];

}
