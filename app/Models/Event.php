<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'eventable_type',
        'eventable_id',
        'name',
        'starts_at',
        'ends_at',
        'location',
        'description',
    ];

    // protected function casts(): array
    // {
    //     return [
    //         'starts_at' => 'datetime:d/m/Y H:i',
    //         'ends_at' => 'datetime:d/m/Y H:i',
    //     ];
    // }

    public function eventable()
    {
        return $this->morphTo();
    }

    public function questions()
    {
        return $this->morphMany(Question::class, 'questionable');
    }
}
