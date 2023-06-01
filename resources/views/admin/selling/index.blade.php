@extends('admin.layouts.admin_master')

@section('title', 'Selling List')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Selling List</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">

                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Customer Name</label>
                            <select class="form-control filter_data" id="customer_id">
                                <option value="">All</option>
                                @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-control filter_data" id="payment_status">
                                <option value="">All</option>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Partially Paid">Partially Paid</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="selling_list_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Invoice No</th>
                                <th>Selling Date</th>
                                <th>Customer Name</th>
                                <th>Grand Total</th>
                                <th>Payment Amount</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Modal -->
                            <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Payment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" method="POST" id="payment_form">
                                                @csrf
                                                <input type="hidden" name="selling_invoice_no" id="selling_invoice_no">
                                                <input type="hidden" name="customer_id" id="payment_customer_id">
                                                <input type="hidden" name="grand_total" id="grand_total">
                                                <div class="mb-3">
                                                    <label class="form-label">Payment Status</label>
                                                    <select name="payment_status" class="form-select">
                                                        <option value="">Payment Status</option>
                                                        <option value="Paid">Paid</option>
                                                        <option value="Partially Paid">Partially Paid</option>
                                                    </select>
                                                    <span class="text-danger error-text payment_status_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Payment Method</label>
                                                    <select name="payment_method" class="form-select">
                                                        <option value="">Payment Method</option>
                                                        <option value="Hand Cash">Hand Cash</option>
                                                        <option value="Online">Online</option>
                                                    </select>
                                                    <span class="text-danger error-text payment_method_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Payment Amount</label>
                                                    <input type="text" name="payment_amount" id="payment_amount" class="form-control" placeholder="Enter payment amount" />
                                                    <span class="text-danger error-text payment_amount_error"></span>
                                                </div>
                                                <button type="submit" id="payment_btn" class="btn btn-primary">Payment</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Read Data
        table = $('#selling_list_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('selling.list') }}",
                "data":function(e){
                    e.customer_id = $('#customer_id').val();
                    e.payment_status = $('#payment_status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'selling_invoice_no', name: 'selling_invoice_no'},
                {data: 'selling_date', name: 'selling_date'},
                {data: 'customer_name', name: 'customer_name'},
                {data: 'grand_total', name: 'grand_total'},
                {data: 'payment_amount', name: 'payment_amount'},
                {data: 'payment_status', name: 'payment_status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#selling_list_table').DataTable().ajax.reload()
        })

        // View Details
        $(document).on('click', '.paymentBtn', function(e){
            e.preventDefault();
            var selling_invoice_no = $(this).attr('id');
            var url = "{{ route('customer.payment', ":selling_invoice_no") }}";
            url = url.replace(':selling_invoice_no', selling_invoice_no)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#selling_invoice_no").val(response.selling_invoice_no);
                    $("#payment_customer_id").val(response.customer_id);
                    $("#grand_total").val(response.grand_total);
                    $("#payment_amount").val(response.grand_total - response.payment_amount);
                }
            });
        })

         // Store Data
         $('#payment_form').on('submit', function(e){
            e.preventDefault();
            var selling_invoice_no = $('#selling_invoice_no').val();
            var url = "{{ route('customer.payment.update', ":selling_invoice_no") }}";
            url = url.replace(':selling_invoice_no', selling_invoice_no)
            const form_data = new FormData(this);
            $("#payment_btn").text('Creating...');
            $.ajax({
                url: url,
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
                            $("#payment_btn").text('Created');
                            $("#payment_form")[0].reset();
                            $('.btn-close').trigger('click');
                            table.ajax.reload();
                            toastr.success(response.message);
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
