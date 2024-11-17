<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(database_path('seeders/csv/refprovince.csv'), 'r');
        fgetcsv($file); // Skip the header

        while (($data = fgetcsv($file)) !== false) {
            try {
                // Check if the record already exists
                $exists = DB::table('provinces')->where('psgc_code', $data[1])->exists();

                if (!$exists) {
                    DB::table('provinces')->insert([
                        'id' => $data[0],
                        'psgc_code' => $data[1],
                        'prov_desc' => $data[2],
                        'reg_code' => $data[3],
                        'prov_code' => $data[4],
                    ]);
                } else {
                    // Log if skipping a duplicate
                    echo "Duplicate entry skipped: {$data[1]}\n";
                }
            } catch (\Exception $e) {
                // Log the error with the problematic data
                dd('Error inserting row:', $data, $e->getMessage());
            }
        }

        fclose($file);
    }
}
