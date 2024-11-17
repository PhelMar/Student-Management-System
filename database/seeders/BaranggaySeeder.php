<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaranggaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(database_path('seeders/csv/refbrgy.csv'), 'r');

        // Skip the header
        fgetcsv($file);

        try {
            while (($data = fgetcsv($file)) !== false) {
                DB::table('baranggays')->insert([
                    'id' => $data[0],
                    'brgy_code' => $data[1],
                    'brgy_desc' => $data[2],
                    'reg_code' => $data[3],
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
