<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Selling_successfullyMail;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Customers_payment_summary;
use App\Models\DefaultSetting;
use App\Models\Product;
use App\Models\Purchase_details;
use App\Models\Purchase_summary;
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
    public function selling (Request $request)
    {
        if ($request->ajax()) {
            $selling_carts = "";
            $query = Selling_cart::where('customer_id', $request->customer_id)
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

    public function getSellingProductList(Request $request)
    {
        $send_products = "<option value=''>--Select Product--</option>";
        $products = Product::where('category_id', $request->category_id)->get();
        foreach ($products as $product) {
            $send_products .= "<option value='$product->id'>$product->product_name</option>";
        }
        return response()->json($send_products);
    }

    public function getSellingProductDetails(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        $selling_price = $product->selling_price;

        $product_purchase_quantity = Purchase_details::where('product_id', $product->id)->where('branch_id', Auth::user()->branch_id)->sum('purchase_quantity');
        $product_selling_quantity = Selling_details::where('product_id', $product->id)->where('branch_id', Auth::user()->branch_id)->sum('selling_quantity');
        $product_stock = $product_purchase_quantity - $product_selling_quantity;

        return response()->json([
            'product_stock' => $product_stock,
            'selling_price' => $selling_price,
        ]);
    }

    public function storeSellingProductCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'category_id' => 'required',
            'product_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if($request->customer_id == 'New Customer'){
                $validator = Validator::make($request->all(), [
                    'customer_name' => 'required',
                    'customer_email' => 'required',
                    'customer_phone_number' => 'required',
                    'customer_address' => 'required',
                ]);

                if($validator->fails()){
                    return response()->json([
                        'status' => 401,
                        'error'=> $validator->errors()->toArray()
                    ]);
                }else{
                    $new_customer_id = Customer::insertGetId([
                        'customer_name' => $request->customer_name,
                        'customer_email' => $request->customer_email,
                        'customer_phone_number' => $request->customer_phone_number,
                        'customer_address' => $request->customer_address,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                    ]);
                    $customer_id = $new_customer_id;
                }
            }else{
                $customer_id = $request->customer_id;
            }

            $exists = Selling_cart::where('customer_id', $customer_id)
                                ->where('product_id', $request->product_id)
                                ->exists();
            if($exists){
                return response()->json([
                    'status' => 402,
                    'message' => 'Selling product already added.',
                ]);
            }else{
                $product_purchase_quantity = Purchase_details::where('product_id', $request->product_id)->where('branch_id', Auth::user()->branch_id)->sum('purchase_quantity');
                $product_selling_quantity = Selling_details::where('product_id', $request->product_id)->where('branch_id', Auth::user()->branch_id)->sum('selling_quantity');
                $stock_quantity = $product_purchase_quantity - $product_selling_quantity;
                if(1 > $stock_quantity){
                    return response()->json([
                        'status' => 403,
                        'message' => 'This quantity of stock is not available.',
                    ]);
                }else{
                    Selling_cart::insert([
                        'customer_id' => $customer_id,
                        'product_id' => $request->product_id,
                        'selling_quantity' => 1,
                        'selling_price' => $request->selling_price,
                        'created_at' => Carbon::now(),
                    ]);

                    $sub_total = 0;
                    foreach(Selling_cart::where('customer_id', $request->customer_id)->get() as $cart){
                        $sub_total += ($cart->selling_quantity*$cart->selling_price);
                    };

                    return response()->json([
                        'status' => 200,
                        'customer_id' => $customer_id,
                        'sub_total' => $sub_total,
                        'message' => 'Selling product added successfully.',
                    ]);
                }
            }
        }
    }

    public function updateSellingProductCart(Request $request)
    {
        $selling_cart = Selling_cart::where('id', $request->cart_id)->first();

        $product_purchase_quantity = Purchase_details::where('product_id', $selling_cart->product_id)->where('branch_id', Auth::user()->branch_id)->sum('purchase_quantity');
        $product_selling_quantity = Selling_details::where('product_id', $selling_cart->product_id)->where('branch_id', Auth::user()->branch_id)->sum('selling_quantity');
        $stock_quantity = $product_purchase_quantity - $product_selling_quantity;
        if($request->selling_quantity > $stock_quantity){
            return response()->json([
                'status' => 400,
                'message' => 'This quantity of stock is not available.',
            ]);
        }else{
            $selling_cart->update([
                'selling_quantity' => $request->selling_quantity,
                'selling_price' => $request->selling_price,
            ]);

            $sub_total = 0;
            foreach(Selling_cart::where('customer_id', $request->customer_id)->get() as $cart){
                $sub_total += ($cart->selling_quantity*$cart->selling_price);
            };
            return response()->json($sub_total);
        }
    }

    public function getSellingCartSubtotal(Request $request)
    {
        $sub_total = 0;
        foreach(Selling_cart::where('customer_id', $request->customer_id)->get() as $cart){
            $sub_total += ($cart->selling_quantity*$cart->selling_price);
        };
        return response()->json($sub_total);
    }

    public function sellingCartProductDelete(Request $request)
    {
        Selling_cart::where('id', $request->cart_id)->delete();

        $sub_total = 0;
        foreach(Selling_cart::where('customer_id', $request->customer_id)->get() as $cart){
            $sub_total += ($cart->selling_quantity*$cart->selling_price);
        };

        return response()->json([
            'sub_total' => $sub_total,
            'message' => 'Selling cart item delete successfully.',
        ]);
    }

    public function sellingStore(Request $request)
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
            $products_data =  Selling_cart::where('customer_id', $request->customer_id);
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
                    $selling_invoice_no = "SI-".Selling_summary::max('id')+1;

                    Selling_summary::insert([
                        'selling_invoice_no' => $selling_invoice_no,
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
                        'selling_invoice_no' => $selling_invoice_no,
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
                            'selling_invoice_no' => $selling_invoice_no,
                            'product_id' => $cart_product->product_id,
                            'selling_quantity' => $cart_product->selling_quantity,
                            'selling_price' => $cart_product->selling_price,
                            'branch_id' => Auth::user()->branch_id,
                        ]);

                        Product::where('id', $cart_product->product_id)->update([
                            'selling_price' => $cart_product->selling_price,
                        ]);

                        Product::where('id', $cart_product->product_id)->increment('selling_quantity', $cart_product->selling_quantity);

                        Selling_cart::find($cart_product->id)->delete();
                    }

                    // Send SMS
                    $customer = Customer::find($request->customer_id);

                    $url = "https://bulksmsbd.net/api/smsapi";
                    $api_key = env('SMS_API_KEY');
                    $senderid = env('SMS_SENDER_ID');
                    $number = "$customer->customer_phone_number";
                    $message = "Hello $customer->customer_name.
                                Your invoice no $request->selling_invoice_no.
                                Your shopping cost $request->grand_total.
                                Your payment amount $request->payment_amount, Your payment method $request->payment_method.
                                Thanks for shopping from our store.
                                ";
                    $data = [
                        "api_key" => $api_key,
                        "senderid" => $senderid,
                        "number" => $number,
                        "message" => $message
                    ];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    // return $response;

                    return response()->json([
                        'status' => 200,
                        'selling_invoice_no' => Crypt::encrypt($selling_invoice_no),
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
            $query = Selling_summary::where('branch_id', Auth::user()->branch_id)
                            ->leftJoin('customers', 'selling_summaries.customer_id', 'customers.id');
            if($request->customer_id){
                $query->where('selling_summaries.customer_id', $request->customer_id);
            }

            if($request->payment_status){
                $query->where('selling_summaries.payment_status', $request->payment_status);
            }

            $selling_summaries = $query->select('selling_summaries.*', 'customers.customer_name')
                                    ->orderBy('created_at', 'DESC')->get();

            return Datatables::of($selling_summaries)
                    ->addIndexColumn()
                    ->editColumn('payment_status', function($row){
                        if($row->payment_status != "Paid"){
                            return'
                            <span class="badge bg-warning">'.$row->payment_status.'</span>
                            <button type="button" id="'.$row->selling_invoice_no.'" class="btn btn-primary btn-sm paymentBtn" data-bs-toggle="modal" data-bs-target="#paymentModal"><i class="fa-regular fa-credit-card"></i></button>
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
                    ->rawColumns(['payment_status', 'action'])
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

                // Send SMS
                $customer = Customer::find($request->customer_id);
                $before_payment_amount = $selling_summary->first()->payment_amount;

                $url = "https://bulksmsbd.net/api/smsapi";
                $api_key = env('SMS_API_KEY');
                $senderid = env('SMS_SENDER_ID');
                $number = "$customer->customer_phone_number";
                $message = "Hello $customer->customer_name.
                            Your invoice no $request->selling_invoice_no.
                            Your shopping cost $request->grand_total.
                            Your before payment amount $before_payment_amount.
                            Your due amount $due_amount.
                            Now your payment amount $request->payment_amount, Your payment method $request->payment_method.
                            Thanks for payment your due amount.
                            ";
                $data = [
                    "api_key" => $api_key,
                    "senderid" => $senderid,
                    "number" => $number,
                    "message" => $message
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                // return $response;
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
}
