<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'alias',
        'description',
    ];

    public $casts = [
        'label' => ModelEnum::class,
    ];

    public function questions(): MorphMany
    {
        return $this->morphMany(Question::class, 'questionable');
    }

    public function events(): MorphMany
    {
        return $this->morphMany(Event::class, 'eventable');
    }

    public function notices(): MorphMany
    {
        return $this->morphMany(Notice::class, 'notifiable');
    }
}
