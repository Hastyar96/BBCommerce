<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubcityLang extends Model
{
    protected $table = 'subcity_langs';

    protected $fillable = [
        'subcity_id',
        'langid',
        'name',
    ];

    public function subcity()
    {
        return $this->belongsTo(Subcity::class);
    }

    public function lang()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }
}
