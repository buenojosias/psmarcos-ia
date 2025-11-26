<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function __construct() {
        //
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['pascom', 'secretary']);
    }

    public function edit(User $user, Service $service)
    {
        return $user->hasAnyRole(['pascom', 'secretary']);
    }

    public function manage(User $user, Service $service)
    {
        return $user->hasAnyRole(['pascom', 'secretary']);
    }
}
