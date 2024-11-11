<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organization_types')->insert([
            ['organization_name' => 'CSG Organization'],
            ['organization_name' => 'DYISTS Organization'],
            ['organization_name' => 'ADEP Organization'],
            ['organization_name' => 'CRIMSOC Organization'],
        ]);
    }
}
