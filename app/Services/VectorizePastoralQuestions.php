<?php

namespace App\Services;

use App\Models\PastoralQuestion;
use Illuminate\Support\Facades\Http;

class VectorizePastoralQuestions
{
    static public function handle($pastoral, $questions)
    {
        $questions = PastoralQuestion::select('id', 'question', 'answer')->whereIn('id', $questions)->get();

        $batchPayload = $questions->map(function ($question) use ($pastoral) {
            return [
                'pastoral' => $pastoral->slug,
                'question_id' => $question->id,
                'question' => $question->question,
                'answer' => $question->answer,
                'text' => "Pergunta: {$question->question}\nResposta: {$question->answer}",
            ];
        })->toArray();

        // Envia o payload para o webhook do N8N
        $response = Http::post(env('N8N_VECTORIZE_WEBHOOK_URL', 'YOUR_WEBHOOK_URL_HERE'), [
            'items' => $batchPayload,
        ]);

        dd($response->json());

        // Verifica sucesso ou falha
        if ($response->successful()) {
            logger('Perguntas vetorizaradas com sucesso no N8N.');
        } else {
            logger()->error('Erro ao vetorizar perguntas no N8N', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return $response->json();
    }
}
