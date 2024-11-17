<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $table = 'provinces';
    protected $fillable = ['psgc_code', 'prov_desc', 'reg_code', 'prov_code'];
    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'prov_code', 'prov_code');
    }
    public function student(){
        return $this->belongsTo(Student::class,'prov_code', 'prov_code');
    }
}
