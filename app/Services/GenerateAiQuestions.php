<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GenerateAiQuestions
{
    public static function generate(string $resource, string $name, string $description = null, array $questions)
    {
        if (is_null($description) && empty($questions)) {
            return null;
        }

        if (!empty($questions) && count($questions) >= 3) {
            return self::generateFromQuestions($resource, $name, $questions);
        } else {
            return self::generateFromDescription($resource, $name, $description);
        }
    }

    // GERAR A PARTIR DAS PERGUNTAS EXISTENTES
    public static function generateFromQuestions(string $resource, string $name, array $questions): array
    {
        // Montar perguntas e respostas formatadas
        $questionsText = '';
        foreach ($questions as $q) {
            $questionsText .= "- {$q['question']}\n  {$q['answer']}\n\n";
        }
        $questionRuleExamples = $resource == 'pastoral'
            ? 'quem pode participar, como fazer parte, horários dos encontros, compromissos, atividades, funções, faixa etária, custo, participação em eventos'
            : 'data e local do evento, horário de início e término, duração, cardápio, organizador, aquisição, reserva ou inscrição antecipadas, custos, finalidade';

        // Prompt principal
        $userPrompt = <<<EOT
            Você está atuando como assistente de um sistema de atendimento via WhatsApp da Secretaria Paroquial. Abaixo estão perguntas e respostas fornecidas por um coordenador de um(a) {$resource} da paróquia. Seu objetivo é gerar sugestões de novas perguntas que possam complementar esse conteúdo, ajudando a tornar o atendimento mais completo e útil para os fiéis.

            {$resource}: {$name}

            ### Perguntas e respostas já cadastradas:
            {$questionsText}

            ---

            Com base nas perguntas e respostas acima, gere entre **4 e 8 novas perguntas relevantes** que um fiel possa fazer sobre o(a) {$resource} "{$name}".

            **Instruções:**
            - Escreva perguntas claras, objetivas e com linguagem acessível.
            - Evite repetir perguntas já existentes.
            - Sempre inclua o nome completo do(a) {$resource} "{$name}" em cada pergunta.
            - Foque em dúvidas práticas, como {$questionRuleExamples} entre outras perguntas relevantes para o(a) {$resource}.
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
                        ['role' => 'system', 'content' => 'Você é um assistente para geração de perguntas sobre o(a) ' . $resource . ' da paróquia.'],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 600,
                ]);
        return $response->json();
    }

    // GERAR A PARTIR DA DESCRIÇÃO
    public static function generateFromDescription(string $resource, string $name, string $description)
    {
        $questionRuleExamples = $resource == 'pastoral'
            ? 'quem pode participar, como fazer parte, horários dos encontros, compromissos, atividades, funções, faixa etária, custo, participação em eventos'
            : 'data e local do evento, horário de início e término, duração, cardápio, organizador, aquisição, reserva ou inscrição antecipadas, custos, finalidade';

        // Prompt principal
        $userPrompt = <<<EOT
            Você está atuando como assistente de um sistema de atendimento via WhatsApp da Secretaria Paroquial. Abaixo a descrição fornecida por um coordenador de um {$resource} da paróquia. Seu objetivo é gerar sugestões de perguntas que possam complementar esse conteúdo, ajudando a tornar o atendimento mais completo e útil para os fiéis.

            {$resource}: {$name}

            ### Descrição do(a) {$resource}:
            {$description}

            ---
            Com base na descrição acima, gere entre **4 e 8 novas perguntas relevantes** que um fiel possa fazer sobre o(a) {$resource} "{$name}".

            **Instruções:**
            - Crie as primeiras perguntas extraindo o conteúdo da descrição fornecida.
            - Escreva perguntas claras, objetivas e com linguagem acessível.
            - Sempre inclua o nome completo do(a) {$resource} "{$name}" em cada pergunta.
            - Foque em dúvidas práticas, como {$questionRuleExamples} entre outras perguntas relevantes para o(a) {$resource}.
            - Não invente informações; baseie-se no tom e tipo de conteúdo já existente.

            **Importante:** retorne as perguntas **somente como uma lista ou array textual**, com cada item em uma linha, assim:

            - Pergunta 1
            - Pergunta 2
            - Pergunta 3
            - ...

            ### Perguntas sugeridas:
            EOT;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Você é um assistente para geração de perguntas sobre o(a) ' . $resource . ' da paróquia.'],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 600,
                ]);
        return $response->json();
    }
}


