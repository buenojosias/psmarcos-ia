<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function __construct()
    {
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

        if ($event->eventable_type === 'service') {
            return $user->hasRole('secretary');
        }

        return $event->eventable?->users->contains($user);
    }

    public function manage(User $user, Event $event)
    {
        if ($user->hasRole('pascom')) {
            return true;
        }

        if ($event->eventable_type === 'service') {
            return $user->hasRole('secretary');
        }

        return $event->eventable?->users->contains($user);
    }
}
