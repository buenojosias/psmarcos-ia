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
}
