<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{

    protected $fillable = [
        'stay_name'
    ];
    public function students(){
        return $this->hasMany(Student::class);
    }
    public function violations(){
        return $this->hasMany(Violation::class);
    }
}
