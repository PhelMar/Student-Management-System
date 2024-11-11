<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("stays")->insert([
            ['stay_name' => 'Parents'],
            ['stay_name' => 'Relatives'],
            ['stay_name' => 'Own Family'],
            ['stay_name' => 'Alone/Dorm'],
            ['stay_name' => 'Others'],
        ]);
    }
}
