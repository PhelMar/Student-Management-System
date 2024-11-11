<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'tbl_students';

    protected $fillable = [
        'id_no',
        'first_name',
        'middle_name',
        'last_name',
        'nick_name',
        'gender_id',
        'birthdate',
        'place_of_birth',
        'permanent_address',
        'current_address',
        'birth_order_among_sibling',
        'contact_no',
        'email_address',
        'facebook_account',
        'dialect_id',
        'student_religion_id',
        'stay_id',
        'fathers_name',
        'fathers_birthdate',
        'fathers_place_of_birth',
        'fathers_address',
        'fathers_contact_no',
        'fathers_highest_education_id',
        'fathers_occupation',
        'fathers_religion_id',
        'number_of_fathers_sibling',
        'mothers_name',
        'mothers_birthdate',
        'mothers_place_of_birth',
        'mothers_address',
        'mothers_contact_no',
        'mothers_highest_education_id',
        'mothers_occupation',
        'mothers_religion_id',
        'number_of_mothers_sibling',
        'income_id',
        'parents_status_id',
        'incase_of_emergency_name',
        'incase_of_emergency_contact',
        'kindergarten',
        'kindergarten_year_attended',
        'elementary',
        'elementary_year_attended',
        'junior_high',
        'junior_high_year_attended',
        'senior_high',
        'senior_high_year_attended',
        'pwd',
        'pwd_remarks',
        'ips',
        'ips_remarks',
        'solo_parent',
        'course_id',
        'year_id',
        'semester_id',
        'school_year_id',
        'age',
    ];
    public function dialect()
    {
        return $this->belongsTo(Dialect::class, 'dialect_id');
    }
    public function  FathersHighestEducation()
    {
        return $this->belongsTo(HighestEducation::class, 'fathers_highest_education_id');
    }
    public function MothersHighestEducation()
    {
        return $this->belongsTo(HighestEducation::class, 'mothers_highest_education_id');
    }
    public function income()
    {
        return $this->belongsTo(Income::class, 'income_id');
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }
    public function stay()
    {
        return $this->belongsTo(Stay::class, 'stay_id');
    }
    public function StudentsReligion()
    {
        return $this->belongsTo(Religion::class, 'student_religion_id');
    }
    public function FathersReligion()
    {
        return $this->belongsTo(Religion::class, 'fathers_religion_id');
    }
    public function MothersReligion()
    {
        return $this->belongsTo(Religion::class, 'mothers_religion_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    public function parent_status(){
        return $this->belongsTo(ParentStatuses::class, 'parents_status_id');
    }
    public function school_year(){
        return $this->belongsTo(SchoolYear::class, 'school_year_id');
    }
    public function violations(){
        return $this->hasMany(Violation::class, 'student_id', 'id_no');
    }
}
