<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CourseSeeder::class,
            DialectSeeder::class,
            EducationSeeder::class,
            GenderSeeder::class,
            IncomeSeeder::class,
            ParentsStatusSeeder::class,
            ReligionSeeder::class,
            SemesterSeeder::class,
            StaySeeder::class,
            YearSeeder::class,
            SchoolYearSeeder::class,
            ViolationsTypeSeeder::class,
            AdminSeeder::class,
            OrganizationTypeSeeder::class,
            PositionSeeder::class,
            ProvinceSeeder::class,
            MunicipalitySeeder::class,
            BaranggaySeeder::class,
        ]);
    }
}
