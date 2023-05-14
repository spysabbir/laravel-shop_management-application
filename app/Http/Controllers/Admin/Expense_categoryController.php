<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense_category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class Expense_categoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $expense_categories = "";
            $query = Expense_category::select('expense_categories.*');

            if($request->status){
                $query->where('expense_categories.status', $request->status);
            }

            $expense_categories = $query->get();

            return Datatables::of($expense_categories)
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

        return view('admin.expense_category.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expense_category_name' => 'required|unique:expense_categories',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            Expense_category::insert([
                'expense_category_name' => $request->expense_category_name,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Expense category store successfully.',
            ]);
        }
    }

    public function edit($id)
    {
        $expense_category = Expense_category::where('id', $id)->first();
        return response()->json($expense_category);
    }

    public function update(Request $request, $id)
    {
        $expense_category = Expense_category::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'expense_category_name' => 'required|unique:expense_categories,expense_category_name,'. $expense_category->id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $expense_category->update([
                'expense_category_name' => $request->expense_category_name,
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Expense category update successfully.',
            ]);
        }
    }

    public function destroy($id)
    {
        $expense_category = Expense_category::where('id', $id)->first();
        $expense_category->updated_by = Auth::user()->id;
        $expense_category->deleted_by = Auth::user()->id;
        $expense_category->save();
        $expense_category->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Expense category destroy successfully.',
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_expense_categories = "";
            $query = Expense_category::onlyTrashed();
            $trashed_expense_categories = $query->get();

            return Datatables::of($trashed_expense_categories)
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
        Expense_category::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Expense_category::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'status' => 200,
            'message' => 'Expense category restore successfully.',
        ]);
    }

    public function forceDelete($id)
    {
        Expense_category::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'status' => 200,
            'message' => 'Expense category force delete successfully.',
        ]);
    }

    public function status($id)
    {
        $expense_category = Expense_category::where('id', $id)->first();
        if($expense_category->status == "Active"){
            $expense_category->update([
                'status' => "Inactive",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Expense category status inactive.',
            ]);
        }else{
            $expense_category->update([
                'status' =>"Active",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Expense category status active.',
            ]);
        }
    }
}
