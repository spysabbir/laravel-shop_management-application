<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase_summary;
use App\Models\Selling_summary;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function dashboard()
    {
        $purchase_summaries = Purchase_summary::all();
        $selling_summaries = Selling_summary::all();
        $categories = Category::count();
        $brands = Brand::count();
        $products = Product::count();
        $customers = Customer::count();
        $suppliers = Supplier::count();
        return view('admin.dashboard', compact('purchase_summaries', 'selling_summaries', 'categories', 'brands', 'products', 'customers', 'suppliers'));
    }

    public function allAdministrator (Request $request)
    {
        if ($request->ajax()) {
            $all_administrator = "";
            $query = User::where('role', '!=', 'Super Admin');

            if($request->status){
                $query->where('users.status', $request->status);
            }
            if($request->role){
                $query->where('users.role', $request->role);
            }

            $all_administrator = $query->get();

            return Datatables::of($all_administrator)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                        ';
                    })
                    ->editColumn('profile_photo', function($row){
                        return '<img src="'.asset('uploads/profile_photo').'/'.$row->profile_photo.'" width="40" >';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Active"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm statusBtn"><i class="fa-solid fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm statusBtn"><i class="fa-solid fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('role', function($row){
                        if($row->role == "Admin"){
                            return'
                            <span class="badge bg-success">'.$row->role.'</span>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->role.'</span>
                            ';
                        }
                    })
                    ->addColumn('last_active', function($row){
                        return'
                        <span class="badge bg-primary">'.date('d-M-Y h:m:s A', strtotime($row->last_active)).'</span>
                        ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-regular fa-pen-to-square"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['created_at', 'profile_photo', 'status', 'role', 'last_active', 'action'])
                    ->make(true);
        }

        $branches = Branch::whereStatus('Active')->get();
        return view('admin.administrator.index', compact('branches'));
    }

    public function administratoreEdit($id)
    {
        $administratore = User::where('id', $id)->first();
        return response()->json($administratore);
    }

    public function administratoreUpdate(Request $request, $id)
    {
        $administratore = User::where('id', $id)->first();

        if ($request->role == "Admin") {
            $branch_id = 'nullable';
        } else {
            $branch_id = 'required';
        }

        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'branch_id' => $branch_id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $administratore->update([
                'role' => $request->role,
                'branch_id' => $request->branch_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Administrator update successfully',
            ]);
        }
    }

    public function administratorStatus($id)
    {
        $administrator = User::where('id', $id)->first();
        if($administrator->status == "Active"){
            $administrator->update([
                'status' => "Inactive",
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Administrator status inactive.',
            ]);
        }else{
            $administrator->update([
                'status' =>"Active",
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Administrator status active.',
            ]);
        }
    }

    public function stockProducts(Request $request)
    {
        if ($request->ajax()) {
            $products = "";
            $query = Product::select('products.*');

            if($request->category_id){
                $query->where('products.category_id', $request->category_id);
            }

            if($request->brand_id){
                $query->where('products.brand_id', $request->brand_id);
            }

            $products = $query->get();
            return Datatables::of($products)
                    ->addIndexColumn()
                    ->editColumn('category_name', function($row){
                        return'
                        <span class="badge bg-info">'.$row->relationtocategory->category_name.'</span>
                        ';
                    })
                    ->editColumn('brand_name', function($row){
                        return'
                        <span class="badge bg-info">'.$row->relationtobrand->brand_name.'</span>
                        ';
                    })
                    ->editColumn('unit_name', function($row){
                        return'
                        <span class="badge bg-info">'.$row->relationtounit->unit_name.'</span>
                        ';
                    })
                    ->editColumn('profit', function($row){
                        return'
                        <span class="badge bg-success">'.$row->selling_price - $row->purchase_price.'</span>
                        ';
                    })
                    ->editColumn('stock', function($row){
                        return'
                        <span class="badge bg-success">'.$row->purchase_quantity - $row->selling_quantity.'</span>
                        ';
                    })
                    ->rawColumns(['category_name', 'brand_name', 'unit_name', 'profit', 'stock'])
                    ->make(true);
        }

        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.stock_products.index', compact('categories', 'brands'));
    }
}
