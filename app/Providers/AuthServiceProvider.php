<?php

namespace App\Providers;

use App\Models\Community;
use App\Models\Pastoral;
use App\Policies\CommunityPolicy;
use App\Policies\EventPolicy;
use App\Policies\PastoralPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Opcodes\LogViewer\Facades\LogViewer;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Community::class => CommunityPolicy::class,
        Pastoral::class => PastoralPolicy::class,
        Event::class => EventPolicy::class,
        User::class => UserPolicy::class,
        Question::class => QuestionPolicy::class,
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

        LogViewer::auth(function ($request) {
            return $request->user()->hasRole('admin');
        });
    }
}
