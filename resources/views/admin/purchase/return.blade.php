@extends('admin.layouts.admin_master')

@section('title', 'Purchase Return')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Purchase Return</h4>
                </div>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    <div class="row mb-3py-2">
                        <div class="col-lg-4 col-12 mb-3">
                            <label class="form-label">Purchase Invoice No</label>
                            <input type="text" name="purchase_invoice_no" value="PI-{{ App\Models\Purchase_summary::max('id')+1 }}" id="purchase_invoice_no" class="form-control filter_data">
                            <span class="text-danger error-text purchase_invoice_no_error"></span>
                        </div>
                        <div class="col-lg-4 col-12 mb-3">
                            <button type="submit" class="btn btn-info mt-4">Find</button>
                        </div>
                    </div>
                </form>
                <form action="#" method="POST" id="purchase_product_form">
                    @csrf
                    <input type="hidden" name="purchase_invoice_no" id="set_purchase_invoice_no">
                    <div class="row mb-3py-2">
                        <div class="col-lg-4 col-12 mb-3">
                            <label class="form-label">Purchase Date</label>
                            <input type="text" name="purchase_date" value="" class="form-control">
                        </div>
                        <div class="col-lg-4 col-12 mb-3">
                            <label class="form-label">Supplier Name</label>
                            <input type="text" name="supplier_id" value="" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3 py-2">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-primary">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Product Name</th>
                                            <th>Brand Name</th>
                                            <th>Unit Name</th>
                                            <th>Purchase Quantity</th>
                                            <th>Purchase Price</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sl No</td>
                                            <td>Product Name</td>
                                            <td>Brand Name</td>
                                            <td>Unit Name</td>
                                            <td>Purchase Quantity</td>
                                            <td>Purchase Price</td>
                                            <td>Total Price</td>
                                            <td>Action</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-dark py-2 d-flex justify-content-end">
                        <div class="col-lg-2 col-12 mb-3">
                            <label class="form-label">Sub Total</label>
                            <input type="text" name="sub_total" value="00" class="form-control" id="sub_total" readonly/>
                            <span class="text-danger error-text sub_total_error"></span>
                        </div>
                        <div class="col-lg-2 col-12 mb-3">
                            <label class="form-label">Discount</label>
                            <input type="text" name="discount" value="00" class="form-control" id="discount"/>
                            <span class="text-danger error-text discount_error"></span>
                        </div>
                        <div class="col-lg-2 col-12 mb-3">
                            <label class="form-label">Grand Total</label>
                            <input type="text" name="grand_total" value="00" class="form-control" id="grand_total" readonly/>
                            <span class="text-danger error-text grand_total_error"></span>
                        </div>
                        <div class="col-lg-2 col-12 mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select" id="payment_status">
                                <option value="">--Select--</option>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Partially Paid">Partially Paid</option>
                            </select>
                            <span class="text-danger error-text payment_status_error"></span>
                        </div>
                        <div class="col-lg-2 col-12 mb-3" id="payment_amount_div">
                            <label class="form-label">Payment Amount</label>
                            <input type="text" name="payment_amount" value="00" class="form-control" id="payment_amount"/>
                            <span class="text-danger error-text payment_amount_error"></span>
                        </div>
                        <div class="col-lg-2 col-12 mb-3" id="payment_method_div">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select" id="payment_method">
                                <option value="">--Select--</option>
                                <option value="Hand Cash">Hand Cash</option>
                                <option value="Online">Online</option>
                            </select>
                            <span id="payment_method_error" class="text-danger"></span>
                        </div>
                        <div class="col-12 d-flex flex-row-reverse">
                            <button class="btb btn-success p-2 m-2" id="purchase_product_btn" type="submit">Purchase</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    
</script>
@endsection
