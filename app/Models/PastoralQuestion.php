<?php

namespace App\Models;

use App\Enums\QuestionStatusEnum;
use Illuminate\Database\Eloquent\Model;

class PastoralQuestion extends Model
{
    protected $fillable = [
        'pastoral_id',
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

    public function pastoral()
    {
        return $this->belongsTo(Pastoral::class);
    }

}
