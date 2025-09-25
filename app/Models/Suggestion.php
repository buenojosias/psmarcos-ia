<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = ['type', 'content', 'usages'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
