<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(database_path('seeders/csv/refcitymun.csv'), 'r');

        // Skip the header
        fgetcsv($file);

        try {
            while (($data = fgetcsv($file)) !== false) {
                DB::table('municipalities')->insert([
                    'id' => $data[0],
                    'psgc_code' => $data[1],
                    'citymun_desc' => $data[2],
                    'reg_desc' => $data[3],
                    'prov_code' => $data[4],
                    'citymun_code' => $data[5],
                ]);
            }
        } catch (\Exception $e) {
            dd('Error inserting row:', $data, $e->getMessage());
        }

        fclose($file);
    }
}
