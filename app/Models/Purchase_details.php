<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_details extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    function relationtobranch(){
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
    function relationtocategory(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    function relationtobrand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
    function relationtoproduct(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    function relationtounit(){
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }
}
