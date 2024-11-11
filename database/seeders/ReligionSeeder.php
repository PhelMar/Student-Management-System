<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('religions')->insert([
            ['religion_name' => 'Catholic'],
            ['religion_name' => 'Islam'],
            ['religion_name' => 'Iglesia ni Cristo'],
            ['religion_name' => 'Aglipay'],
            ['religion_name' => 'Seventh-day Adventist'],
            ['religion_name' => 'One-Way'],
            ['religion_name' => 'Assembly'],
            ['religion_name' => 'Pentecostal'],
            ['religion_name' => 'Others'],
        ]);
    }
}
