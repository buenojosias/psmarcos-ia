<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class UserPolicy
{
    public function __construct() {
        //
    }

    public function any(User $user)
    {
        // return true;
        return $user->hasRole('pascom');
    }

    public function editAdmin(User $auth, User $user)
    {
        if ($user->hasRole('admin')) {
            return false;
        }
        return true;
    }

    public function edit(User $auth, User $user)
    {
        if ($auth->hasRole('pascom')) {
            return true;
        }

        return $user->created_by === $auth->id;
    }

    // public function manage(User $user, Event $event)
    // {
    //     if ($user->hasRole('pascom')) {
    //         return true;
    //     }

    //     return $event->eventable?->users->contains($user);
    // }
}
