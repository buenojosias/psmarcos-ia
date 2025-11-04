<?php

namespace App\Services;

use App\Models\Suggestion;

class DeleteQuestionService
{
    static public function execute(int $id)
    {
        $question = \App\Models\Question::find($id);

        if (!$question) {
            return false;
        }

        if ($question->suggestion_id) {
            Suggestion::find($question->suggestion_id)->decrement('usages');
        }

        if ($question->status->value == 'processed') {
            \DB::connection('pgsql')->table(config('database.table_vector'))
                ->where('doc_type', 'qa')
                ->where('resource', $question->resource)
                ->where('model_id', $question->id)
                ->delete();
        }

        return $question->delete();
    }
}
