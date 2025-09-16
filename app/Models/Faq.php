<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
      protected $fillable = [
        'name',
        'is_active',
    ];
      public function translations()
    {
        return $this->hasMany(FaqLang::class);
    }
}
