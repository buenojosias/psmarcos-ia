<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Facades\Http;

class VectorizeQuestionService
{
    static public function vectorize(string $resource, $model, $question)
    {
        // $question = Question::select('id', 'question', 'answer')->whereIn('id', $question)->get();

        // $batchPayload = $question->map(function ($question) use ($resource, $model) {
            // return [
                $batchPayload['resource'] = $resource;
                $batchPayload['name'] = $model['slug'];
                $batchPayload['model_id'] = $question['id'];
                $batchPayload['question'] = $question['question'];
                $batchPayload['answer'] = $question['answer'];
                $batchPayload['text'] = "**Pergunta:** {$question['question']}**\n**Resposta:** {$question['answer']}";
        //     ];
        // });

        return VectorizeAndStoreService::vectorizeAndStore($batchPayload);
    }
}
