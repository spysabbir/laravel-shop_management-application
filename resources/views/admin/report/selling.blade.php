@extends('admin.layouts.admin_master')

@section('title', 'Selling Report')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Selling Report</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">

                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <form action="{{ route('selling.report.export') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label class="form-label">Customer Name</label>
                                <select class="form-control filter_data" name="customer_id" id="customer_id">
                                    <option value="">All</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Payment Status</label>
                                <select class="form-control filter_data" name="payment_status" id="payment_status">
                                    <option value="">All</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Partially Paid">Partially Paid</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label">Purchase Date Start</label>
                                <input type="date" class="form-control filter_data" name="selling_date_start" id="selling_date_start">
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label">Purchase Date End</label>
                                <input type="date" class="form-control filter_data" name="selling_date_end" id="selling_date_end">
                            </div>
                            <div class="col-lg-1 pt-3">
                                <button class="btn btn-sm btn-success mt-3" type="submit">Export</button>
                            </div>
                        </div>
                    </form>
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
                                <th>Selling Agent</th>
                            </tr>
                        </thead>
                        <tbody>
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
                url: "{{ route('selling.report') }}",
                "data":function(e){
                    e.customer_id = $('#customer_id').val();
                    e.payment_status = $('#payment_status').val();
                    e.selling_date_start = $('#selling_date_start').val();
                    e.selling_date_end = $('#selling_date_end').val();
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
                {data: 'name', name: 'name'},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#selling_list_table').DataTable().ajax.reload()
        })
    });
</script>
@endsection
