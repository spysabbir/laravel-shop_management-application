@extends('admin.layouts.admin_master')

@section('title', 'Purchase Report')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Purchase Report</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">

                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <form action="{{ route('purchase.report.export') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-2">
                                <label class="form-label">Branch Name</label>
                                <select class="form-control filter_data" name="branch_id" id="branch_id">
                                    <option value="">All</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label">Supplier Name</label>
                                <select class="form-control filter_data" name="supplier_id" id="supplier_id">
                                    <option value="">All</option>
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
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
                            <div class="col-lg-2">
                                <label class="form-label">Purchase Date Start</label>
                                <input type="date" class="form-control filter_data" name="purchase_date_start" id="purchase_date_start">
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Purchase Date End</label>
                                <input type="date" class="form-control filter_data" name="purchase_date_end" id="purchase_date_end">
                            </div>
                            <div class="col-lg-1 pt-3">
                                <button class="btn btn-sm btn-success mt-3" type="submit">Export</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="purchase_list_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Invoice No</th>
                                <th>Purchase Date</th>
                                <th>Supplier Name</th>
                                <th>Grand Total</th>
                                <th>Payment Amount</th>
                                <th>Payment Status</th>
                                <th>Purchase Agent</th>
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
        table = $('#purchase_list_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('purchase.report') }}",
                "data":function(e){
                    e.branch_id = $('#branch_id').val();
                    e.supplier_id = $('#supplier_id').val();
                    e.payment_status = $('#payment_status').val();
                    e.purchase_date_start = $('#purchase_date_start').val();
                    e.purchase_date_end = $('#purchase_date_end').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'purchase_invoice_no', name: 'purchase_invoice_no'},
                {data: 'purchase_date', name: 'purchase_date'},
                {data: 'supplier_name', name: 'supplier_name'},
                {data: 'grand_total', name: 'grand_total'},
                {data: 'payment_amount', name: 'payment_amount'},
                {data: 'payment_status', name: 'payment_status'},
                {data: 'name', name: 'name'},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#purchase_list_table').DataTable().ajax.reload()
        })

    });
</script>
@endsection
