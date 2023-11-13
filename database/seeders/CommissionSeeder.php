<?php

namespace Database\Seeders;

use App\Models\Commission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Commission::create([
            'from' => 0,
            'to' => 99,
            'amount' => 10,
        ]);

        Commission::create([
            'from' => 100,
            'to' => 499,
            'amount' => 20,
        ]);

        Commission::create([
            'from' => 500,
            'to' => 1000,
            'amount' => 30,
        ]);
    }
}
