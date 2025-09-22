<?php

namespace App\Services;

use OpenAI;
use Illuminate\Support\Facades\Http;

class VectorizeAndStoreService
{
    static public function vectorizeAndStore(array $items): void
    {
        $openaiApiKey = env('OPENAI_API_KEY', 'YOUR_OPENAI_API_KEY_HERE');
        $client = OpenAI::client($openaiApiKey);
        $savedEmbeddings = [];

        foreach ($items as $item) {
            $embedding = self::generateEmbedding($client, $item['text']);

            if ($embedding) {
                $payload = [
                    'content' => $item['text'],
                    'metadata' => [
                        'name' => $item['pastoral'],
                        'source' => 'blob',
                        'blobType' => 'text/plain',
                        'resource' => 'pergunta_pastoral',
                        'question_id' => $item['question_id']
                    ],
                    'embedding' => $embedding
                ];

                try {
                    $response = Http::timeout(10)->post(env('N8N_VECTORIZE_WEBHOOK_URL', 'YOUR_WEBHOOK_URL_HERE'), $payload);
                    $responseData = $response->json() ?? null;

                    if ($responseData['id']) {
                        $savedEmbeddings[] = $item['question_id'];
                    } else {
                        dump(false);
                    }
                } catch (\Exception $e) {
                    dd("Erro ao enviar para N8N", [
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
        return $savedEmbeddings;
    }

    static protected function generateEmbedding($client, string $text): ?array
    {
        $response = $client->embeddings()->create([
            'model' => 'text-embedding-3-small', // ou outro modelo compatível
            'input' => $text,
        ]);

        return $response->embeddings[0]->embedding ?? null;
    }
}
