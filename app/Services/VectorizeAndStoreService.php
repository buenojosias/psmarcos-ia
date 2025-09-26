<?php

namespace App\Services;

use Carbon\Carbon;
use DB;
use OpenAI;
use Illuminate\Support\Facades\Http;

class VectorizeAndStoreService
{
    static public function vectorizeAndStore($item)
    {
        $openaiApiKey = env('OPENAI_API_KEY', 'YOUR_OPENAI_API_KEY_HERE');
        $client = OpenAI::client($openaiApiKey);

        if ($embedding = self::generateEmbedding($client, $item['text'])) {
            return self::upsertPayload([
                'resource' => $item['resource'],
                'name' => $item['name'],
                'question_id' => $item['question_id'],
                'question' => $item['question'],
                'answer' => $item['answer'],
                'content' => $item['text'],
                'embedding' => $embedding,
                'metadata' => [
                    'resource' => $item['resource'],
                    $item['resource'] . '_name' => $item['name'],
                    'source' => 'blob',
                    'blobType' => 'text/plain',
                    'question_id' => $item['question_id'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                ],
                'version' => 1,
            ]);
        } else {
            return false;
        }
    }

    static public function upsertPayload(array $payload)
    {
        // Normaliza/valida entradas mínimas
        $resource = $payload['resource'] ?? null;
        $name = $payload['name'] ?? null;
        $questionId = $payload['question_id'] ?? null;
        $question = $payload['question'] ?? '';
        $answer = $payload['answer'] ?? '';
        $content = $payload['content'] ?? '';
        $embeddingArr = $payload['embedding'] ?? null;   // pode ser array ou null
        $metadataArr = $payload['metadata'] ?? [];

        // Converte embedding array -> string "[0.1,0.2,...]" ou null
        $embeddingSql = null;
        if (!empty($embeddingArr) && is_array($embeddingArr)) {
            $flat = array_values(array_filter(array_map(
                fn($v) => is_null($v) ? null : (float) $v,
                $embeddingArr
            ), fn($v) => $v !== null || $v === 0.0)); // mantém zeros

            if (!empty($flat)) {
                $embeddingSql = '[' . implode(',', $flat) . ']';
            } else {
                $embeddingSql = null;
            }
        }

        // metadata -> json string
        $metadataJson = json_encode($metadataArr);

        // version (pode ajustar conforme sua lógica)
        $version = $payload['version'] ?? 1;

        $sql = "
                INSERT INTO documents
                    (resource, name, question_id, question, answer, content, embedding, metadata, version)
                VALUES (?, ?, ?, ?, ?, ?, ?::vector, ?::jsonb, ?)
                ON CONFLICT (question_id, name, resource) DO UPDATE
                SET question = EXCLUDED.question,
                    answer   = EXCLUDED.answer,
                    content  = EXCLUDED.content,
                    embedding = COALESCE(EXCLUDED.embedding, documents.embedding),
                    metadata = EXCLUDED.metadata,
                    version = documents.version + 1,
                    embedding_status = CASE WHEN EXCLUDED.embedding IS NOT NULL THEN 'done' ELSE documents.embedding_status END,
                    updated_at = now();
            ";

        $connName = 'pgsql'; // conforme sua conexão

        // IMPORTANTE: 9 placeholders -> 9 bindings
        $created = DB::connection($connName)->statement($sql, [
            $resource,
            $name,
            $questionId,
            $question,
            $answer,
            $content,
            $embeddingSql,   // string no formato [v1,v2,...] ou null
            $metadataJson,
            $version
        ]);

        return $created ?? false;
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


// try {
//     $response = Http::timeout(10)->post(env('N8N_VECTORIZE_WEBHOOK_URL', 'YOUR_WEBHOOK_URL_HERE'), $payload);
//     $responseData = $response->json() ?? null;

//     if ($responseData['id']) {
//         $savedEmbeddings[] = $item['question_id'];
//     } else {
//         dump(false);
//     }
// } catch (\Exception $e) {
//     dd("Erro ao enviar para N8N", [
//         'error' => $e->getMessage()
//     ]);
// }
