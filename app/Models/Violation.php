<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'course_id', 'year_id', 'semester_id', 'school_year_id',
        'violations_type_id', 'violations_level', 'remarks', 'violations_date',
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id', 'id_no');
    }
    public function violationType(){
        return $this->belongsTo(ViolationsType::class,'violations_type_id');
    }

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
    public function year(){
        return $this->belongsTo(Year::class,'year_id');
    }
    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id');
    }
    public function school_year(){
        return $this->belongsTo(SchoolYear::class,'school_year_id');
    }
}
