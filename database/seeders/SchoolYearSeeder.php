<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('school_years')->insert([
            ['school_year_name' => '2024/2025'],
            ['school_year_name' => '2025/2026'],
            ['school_year_name' => '2026/2027'],
        ]);
    }
}
