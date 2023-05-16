<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffDesignation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StaffDesignationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $staff_designations = "";
            $query = StaffDesignation::select('staff_designations.*');

            if($request->status){
                $query->where('staff_designations.status', $request->status);
            }

            $staff_designations = $query->get();

            return Datatables::of($staff_designations)
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

        return view('admin.staff_designation.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designation_name' => 'required|unique:staff_designations',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            StaffDesignation::insert([
                'designation_name' => $request->designation_name,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Staff designation store successfully.',
            ]);
        }
    }

    public function edit($id)
    {
        $staff_designation = StaffDesignation::where('id', $id)->first();
        return response()->json($staff_designation);
    }

    public function update(Request $request, $id)
    {
        $staff_designation = StaffDesignation::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'designation_name' => 'required|unique:staff_designations,designation_name,'. $staff_designation->id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $staff_designation->update([
                'designation_name' => $request->designation_name,
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Staff designation update successfully.',
            ]);
        }
    }

    public function destroy($id)
    {
        $staff_designation = StaffDesignation::where('id', $id)->first();
        $staff_designation->updated_by = Auth::user()->id;
        $staff_designation->deleted_by = Auth::user()->id;
        $staff_designation->save();
        $staff_designation->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Staff designation destroy successfully.',
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_staff_designations = "";
            $query = StaffDesignation::onlyTrashed();
            $trashed_staff_designations = $query->get();

            return Datatables::of($trashed_staff_designations)
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
        StaffDesignation::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        StaffDesignation::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'status' => 200,
            'message' => 'Staff designation restore successfully.',
        ]);
    }

    public function forceDelete($id)
    {
        StaffDesignation::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'status' => 200,
            'message' => 'Staff designation force delete successfully.',
        ]);
    }

    public function status($id)
    {
        $staff_designation = StaffDesignation::where('id', $id)->first();
        if($staff_designation->status == "Active"){
            $staff_designation->update([
                'status' => "Inactive",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Staff designation status inactive.',
            ]);
        }else{
            $staff_designation->update([
                'status' =>"Active",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Staff designation status active.',
            ]);
        }
    }
}
