@extends('admin.layouts.admin_master')

@section('title', 'Purchase')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Purchase Product</h4>
                </div>
            </div>
            <div class="card-body">
                <form action="#" method="POST" id="purchase_cart_form">
                    @csrf
                    <div class="row mb-3 bg-dark py-2">
                        <div class="col-lg-2 col-12 mb-3">
                            <label class="form-label text-white">Purchase Invoice No</label>
                            <input type="text" name="purchase_invoice_no" value="PI-{{ App\Models\Purchase_summary::max('id')+1 }}" id="purchase_invoice_no" class="form-control filter_data">
                            <span class="text-danger error-text purchase_invoice_no_error"></span>
                        </div>
                        <div class="col-lg-3 col-12 mb-3">
                            <label class="form-label text-white">Purchase Date</label>
                            <input type="date" name="purchase_date" id="purchase_date" class="form-control filter_data">
                            <span class="text-danger error-text purchase_date_error"></span>
                        </div>
                        <div class="col-lg-4 col-12 mb-3">
                            <label class="form-label text-white">Supplier Name</label>
                            <select class="form-select filter_data select_supplier" name="supplier_id" id="supplier_id">
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }} ({{ $supplier->supplier_phone_number }})</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text supplier_id_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3 bg-info py-2">
                        <div class="col-lg-3 col-12 mb-3">
                            <label class="form-label text-dark">Category Name</label>
                            <select name="category_id" class="form-select select_category" >
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text category_id_error"></span>
                        </div>
                        <div class="col-lg-3 col-12 mb-3">
                            <label class="form-label text-dark">Product Name</label>
                            <select name="product_id" class="form-select select_product" id="all_product">
                                <option value="">Select Category First</option>
                            </select>
                            <span class="text-danger error-text product_id_error"></span>
                        </div>
                        <div class="col-lg-2 col-12 mb-3">
                            <label class="form-label text-dark">Product Stoct</label>
                            <input type="text" id="get_product_stock" style="width: 150px" readonly>
                        </div>
                        <div class="col-lg-2 col-12 mb-3">
                            <label class="form-label text-dark">Purchase Price</label>
                            <input type="text" id="get_purchase_price" name="purchase_price" style="width: 150px" readonly>
                        </div>
                        <div class="col-lg-1 pt-3">
                            <button class="btn btn-primary mt-2" id="purchase_cart_btn" type="Submit"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>
                </form>
                <div class="row mb-3 py-2">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-primary" id="purchase_carts_table">
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

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <form action="#" method="POST" id="purchase_product_form">
                    @csrf
                    <input type="hidden" name="purchase_invoice_no" id="set_purchase_invoice_no">
                    <input type="hidden" name="purchase_date" id="set_purchase_date">
                    <input type="hidden" name="supplier_id" id="set_supplier_id">
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
    $(document).ready(function() {

        $('.select_supplier').select2({
            placeholder: 'Select an supplier',
            theme: "classic"
        });

        $('.select_category').select2({
            placeholder: 'Select an category'
        });

        $('.select_product').select2({
            placeholder: 'Select category first'
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Get Product
        $(document).on('change', '.select_category', function(e){
            e.preventDefault();
            var category_id = $(this).val();
            $.ajax({
                url: '{{ route('purchase.product.list') }}',
                method: 'POST',
                data: {category_id:category_id},
                success: function(response) {
                    $('#all_product').html(response);
                }
            });
        })

        // Get Product Details
        $(document).on('change', '.select_product', function(e){
            e.preventDefault();
            var product_id = $(this).val();
            $.ajax({
                url: '{{ route('purchase.product.details') }}',
                method: 'POST',
                data: {product_id:product_id},
                success: function(response) {
                    $('#get_product_stock').val(response.product_stock);
                    $('#get_purchase_price').val(response.purchase_price);
                }
            });
        })

        // Store Purchase Cart Data
        $('#purchase_cart_form').on('submit', function(e){
            e.preventDefault();
            const form_data = new FormData(this);
            $("#purchase_cart_btn").text('Creating');
            $.ajax({
                url: '{{ route('add.purchase.cart') }}',
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        if(response.status == 401){
                            toastr.warning(response.message);
                        }else{
                            $("#purchase_cart_btn").text('Created');
                            table.ajax.reload();
                            toastr.success(response.message);
                        }
                    }
                }
            });
        });

        // Read Purchase Cart Data
        table = $('#purchase_carts_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('purchase.product') }}",
                "data":function(e){
                    e.purchase_invoice_no = $('#purchase_invoice_no').val();
                    e.purchase_date = $('#purchase_date').val();
                    e.supplier_id = $('#supplier_id').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'product_name', name: 'product_name'},
                {data: 'brand_name', name: 'brand_name'},
                {data: 'unit_name', name: 'unit_name'},
                {data: 'purchase_quantity', name: 'purchase_quantity'},
                {data: 'purchase_price', name: 'purchase_price'},
                {data: 'total_price', name: 'total_price'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Change Purchase Quantity
        $(document).on("change", ".purchase_quantity, .purchase_price", function () {
            var purchase_quantity = $('.purchase_quantity').val();
            var purchase_price = $('.purchase_price').val();
            var cart_id = $(this).attr('id');
            var purchase_invoice_no = $('#purchase_invoice_no').val();
            var purchase_date = $('#purchase_date').val();
            var supplier_id = $('#supplier_id').val();
            $.ajax({
                url: '{{ route('change.purchase.cart.data') }}',
                method: 'POST',
                data: {cart_id:cart_id, purchase_quantity:purchase_quantity, purchase_price:purchase_price, purchase_invoice_no:purchase_invoice_no, purchase_date:purchase_date, supplier_id:supplier_id},
                success: function(response) {
                    $('#purchase_carts_table').DataTable().ajax.reload();
                    $('#sub_total').val(response);
                    $('#grand_total').val(response);
                    $('#payment_amount').val(response);
                }
            });
        })

        // Change Discount
        $(document).on('keyup', '#discount', function(e){
            e.preventDefault();
            var sub_total = $('#sub_total').val();
            let discountValue = $(this).val();
            if (discountValue != 0) {
                var discount = $(this).val();
            } else {
                var discount = 0;
            }
            var grand_total = parseInt(sub_total) - parseInt(discount);
            $('#grand_total').val(grand_total);
            $('#payment_amount').val(grand_total);
        })

        // Purchase Item Delete
        $(document).on('click', '.deleteBtn', function(e){
            e.preventDefault();
            var purchase_invoice_no = $('#purchase_invoice_no').val();
            var purchase_date = $('#purchase_date').val();
            var supplier_id = $('#supplier_id').val();
            var cart_id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('purchase.cart.item.delete') }}",
                        method: 'POST',
                        data: {cart_id:cart_id, purchase_invoice_no:purchase_invoice_no, purchase_date:purchase_date, supplier_id:supplier_id},
                        success: function(response) {
                            $('#purchase_carts_table').DataTable().ajax.reload()
                            $('#sub_total').val(response.sub_total);
                            $('#grand_total').val(response.sub_total);
                            $('#payment_amount').val(response.sub_total);
                            toastr.error(response.message);
                        }
                    });
                }
            })
        })

        // Change Payment Status
        $('#payment_amount_div').hide();
        $(document).on('change', '#payment_status', function(e){
            e.preventDefault();
            if($('#payment_status').find(":selected").val() == 'Partially Paid'){
                $('#payment_amount').val('');
                $('#payment_amount_div').show();
            }else{
                if($('#payment_status').find(":selected").val() == 'Unpaid'){
                    $('#payment_amount').val('00');
                    $('#payment_amount_div').hide();
                }else{
                    $('#payment_amount').val($('#grand_total').val());
                    $('#payment_amount_div').hide();
                }
            }
        })

        // Change Payment Method
        $('#payment_method_div').hide();
        $(document).on('change', '#payment_status', function(e){
            e.preventDefault();
            if($('#payment_status').find(":selected").val() == 'Paid' || $('#payment_status').find(":selected").val() == 'Partially Paid'){
                $('#payment_method_div').show();
                $('#payment_method').val("")
            }else{
                if($('#payment_status').find(":selected").val() == 'Unpaid'){
                    $('#payment_method_div').hide();
                    $('#payment_method').val("")
                }else{
                    $('#payment_method_div').hide();
                    $('#payment_method').val("")
                }
            }
        })

        // Get Subtotal
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            var purchase_invoice_no = $('#purchase_invoice_no').val();
            var purchase_date = $('#purchase_date').val();
            var supplier_id = $('#supplier_id').val();
            $('#set_purchase_invoice_no').val(purchase_invoice_no)
            $('#set_purchase_date').val(purchase_date)
            $('#set_supplier_id').val(supplier_id)
            $.ajax({
                url: '{{ route('purchase.subtotal') }}',
                method: 'POST',
                data: {purchase_invoice_no:purchase_invoice_no, purchase_date:purchase_date, supplier_id:supplier_id},
                success: function(response) {
                    $('#purchase_carts_table').DataTable().ajax.reload();
                    $('#sub_total').val(response);
                    $('#grand_total').val(response);
                    $('#payment_amount').val(response);
                }
            });
        })

        // Store Purchase Product Data
        $('#purchase_product_form').on('submit', function(e){
            e.preventDefault();
            const form_data = new FormData(this);
            $("#purchase_btn").text('Creating');
            $.ajax({
                url: '{{ route('store.purchase.product') }}',
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                    $("#payment_method_error").html('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        if(response.status == 401){
                            toastr.warning(response.message);
                        }else{
                            if(response.status == 402){
                                $("#payment_method_error").html(response.message);
                            }else{
                                $('#purchase_carts_table').DataTable().ajax.reload()
                                $("#purchase_product_btn").text('Created');
                                $("#purchase_cart_form")[0].reset();
                                $("#purchase_product_form")[0].reset();
                                toastr.success(response.message);
                                window.location = '{{ route('purchase.list') }}'
                            }
                        }
                    }
                }
            });
        });
    });

</script>
@endsection
