<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use TallStackUi\Facades\TallStackUi;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Relation::morphMap([
            'community' => \App\Models\Community::class,
            'pastoral' => \App\Models\Pastoral::class,
        ]);

        TallStackUi::personalize()
            ->layout()
            ->block('main', 'mx-auto max-w-full p-6');
    }
}
