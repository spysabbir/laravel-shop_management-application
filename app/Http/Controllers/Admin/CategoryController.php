<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = "";
            $query = Category::select('categories.*');

            if($request->status){
                $query->where('categories.status', $request->status);
            }

            $categories = $query->get();

            return Datatables::of($categories)
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

        return view('admin.category.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories',
            'category_photo' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $category_photo_name = Str::slug($request->category_name)."-photo".".". $request->file('category_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/category_photo/").$category_photo_name;
            Image::make($request->file('category_photo'))->resize(400, 450)->save($upload_link);

            Category::insert([
                'category_name' => $request->category_name,
                'category_photo' => $category_photo_name,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Category store successfully.',
            ]);
        }
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories,category_name,'. $category->id,
            'category_photo' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if($request->hasFile('category_photo')){
                unlink(base_path("public/uploads/category_photo/").$category->category_photo);
                $category_photo_name = Str::slug($request->category_name)."-photo".".". $request->file('category_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/category_photo/").$category_photo_name;
                Image::make($request->file('category_photo'))->resize(400, 450)->save($upload_link);
                $category->update([
                    'category_photo' => $category_photo_name,
                    'updated_by' => Auth::user()->id
                ]);
            }
            $category->update([
                'category_name' => $request->category_name,
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Category update successfully.',
            ]);
        }
    }

    public function destroy($id)
    {
        $category = Category::where('id', $id)->first();
        $category->updated_by = Auth::user()->id;
        $category->deleted_by = Auth::user()->id;
        $category->save();
        $category->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Category destroy successfully.',
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_categories = "";
            $query = Category::onlyTrashed();
            $trashed_categories = $query->get();

            return Datatables::of($trashed_categories)
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
        Category::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Category::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'status' => 200,
            'message' => 'Category restore successfully.',
        ]);
    }

    public function forceDelete($id)
    {
        unlink(base_path("public/uploads/category_photo/").Category::onlyTrashed()->where('id', $id)->first()->category_photo);
        Category::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'status' => 200,
            'message' => 'Category force delete successfully.',
        ]);
    }

    public function status($id)
    {
        $category = Category::where('id', $id)->first();
        if($category->status == "Active"){
            $category->update([
                'status' => "Inactive",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Category status inactive.',
            ]);
        }else{
            $category->update([
                'status' =>"Active",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Category status active.',
            ]);
        }
    }
}
