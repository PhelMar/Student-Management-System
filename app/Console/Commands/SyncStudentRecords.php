<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\StudentRecord;

class SyncStudentRecords extends Command
{
    protected $signature = 'sync:student-records';
    protected $description = 'Sync missing student_records from tbl_students without duplicates';

    public function handle()
    {
        $this->info('Starting to sync missing student records...');

        // Chunking for memory efficiency
        Student::where('status', 'active')->chunk(100, function ($students) {
            foreach ($students as $student) {
                StudentRecord::firstOrCreate([
                    'student_id'     => $student->id,
                    'course_id'      => $student->course_id ?? null,
                    'year_id'        => $student->year_id ?? null,
                    'semester_id'    => $student->semester_id ?? null,
                    'school_year_id' => $student->school_year_id ?? null,
                ]);
            }
        });

        $this->info('Sync completed successfully!');
        return 0;
    }
}
