<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PwdRemarks extends Model
{
    public function students()
{
    return $this->hasMany(Student::class, 'pwd_remarks_id');
}
}
