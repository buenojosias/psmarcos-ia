<?php

namespace App\Models;

use App\Enums\WeekdayEnum;
use Illuminate\Database\Eloquent\Model;

class Mass extends Model
{
    protected $fillable = [
        'community_id',
        'name',
        'weekday',
        'time',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'time' => 'datetime:H:i',
            'weekday' => WeekdayEnum::class,
        ];
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
