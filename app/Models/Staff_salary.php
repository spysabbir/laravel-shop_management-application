<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff_salary extends Model
{
    use HasFactory;

    function relationtostaff(){
        return $this->hasOne(Staff::class, 'id', 'staff_id');
    }
}
