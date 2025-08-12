<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['image'];

    public function langs()
    {
        return $this->hasMany(GoalLang::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'goal_products');
    }


}
