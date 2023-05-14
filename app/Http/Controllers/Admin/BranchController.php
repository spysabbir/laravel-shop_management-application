<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
class BranchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $branches = "";
            $query = Branch::select('branches.*');

            if($request->status){
                $query->where('branches.status', $request->status);
            }

            $branches = $query->get();

            return Datatables::of($branches)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                        ';
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
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm viewBtn" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-regular fa-pen-to-square"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBtn"><i class="fa-solid fa-trash-can"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['created_at', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.branch.index');
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
            Branch::insert([
                'branch_name' => $request->branch_name,
                'branch_email' => $request->branch_email,
                'branch_phone_number' => $request->branch_phone_number,
                'branch_address' => $request->branch_address,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Branch store successfully.',
            ]);
        }
    }

    public function show($id)
    {
        $branch = Branch::where('id', $id)->first();
        return view('admin.branch.show', compact('branch'));
    }

    public function edit($id)
    {
        $branch = Branch::where('id', $id)->first();
        return response()->json($branch);
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $branch->update([
                'branch_name' => $request->branch_name,
                'branch_email' => $request->branch_email,
                'branch_phone_number' => $request->branch_phone_number,
                'branch_address' => $request->branch_address,
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Branch update successfully.',
            ]);
        }
    }

    public function destroy($id)
    {
        $branch = Branch::where('id', $id)->first();
        $branch->updated_by = Auth::user()->id;
        $branch->deleted_by = Auth::user()->id;
        $branch->save();
        $branch->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Branch destroy successfully.',
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_branches = "";
            $query = Branch::onlyTrashed();
            $trashed_branches = $query->get();

            return Datatables::of($trashed_branches)
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
        Branch::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Branch::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'status' => 200,
            'message' => 'Branch restore successfully.',
        ]);
    }

    public function forceDelete($id)
    {
        Branch::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'status' => 200,
            'message' => 'Branch force delete successfully.',
        ]);
    }

    public function status($id)
    {
        $branch = Branch::where('id', $id)->first();
        if($branch->status == "Active"){
            $branch->update([
                'status' => "Inactive",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Branch status inactive.',
            ]);
        }else{
            $branch->update([
                'status' =>"Active",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Branch status active.',
            ]);
        }
    }
}
