<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationsType extends Model
{
    use HasFactory;

    protected $table = 'violations_type';

    public function violations(){
        return $this->hasMany(Violation::class, 'violations_type_id');
    }
}
