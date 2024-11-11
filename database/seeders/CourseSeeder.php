<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("courses")->insert([
            ['course_name' => 'BSIT'],
            ['course_name' => 'BSTM'],
            ['course_name' => 'BSBA FM'],
            ['course_name' => 'BSBA MM'],
            ['course_name' => 'BEED'],
            ['course_name' => 'BSED VALUES'],
            ['course_name' => 'BSED ENGLISH'],
            ['course_name' => 'BSED SOCIAL STUDIES'],
            ['course_name' => 'BSCRIM'],
        ]);
    }
}
