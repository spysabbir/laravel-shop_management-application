<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selling_summary extends Model
{
    use HasFactory;
    protected $guarded = [];

    function relationtocustomer(){
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    function relationtoproduct(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
