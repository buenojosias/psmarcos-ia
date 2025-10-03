<?php

namespace App\Services;

use App\Enums\WeekdayEnum;
use App\Models\Question;

class VectorizeMassService
{
    static public function vectorizeMassData($mass)
    {
        $batchPayload['resource'] = 'missa';
        $batchPayload['name'] = $mass['name'];
        $batchPayload['model_id'] = $mass['id'];
        $batchPayload['doc_type'] = 'mass_data';
        $batchPayload['text'] = "Missa na {$mass['community']['name']}, " . strtolower($mass['weekday']->getLabel()) . " às {$mass['time']->format('H:i')}." . ($mass['note'] ? "\n Observação: {$mass['note']}" : '');

        $batchPayload['metadata'] = [
            'community' => $mass['community']['name'],
            'doc_type' => 'mass_data',
            'model_id' => $mass['id'] ?? null,
            'name' => $mass['name'] ?? null,
            'resource' => 'missa',
        ];

        if (isset($mass['note'])) {
            $batchPayload['metadata']['note'] = $mass['note'];
        }

        $batchPayload['metadata']['schedule'] = [
            'type' => 'recurrent',
            'weekday' => $mass['weekday']->value,
            'weekday_label' => $mass['weekday']->getLabel(),
            'time' => $mass['time']->format('H:i:s'),
        ];

        return VectorizeAndStoreQAService::vectorizeAndStore($batchPayload);
    }

    static public function vectorizeMassQuestions($mass)
    {
        $batchPayload['resource'] = 'missa';
        $batchPayload['name'] = $mass['name'];
        $batchPayload['model_id'] = $mass['id'];
        $batchPayload['question'] = $mass['question'];
        $batchPayload['answer'] = $mass['answer'];
        // $batchPayload['text'] = "**Pergunta:** {$mass['question']}**\n**Resposta:** {$mass['answer']}";

        $batchPayload['schedule'] = [
            'type' => 'recurrent',
            'weekday' => 'domingo',
            'time' => '10:00',
        ];
    }
}
