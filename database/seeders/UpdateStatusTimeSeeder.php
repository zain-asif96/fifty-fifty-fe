<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\UpdateStatusTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateStatusTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UpdateStatusTime::create([
            'model_name' => 'App\Models\Post',
            'status' => Post::ON_HOLD,
            'time' => 6000,
        ]);

        UpdateStatusTime::create([
            'model_name' => 'App\Models\Transaction',
            'time' => 6000,
        ]);
    }
}
