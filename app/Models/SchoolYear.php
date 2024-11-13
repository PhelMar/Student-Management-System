<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $fillable = [
        'school_year_name',
    ];
    public function students(){
        return $this->hasMany(Student::class);
    }
    public function violations(){
        return $this->hasMany(Violation::class);
    }
}
