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
        'current_province_id',
        'current_municipality_id',
        'current_barangay_id',
        'current_purok',
        'permanent_province_id',
        'permanent_municipality_id',
        'permanent_barangay_id',
        'permanent_purok',
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
        'fathers_province_id',
        'fathers_municipality_id',
        'fathers_barangay_id',
        'fathers_purok',
        'fathers_contact_no',
        'fathers_highest_education_id',
        'fathers_occupation',
        'fathers_religion_id',
        'number_of_fathers_sibling',
        'mothers_name',
        'mothers_birthdate',
        'mothers_place_of_birth',
        'mothers_province_id',
        'mothers_municipality_id',
        'mothers_barangay_id',
        'mothers_purok',
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
        'pwd_remarks_id',
        'ips',
        'ips_remarks',
        'solo_parent',
        'age',
        'four_ps',
        'scholarship',
        'scholarship_remarks',
    ];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucwords(strtolower($value));
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = ucwords(strtolower($value));
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords(strtolower($value));
    }

    public function setNickNameAttribute($value)
    {
        $this->attributes['nick_name'] = ucwords(strtolower($value));
    }

    public function setFathersNameAttribute($value)
    {
        $this->attributes['fathers_name'] = ucwords(strtolower($value));
    }

    public function setMothersNameAttribute($value)
    {
        $this->attributes['mothers_name'] = ucwords(strtolower($value));
    }

    public function setIncaseOfEmergencyAttribute($value)
    {
        $this->attributes['incase_of_emergency_name'] = ucwords(strtolower($value));
    }
    public function setPlaceOfBirthAttribute($value)
    {
        $this->attributes['place_of_birth'] = ucwords(strtolower($value));
    }
    public function setCurrentPurokAttribute($value)
    {
        $this->attributes['current_purok'] = ucwords(strtolower($value));
    }
    public function setPermanentPurokAttribute($value)
    {
        $this->attributes['permanent_purok'] = ucwords(strtolower($value));
    }
    public function setFacebookAccountAttribute($value)
    {
        $this->attributes['facebook_account'] = ucwords(strtolower($value));
    }
    public function setFathersPlaceOfBirthAttribute($value)
    {
        $this->attributes['fathers_place_of_birth'] = ucwords(strtolower($value));
    }
    public function setMothersPlaceOfBirthAttribute($value)
    {
        $this->attributes['mothers_place_of_birth'] = ucwords(strtolower($value));
    }
    public function setFathersPurokAttribute($value)
    {
        $this->attributes['fathers_purok'] = ucwords(strtolower($value));
    }
    public function setMothersPurokAttribute($value)
    {
        $this->attributes['mothers_purok'] = ucwords(strtolower($value));
    }
    public function setFathersOccupationAttribute($value)
    {
        $this->attributes['fathers_occupation'] = ucwords(strtolower($value));
    }
    public function setMothersOccupationAttribute($value)
    {
        $this->attributes['mothers_occupation'] = ucwords(strtolower($value));
    }
    public function setKindergartenAttribute($value)
    {
        $this->attributes['kindergarten'] = ucwords(strtolower($value));
    }
    public function setElementaryAttribute($value)
    {
        $this->attributes['elementary'] = ucwords(strtolower($value));
    }
    public function setJuniorHighAttribute($value)
    {
        $this->attributes['junior_high'] = ucwords(strtolower($value));
    }
    public function setSeniorHighAttribute($value)
    {
        $this->attributes['senior_high'] = ucwords(strtolower($value));
    }
    public function setIpsRemarksAttribute($value)
    {
        $this->attributes['ips_remarks'] = ucwords(strtolower($value));
    }
    public function setScholarshipRemarksAttribute($value)
    {
        $this->attributes['scholarship_remarks'] = ucwords(strtolower($value));
    }


    public function records()
    {
        return $this->hasMany(StudentRecord::class, 'student_id');
    }

    public function latestRecord()
    {
        return $this->hasOne(StudentRecord::class, 'student_id')->latestOfMany();
    }

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

    public function pwdRemarks()
    {
        return $this->belongsTo(PwdRemarks::class, 'pwd_remarks_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    public function parent_status()
    {
        return $this->belongsTo(ParentStatuses::class, 'parents_status_id');
    }
    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id');
    }
    public function violations()
    {
        return $this->hasMany(Violation::class, 'student_id', 'id_no');
    }

    public function clearance()
    {
        return $this->hasMany(Clearance::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'prov_code', 'prov_code');
    }
    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'current_municipality_id', 'citymun_code');
    }
    public function currentProvince()
    {
        return $this->belongsTo(Province::class, 'current_province_id', 'prov_code');
    }
    public function currentMunicipality()
    {
        return $this->belongsTo(Municipality::class, 'current_municipality_id', 'citymun_code');
    }
    public function currentBarangay()
    {
        return $this->belongsTo(Baranggay::class, 'current_barangay_id', 'brgy_code');
    }
    public function permanentProvince()
    {
        return $this->belongsTo(Province::class, 'permanent_province_id', 'prov_code');
    }
    public function permanentMunicipality()
    {
        return $this->belongsTo(Municipality::class, 'permanent_municipality_id', 'citymun_code');
    }
    public function permanentBarangay()
    {
        return $this->belongsTo(Baranggay::class, 'permanent_barangay_id', 'brgy_code');
    }

    public function fathersProvince()
    {
        return $this->belongsTo(Province::class, 'fathers_province_id', 'prov_code');
    }
    public function fathersMunicipality()
    {
        return $this->belongsTo(Municipality::class, 'fathers_municipality_id', 'citymun_code');
    }
    public function fathersBarangay()
    {
        return $this->belongsTo(Baranggay::class, 'fathers_barangay_id', 'brgy_code');
    }

    public function mothersProvince()
    {
        return $this->belongsTo(Province::class, 'mothers_province_id', 'prov_code');
    }
    public function mothersMunicipality()
    {
        return $this->belongsTo(Municipality::class, 'mothers_municipality_id', 'citymun_code');
    }
    public function mothersBarangay()
    {
        return $this->belongsTo(Baranggay::class, 'mothers_barangay_id', 'brgy_code');
    }
    public function organization()
    {
        return $this->hasMany(Organization::class, 'student_id', 'id_no');
    }
}
