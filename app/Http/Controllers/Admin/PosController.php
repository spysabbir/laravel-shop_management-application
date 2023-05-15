<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function purchaseProduct ()
    {
        $suppliers = Supplier::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return view('admin.purchase.create', compact('suppliers', 'categories'));
    }

    public function getProducts(Request $request)
    {
        $send_products = "";
        $products = Product::where('category_id', $request->category_id)->get();
        if($products->count() <= 0){
            $send_products .= '
            <div class="col-lg-12 mb-3 text-center" >
                <span class="text-danger">Not Found</span>
            </div>
            ';
        }else{
            foreach ($products as $product) {
                $send_products .= '
                <div class="col-lg-4 col-12 mb-3" >
                    <div class="card ">
                        <img src="'.asset('uploads/product_photo')."/".$product->product_photo.'" class="card-img-top" height="100px" alt="Product Photo">
                        <div class="card-body p-2">
                            <p class="card-title">'.$product->product_name.'</p>
                            <h6 class="card-subtitle">Price: '.$product->selling_price.'</h6>
                        </div>
                        <button class="btn btn-primary mt-2 add_item_btn" id="'.$product->product_name.'" type="button"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                ';
            }
        }
        return response()->json($send_products);
    }

    public function purchaseProductStore(Request $request)
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
            if($request->payment_status != 'Unpaid' && $request->payment_method == NULL){
                return response()->json([
                    'status' => 402,
                    'message' => 'The payment_method field is required.',
                ]);
            }else{
                $purchase_summery_id = Purchase_summary::insertGetId([
                    'purchase_invoice_no' => $request->purchase_invoice_no,
                    'purchase_date' => $request->purchase_date,
                    'supplier_id' => $request->supplier_id,
                    'sub_total' => $request->sub_total,
                    'discount' => $request->discount,
                    'grand_total' => $request->grand_total,
                    'payment_status' => $request->payment_status,
                    'payment_amount' => $request->payment_amount,
                    'purchase_agent_id' => Auth::user()->id,
                    // 'branch_id' => Auth::user()->branch_id,
                    'branch_id' => 1,
                    'created_at' => Carbon::now(),
                ]);

                Suppliers_payment_summary::insert([
                    'supplier_id' => $request->supplier_id,
                    'purchase_invoice_no' => $request->purchase_invoice_no,
                    'grand_total' => $request->grand_total,
                    'payment_status' => $request->payment_status,
                    'payment_method' => $request->payment_method,
                    'payment_amount' => $request->payment_amount,
                    'payment_agent_id' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);

                foreach($request->inputs as $value){
                    Purchase_details::insert($value+[
                        'purchase_invoice_no' => $request->purchase_invoice_no,
                        'created_at' => Carbon::now()
                    ]);
                }
                Product::where('product_name', $value->product_id)->update([
                        'purchase_price' => $value->purchase_price,
                    ]);
                Product::where('product_name', $value->product_id)->increment('purchase_quantity', $value->purchase_quantity);

                // $purchase_summary = Purchase_summary::find($purchase_summery_id);
                // Mail::to(Supplier::find($request->supplier_id)->supplier_email)
                // ->send(new Purchase_successfullyMail($purchase_summary));

                return response()->json([
                    'status' => 200,
                    'message' => 'Product purchase successfully.',
                ]);
            }
        }
    }

    public function purchaseList(Request $request)
    {
        if ($request->ajax()) {
            $purchase_summaries = "";
            $query = Purchase_summary::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->leftJoin('suppliers', 'purchase_summaries.supplier_id', 'suppliers.id')
                ->leftJoin('users', 'purchase_summaries.purchase_agent_id', 'users.id');

            if($request->supplier_id){
                $query->where('purchase_summaries.supplier_id', $request->supplier_id);
            }
            if($request->payment_status){
                $query->where('purchase_summaries.payment_status', $request->payment_status);
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
                            <a href="'.route('purchase.invoice.download', Crypt::encrypt($row->purchase_invoice_no)) .'"  class="btn btn-primary btn-sm" ><i class="fa-solid fa-download"></i></a>
                            <a href="'.route('purchase.invoice', Crypt::encrypt($row->purchase_invoice_no) ).'" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-print"></i></a>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['purchase_date', 'payment_status', 'action'])
                    ->make(true);
        }

        $suppliers = Supplier::all();
        return view('admin.purchase.index', compact('suppliers'));
    }

    public function supplierPayment($purchase_invoice_no)
    {
        $purchase_summary = Purchase_summary::where('purchase_invoice_no', $purchase_invoice_no)->first();
        return response()->json($purchase_summary);
    }

    public function supplierPaymentUpdate(Request $request, $purchase_invoice_no)
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
            $purchase_summary = Purchase_summary::where('purchase_invoice_no', $purchase_invoice_no);
            $due_amount = $purchase_summary->first()->grand_total - $purchase_summary->first()->payment_amount;
            if($request->payment_amount > $due_amount){
                return response()->json([
                    'status' => 401,
                    'message' => 'Payment quantity greater than due amount',
                ]);
            }else{
                $purchase_summary->increment('payment_amount', $request->payment_amount);
                $purchase_summary->update([
                    'payment_status' => $request->payment_status,
                ]);
                Suppliers_payment_summary::insert([
                    'supplier_id' => $request->supplier_id,
                    'purchase_invoice_no' => $request->purchase_invoice_no,
                    'grand_total' => $request->grand_total,
                    'payment_status' => $request->payment_status,
                    'payment_method' => $request->payment_method,
                    'payment_amount' => $request->payment_amount,
                    'payment_agent_id' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Supplier payment successfully.',
                ]);
            }
        }
    }

    public function purchaseInvoice($purchase_invoice_no){
        $default_setting = DefaultSetting::first();
        $purchase_invoice_no = Crypt::decrypt($purchase_invoice_no);
        $purchase_summary = Purchase_summary::where('purchase_invoice_no', $purchase_invoice_no)->first();
        $purchase_details = Purchase_details::where('purchase_invoice_no', $purchase_invoice_no)->get();
        $payment_summaries = Suppliers_payment_summary::where('purchase_invoice_no', $purchase_invoice_no)->get();
        return view('admin.purchase.invoice', compact('default_setting', 'purchase_summary', 'purchase_details', 'payment_summaries'));
    }

    public function purchaseInvoiceDownload($purchase_invoice_no){
        $default_setting = DefaultSetting::first();
        $purchase_invoice_no = Crypt::decrypt($purchase_invoice_no);
        $purchase_summary = Purchase_summary::where('purchase_invoice_no', $purchase_invoice_no)->first();
        $purchase_details = Purchase_details::where('purchase_invoice_no', $purchase_invoice_no)->get();
        $payment_summaries = Suppliers_payment_summary::where('purchase_invoice_no', $purchase_invoice_no)->get();
        $pdf = Pdf::loadView('admin.purchase.invoice', compact('default_setting', 'purchase_summary', 'purchase_details', 'payment_summaries'));
        return $pdf->stream($purchase_invoice_no.'invoice.pdf');
    }
}
