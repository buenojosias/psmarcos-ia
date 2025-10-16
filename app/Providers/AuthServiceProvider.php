<?php

namespace App\Providers;

use App\Models\Community;
use App\Models\Pastoral;
use App\Policies\CommunityPolicy;
use App\Policies\PastoralPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Community::class => CommunityPolicy::class,
        Pastoral::class => PastoralPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });
    }
}
