<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            ['positions_name' => 'President'],
            ['positions_name' => 'Vice President'],
            ['positions_name' => 'Secretary'],
            ['positions_name' => 'Treasurer'],
            ['positions_name' => 'Auditor'],
            ['positions_name' => 'P.I.O'],
            ['positions_name' => 'Governor'],
            ['positions_name' => 'Vice Governor'],
        ]);
    }
}
