<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    public function purchaseReturn(){
        $suppliers = Supplier::where('status', 'Active')->get();
        return view('admin.purchase.return', compact('suppliers'));
    }
}
