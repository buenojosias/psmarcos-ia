<?php

namespace App\Services;

use App\Models\Document;
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
            self::deleteEmbeded($question);
        }

        return $question->delete();
    }

    static public function deleteEmbeded($question)
    {
        try {
            $doc = Document::where('doc_type', 'qa')
                ->where('resource', $question->questionable_type)
                ->where('model_id', $question->id)
                ->first();

            return $doc->delete();
            // \DB::connection('pgsql')->table(config('database.table_vector'))
            //     ->where('doc_type', 'qa')
            //     ->where('resource', $question->questionable_type)
            //     ->where('model_id', $question->id)
            //     ->delete();

            // return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
