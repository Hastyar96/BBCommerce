<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    public function langs()
    {
        return $this->hasMany(TagLang::class, 'tag_id');
    }
}
