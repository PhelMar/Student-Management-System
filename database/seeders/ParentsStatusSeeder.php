<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentsStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parent_statuses')->insert([
            ['status' => 'Married and Living Together'],
            ['status' => 'Permanently Separated'],
            ['status' => 'Marriage Anulled/Legally Separated'],
            ['status' => 'Both with Other Partner'],
            ['status' => 'Father/Mother with another partner'],
            ['status' => 'Temporarily Separated'],
            ['status' => 'Father OFW'],
            ['status' => 'Mother OFW'],
            ['status' => 'Not Married'],
        ]);
    }
}
