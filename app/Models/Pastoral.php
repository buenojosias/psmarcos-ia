<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Pastoral extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id',
        'name',
        'slug',
        'description',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_leader');
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

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
