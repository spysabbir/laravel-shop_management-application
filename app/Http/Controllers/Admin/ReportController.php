<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExpenseExport;
use App\Exports\PurchaseExport;
use App\Exports\SellingExport;
use App\Exports\StockExport;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Expense_category;
use App\Models\Product;
use App\Models\Purchase_summary;
use App\Models\Selling_summary;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function stockReport(Request $request){
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
        return view('admin.report.stock', compact('categories', 'brands'));
    }

    public function stockReportExport(Request $request)
    {
        $products = "";
            $query = Product::select('products.*');

            if($request->category_id){
                $query->where('products.category_id', $request->category_id);
            }

            if($request->brand_id){
                $query->where('products.brand_id', $request->brand_id);
            }

            $products = $query->get();

        return Excel::download(new StockExport($products), 'stock.xlsx');
    }

    public function expenseReport(Request $request){
        if ($request->ajax()) {
            $expenses = "";
            $query = Expense::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')
                    ->leftJoin('expense_categories', 'expenses.expense_category_id', 'expense_categories.id');

            if($request->expense_date_start){
                $query->whereDate('expenses.created_at', '>=', $request->expense_date_start);
            }

            if($request->expense_date_end){
                $query->whereDate('expenses.created_at', '<=', $request->expense_date_end);
            }

            if($request->expense_category_id){
                $query->where('expenses.expense_category_id', $request->expense_category_id);
            }

            $expenses = $query->select('expenses.*', 'expense_categories.expense_category_name');

            return Datatables::of($expenses->get())
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                        ';
                    })
                    ->rawColumns(['created_at'])
                    ->make(true);
        }

        $expense_categories = Expense_category::all();
        return view('admin.report.expense', compact('expense_categories'));
    }

    public function expenseReportExport(Request $request)
    {
        $expenses = "";
        $query = Expense::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')
                ->leftJoin('expense_categories', 'expenses.expense_category_id', 'expense_categories.id');

        if($request->expense_date_start){
            $query->whereDate('expenses.created_at', '>=', $request->expense_date_start);
        }

        if($request->expense_date_end){
            $query->whereDate('expenses.created_at', '<=', $request->expense_date_end);
        }

        if($request->expense_category_id){
            $query->where('expenses.expense_category_id', $request->expense_category_id);
        }

        $expenses = $query->select('expenses.*', 'expense_categories.expense_category_name')->get();

        return Excel::download(new ExpenseExport($expenses), 'expense.xlsx');
    }

    public function purchaseReport(Request $request){
        if ($request->ajax()) {
            $purchase_summaries = "";
            $query = Purchase_summary::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')
                ->leftJoin('suppliers', 'purchase_summaries.supplier_id', 'suppliers.id')
                ->leftJoin('users', 'purchase_summaries.purchase_agent_id', 'users.id');

            if($request->supplier_id){
                $query->where('purchase_summaries.supplier_id', $request->supplier_id);
            }
            if($request->payment_status){
                $query->where('purchase_summaries.payment_status', $request->payment_status);
            }

            if($request->purchase_date_start){
                $query->whereDate('purchase_summaries.purchase_date', '>=', $request->purchase_date_start);
            }

            if($request->purchase_date_end){
                $query->whereDate('purchase_summaries.purchase_date', '<=', $request->purchase_date_end);
            }

            $purchase_summaries = $query->select('purchase_summaries.*', 'suppliers.supplier_name', 'users.name')->get();

            return Datatables::of($purchase_summaries)
                    ->addIndexColumn()
                    ->editColumn('purchase_date', function($row){
                        return'
                            <span class="badge bg-success">'.date('d-M-Y h:m:s A', strtotime($row->purchase_date)).'</span>
                        ';
                    })
                    ->editColumn('payment_status', function($row){
                        if($row->payment_status != "Paid"){
                            return'
                            <span class="badge bg-warning">'.$row->payment_status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm paymentBtn" data-bs-toggle="modal" data-bs-target="#paymentModal"><i class="fa-regular fa-credit-card"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-success">'.$row->payment_status.'</span>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        ';
                        return $btn;
                    })
                    ->rawColumns(['purchase_date', 'payment_status', 'action'])
                    ->make(true);
        }

        $suppliers = Supplier::all();
        return view('admin.report.purchase', compact('suppliers'));
    }

    public function purchaseReportExport(Request $request)
    {
        $purchase_summaries = "";
            $query = Purchase_summary::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')
                ->leftJoin('suppliers', 'purchase_summaries.supplier_id', 'suppliers.id')
                ->leftJoin('users', 'purchase_summaries.purchase_agent_id', 'users.id');

            if($request->supplier_id){
                $query->where('purchase_summaries.supplier_id', $request->supplier_id);
            }
            if($request->payment_status){
                $query->where('purchase_summaries.payment_status', $request->payment_status);
            }

            if($request->purchase_date_start){
                $query->whereDate('purchase_summaries.purchase_date', '>=', $request->purchase_date_start);
            }

            if($request->purchase_date_end){
                $query->whereDate('purchase_summaries.purchase_date', '<=', $request->purchase_date_end);
            }

            $purchase_summaries = $query->select('purchase_summaries.*', 'suppliers.supplier_name', 'users.name')->get();

        return Excel::download(new PurchaseExport($purchase_summaries), 'purchase.xlsx');
    }

    public function sellingReport(Request $request){
        if ($request->ajax()) {
            $selling_summaries = "";
            $query = Selling_summary::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')
                ->leftJoin('customers', 'selling_summaries.customer_id', 'customers.id')
                ->leftJoin('users', 'selling_summaries.selling_agent_id', 'users.id');

            if($request->customer_id){
                $query->where('selling_summaries.customer_id', $request->customer_id);
            }

            if($request->payment_status){
                $query->where('selling_summaries.payment_status', $request->payment_status);
            }

            if($request->selling_date_start){
                $query->whereDate('selling_summaries.selling_date', '>=', $request->selling_date_start);
            }

            if($request->selling_date_end){
                $query->whereDate('selling_summaries.selling_date', '<=', $request->selling_date_end);
            }

            $selling_summaries = $query->select('selling_summaries.*', 'customers.customer_name', 'users.name')->get();

            return Datatables::of($selling_summaries)
                    ->addIndexColumn()
                    ->editColumn('selling_date', function($row){
                        return'
                            <span class="badge bg-success">'.date('d-M-Y h:m:s A', strtotime($row->selling_date)).'</span>
                        ';
                    })
                    ->editColumn('payment_status', function($row){
                        if($row->payment_status != "Paid"){
                            return'
                            <span class="badge bg-warning">'.$row->payment_status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm paymentBtn" data-bs-toggle="modal" data-bs-target="#paymentModal"><i class="fa-regular fa-credit-card"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-success">'.$row->payment_status.'</span>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        ';
                        return $btn;
                    })
                    ->rawColumns(['selling_date', 'payment_status', 'action'])
                    ->make(true);
        }

        $customers = Customer::all();
        return view('admin.report.selling', compact('customers'));
    }

    public function sellingReportExport(Request $request)
    {
        $selling_summaries = "";
            $query = Selling_summary::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')
                ->leftJoin('customers', 'selling_summaries.customer_id', 'customers.id')
                ->leftJoin('users', 'selling_summaries.selling_agent_id', 'users.id');

            if($request->customer_id){
                $query->where('selling_summaries.customer_id', $request->customer_id);
            }

            if($request->payment_status){
                $query->where('selling_summaries.payment_status', $request->payment_status);
            }

            if($request->selling_date_start){
                $query->whereDate('selling_summaries.selling_date', '>=', $request->selling_date_start);
            }

            if($request->selling_date_end){
                $query->whereDate('selling_summaries.selling_date', '<=', $request->selling_date_end);
            }

            $selling_summaries = $query->select('selling_summaries.*', 'customers.customer_name', 'users.name')->get();


        return Excel::download(new SellingExport($selling_summaries), 'selling.xlsx');
    }
}
