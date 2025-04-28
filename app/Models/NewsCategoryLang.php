<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategoryLang extends Model
{
    protected $fillable = [
        'news_category_id',
        'language_id',
        'name',
        'description',
       ];
}
