<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagLang extends Model
{
    protected $fillable = ['tag_id', 'language_id', 'name', 'description'];
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
