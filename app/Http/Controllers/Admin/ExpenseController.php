<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Expense_category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $expenses = "";
            $query = Expense::where('branch_id', Auth::user()->branch_id);

            if($request->status){
                $query->where('expenses.status', $request->status);
            }

            if($request->expense_category_id){
                $query->where('expenses.expense_category_id', $request->expense_category_id);
            }

            $expenses = $query->select('expenses.*')->get();

            return Datatables::of($expenses)
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

        $expense_categories = Expense_category::where('status', 'Active')->get();
        return view('admin.expense.index', compact('expense_categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            Expense::insert([
                'branch_id' => Auth::user()->branch_id,
                'expense_category_id' => $request->expense_category_id,
                'expense_date' => $request->expense_date,
                'expense_title' => $request->expense_title,
                'expense_cost' => $request->expense_cost,
                'expense_description' => $request->expense_description,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Expense store successfully.',
            ]);
        }
    }

    public function edit($id)
    {
        $expense = Expense::where('id', $id)->first();
        return response()->json($expense);
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $expense->update([
                'branch_id' => Auth::user()->branch_id,
                'expense_category_id' => $request->expense_category_id,
                'expense_date' => $request->expense_date,
                'expense_title' => $request->expense_title,
                'expense_cost' => $request->expense_cost,
                'expense_description' => $request->expense_description,
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Expense update successfully.',
            ]);
        }
    }

    public function destroy($id)
    {
        $expense = Expense::where('id', $id)->first();
        $expense->updated_by = Auth::user()->id;
        $expense->deleted_by = Auth::user()->id;
        $expense->save();
        $expense->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Expense destroy successfully.',
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_expenses = "";
            $query = Expense::onlyTrashed();
            $trashed_expenses = $query->get();

            return Datatables::of($trashed_expenses)
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
        Expense::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Expense::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'status' => 200,
            'message' => 'Expense restore successfully.',
        ]);
    }

    public function forceDelete($id)
    {
        Expense::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'status' => 200,
            'message' => 'Expense force delete successfully.',
        ]);
    }

    public function status($id)
    {
        $expense = Expense::where('id', $id)->first();
        if($expense->status == "Active"){
            $expense->update([
                'status' => "Inactive",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Expense status inactive.',
            ]);
        }else{
            $expense->update([
                'status' =>"Active",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Expense status active.',
            ]);
        }
    }
}
