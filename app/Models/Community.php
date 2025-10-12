<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Community extends Model
{
    protected $fillable = [
        'name',
        'alias',
        'address',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_leader');
    }

    public function leaders()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('is_leader', true);
    }

    public function pastorals()
    {
        return $this->hasMany(Pastoral::class);
    }

    public function events()
    {
        return $this->morphMany(Event::class, 'eventable');
    }

    public function masses()
    {
        return $this->hasMany(Mass::class);
    }

    public function questions()
    {
        return $this->morphMany(Question::class, 'questionable');
    }

    public function notices()
    {
        return $this->morphMany(Notice::class, 'notifiable');
    }
}
