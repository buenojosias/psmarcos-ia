<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'roles' => 'array',
        ];
    }

    // Retorna array (sempre) — facilita uso nas views
    public function getRolesArray(): array
    {
        return $this->roles ?? [];
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRolesArray(), true);
    }

    /** aceita string ou array */
    public function hasAnyRole(array|string $roles): bool
    {
        $roles = (array) $roles;
        return count(array_intersect($roles, $this->getRolesArray())) > 0;
    }

    public function pastorals()
    {
        return $this->hasMany(Pastoral::class);
    }
}
