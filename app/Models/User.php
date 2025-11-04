<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
        'created_by',
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

    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class)
            ->withPivot('is_leader');
    }

    public function pastorals(): BelongsToMany
    {
        return $this->belongsToMany(Pastoral::class)
            ->withPivot('is_leader');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function children(): HasMany
    {
        return $this->hasMany(User::class, 'created_by');
    }
}
