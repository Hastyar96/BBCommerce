<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = ['name', 'seen', 'news_category_id'];
    public $timestamps = true;
}
