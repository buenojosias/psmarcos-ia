<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = ['type', 'content', 'usages'];

    public function pastoralQuestions()
    {
        return $this->hasMany(PastoralQuestion::class);
    }
}
