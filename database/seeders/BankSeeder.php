<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first = include('Banks/firstList.php');
        $second = include('Banks/secondList.php');
        $third = include('Banks/thirdList.php');
        $fourth = include('Banks/fourthList.php');
        $fifth = include('Banks/fifthList.php');
        $sixth = include('Banks/sixthList.php');
        $seventh = include('Banks/seventhList.php');


        DB::table('banks')->insert([
            ...$first,
            ...$second,
            ...$third,
            ...$fourth,
            ...$fifth,
            ...$sixth,
            ...$seventh,
        ]);
    }
}
