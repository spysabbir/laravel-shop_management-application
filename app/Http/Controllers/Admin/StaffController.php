<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Expense;
use App\Models\Staff;
use App\Models\Staff_salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class StaffController extends Controller
{
    public function index (Request $request)
    {
        if ($request->ajax()) {
            $all_staff = "";
            $query = Staff::where('branch_id', Auth::user()->branch_id);

            if($request->status){
                $query->where('staff.status', $request->status);
            }

            if($request->staff_gender){
                $query->where('staff.staff_gender', $request->staff_gender);
            }

            if($request->branch_id){
                $query->where('staff.branch_id', $request->branch_id);
            }

            $all_staff = $query->select('staff.*')->get();

            return Datatables::of($all_staff)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                        ';
                    })
                    ->editColumn('profile_photo', function($row){
                        return '<img src="'.asset('uploads/profile_photo').'/'.$row->profile_photo.'" width="40" >';
                    })
                    ->editColumn('branch_name', function($row){
                        return'
                        <span class="badge bg-primary">'.$row->relationtobranch->branch_name.'</span>
                        ';
                    })
                    ->editColumn('staff_gender', function($row){
                        if($row->staff_gender == "Male"){
                            return'
                            <span class="badge bg-success">'.$row->staff_gender.'</span>
                            ';
                        }elseif($row->staff_gender == "Female"){
                            return'
                            <span class="badge bg-info">'.$row->staff_gender.'</span>
                            ';
                        }
                        else{
                            return'
                            <span class="badge bg-primary">'.$row->staff_gender.'</span>
                            ';
                        }
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
                    ->rawColumns(['created_at', 'profile_photo', 'branch_name', 'staff_gender', 'status', 'action'])
                    ->make(true);
        }

        $branches = Branch::whereStatus('Active')->get();
        return view('admin.staff.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'staff_gender' => 'required',
            'profile_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $staff_id = Staff::insertGetId([
                'branch_id' => Auth::user()->branch_id,
                'staff_name' => $request->staff_name,
                'staff_position' => $request->staff_position,
                'staff_email' => $request->staff_email,
                'staff_phone_number' => $request->staff_phone_number,
                'staff_gender' => $request->staff_gender,
                'staff_nid_no' => $request->staff_nid_no,
                'staff_date_of_birth' => $request->staff_date_of_birth,
                'staff_address' => $request->staff_address,
                'staff_salary' => $request->staff_salary,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            // Profile Photo Upload
            if($request->hasFile('profile_photo')){
                $profile_photo_name =  $staff_id."-".$request->staff_name."-Photo".".". $request->file('profile_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/profile_photo/").$profile_photo_name;
                Image::make($request->file('profile_photo'))->resize(600, 600)->save($upload_link);
                Staff::find($staff_id)->update([
                    'profile_photo' => $profile_photo_name,
                    'updated_by' => Auth::user()->id
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Staff store successfully.',
            ]);
        }
    }

    public function show($id)
    {
        $staff = Staff::where('id', $id)->first();
        return view('admin.staff.show', compact('staff'));
    }

    public function edit($id)
    {
        $staff = Staff::where('id', $id)->first();
        return response()->json($staff);
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'staff_gender' => 'required',
            'profile_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $staff->update([
                'branch_id' => Auth::user()->branch_id,
                'staff_name' => $request->staff_name,
                'staff_position' => $request->staff_position,
                'staff_email' => $request->staff_email,
                'staff_phone_number' => $request->staff_phone_number,
                'staff_gender' => $request->staff_gender,
                'staff_nid_no' => $request->staff_nid_no,
                'staff_date_of_birth' => $request->staff_date_of_birth,
                'staff_address' => $request->staff_address,
                'staff_salary' => $request->staff_salary,
                'updated_by' => Auth::user()->id,
            ]);

            // Profile Photo Upload
            if($request->hasFile('profile_photo')){
                if($staff->profile_photo != 'default_profile_photo.png'){
                    unlink(base_path("public/uploads/profile_photo/").$staff->profile_photo);
                }
                $profile_photo_name =  $id."-".$request->staff_name."-Photo".".". $request->file('profile_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/profile_photo/").$profile_photo_name;
                Image::make($request->file('profile_photo'))->resize(600, 600)->save($upload_link);
                $staff->update([
                    'profile_photo' => $profile_photo_name,
                    'updated_by' => Auth::user()->id,
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Staff updated successfully.',
            ]);
        }
    }

    public function destroy($id)
    {
        $staff = Staff::where('id', $id)->first();
        $staff->updated_by = Auth::user()->id;
        $staff->deleted_by = Auth::user()->id;
        $staff->save();
        $staff->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Staff destroy successfully.',
        ]);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $trashed_staff = "";
            $query = Staff::onlyTrashed();
            $trashed_staff = $query->get();

            return Datatables::of($trashed_staff)
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
        Staff::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Staff::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'status' => 200,
            'message' => 'Staff restore successfully.',
        ]);
    }

    public function forceDelete($id)
    {
        Staff::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'status' => 200,
            'message' => 'Staff force delete successfully.',
        ]);
    }

    public function Status($id)
    {
        $staff = Staff::where('id', $id)->first();
        if($staff->status == "Active"){
            $staff->update([
                'status' => "Inactive",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Staff status inactive.',
            ]);
        }else{
            $staff->update([
                'status' =>"Active",
                'updated_by' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Staff status active.',
            ]);
        }
    }

    public function staffSalary(Request $request)
    {
        if ($request->ajax()) {
            $all_staff = "";
            $query = Staff::where('branch_id', Auth::user()->branch_id);

            if($request->status){
                $query->where('staff.status', $request->status);
            }

            $all_staff = $query->select('staff.*')->get();

            return Datatables::of($all_staff)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-info">'.$row->created_at->format('d-M-Y').'</span>
                        ';
                    })
                    ->editColumn('profile_photo', function($row){
                        return '<img src="'.asset('uploads/profile_photo').'/'.$row->profile_photo.'" width="40" >';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm paymentSalaryDetailsBtn" data-bs-toggle="modal" data-bs-target="#paymentSalaryDetailsModal"><i class="fa-solid fa-eye"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm paymentSalaryBtn" data-bs-toggle="modal" data-bs-target="#paymentSalaryModal"><i class="fa-solid fa-credit-card"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['created_at', 'profile_photo', 'action'])
                    ->make(true);
        }
        return view('admin.staff.salary');
    }

    public function staffSalaryPaymentForm($id)
    {
        $staff = Staff::where('id', $id)->first();
        return response()->json($staff);
    }

    public function staffSalaryPaymentStore(Request $request, $id)
    {
        $staff = Staff::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $exists = Staff_salary::where('staff_id', $id)
                ->where('salary_year', $request->salary_year)
                ->where('salary_month', $request->salary_month)
                ->exists();

            if($exists){
                return response()->json([
                    'status' => 401,
                    'message' => 'Staff salary already payment.',
                ]);
            }else{
                if($staff->staff_salary < $request->payment_salary){
                    return response()->json([
                        'status' => 402,
                        'message' => 'Payment salary is greater than the staff salary.',
                    ]);
                }else{
                    Staff_salary::insert([
                        'staff_id' => $id,
                        'salary_year' => $request->salary_year,
                        'salary_month' => $request->salary_month,
                        'payment_salary' => $request->payment_salary,
                        'payment_date' => Carbon::now(),
                    ]);

                    if(Expense::where('expense_title', $request->salary_year." ".$request->salary_month." Salary")->exists()){
                        Expense::where('expense_title', $request->salary_year." ".$request->salary_month." Salary")->increment('expense_cost', $request->payment_salary);
                    }else{
                        Expense::insert([
                            'branch_id' => $staff->branch_id,
                            'expense_category_id' => 1,
                            'expense_date' => date('Y-m-d'),
                            'expense_title' => $request->salary_year." ".$request->salary_month." Salary",
                            'expense_cost' => $request->payment_salary,
                            'expense_description' => $request->salary_year." ".$request->salary_month." Salary",
                            'created_by' => Auth::user()->id,
                            'created_at' => Carbon::now(),
                        ]);
                    }

                    return response()->json([
                        'status' => 200,
                        'message' => 'Staff salary payment successfully.',
                    ]);
                }
            }

        }
    }

    public function staffSalaryPaymentDetails($id)
    {
        $staff = Staff::where('id', $id)->first();
        $staff_salaries = Staff_salary::where('staff_id', $id)->get();
        return view('admin.staff.salary_details', compact('staff', 'staff_salaries'));
    }
}
