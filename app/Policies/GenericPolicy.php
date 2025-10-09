<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class GenericPolicy
{
    public function __construct()
    {
        //
    }

    protected string $ownerColumn = 'user_id';

    public function edit(User $user, Model $model): bool|Response
    {
        return $this->canModify($user, $model)
            ? Response::allow()
            : Response::deny('Ação não autorizada.');
    }

    public function delete(User $user, Model $model): bool|Response
    {
        return $this->canModify($user, $model)
            ? Response::allow()
            : Response::deny('Ação não autorizada.');
    }

    protected function canModify(User $user, Model $model): bool
    {
        // admin ou pascom pode sempre
        if ($user->hasAnyRole(['admin', 'pascom'])) {
            return true;
        }

        // coordinator ou secretary apenas se for dono
        if ($user->hasAnyRole(['coordinator', 'secretary'])) {
            return data_get($model, $this->ownerColumn) === $user->id;
        }

        return false;
    }
}
