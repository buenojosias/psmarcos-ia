<?php

namespace App\Models;

use App\Enums\SuggestionTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = ['type', 'content', 'usages'];

    protected $casts = [
        'usages' => 'integer',
        'type' => SuggestionTypeEnum::class,
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
