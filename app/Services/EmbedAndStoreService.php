<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenAI;
use OpenAI\Client as OpenAIClient;

class EmbedAndStoreService
{
    protected static ?OpenAIClient $client = null;
    protected const EMBEDDING_MODEL = 'text-embedding-3-small';
    protected const EMBEDDING_DIMENSIONS = 1536;
    protected const MAX_TOKENS = 8191; // Limite do modelo
    protected const CONNECTION = 'pgsql';

    // Inicializa ou retorna client OpenAI singleton
    protected static function getClient(): OpenAIClient
    {
        if (self::$client === null) {
            $apiKey = config('services.openai.api_key') ?? env('OPENAI_API_KEY');

            if (empty($apiKey)) {
                throw new \RuntimeException('OpenAI API key não configurada');
            }

            self::$client = OpenAI::client($apiKey);
        }

        return self::$client;
    }

    // Vetoriza e armazena documento no banco vetorial
    public static function vectorizeAndStore(array $item): bool|int
    {
        try {
            // Validações
            self::validateInput($item);

            // Gerar embedding
            $embedding = self::generateEmbedding($item['text']);

            if (!$embedding) {
                Log::error('Falha ao gerar embedding', [
                    'resource' => $item['resource'],
                    'model_id' => $item['question_id'] ?? null,
                ]);
                return false;
            }

            // Preparar payload para upsert
            $payload = self::preparePayload($item, $embedding);

            // Executar upsert
            return self::upsertPayload($payload);

        } catch (\Exception $e) {
            Log::error('Erro em vectorizeAndStore', [
                'message' => $e->getMessage(),
                'item' => $item,
                'trace' => $e->getTraceAsString(),
            ]);
            return false;
        }
    }

    // Valida dados de entrada
    protected static function validateInput(array $item): void
    {
        $required = ['resource', 'text'];
        foreach ($required as $field) {
            if (empty($item[$field])) {
                throw new \InvalidArgumentException("Campo obrigatório ausente: {$field}");
            }
        }

        // Validar tamanho do texto (aproximação: 1 token ≈ 4 caracteres)
        $estimatedTokens = mb_strlen($item['text']) / 4;
        if ($estimatedTokens > self::MAX_TOKENS) {
            throw new \InvalidArgumentException(
                "Texto muito longo (~{$estimatedTokens} tokens). Máximo: " . self::MAX_TOKENS
            );
        }

        // Validar tipo 'qa' tem question
        if (!empty($item['question']) && empty($item['question'])) {
            throw new \InvalidArgumentException("Documentos tipo 'qa' devem ter 'question'");
        }
    }

    // Prepara payload para inserção no banco
    protected static function preparePayload(array $item, array $embedding): array
    {
        // $content = '**Pergunta:** ' . ($item['question'] ?? '') . '**\n** Resposta:** ' . ($item['answer'] ?? '');
        $content = $item['text'];
        $payload = [
            'resource' => $item['resource'],
            'name' => $item['name'] ?? null,
            'model_id' => $item['model_id'] ?? null,
            'doc_type' => $item['doc_type'],
            'question' => $item['question'] ?? null,
            'answer' => $item['answer'] ?? null,
            'content' => $content,
            'embedding' => $embedding,
            'metadata' => json_encode($item['metadata']),
        ];

        return $payload;
    }

    // Insere ou atualiza documento no banco vetorial
    // Estratégia: Upsert por (resource + model_id) com versionamento
    public static function upsertPayload(array $payload): int
    {
        return DB::connection(self::CONNECTION)->transaction(function () use ($payload) {

            // $resource = $payload['resource'];
            // $modelId = $payload['model_id'];

            // Buscar documento existente
            // $existing = DB::connection(self::CONNECTION)
            //     ->table('documents')
            //     ->where('resource', $resource)
            //     ->where('model_id', $modelId)
            //     ->orderBy('version', 'desc')
            //     ->first();

            // Converter embedding array para string PostgreSQL vector format
            $embeddingStr = self::arrayToVectorString($payload['embedding']);

            // Preparar dados comuns
            $data = [
                'resource' => $payload['resource'],
                'name' => $payload['name'],
                'model_id' => $payload['model_id'],
                'doc_type' => $payload['doc_type'],
                'question' => $payload['question'],
                'answer' => $payload['answer'],
                'content' => $payload['content'],
                'metadata' => $payload['metadata'],
                'updated_at' => Carbon::now(),
            ];

            // if ($existing) {
            //     // Verificar se conteúdo mudou
            //     $existingMetadata = json_decode($existing->metadata, true);
            //     $newMetadata = json_decode($payload['metadata'], true);

            //     $contentChanged = ($existingMetadata['text_hash'] ?? null) !== ($newMetadata['text_hash'] ?? null);

            //     if ($contentChanged) {
            //         // Criar nova versão
            //         $data['version'] = $existing->version + 1;
            //         $data['created_at'] = Carbon::now();

            //         $documentId = DB::connection(self::CONNECTION)
            //             ->table('documents')
            //             ->insertGetId(array_merge($data, [
            //                 'embedding' => DB::raw("'{$embeddingStr}'::vector")
            //             ]));

            //         Log::info('Nova versão de documento criada', [
            //             'id' => $documentId,
            //             'resource' => $resource,
            //             'model_id' => $modelId,
            //             'version' => $data['version'],
            //         ]);

            //         return true;
            //     } else {
            //         // Apenas atualizar timestamp (sem mudança real)
            //         DB::connection(self::CONNECTION)
            //             ->table('documents')
            //             ->where('id', $existing->id)
            //             ->update(['updated_at' => Carbon::now()]);

            //         Log::debug('Documento sem mudanças, apenas timestamp atualizado', [
            //             'id' => $existing->id,
            //             'resource' => $resource,
            //             'model_id' => $modelId,
            //         ]);

            //         return $existing->id;
            //     }
            // } else {
                // Inserir novo documento
                $data['version'] = 1;
                $data['created_at'] = Carbon::now();

                $documentId = DB::connection(self::CONNECTION)
                    ->table('documents')
                    ->insertGetId(array_merge($data, [
                        'embedding' => DB::raw("'{$embeddingStr}'::vector")
                    ]));

                return true;
            // }
        });
    }

    // Gera embedding usando OpenAI API
    protected static function generateEmbedding(string $text): ?array
    {
        try {
            $client = self::getClient();

            $response = $client->embeddings()->create([
                'model' => self::EMBEDDING_MODEL,
                'input' => $text,
            ]);

            $embedding = $response->embeddings[0]->embedding ?? null;

            // Validar dimensionalidade
            if ($embedding && count($embedding) !== self::EMBEDDING_DIMENSIONS) {
                Log::error('Embedding com dimensão incorreta', [
                    'expected' => self::EMBEDDING_DIMENSIONS,
                    'received' => count($embedding),
                ]);
                return null;
            }

            return $embedding;

        } catch (\OpenAI\Exceptions\ErrorException $e) {
            Log::error('Erro na API OpenAI', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Erro ao gerar embedding', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    // Converte array PHP para string no formato PostgreSQL vector
    protected static function arrayToVectorString(array $embedding): string
    {
        return '[' . implode(',', $embedding) . ']';
    }

    // Processa batch de items (útil para importações em massa)
    public static function batchVectorizeAndStore(array $items): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'ids' => [],
        ];

        foreach ($items as $item) {
            $result = self::vectorizeAndStore($item);

            if ($result) {
                $results['success']++;
                $results['ids'][] = $result;
            } else {
                $results['failed']++;
            }
        }
        return $results;
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
