<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    public function students(){
        return $this->hasMany(Student::class, 'income_id');
    }
}
