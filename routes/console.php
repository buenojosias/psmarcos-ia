<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');

Schedule::call(function () {
    $notices = \App\Models\Notice::query()->where('expires_at', '<', date('Y-m-d'))->get();
    foreach ($notices as $notice) {
        $embeded = \App\Models\Document::where('resource', 'aviso')->where('model_id', $notice->id)->first();
        $notice->delete();
        if ($embeded) {
            $embeded->delete();
        }
    }
})->dailyAt('00:00');
