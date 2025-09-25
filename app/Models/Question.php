<?php

namespace App\Models;

use App\Enums\QuestionStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Question extends Model
{
    protected $fillable = [
        'questionable',
        'suggestion_id',
        'question',
        'answer',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => QuestionStatusEnum::class,
        ];
    }

    public function questionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function suggestion(): BelongsTo
    {
        return $this->belongsTo(Suggestion::class);
    }
}
