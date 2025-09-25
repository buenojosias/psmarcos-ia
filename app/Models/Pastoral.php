<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Pastoral extends Model
{
    protected $fillable = [
        'community_id',
        'user_id',
        'name',
        'slug',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function questions(): MorphMany
    {
        return $this->morphMany(Question::class, 'questionable');
    }
}
