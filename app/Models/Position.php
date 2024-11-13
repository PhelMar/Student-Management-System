<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    protected $fillable = [
        'positions_name',
    ];
    public function organizations(){
        return $this->hasMany(Organization::class, 'positions_id');
    }
}
