<?php

namespace App\Policies;

use App\Models\Mass;
use App\Models\User;

class MassPolicy
{
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['pascom']);
    }

    public function edit(User $user, Mass $mass)
    {
        if ($user->hasRole('pascom')) {
            return true;
        }

        return $mass->community->leaders->contains($user);
    }

    public function delete(User $user)
    {
        return $user->hasRole('pascom');
    }
}
