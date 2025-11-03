<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function __construct() {
        //
    }

    public function create(User $user)
    {
        return $user->hasRole('pascom');
    }

    public function edit(User $user, Event $event)
    {
        if ($user->hasRole('pascom')) {
            return true;
        }

        return ($user->hasRole('coordinator') && $event->eventable->users->contains($user));
    }

    public function manage(User $user, Event $event)
    {
        if ($user->hasRole('pascom')) {
            return true;
        }

        return ($user->hasRole('coordinator') && $event->eventable->users->contains($user));
    }
}
