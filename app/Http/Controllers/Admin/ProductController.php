<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = "";
            $query = Product::leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', 'brands.id')
            ->leftJoin('units', 'products.unit_id', 'units.id');

            if($request->status){
                $query->where('products.status', $request->status);
            }

            $products = $query->select('products.*', 'categories.category_name', 'brands.brand_name', 'units.unit_name')->get();

            return Datatables::of($products)
                    ->addIndexColumn()
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
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm viewBtn" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-regular fa-pen-to-square"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBtn"><i class="fa-solid fa-trash-can"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }

        $categories = Category::where('status', 'Active')->get();
        $brands = Brand::where('status', 'Active')->get();
        $units = Unit::where('status', 'Active')->get();
        return view('admin.product.index', compact('categories', 'brands', 'units'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'product_name' => 'required|unique:products',
            'product_photo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $product_code = Str::random(10);
            $product_id = Product::insertGetId([
                'category_id' => $request->category_id,
                'product_name' => $request->product_name,
                'product_code' => $product_code,
                'brand_id' => $request->brand_id,
                'unit_id' => $request->unit_id,
                'selling_price' => $request->selling_price,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            if($request->hasFile('product_photo')){
                $product_photo_name =  $product_id."-".$request->product_name."-Photo".".". $request->file('product_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/product_photo/").$product_photo_name;
                Image::make($request->file('product_photo'))->resize(600, 600)->save($upload_link);
                Product::find($product_id)->update([
                    'product_photo' => $product_photo_name,
                    'updated_by' => Auth::user()->id
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Product store successfully.',
            ]);
        }
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        return view('admin.product.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'product_name' => 'required|unique:products,product_name,'. $product->id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if($product->purchase_price > $request->selling_price){
                return response()->json([
                    'status' => 401,
                    'message' => 'Product selling price is not less than Product purchase price.',
                ]);
            }else{
                $product_code = Str::random(10);
                $product->update([
                    'category_id' => $request->category_id,
                    'product_name' => $request->product_name,
                    'product_code' => $product_code,
                    'brand_id' => $request->brand_id,
                    'unit_id' => $request->unit_id,
                    'selling_price' => $request->selling_price,
                    'updated_by' => Auth::user()->id,
                ]);

                if($request->hasFile('product_photo')){
                    if($product->product_photo != 'default_product_photo.jpg'){
                        unlink(base_path("public/uploads/product_photo/").$product->product_photo);
                    }
                    $product_photo_name =  $id."-".$request->product_name."-Photo".".". $request->file('product_photo')->getClientOriginalExtension();
                    $upload_link = base_path("public/uploads/product_photo/").$product_photo_name;
                    Image::make($request->file('product_photo'))->resize(600, 600)->save($upload_link);
                    $product->update([
                        'product_photo' => $product_photo_name,
                        'updated_by' => Auth::user()->id
                    ]);
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Product update successfully.',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        $product->updated_by = Auth::user()->id;
        $product->deleted_by = Auth::user()->id;
        $product->save();
        $product->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Product destroy successfully.',
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_products = "";
            $query = Product::onlyTrashed();
            $trashed_products = $query->get();

            return Datatables::of($trashed_products)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if (Auth::user()->role == 'Super Admin') {
                            $btn = '
                                <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm restoreBtn"><i class="fa-solid fa-rotate"></i></button>
                                <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm forceDeleteBtn"><i class="fa-solid fa-delete-left"></i></button>
                            ';
                            return $btn;
                        } else {
                            $btn = '
                                <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm restoreBtn"><i class="fa-solid fa-rotate"></i></button>
                            ';
                            return $btn;
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function restore($id)
    {
        Product::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Product::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'status' => 200,
            'message' => 'Product restore successfully.',
        ]);
    }

    public function forceDelete($id)
    {
        if(Product::onlyTrashed()->where('id', $id)->first()->product_photo != 'default_product_photo.jpg'){
            unlink(base_path("public/uploads/product_photo/").Product::onlyTrashed()->where('id', $id)->first()->product_photo);
        }
        Product::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'status' => 200,
            'message' => 'Product force delete successfully.',
        ]);
    }

    public function status($id)
    {
        $product = Product::where('id', $id)->first();
        if($product->status == "Active"){
            $product->update([
                'status' => "Inactive",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Product status inactive.',
            ]);
        }else{
            $product->update([
                'status' =>"Active",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Product status active.',
            ]);
        }
    }
}
