<?php


namespace App\Traits;


trait HasAbilities
{

    public function abilities()
    {
        return $this->roles->map->abilities->flatten()->pluck('name')->unique();
    }
}
