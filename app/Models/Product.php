<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    function relationtocategory(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    function relationtobrand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    function relationtounit(){
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }
}
