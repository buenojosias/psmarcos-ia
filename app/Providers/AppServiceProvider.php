<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
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
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        Blade::if('anyrole', function ($roles) {
            return auth()->check() && auth()->user()->hasAnyRole($roles);
        });

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
            ->table()
            ->block('table.td')
            ->replace('py-4', 'py-3');

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
