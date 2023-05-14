<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_cart extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    function relationtobrand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    function relationtounit(){
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }
}
