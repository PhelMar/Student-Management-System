<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{

    use HasFactory;

    protected $table = 'municipalities';
    protected $fillable = ['psgc_code', 'citymun_desc', 'reg_desc', 'prov_code', 'citymun_code'];
    public function barangays()
    {
        return $this->hasMany(Baranggay::class, 'citymun_code', 'citymun_code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'prov_code', 'prov_code');
    }
}
