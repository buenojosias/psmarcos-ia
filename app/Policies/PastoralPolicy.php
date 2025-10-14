<?php

namespace App\Policies;

use App\Models\Pastoral;
use App\Models\User;

class PastoralPolicy
{
    public function __construct() {
        //
    }

    public function create(User $user)
    {
        return $user->hasRole('pascom');
    }

    public function edit(User $user, Pastoral $pastoral)
    {
        if ($user->hasRole('pascom')) {
            return true;
        }

        return ($user->hasRole('coordinator') && $pastoral->leaders->contains($user));
    }

    public function manage(User $user, Pastoral $pastoral)
    {
        if ($user->hasRole('pascom')) {
            return true;
        }

        return ($user->hasRole('coordinator') && $pastoral->leaders->contains($user));
    }
}
