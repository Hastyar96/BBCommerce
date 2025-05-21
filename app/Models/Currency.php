<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function langs()
    {
        return $this->hasMany(GoalLang::class, 'goal_id');
    }
}
