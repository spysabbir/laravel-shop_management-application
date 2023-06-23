<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;

class SellingReturnController extends Controller
{
    public function sellingReturn(){
        $customers = Customer::where('status', 'Active')->get();
        return view('admin.selling.return', compact('customers'));
    }
}
