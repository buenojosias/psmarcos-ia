<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function __invoke()
    {
        $masses = \DB::connection('pgsql')
                    ->table('documents')
                    ->where('resource', 'missa')
                    ->select('id', 'resource', 'name', 'model_id', 'doc_type', 'content', 'metadata', 'tsv')
                    ->get();

        return response()->json($masses);
    }
}
