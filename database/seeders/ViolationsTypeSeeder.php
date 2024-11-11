<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViolationsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('violations_type')->insert([
            ['violation_type_name' => 'Bullying'],
            ['violation_type_name' => 'Disrespect'],
            ['violation_type_name' => 'Drunk'],
            ['violation_type_name' => 'Improper Haircut/Hair Color'],
            ['violation_type_name' => 'Non-wearing of school ID'],
            ['violation_type_name' => 'Non-wearing of school uniform'],
            ['violation_type_name' => 'Out of class without permission'],
            ['violation_type_name' => 'Repeated Class Disturbance'],
            ['violation_type_name' => 'Wearing of Earings(Male)'],
            ['violation_type_name' => 'Inappropriate behavior in hitting another student'],
            ['violation_type_name' => 'Cheating'],
            ['violation_type_name' => 'Dress Code Violation'],
            ['violation_type_name' => 'Gambling'],
            ['violation_type_name' => 'Littering'],
            ['violation_type_name' => 'Lying'],
            ['violation_type_name' => 'Smoking'],
            ['violation_type_name' => 'Using other ID'],
            ['violation_type_name' => 'Vandalism'],
        ]);
    }
}
