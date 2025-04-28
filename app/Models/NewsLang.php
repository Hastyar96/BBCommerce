<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsLang extends Model
{
    protected $table = 'news_langs';
    protected $fillable = ['news_id', 'language_id', 'title', 'description'];
    public $timestamps = false;
}
