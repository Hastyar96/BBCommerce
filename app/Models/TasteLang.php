<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasteLang extends Model
{
    protected $fillable =
    [
        'name',
        'taste_id',
        'language_id',
    ];

    public function taste()
    {
        return $this->belongsTo(Taste::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }


}
