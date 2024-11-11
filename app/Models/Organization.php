<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'tbl_organizations';
    protected $fillable = [
        'student_id', 'course_id', 'year_id', 'semester_id', 'school_year_id',
        'organization_types_id', 'positions_id', 'organization_date',
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id', 'id_no');
    }
    public function position(){
        return $this->belongsTo(Position::class,'positions_id');
    }
    public function organizationType(){
        return $this->belongsTo(OrganizationType::class,'organization_types_id');
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
