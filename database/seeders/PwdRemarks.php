<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PwdRemarks extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pwd_remarks')->insert([
            ['pwd_name' => 'Visual Impairments'],
            ['pwd_name' => 'Hearing Impairments'],
            ['pwd_name' => 'Intellectual Disability'],
            ['pwd_name' => 'Chronic Illness'],
            ['pwd_name' => 'Others'],
        ]);
    }
}
