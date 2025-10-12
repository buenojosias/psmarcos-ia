<?php

namespace App\Policies;

use App\Models\Community;
use App\Models\User;

class CommunityPolicy
{
    public function __construct() {
        //
    }

    public function create(User $user)
    {
        return $user->hasRole('pascom');
    }

    public function edit(User $user, Community $community)
    {
        if ($user->hasRole('pascom')) {
            return true;
        }

        return $community->leaders->contains($user);
    }

    public function manage(User $user, Community $community)
    {
        if ($user->hasRole('pascom')) {
            return true;
        }

        return $community->users->contains($user);
    }
}
