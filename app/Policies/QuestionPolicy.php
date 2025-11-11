<?php

namespace App\Policies;

use App\Models\Community;
use App\Models\User;

class QuestionPolicy
{
    public function __construct() {
        //
    }

    public function vectorize(User $user)
    {
        return $user->hasRole('pascom');
    }
}
