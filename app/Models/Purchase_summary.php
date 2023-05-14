<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_summary extends Model
{
    use HasFactory;
    protected $guarded = [];

    function relationtosupplier(){
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
    
    function relationtoproduct(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
