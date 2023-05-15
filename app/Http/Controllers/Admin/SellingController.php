<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Selling_successfullyMail;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Customers_payment_summary;
use App\Models\DefaultSetting;
use App\Models\Product;
use App\Models\Selling_cart;
use App\Models\Selling_details;
use App\Models\Selling_summary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class SellingController extends Controller
{
    public function sellingProduct (Request $request)
    {
        if ($request->ajax()) {
            $selling_carts = "";
            $query = Selling_cart::where('selling_invoice_no', $request->selling_invoice_no)
                ->where('selling_date', $request->selling_date)
                ->where('customer_id', $request->customer_id)
                ->leftJoin('products', 'selling_carts.product_id', 'products.id');

            $selling_carts = $query->select('selling_carts.*', 'products.product_name', 'products.selling_price', 'products.unit_id', 'products.brand_id')->get();

            return Datatables::of($selling_carts)
                    ->addIndexColumn()
                    ->editColumn('brand_name', function($row){
                        return'
                        <span class="badge bg-success">'.$row->relationtobrand->brand_name.'</span>
                        ';
                    })
                    ->editColumn('unit_name', function($row){
                        return'
                        <span class="badge bg-success">'.$row->relationtounit->unit_name.'</span>
                        ';
                    })
                    ->editColumn('selling_quantity', function($row){
                        return'
                        <input type="text" value="'.$row->selling_quantity.'" class="form-control selling_quantity" id="'.$row->id.'"/>
                        ';
                    })
                    ->editColumn('selling_price', function($row){
                        return'
                        <input type="text" value="'.$row->selling_price.'" class="form-control selling_price" id="'.$row->id.'" readonly/>
                        ';
                    })
                    ->editColumn('total_price', function($row){
                        return'
                        <span class="badge bg-success">'.$row->selling_quantity * $row->selling_price.'</span>
                        ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBtn"><i class="fa-solid fa-trash-can"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['selling_quantity', 'unit_name', 'brand_name', 'selling_price', 'total_price', 'action'])
                    ->make(true);
        }

        $customers = Customer::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return view('admin.selling.create', compact('customers', 'categories'));
    }

    public function sellingCartDelete()
    {
        Selling_cart::truncate();
        return back();
    }

    public function getProducts(Request $request)
    {
        $send_products = "<option>--Select Product--</option>";
        $products = Product::where('category_id', $request->category_id)->get();
        foreach ($products as $product) {
            $send_products .= "<option value='$product->id'>$product->product_name</option>";
        }
        return response()->json($send_products);
    }

    public function sellingProductDetails(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        $selling_price = $product->selling_price;
        $product_stock = ($product->purchase_quantity-$product->selling_quantity);
        return response()->json([
            'product_stock' => $product_stock,
            'selling_price' => $selling_price,
        ]);
    }

    public function sellingCartStore(Request $request)
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
            $exists = Selling_cart::where('selling_invoice_no', $request->selling_invoice_no)
                ->where('selling_date', $request->selling_date)
                ->where('customer_id', $request->customer_id)->where('product_id', $request->product_id)->exists();
            if($exists){
                return response()->json([
                    'status' => 401,
                    'message' => 'Selling product already added.',
                ]);
            }else{
                Selling_cart::insert([
                    'selling_invoice_no' => $request->selling_invoice_no,
                    'selling_date' => $request->selling_date,
                    'customer_id' => $request->customer_id,
                    'product_id' => $request->product_id,
                    'selling_price' => $request->selling_price,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Selling product added successfully.',
                ]);
            }
        }
    }

    public function sellingCartItemDelete(Request $request)
    {
        Selling_cart::where('id', $request->cart_id)->delete();

        $sub_total = 0;
        foreach(Selling_cart::where('selling_invoice_no', $request->selling_invoice_no)
                    ->where('selling_date', $request->selling_date)
                    ->where('customer_id', $request->customer_id)->get() as $cart){
            $sub_total += ($cart->selling_quantity*$cart->selling_price);
        };

        return response()->json([
            'sub_total' => $sub_total,
            'message' => 'Selling cart item delete successfully.',
        ]);
    }

    public function changeSellingQuantity(Request $request)
    {
        $selling_cart = Selling_cart::where('id', $request->cart_id)->first();
        $product = Product::where('id', $selling_cart->product_id)->first();

        $stock_quantity = $product->purchase_quantity - $product->selling_quantity;
        if($request->selling_quantity > $stock_quantity){
            return response()->json([
                'status' => 400,
                'message' => 'This quantity of stock is not available.',
            ]);
        }else{
            $selling_cart->update([
                'selling_quantity' => $request->selling_quantity,
            ]);

            $sub_total = 0;
            foreach(Selling_cart::where('selling_invoice_no', $request->selling_invoice_no)
                        ->where('selling_date', $request->selling_date)
                        ->where('customer_id', $request->customer_id)->get() as $cart){
                $sub_total += ($cart->selling_quantity*$cart->selling_price);
            };
            return response()->json($sub_total);
        }
    }

    public function changeSellingPrice(Request $request)
    {
        Selling_cart::where('id', $request->cart_id)->update([
            'selling_price' => $request->selling_price,
        ]);
        $sub_total = 0;
        foreach(Selling_cart::where('selling_invoice_no', $request->selling_invoice_no)
                    ->where('selling_date', $request->selling_date)
                    ->where('customer_id', $request->customer_id)->get() as $cart){
            $sub_total += ($cart->selling_quantity*$cart->selling_price);
        };
        return response()->json($sub_total);
    }

    public function getSubTotal(Request $request)
    {
        $sub_total = 0;
        foreach(Selling_cart::where('selling_invoice_no', $request->selling_invoice_no)
                    ->where('selling_date', $request->selling_date)
                    ->where('customer_id', $request->customer_id)->get() as $cart){
            $sub_total += ($cart->selling_quantity*$cart->selling_price);
        };
        return response()->json($sub_total);
    }

    public function sellingProductStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'discount' => 'nullable',
            'payment_method' => 'nullable',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $products_data =  Selling_cart::where('selling_invoice_no', $request->selling_invoice_no)
                        ->where('selling_date', $request->selling_date)
                        ->where('customer_id', $request->customer_id);
            if(!$products_data->exists()){
                return response()->json([
                    'status' => 401,
                    'message' => 'Selling product not added.',
                ]);
            }else{
                if($request->payment_status != 'Unpaid' && $request->payment_method == NULL){
                    return response()->json([
                        'status' => 402,
                        'message' => 'The payment_method field is required.',
                    ]);
                }else{
                    $selling_summery_id = Selling_summary::insertGetId([
                        'selling_invoice_no' => $request->selling_invoice_no,
                        'selling_date' => $request->selling_date,
                        'customer_id' => $request->customer_id,
                        'sub_total' => $request->sub_total,
                        'discount' => $request->discount,
                        'grand_total' => $request->grand_total,
                        'payment_status' => $request->payment_status,
                        'payment_amount' => $request->payment_amount,
                        'selling_agent_id' => Auth::user()->id,
                        'branch_id' => Auth::user()->branch_id,
                        'created_at' => Carbon::now(),
                    ]);

                    Customers_payment_summary::insert([
                        'customer_id' => $request->customer_id,
                        'selling_invoice_no' => $request->selling_invoice_no,
                        'grand_total' => $request->grand_total,
                        'payment_status' => $request->payment_status,
                        'payment_method' => $request->payment_method,
                        'payment_amount' => $request->payment_amount,
                        'payment_agent_id' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                    ]);

                    $cart_products = $products_data->get();
                    foreach($cart_products as $cart_product){
                        Selling_details::insert([
                            'selling_invoice_no' => $cart_product->selling_invoice_no,
                            'product_id' => $cart_product->product_id,
                            'selling_quantity' => $cart_product->selling_quantity,
                            'selling_price' => $cart_product->selling_price,
                            'created_at' => Carbon::now(),
                        ]);

                        Product::where('id', $cart_product->product_id)->update([
                            'selling_price' => $cart_product->selling_price,
                        ]);
                        Product::where('id', $cart_product->product_id)->increment('selling_quantity', $cart_product->selling_quantity);
                        $cart_product->truncate();
                    }

                    // $selling_summary = Selling_summary::find($selling_summery_id);
                    // Mail::to(Customer::find($request->customer_id)->customer_email)
                    // ->send(new Selling_successfullyMail($selling_summary));

                    return response()->json([
                        'status' => 200,
                        'message' => 'Product selling successfully.',
                    ]);
                }
            }
        }
    }

    public function sellingList(Request $request)
    {
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
                            <a href="'.route('selling.invoice.download', Crypt::encrypt($row->selling_invoice_no)).'" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-download"></i></a>
                            <a href="'.route('selling.invoice', Crypt::encrypt($row->selling_invoice_no) ).'" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-print"></i></a>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['selling_date', 'payment_status', 'action'])
                    ->make(true);
        }

        $customers = Customer::all();
        return view('admin.selling.index', compact('customers'));
    }

    public function customerPayment($selling_invoice_no)
    {
        $selling_summary = Selling_summary::where('selling_invoice_no', $selling_invoice_no)->first();
        return response()->json($selling_summary);
    }

    public function customerPaymentUpdate(Request $request, $selling_invoice_no)
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
            $selling_summary = Selling_summary::where('selling_invoice_no', $selling_invoice_no);
            $due_amount = $selling_summary->first()->grand_total - $selling_summary->first()->payment_amount;
            if($request->payment_amount > $due_amount){
                return response()->json([
                    'status' => 401,
                    'message' => 'Payment quantity greater than due amount',
                ]);
            }else{
                $selling_summary->increment('payment_amount', $request->payment_amount);
                $selling_summary->update([
                    'payment_status' => $request->payment_status,
                ]);
                Customers_payment_summary::insert([
                    'customer_id' => $request->customer_id,
                    'selling_invoice_no' => $request->selling_invoice_no,
                    'grand_total' => $request->grand_total,
                    'payment_status' => $request->payment_status,
                    'payment_method' => $request->payment_method,
                    'payment_amount' => $request->payment_amount,
                    'payment_agent_id' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Customer payment successfully.',
                ]);
            }
        }
    }

    public function sellingInvoice($selling_invoice_no){
        $default_setting = DefaultSetting::first();
        $selling_invoice_no = Crypt::decrypt($selling_invoice_no);
        $selling_summary = Selling_summary::where('selling_invoice_no', $selling_invoice_no)->first();
        $selling_details = Selling_details::where('selling_invoice_no', $selling_invoice_no)->get();
        $payment_summaries = Customers_payment_summary::where('selling_invoice_no', $selling_invoice_no)->get();
        return view('admin.selling.invoice', compact('default_setting', 'selling_summary', 'selling_details', 'payment_summaries'));
    }

    public function sellingInvoiceDownload($selling_invoice_no){
        $default_setting = DefaultSetting::first();
        $selling_invoice_no = Crypt::decrypt($selling_invoice_no);
        $selling_summary = Selling_summary::where('selling_invoice_no', $selling_invoice_no)->first();
        $selling_details = Selling_details::where('selling_invoice_no', $selling_invoice_no)->get();
        $payment_summaries = Customers_payment_summary::where('selling_invoice_no', $selling_invoice_no)->get();
        $pdf = Pdf::loadView('admin.selling.invoice', compact('default_setting', 'selling_summary', 'selling_details', 'payment_summaries'));
        return $pdf->stream($selling_invoice_no.'-invoice.pdf');
    }
}
