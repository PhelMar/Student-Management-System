<?php

namespace App\Helpers;

use App\Models\SchoolYear;
use App\Models\Semester;
use Carbon\Carbon;

class SchoolHelper
{
    /**
     * Get the current school year and semester safely.
     *
     * @return array
     */
    public static function getCurrentSchoolYearAndSemester(): array
    {
        $month = Carbon::now()->month;

        // 1. Get latest school year (admin-added, safe way)
        $currentSchoolYear = SchoolYear::orderBy('id', 'desc')->first();

        // 2. Decide semester based on month
        if ($month >= 8 || $month <= 1) {
            $semesterName = '1st Semester'; // Aug–Jan
        } elseif ($month >= 2 && $month <= 6) {
            $semesterName = '2nd Semester'; // Feb–Jun
        } else {
            $semesterName = null; // July (no semester)
        }

        // 3. Find semester model
        $currentSemester = Semester::where('semester_name', $semesterName)->first();

        return [
            'school_year_id'   => $currentSchoolYear?->id,
            'semester_id'      => $currentSemester?->id,
            'school_year'      => $currentSchoolYear,
            'semester'         => $currentSemester,
        ];
    }
}
