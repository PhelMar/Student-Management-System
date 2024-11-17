<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baranggay extends Model
{

    use HasFactory;

    protected $table = 'baranggays';
    protected $fillable = ['brgy_code', 'brgy_desc', 'reg_code', 'prov_code', 'citymun_code'];
    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'citymun_code', 'citymun_code');
    }
}
