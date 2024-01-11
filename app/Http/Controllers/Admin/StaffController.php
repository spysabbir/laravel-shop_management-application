<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Expense_category;
use App\Models\Staff;
use App\Models\Staff_salary;
use App\Models\StaffDesignation;
use App\Models\StaffPayment;
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

            if($request->staff_designation_id){
                $query->where('staff.staff_designation_id', $request->staff_designation_id);
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
                    ->editColumn('staff_designation', function($row){
                        return'
                        <span class="badge bg-primary">'.$row->relationtostaffdesignation->designation_name.'</span>
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
                    ->editColumn('staff_salary', function($row){
                        return'
                        <span class="badge bg-info">'.$row->staff_salary.'</span>
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm assignSalaryBtn" data-bs-toggle="modal" data-bs-target="#assignSalaryModal"><i class="fa-solid fa-credit-card"></i></button>
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
                    ->rawColumns(['created_at', 'profile_photo', 'branch_name', 'staff_designation', 'staff_gender', 'staff_salary', 'status', 'action'])
                    ->make(true);
        }

        $staff_designations = StaffDesignation::whereStatus('Active')->get();
        return view('admin.staff.index', compact('staff_designations'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'staff_gender' => 'required',
            'profile_photo' => 'nullable|image|mimes:png,jpg,jpeg'
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
                'staff_designation_id' => $request->staff_designation_id,
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

            Staff_salary::insert([
                'staff_id' => $staff_id,
                'new_salary' => $request->staff_salary,
                'assign_date' => date('Y-m-d'),
                'assign_by' => Auth::user()->id,
                'assign_at' => Carbon::now(),
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
            'profile_photo' => 'nullable|image|mimes:png,jpg,jpeg'
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
                'staff_designation_id' => $request->staff_designation_id,
                'staff_email' => $request->staff_email,
                'staff_phone_number' => $request->staff_phone_number,
                'staff_gender' => $request->staff_gender,
                'staff_nid_no' => $request->staff_nid_no,
                'staff_date_of_birth' => $request->staff_date_of_birth,
                'staff_address' => $request->staff_address,
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

    public function assignStaffSalary($id)
    {
        $staff = Staff::where('id', $id)->first();

        $send_staff_salary_data = "
            <div class='row border align-items-center'>
                <div class='col-lg-4 border'>New Salary</div>
                <div class='col-lg-4 border'>Assign Date</div>
                <div class='col-lg-4 border'>Action</div>
            </div>
        ";
        $staff_salaries = Staff_salary::where('staff_id', $id)->get();
        foreach ($staff_salaries as $staff_salary){
            $staff_id = Staff_salary::where('staff_id', $staff_salary->staff_id)->orderBy('id', 'desc')->first()->id;
            $send_staff_salary_data .= '
            <div class="row border align-items-center">
                <div class="col-lg-4 border">'.$staff_salary->new_salary.'</div>
                <div class="col-lg-4 border">'.$staff_salary->assign_date.'</div>
                <div class="col-lg-4 border">
                    '.($staff_id == $staff_salary->id ? '<button type="button" id="'.$staff_salary->id.'" class="btn btn-danger btn-sm assign_staff_salary_delete_btn">Delete</button>
                    ' : '<span class="badge bg-warning">N/A</span>').'
                </div>
            </div>
            ';
        }

        return response()->json([
            'staff' => $staff,
            'send_staff_salary_data' => $send_staff_salary_data,
        ]);
    }

    public function assignStaffSalaryStore(Request $request)
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
            Staff_salary::insert([
                'staff_id' => $request->staff_id,
                'new_salary' => $request->new_salary,
                'assign_date' =>  $request->assign_date,
                'assign_by' => Auth::user()->id,
                'assign_at' => Carbon::now(),
            ]);

            Staff::where('id', $request->staff_id)->update([
                'staff_salary' => $request->new_salary,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Staff salary assign successfully.',
            ]);
        }
    }

    public function assignStaffSalaryDestroy($id)
    {
        $staff_salary = Staff_salary::where('id', $id)->first();
        $staff_salary->delete();
        $last_salary = Staff_salary::where('staff_id', $staff_salary->staff_id)->orderBy('id', 'desc')->first()->new_salary;

        Staff::where('id', $staff_salary->staff_id)->update([
            'staff_salary' => $last_salary,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Assign staff salary destroy successfully.',
        ]);
    }

    public function staffPayment(Request $request)
    {
        if ($request->ajax()) {
            $all_staff = "";
            $query = Staff::where('branch_id', Auth::user()->branch_id)->where('status', 'Active');

            if($request->staff_designation_id){
                $query->where('staff.staff_designation_id', $request->staff_designation_id);
            }

            $all_staff = $query->select('staff.*')->get();

            return Datatables::of($all_staff)
                    ->addIndexColumn()
                    ->editColumn('profile_photo', function($row){
                        return '<img src="'.asset('uploads/profile_photo').'/'.$row->profile_photo.'" width="40" >';
                    })
                    ->editColumn('staff_designation', function($row){
                        return'
                        <span class="badge bg-info">'.StaffDesignation::find($row->staff_designation_id)->designation_name.'</span>
                        ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm viewStaffPaymentDetailsBtn" data-bs-toggle="modal" data-bs-target="#viewStaffPaymentDetailsModal"><i class="fa-solid fa-eye"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm staffPaymentBtn" data-bs-toggle="modal" data-bs-target="#staffPaymentModal"><i class="fa-solid fa-credit-card"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['profile_photo', 'staff_designation', 'action'])
                    ->make(true);
        }

        $staffDesignations = StaffDesignation::where('status', 'Active')->get();
        return view('admin.staff.payment', compact('staffDesignations'));
    }

    public function staffPaymentForm($id)
    {
        $staff = Staff::where('id', $id)->first();
        return response()->json($staff);
    }

    public function staffPaymentStore(Request $request, $id)
    {
        $staff = Staff::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'payment_note' => 'nullable',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        } else{
            if ($staff->staff_salary < $request->payment_amount){
                return response()->json([
                    'status' => 401,
                    'message' => 'Payment amount is greater than the staff salary amount.',
                ]);
            } else{
                $payment_amount = StaffPayment::where('staff_id', $id)
                ->where('payment_type', $request->payment_type)
                ->where('payment_year', $request->payment_year)
                ->where('payment_month', $request->payment_month)
                ->sum('payment_amount');

                if ($payment_amount == $staff->staff_salary){
                    return response()->json([
                        'status' => 402,
                        'message' => 'Staff already received '.$payment_amount.' amount',
                    ]);
                } else{
                    $due_amount = $staff->staff_salary- $payment_amount;
                    if ($due_amount < $request->payment_amount) {
                        return response()->json([
                            'status' => 403,
                            'message' => 'Staff already received advance '.$payment_amount.' amount please provide '.$due_amount.' amount',
                        ]);
                    } else {
                        StaffPayment::insert([
                            'staff_id' => $id,
                            'payment_type' => $request->payment_type,
                            'payment_year' => $request->payment_year,
                            'payment_month' => $request->payment_month,
                            'payment_amount' => $request->payment_amount,
                            'payment_note' => $request->payment_note,
                            'payment_by' => Auth::user()->id,
                            'payment_at' => Carbon::now(),
                        ]);

                        $get_category = Expense_category::where('expense_category_name', $request->payment_type)->first();
                        $expense = Expense::where('branch_id', Auth::user()->branch_id)
                                        ->where('expense_category_id', $get_category->id)
                                        ->where('expense_title', $request->payment_year." ".$request->payment_month." Payment");
                        if($expense->exists()){
                            $expense->increment('expense_cost', $request->payment_amount);
                        }else{
                            Expense::insert([
                                'branch_id' => Auth::user()->branch_id,
                                'expense_category_id' => $get_category->id,
                                'expense_date' => date('Y-m-d'),
                                'expense_title' => $request->payment_year." ".$request->payment_month." Payment",
                                'expense_cost' => $request->payment_amount,
                                'expense_description' => $request->payment_year." ".$request->payment_month." Payment". $request->payment_note,
                                'created_by' => Auth::user()->id,
                                'created_at' => Carbon::now(),
                            ]);
                        }

                        return response()->json([
                            'status' => 200,
                            'message' => 'Staff payment received successfully.',
                        ]);
                    }
                }
            }

        }
    }

    public function staffPaymentDetails($id)
    {
        $staff = Staff::where('id', $id)->first();
        $staff_payments = StaffPayment::where('staff_id', $id)->get();
        return view('admin.staff.salary_details', compact('staff', 'staff_payments'));
    }
}
