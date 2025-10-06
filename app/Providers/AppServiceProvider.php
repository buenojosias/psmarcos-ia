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
            'event' => \App\Models\Event::class,
            'mass' => \App\Models\Mass::class,
        ]);

        TallStackUi::personalize()
            ->layout()
            ->block('main', 'mx-auto max-w-full p-4 md:p-6');

        TallStackUi::personalize()
            ->button()
            ->block('wrapper.sizes.md')
            ->replace('text-md', 'text-sm')
            ->and()
            ->button()
            ->block('wrapper.sizes.sm')
            ->replace('text-md', 'text-xs');
    }
}
