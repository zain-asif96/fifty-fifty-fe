<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles
{

    public function assignRole($role): void
    {
        $this->roles()->save($role);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasRole($roleName): bool
    {
        return !!$this->roles()->where('name', $roleName)->first();
    }

    public function hasAnyRole(array $roleNames): bool
    {
        return !!$this->roles()->whereIn('name', $roleNames)->first();
    }
}
