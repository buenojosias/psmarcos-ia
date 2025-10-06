<?php

namespace App\Services;

class VectorizeQuestionService
{
    static public function vectorize(string $resource, $model, $question)
    {
        $batchPayload['resource'] = $resource;
        $batchPayload['name'] = $model['name'];
        $batchPayload['model_id'] = $question['id'];
        $batchPayload['doc_type'] = 'mass_data';
        $batchPayload['question'] = $question['question'];
        $batchPayload['answer'] = $question['answer'];
        $batchPayload['text'] = "**Pergunta:** {$question['question']}** \n **Resposta:** {$question['answer']}";

        $batchPayload['metadata'] = [
            'resource' => $resource,
            'name' => $model['name'] ?? null,
            'model_id' => $question['id'] ?? null,
        ];

        if ($resource === 'event') {
            $batchPayload['metadata']['schedule'] = [
                'type' => 'single_event',
                'datetime' => $model['starts_at'],
            ];
        }

        return EmbedAndStoreService::vectorizeAndStore($batchPayload);
    }
}
