<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = [
        'name',
        'alias',
        'address',
    ];

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

    public function notices()
    {
        return $this->morphMany(Notice::class, 'notifiable');
    }
}
