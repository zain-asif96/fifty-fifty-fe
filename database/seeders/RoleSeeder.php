<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $superAdmin = Role::create([
            'name' => 'super.admin',
            'label' => 'Application Super Administrator',
        ]);

        $admin = Role::create([
            'name' => 'admin',
            'label' => 'Application Administrator',
        ]);

        $manager = Role::create([
            'name' => 'manager',
            'label' => 'Application Manager',
        ]);

        $superEditAbility = Ability::where('name', 'super.edit')->first();
        $editAbility = Ability::where('name', 'edit')->first();
        $viewAbility = Ability::where('name', 'view')->first();

        $superAdmin->allowTo([$superEditAbility, $editAbility, $viewAbility]);

        $admin->allowTo($editAbility);

        $manager->allowTo($viewAbility);
    }
}
