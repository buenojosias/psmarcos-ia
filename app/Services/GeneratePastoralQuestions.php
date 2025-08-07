<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeneratePastoralQuestions
{
    public static function generate(array $questions, string $pastoral_name)
    {
        if (empty($questions)) {
            return null;
        }

        // Montar perguntas e respostas formatadas
        $questionsText = '';
        foreach ($questions as $q) {
            $questionsText .= "- {$q['question']}\n  {$q['answer']}\n\n";
        }

        // Prompt principal
        $userPrompt = <<<EOT
Você está atuando como assistente de um sistema de atendimento via WhatsApp da Secretaria Paroquial. Abaixo estão perguntas e respostas fornecidas por um coordenador de um grupo da paróquia. Seu objetivo é gerar sugestões de novas perguntas que possam complementar esse conteúdo, ajudando a tornar o atendimento mais completo e útil para os fiéis.

Grupo: {$pastoral_name}

### Perguntas e respostas já cadastradas:
{$questionsText}

---

Com base nas perguntas e respostas acima, gere entre **4 e 8 novas perguntas relevantes** que um fiel possa fazer sobre o grupo "{$pastoral_name}".

**Instruções:**
- Escreva perguntas claras, objetivas e com linguagem acessível.
- Evite repetir perguntas já existentes.
- Sempre inclua o nome completo do grupo "{$pastoral_name}" em cada pergunta.
- Foque em dúvidas práticas, como quem pode participar, como entrar, horários, compromissos, atividades, funções, faixa etária, custo, participação em eventos etc.
- Não invente informações; baseie-se no tom e tipo de conteúdo já existente.

**Importante:** retorne as perguntas **somente como uma lista ou array textual**, com cada item em uma linha, assim:

- Pergunta 1
- Pergunta 2
- Pergunta 3
- ...

### Novas perguntas sugeridas:
EOT;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Você é um assistente para geração de perguntas sobre grupos da paróquia.'],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 600,
                ]);
        return $response->json();
    }
}
