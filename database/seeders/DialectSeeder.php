<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DialectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dialects')->insert([
            ['dialect_name' => 'Tagalog'],
            ['dialect_name' => 'Cebuano'],
            ['dialect_name' => 'Hiligaynon'],
            ['dialect_name' => 'Ilonggo'],
            ['dialect_name' => 'Ilocano'],
            ['dialect_name' => 'Bicol'],
            ['dialect_name' => 'Waray'],
            ['dialect_name' => 'Pangasinan'],
            ['dialect_name' => 'Maguindanao'],
            ['dialect_name' => 'Kapampangan'],
            ['dialect_name' => 'Others'],

        ]);
    }
}
