<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExpenseExport;
use App\Exports\PurchaseExport;
use App\Exports\SellingExport;
use App\Exports\StockExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Expense_category;
use App\Models\Product;
use App\Models\Purchase_details;
use App\Models\Purchase_summary;
use App\Models\Selling_details;
use App\Models\Selling_summary;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function stockReport(Request $request){

            if ($request->ajax()) {
                $productStock = "";

                $query = Purchase_details::select(
                    'purchase_details.product_id',
                    'purchase_details.branch_id',
                    'products.category_id',
                    'products.brand_id',
                    'products.unit_id',
                    DB::raw('SUM(purchase_details.purchase_quantity) as total_purchase_quantity'),
                    DB::raw('COALESCE(SUM(selling_details.total_selling_quantity), 0) as total_selling_quantity'),
                    DB::raw('(COALESCE(SUM(purchase_details.purchase_quantity), 0) - COALESCE(SUM(selling_details.total_selling_quantity), 0)) as stock_quantity')
                )
                ->leftJoinSub(
                    Selling_details::select('product_id', 'branch_id', DB::raw('SUM(selling_quantity) as total_selling_quantity'))
                        ->groupBy('product_id', 'branch_id'),
                    'selling_details',
                    function ($join) {
                        $join->on('purchase_details.product_id', '=', 'selling_details.product_id')
                            ->on('purchase_details.branch_id', '=', 'selling_details.branch_id');
                    }
                )
                ->groupBy('purchase_details.product_id', 'purchase_details.branch_id', 'products.category_id', 'products.brand_id', 'products.unit_id')
                ->leftJoin('products', 'purchase_details.product_id', '=', 'products.id');

                if ($request->branch_id) {
                    $query->where('purchase_details.branch_id', $request->branch_id);
                }
                if ($request->category_id) {
                    $query->where('products.category_id', $request->category_id);
                }
                if ($request->brand_id) {
                    $query->where('products.brand_id', $request->brand_id);
                }

                $productStock = $query->get();

                return Datatables::of($productStock)
                            ->addIndexColumn()
                            ->editColumn('branch_name', function($row){
                                return'
                                <span class="badge bg-info">'.$row->relationtobranch->branch_name.'</span>
                                ';
                            })
                            ->editColumn('category_name', function($row){
                                return'
                                <span class="badge bg-info">'.$row->relationtocategory->category_name.'</span>
                                ';
                            })
                            ->editColumn('product_name', function($row){
                                return'
                                <span class="badge bg-info">'.$row->relationtoproduct->product_name.'</span>
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
                            ->rawColumns(['branch_name', 'category_name', 'product_name', 'brand_name', 'unit_name'])
                            ->make(true);
        }

        $categories = Category::all();
        $brands = Brand::all();
        $branches = Branch::all();
        return view('admin.report.stock', compact('categories', 'brands', 'branches'));
    }

    public function stockReportExport(Request $request)
    {
        $productStock = "";

        $query = Purchase_details::select(
            'purchase_details.product_id',
            'purchase_details.branch_id',
            'products.category_id',
            'products.brand_id',
            'products.unit_id',
            DB::raw('SUM(purchase_details.purchase_quantity) as total_purchase_quantity'),
            DB::raw('SUM(selling_details.total_selling_quantity) as total_selling_quantity'),
            DB::raw('(COALESCE(SUM(purchase_details.purchase_quantity), 0) - COALESCE(SUM(selling_details.total_selling_quantity), 0)) as stock_quantity')
        )
        ->leftJoinSub(
            Selling_details::select('product_id', 'branch_id', DB::raw('SUM(selling_quantity) as total_selling_quantity'))
                ->groupBy('product_id', 'branch_id'),
            'selling_details',
            function ($join) {
                $join->on('purchase_details.product_id', '=', 'selling_details.product_id')
                    ->on('purchase_details.branch_id', '=', 'selling_details.branch_id');
            }
        )
        ->groupBy('purchase_details.product_id', 'purchase_details.branch_id', 'products.category_id', 'products.brand_id', 'products.unit_id')
        ->leftJoin('products', 'purchase_details.product_id', '=', 'products.id');

        if ($request->branch_id) {
            $query->where('purchase_details.branch_id', $request->branch_id);
        }
        if ($request->category_id) {
            $query->where('products.category_id', $request->category_id);
        }
        if ($request->brand_id) {
            $query->where('products.brand_id', $request->brand_id);
        }

        $productStock = $query->get();

        return Excel::download(new StockExport($productStock), 'stock.xlsx');
    }

    public function expenseReport(Request $request){
        if ($request->ajax()) {
            $expenses = "";
            $query = Expense::orderBy('id', 'DESC')
                    ->leftJoin('expense_categories', 'expenses.expense_category_id', 'expense_categories.id')
                    ->leftJoin('branches', 'expenses.branch_id', 'branches.id');

            if($request->expense_date_start){
                $query->whereDate('expenses.created_at', '>=', $request->expense_date_start);
            }

            if($request->expense_date_end){
                $query->whereDate('expenses.created_at', '<=', $request->expense_date_end);
            }

            if($request->expense_category_id){
                $query->where('expenses.expense_category_id', $request->expense_category_id);
            }

            if($request->branch_id){
                $query->where('expenses.branch_id', $request->branch_id);
            }

            $expenses = $query->select('expenses.*', 'expense_categories.expense_category_name', 'branches.branch_name');

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
        $branches = Branch::all();
        return view('admin.report.expense', compact('expense_categories', 'branches'));
    }

    public function expenseReportExport(Request $request)
    {
        $expenses = "";
        $query = Expense::orderBy('id', 'DESC')
                ->leftJoin('expense_categories', 'expenses.expense_category_id', 'expense_categories.id')
                ->leftJoin('branches', 'expenses.branch_id', 'branches.id');

        if($request->expense_date_start){
            $query->whereDate('expenses.created_at', '>=', $request->expense_date_start);
        }

        if($request->expense_date_end){
            $query->whereDate('expenses.created_at', '<=', $request->expense_date_end);
        }

        if($request->expense_category_id){
            $query->where('expenses.expense_category_id', $request->expense_category_id);
        }

        if($request->branch_id){
            $query->where('expenses.branch_id', $request->branch_id);
        }

        $expenses = $query->select('expenses.*', 'expense_categories.expense_category_name', 'branches.branch_name')->get();

        return Excel::download(new ExpenseExport($expenses), 'expense.xlsx');
    }

    public function purchaseReport(Request $request){
        if ($request->ajax()) {
            $purchase_summaries = "";
            $query = Purchase_summary::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')
                ->leftJoin('suppliers', 'purchase_summaries.supplier_id', 'suppliers.id')
                ->leftJoin('users', 'purchase_summaries.purchase_agent_id', 'users.id');

            if($request->branch_id){
                $query->where('purchase_summaries.branch_id', $request->branch_id);
            }

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
                            ';
                        }else{
                            return'
                            <span class="badge bg-success">'.$row->payment_status.'</span>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <a href="'.route('purchase.invoice', Crypt::encrypt($row->purchase_invoice_no) ).'" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-download"></i></a>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['purchase_date', 'payment_status', 'action'])
                    ->make(true);
        }

        $suppliers = Supplier::all();
        $branches = Branch::all();
        return view('admin.report.purchase', compact('suppliers', 'branches'));
    }

    public function purchaseReportExport(Request $request)
    {
        $purchase_summaries = "";
        $query = Purchase_summary::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')
            ->leftJoin('suppliers', 'purchase_summaries.supplier_id', 'suppliers.id')
            ->leftJoin('users', 'purchase_summaries.purchase_agent_id', 'users.id');

        if($request->branch_id){
            $query->where('purchase_summaries.branch_id', $request->branch_id);
        }

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

            if($request->branch_id){
                $query->where('selling_summaries.branch_id', $request->branch_id);
            }

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
                            ';
                        }else{
                            return'
                            <span class="badge bg-success">'.$row->payment_status.'</span>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <a href="'.route('selling.invoice', Crypt::encrypt($row->selling_invoice_no) ).'" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-print"></i></a>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['selling_date', 'payment_status', 'action'])
                    ->make(true);
        }

        $customers = Customer::all();
        $branches = Branch::all();
        return view('admin.report.selling', compact('customers', 'branches'));
    }

    public function sellingReportExport(Request $request)
    {
        $selling_summaries = "";

        $query = Selling_summary::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')
            ->leftJoin('customers', 'selling_summaries.customer_id', 'customers.id')
            ->leftJoin('users', 'selling_summaries.selling_agent_id', 'users.id');

        if($request->branch_id){
            $query->where('selling_summaries.branch_id', $request->branch_id);
        }

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
