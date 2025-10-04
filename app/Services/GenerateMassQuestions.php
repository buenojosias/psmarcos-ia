<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GenerateMassQuestions
{
    public static function generate(array $masses): array
    {
        // valida e prepara input
        if (empty($masses)) {
            return [];
        }

        // mapa de id => descrição curta para referência no prompt
        $massesList = [];
        foreach ($masses as $mass) {
            $id = data_get($mass, 'id');
            $name = data_get($mass, 'name', '');
            $note = data_get($mass, 'note', '');
            $massText = trim($name . ($note ? " — {$note}" : ""));
            $massesList[] = [
                'id' => $id,
                'text' => $massText,
                'community' => data_get($mass, 'community') // opcional
            ];
        }

        // constrói bloco textual para o prompt (linha por linha com id)
        $massesText = '';
        foreach ($massesList as $m) {
            $massesText .= "- [id: {$m['id']}] {$m['text']}\n";
        }

        // prompt pedindo JSON estruturado
        $userPrompt = <<<EOT
            Você é um assistente que transforma uma lista de missas em perguntas e respostas (QAs) para um sistema de atendimento via WhatsApp.
            Não invente informações: baseie-se **exclusivamente** nas missas listadas abaixo.

            Formato de entrada (a seguir): cada linha contém o id da missa entre colchetes e a descrição.
            ### Missas:
            {$massesText}

            Tarefa:
            1) Gere **até 15** pares pergunta/resposta relevantes cobrindo dúvidas práticas dos fiéis (horário, dia, comunidade, missas especiais, "noite", "catequese", etc).
            2) Para cada QA, inclua os campos: "question", "answer", "source_ids" (lista de ids das missas usadas como base), "tags" (palavras-chaves como "sábado","domingo","noite","catequese","matriz-sao-marcos").
            3) Retorne **apenas** um JSON válido: um array de objetos. Exemplo de saída esperada:

            [
            {
                "question": "Qual é o horário da Missa na Matriz São Marcos aos domingos?",
                "answer": "A Missa na Matriz São Marcos aos domingos acontece às 08:00 e às 10:00.",
                "source_ids": [56,58],
                "tags": ["domingo","manhã","matriz-sao-marcos"]
            },
            ...
            ]

            Regras:
            - Não invente missas nem horários fora da lista.
            - Se uma pergunta não se aplicar, não a inclua.
            - Use linguagem clara e objetiva (português).
        EOT;

        // chamada com timeout e retry
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])
                ->timeout(30)           // ajuste conforme necessário
                ->retry(2, 100)         // 2 tentativas adicionais com backoff
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Você é um assistente para geração de perguntas e respostas sobre missas.'],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'temperature' => 0.2,
                    'max_tokens' => 1500,
                    'n' => 1,
                ]);
        } catch (\Exception $e) {
            // log e fallback
            \Log::error('OpenAI request failed: ' . $e->getMessage());
            return [];
        }

        if (!$response->successful()) {
            \Log::error('OpenAI responded with error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return [];
        }

        $body = $response->json();

        // extrai mensagem do assistant
        $assistantText = data_get($body, 'choices.0.message.content', null);
        if (!$assistantText) {
            \Log::warning('OpenAI returned no assistant text', ['body' => $body]);
            return [];
        }

        // tenta decodificar JSON (esperado)
        $qaList = json_decode($assistantText, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($qaList)) {
            // valida elementos básicos e sanitize
            $clean = [];
            foreach ($qaList as $item) {
                if (!isset($item['question']) || !isset($item['answer'])) {
                    continue;
                }
                $clean[] = [
                    'question' => trim($item['question']),
                    'answer' => trim($item['answer']),
                    'source_ids' => array_values(array_unique(array_map('intval', (array) ($item['source_ids'] ?? [])))),
                    'tags' => array_values(array_unique(array_map('strval', (array) ($item['tags'] ?? []))))
                ];
            }
            return $clean;
        }

        // fallback: modelo pode ter retornado texto em lista - parse simples por linhas
        $lines = preg_split('/\r?\n/', $assistantText);
        $result = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '')
                continue;
            // tenta extrair padrão: - **Pergunta:** ... **Resposta:** ...
            if (preg_match('/\*\*Pergunta:\*\*\s*(.+?)\s*\*\*Resposta:\*\*\s*(.+)$/i', $line, $m)) {
                $result[] = ['question' => trim($m[1]), 'answer' => trim($m[2]), 'source_ids' => [], 'tags' => []];
            }
        }
        return $result;
    }

}


