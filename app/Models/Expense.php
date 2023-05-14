<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    function relationtoexpensecategory(){
        return $this->hasOne(Expense_category::class, 'id', 'expense_category_id');
    }
}
