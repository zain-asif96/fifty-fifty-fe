<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            CurrencySeeder::class,
            CountrySeeder::class,
            BankSeeder::class,
            AbilitySeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            NewRoleSeeder::class,
            NewUserSeeder::class,
            UpdateStatusTimeSeeder::class,
            CommissionSeeder::class,
        ]);
    }
}
