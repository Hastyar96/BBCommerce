<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalLang extends Model
{
    protected $fillable = ['goal_id', 'language_id', 'name', 'description'];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
