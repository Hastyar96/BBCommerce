<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqLang extends Model
{
    protected $fillable = [
        'faq_id',
        'language_id',
        'question',
        'answer',
    ];

    public function faq()
    {
        return $this->belongsTo(Faq::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
