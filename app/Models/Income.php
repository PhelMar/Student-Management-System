<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{

    protected $fillable = [
        'income_base'
    ];
    public function students(){
        return $this->hasMany(Student::class, 'income_id');
    }
}
