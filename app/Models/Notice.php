<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notice extends Model
{
    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'content',
        'expires_at',
    ];

    protected $dates = [
        'expires_at',
    ];

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
