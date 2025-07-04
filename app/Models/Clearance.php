<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    protected $table = 'tbl_clearances';

    protected $fillable = [
        'student_id',
        'course_id',
        'year_id',
        'semester_id',
        'school_year_id',
        'control_no',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id_no');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id', 'id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id', 'id');
    }
}