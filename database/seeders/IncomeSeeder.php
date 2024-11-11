<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("incomes")->insert([
            ['income_base' => 'Below ₱10,000'],
            ['income_base' => '₱10,000-₱20,000'],
            ['income_base' => '₱20,000-₱30,000'],
            ['income_base' => 'Above ₱30,000'],
        ]);
    }
}
