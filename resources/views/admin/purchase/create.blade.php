@extends('admin.layouts.admin_master')

@section('title', 'Purchase')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Purchase</h4>
                    <p class="card-text">Product</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label text-dark">Category Name</label>
                            <select name="inputs[0][category_id]" class="form-select select_category" >
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text category_id_error"></span>
                        </div>
                        <div class="row get_all_product">

                        </div>
                    </div>
                    <div class="col-lg-8">
                        <form action="#" method="POST" id="purchaseProductForm">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-lg-4 col-12 mb-3">
                                    <label class="form-label text-white">Purchase Invoice No</label>
                                    <input type="text" name="purchase_invoice_no" value="PI-{{ App\Models\Purchase_summary::max('id')+1 }}" id="purchase_invoice_no" class="form-control filter_data">
                                    <span class="text-danger error-text purchase_invoice_no_error"></span>
                                </div>
                                <div class="col-lg-4 col-12 mb-3">
                                    <label class="form-label text-white">Purchase Date</label>
                                    <input type="date" name="purchase_date" id="purchase_date" class="form-control filter_data">
                                    <span class="text-danger error-text purchase_date_error"></span>
                                </div>
                                <div class="col-lg-4 col-12 mb-3">
                                    <label class="form-label text-white">Supplier Name</label>
                                    <select class="form-select filter_data select_supplier" name="supplier_id" id="supplier_id">
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text supplier_id_error"></span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Item Details</h4>
                                        </div>
                                        <div class="card-body" id="item_list">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4 col-12 mb-3">
                                    <label class="form-label">Sub Total</label>
                                    <input type="number" name="sub_total" value="00" class="form-control" id="get_sub_total" readonly/>
                                    <span class="text-danger error-text sub_total_error"></span>
                                </div>
                                <div class="col-lg-4 col-12 mb-3">
                                    <label class="form-label">Discount</label>
                                    <input type="number" name="discount" value="00" class="form-control get_discount"/>
                                    <span class="text-danger error-text discount_error"></span>
                                </div>
                                <div class="col-lg-4 col-12 mb-3">
                                    <label class="form-label">Grand Total</label>
                                    <input type="number" name="grand_total" value="00" class="form-control" id="get_grand_total" readonly/>
                                    <span class="text-danger error-text grand_total_error"></span>
                                </div>
                                <div class="col-lg-4 col-12 mb-3">
                                    <label class="form-label">Payment Status</label>
                                    <select name="payment_status" class="form-select" id="payment_status">
                                        <option value="">--Select--</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Unpaid">Unpaid</option>
                                        <option value="Partially Paid">Partially Paid</option>
                                    </select>
                                    <span class="text-danger error-text payment_status_error"></span>
                                </div>
                                <div class="col-lg-4 col-12 mb-3" id="payment_amount_div">
                                    <label class="form-label">Payment Amount</label>
                                    <input type="text" name="payment_amount" value="00" class="form-control" id="payment_amount"/>
                                    <span class="text-danger error-text payment_amount_error"></span>
                                </div>
                                <div class="col-lg-4 col-12 mb-3" id="payment_method_div">
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
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){

        $('.select_supplier').select2({
            placeholder: 'Select an supplier',
            theme: "classic"
        });

        $('.select_category').select2({
            placeholder: 'Select an category'
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add Item
        var counter = 0;
        $(document).on('click', '.add_item_btn', function() {
            ++counter;
            var product_name = $(this).attr('id');
            $('#item_list').append(`
                <div class="row">
                    <div class="col-lg-5 col-12 mb-3">
                        <label class="form-label text-dark">Product Name</label>
                        <input type="text" class="form-control" name="inputs[`+ counter +`][product_id]" value="${product_name}" readonly>
                        <span class="text-danger error-text product_id_error"></span>
                    </div>
                    <div class="col-lg-2 col-12 mb-3">
                        <label class="form-label text-dark">Purchase Qty</label>
                        <input type="number" class="form-control get_purchase_qty" name="inputs[`+ counter +`][purchase_quantity]">
                    </div>
                    <div class="col-lg-2 col-12 mb-3">
                        <label class="form-label text-dark">Purchase Price</label>
                        <input type="number" class="form-control get_purchase_price" name="inputs[`+ counter +`][purchase_price]">
                    </div>
                    <div class="col-lg-2 col-12 mb-3">
                        <label class="form-label text-dark">Total Price</label>
                        <input type="number" class="form-control get_total_price">
                    </div>
                    <div class="col-lg-1 pt-3">
                        <button class="btn btn-danger mt-2 remove_item_btn" type="button"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
            `);
        });

        // Remove Item
        $(document).on('click', '.remove_item_btn', function() {
            $(this).parent().parent().remove();
        });

        // Get all product
        $('body').on('change', '.select_category', function() {
            var category_id = $(this).val();
            var $this = $(this);
            $.ajax({
                url: "{{ route('purchase.product.list') }}",
                type: 'POST',
                data: {category_id: category_id},
                success: function(response) {
                    $this.closest('.row').find('.get_all_product').html(response);
                }
            });
        });

        // Calculate the grand total when the item quantity or cost rate is changed
        $('body').on("change", ".get_purchase_qty, .get_purchase_price", function () {
            var purchase_qty = $(this).closest(".row").find(".get_purchase_qty").val();
            var purchase_price = $(this).closest(".row").find(".get_purchase_price").val();
            var total_cost = purchase_qty * purchase_price;
            $(this).closest(".row").find(".get_total_price").val(total_cost);

            // Calculate the grand total
            var grand_total = 0;
            $(".get_total_price").each(function () {
                grand_total += parseFloat($(this).val()) || 0;
            });
            $("#get_sub_total").val(grand_total);
            $("#get_grand_total").val(grand_total);
        });

        // Change Discount
        $('body').on('change', '.get_discount', function(){
            var sub_total = $('#get_sub_total').val();
            let discountValue = $(this).val();
            if (discountValue != 0) {
                var discount = $(this).val();
            } else {
                var discount = 0;
            }
            var grand_total = parseInt(sub_total) - parseInt(discount);
            $('#get_grand_total').val(grand_total);
            $('#payment_amount').val(grand_total);
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
                    $('#payment_amount').val($('#get_grand_total').val());
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

         // Store Purchase Product Data
         $('#purchaseProductForm').on('submit', function(e){
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
    })
</script>
@endsection
