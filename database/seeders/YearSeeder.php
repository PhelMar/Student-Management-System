<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("years")->insert([
            ['year_name' => '1st Year'],
            ['year_name' => '2nd Year'],
            ['year_name' => '3rd Year'],
            ['year_name' => '4th Year'],
        ]);
    }
}
