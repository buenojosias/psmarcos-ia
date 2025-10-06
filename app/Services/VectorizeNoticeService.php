<?php

namespace App\Services;

class VectorizeNoticeService
{
    static public function vectorizeNoticeData($resource, $notice)
    {
        $batchPayload['resource'] = 'aviso';
        $batchPayload['name'] = $notice['notifiable']['name'];
        $batchPayload['model_id'] = $notice['id'];
        $batchPayload['doc_type'] = 'notice_data';
        $batchPayload['text'] = $notice['content'];

        $batchPayload['metadata'] = [
            'resource' => 'aviso',
            // "{$resource}" => $notice['notifiable']['name'],
            'doc_type' => 'notice_data',
            'model_id' => $notice['id'],
            'expires_at' => $notice['expires_at'],
        ];
        $batchPayload['metadata'][$resource] = $notice['notifiable']['name'];

        return EmbedAndStoreService::vectorizeAndStore($batchPayload);
    }
}
