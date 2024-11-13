<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    protected $fillable = [
        'religion_name',
    ];
    public function students(){
        return $this->hasMany(Student::class);
    }
}
