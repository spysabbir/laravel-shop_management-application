<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    function relationtobranch(){
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    function relationtostaffdesignation(){
        return $this->hasOne(StaffDesignation::class, 'id', 'staff_designation_id');
    }
}
