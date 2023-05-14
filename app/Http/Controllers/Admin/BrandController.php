<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $brands = "";
            $query = Brand::select('brands.*');

            if($request->status){
                $query->where('brands.status', $request->status);
            }

            $brands = $query->get();

            return Datatables::of($brands)
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
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-regular fa-pen-to-square"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBtn"><i class="fa-solid fa-trash-can"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }

        return view('admin.brand.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|unique:brands',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $brand_photo_name = Str::slug($request->brand_name)."-photo".".". $request->file('brand_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/brand_photo/").$brand_photo_name;
            Image::make($request->file('brand_photo'))->resize(330, 88)->save($upload_link);

            Brand::insert([
                'brand_name' => $request->brand_name,
                'brand_photo' => $brand_photo_name,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Brand store successfully.',
            ]);
        }
    }

    public function edit($id)
    {
        $brand = Brand::where('id', $id)->first();
        return response()->json($brand);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|unique:brands,brand_name,'. $brand->id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if($request->hasFile('brand_photo')){
                // unlink(base_path("public/uploads/brand_photo/").$brand->brand_photo);
                $brand_photo_name = Str::slug($request->brand_name)."-photo".".". $request->file('brand_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/brand_photo/").$brand_photo_name;
                Image::make($request->file('brand_photo'))->resize(330, 88)->save($upload_link);
                $brand->update([
                    'brand_photo' => $brand_photo_name,
                    'updated_by' => Auth::user()->id
                ]);
            }
            $brand->update([
                'brand_name' => $request->brand_name,
                'updated_by' => Auth::user()->id,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Brand updated successfully.',
            ]);
        }
    }

    public function destroy($id)
    {
        $brand = Brand::where('id', $id)->first();
        $brand->updated_by = Auth::user()->id;
        $brand->deleted_by = Auth::user()->id;
        $brand->save();
        $brand->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Brand destroy successfully.',
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_brands = "";
            $query = Brand::onlyTrashed();
            $trashed_brands = $query->get();

            return Datatables::of($trashed_brands)
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
        Brand::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Brand::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'status' => 200,
            'message' => 'Brand restore successfully.',
        ]);
    }

    public function forceDelete($id)
    {
        unlink(base_path("public/uploads/brand_photo/").Brand::onlyTrashed()->where('id', $id)->first()->brand_photo);
        Brand::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'status' => 200,
            'message' => 'Brand force delete successfully.',
        ]);
    }

    public function status($id)
    {
        $brand = Brand::where('id', $id)->first();
        if($brand->status == "Active"){
            $brand->update([
                'status' => "Inactive",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Brand status inactive.',
            ]);
        }else{
            $brand->update([
                'status' =>"Active",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Brand status active.',
            ]);
        }
    }
}
