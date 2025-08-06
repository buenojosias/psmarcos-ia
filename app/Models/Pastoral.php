<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pastoral extends Model
{
    protected $fillable = [
        'community_id',
        'name',
        'slug',
        'description',
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
