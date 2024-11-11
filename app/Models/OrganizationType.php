<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    public function organizations(){
        return $this->hasMany(Organization::class, 'organization_types_id');
    }
}
