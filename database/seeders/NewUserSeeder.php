<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fifty_user_1 = User::factory(1)
            ->create([
                    'first_name' => 'Anya',
                    'last_name' => 'Foley',
                    'email' => 'anya_folay@fiftydomain.com',
                    'country' => 'CA',
                    'password' => Hash::make('password'),
                ]
            )->first();

        $fifty_user_2 = User::factory(1)
            ->create([
                    'first_name' => 'Aaron',
                    'last_name' => 'Lambert',
                    'email' => 'aaron_lambert@fiftydomain.com',
                    'country' => 'CA',
                    'password' => Hash::make('password'),
                ]
            )->first();

        $fifty_user_3 = User::factory(1)
            ->create([
                    'first_name' => 'Trinity',
                    'last_name' => 'May',
                    'email' => 'trinity_may@fiftydomain.com',
                    'country' => 'CA',
                    'password' => Hash::make('password'),
                ]
            )->first();


        $fifty_user_4 = User::factory(1)
            ->create([
                    'first_name' => 'Raphael',
                    'last_name' => 'Woods',
                    'email' => 'raphael_woods@fiftydomain.com',
                    'country' => 'CA',
                    'password' => Hash::make('password'),
                ]
            )->first();


        $fifty_user_5 = User::factory(1)
            ->create([
                    'first_name' => 'Nataly',
                    'last_name' => 'Serrano',
                    'email' => 'nataly_serrano@fiftydomain.com',
                    'country' => 'CA',
                    'password' => Hash::make('password'),
                ]
            )->first();


        $fifty_user_6 = User::factory(1)
            ->create([
                    'first_name' => 'Clark',
                    'last_name' => 'Padilla',
                    'email' => 'clark_padilla@fiftydomain.com',
                    'country' => 'CA',
                    'password' => Hash::make('password'),
                ]
            )->first();


        $fifty_user_1->assignRole(Role::fiftyUser());
        $fifty_user_2->assignRole(Role::fiftyUser());
        $fifty_user_3->assignRole(Role::fiftyUser());
        $fifty_user_4->assignRole(Role::fiftyUser());
        $fifty_user_5->assignRole(Role::fiftyUser());
        $fifty_user_6->assignRole(Role::fiftyUser());

    }
}
