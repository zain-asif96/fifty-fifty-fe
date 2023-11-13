<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Role extends Model
{
    use HasFactory;

    public static function superAdmin()
    {
        return Role::where('name', 'super.admin')->first();
    }

    public static function admin()
    {
        return Role::where('name', 'admin')->first();
    }

    public static function manager()
    {
        return Role::where('name', 'manager')->first();
    }

    public static function fiftyUser()
    {
        return Role::where('name', 'fifty.user')->first();
    }

    public function allowTo($abilities): Model|array|Collection
    {

        if (is_array($abilities)) {
            return $this->abilities()->saveMany($abilities);
        }

        return $this->abilities()->save($abilities);
    }

    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(Ability::class)->withTimestamps();
    }
}
