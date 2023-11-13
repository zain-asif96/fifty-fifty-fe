<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('abilities')->insert([
            [
                'name' => 'super.edit',
                'label' => 'View and edit everything in the admin panel.',
            ],
            [
                'name' => 'edit',
                'label' => 'View and edit only some areas in the admin panel.',
            ],
            [
                'name' => 'view',
                'label' => 'View different information in the admin panel',
            ],
        ]);
    }
}
