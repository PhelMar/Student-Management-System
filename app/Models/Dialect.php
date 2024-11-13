<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dialect extends Model
{

    protected $fillable = [
        'dialect_name',
    ];
    public function students(){
        return $this->hasMany(Student::class);
    }
}
