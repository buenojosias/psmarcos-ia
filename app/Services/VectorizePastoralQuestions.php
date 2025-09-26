<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Facades\Http;

class VectorizePastoralQuestions
{
    static public function handle($pastoral, $questions)
    {
        $questions = Question::select('id', 'question', 'answer')->whereIn('id', $questions)->get();

        $batchPayload = $questions->map(function ($question) use ($pastoral) {
            return [
                'pastoral' => $pastoral->slug,
                'question_id' => $question->id,
                'question' => $question->question,
                'answer' => $question->answer,
                'text' => "**Pergunta:** {$question->question}**\n**Resposta:** {$question->answer}",
            ];
        })->toArray();

        $vectorized = VectorizeAndStoreService::vectorizeAndStore($batchPayload);
        dd($vectorized);
    }
}
