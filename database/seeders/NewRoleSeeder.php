<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fiftyUser = Role::create([
            'name' => 'fifty.user',
            'label' => 'Application Users for Posts'
        ]);
        $viewAbility = Ability::where('name', 'view')->first();
        $fiftyUser->allowTo($viewAbility);
    }
}
