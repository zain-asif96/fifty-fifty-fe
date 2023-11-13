<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $superAdmin = User::factory(1)
            ->create([
                    'first_name' => 'Super',
                    'last_name' => 'Admin',
                    'email' => 'super_admin@fiftydomain.com',
                    'country' => 'CA',
                    'password' => Hash::make('super_administrator'),
                ]
            )->first();

        $superAdmin->assignRole(Role::superAdmin());

        $admin = User::factory(1)
            ->create([
                    'first_name' => 'Editor',
                    'last_name' => 'Admin',
                    'email' => 'editor_admin@fiftydomain.com',
                    'country' => 'CA',
                    'password' => Hash::make('editor_administrator'),
                ]
            )->first();

        $admin->assignRole(Role::admin());


        $manager = User::factory(1)
            ->create([
                    'first_name' => 'Manager',
                    'last_name' => 'Admin',
                    'email' => 'manager_admin@fiftydomain.com',
                    'country' => 'CA',
                    'password' => Hash::make('manager_administrator'),
                ]
            )->first();

        $manager->assignRole(Role::manager());
    }
}
