<?php

namespace App\Services;

class DeleteQuestionService
{
    static public function execute(int $id)
    {
        $question = \App\Models\Question::find($id);

        if (!$question) {
            return false;
        }

        if ($question->status->value == 'processed') {
            \DB::connection('pgsql')->table(config('database.table_vector'))
                ->where('model_id', $question->id)
                ->delete();
        }

        return $question->delete();
    }
}
