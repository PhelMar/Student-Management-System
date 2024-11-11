<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('highest_education')->insert([
            ['highest_education_level' => 'Elementary Level'],
            ['highest_education_level' => 'High School Level'],
            ['highest_education_level' => 'Senior High School Level'],
            ['highest_education_level' => 'College Level'],
            ['highest_education_level' => 'Others'],
        ]);
    }
}
