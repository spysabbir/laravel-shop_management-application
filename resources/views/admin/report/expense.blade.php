@extends('admin.layouts.admin_master')

@section('title', 'Expense Report')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Expense Report</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <form action="{{  route('expense.report.export')  }}" method="POST">
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
                                <label class="form-label">Expense Category Name</label>
                                <select class="form-select filter_data" name="expense_category_id" id="expense_category_id">
                                    <option value="">All</option>
                                    @foreach ($expense_categories as $expense_category)
                                    <option value="{{ $expense_category->id }}">{{ $expense_category->expense_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label">Expense Date Start</label>
                                <input type="date" class="form-control filter_data" name="expense_date_start" id="expense_date_start">
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label">Expense Date End</label>
                                <input type="date" class="form-control filter_data" name="expense_date_end" id="expense_date_end">
                            </div>
                            <div class="col-lg-1 pt-3">
                                <button class="btn btn-sm btn-success mt-3" type="submit">Export</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="expense_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Expense Branch Name</th>
                                <th>Expense Category Name</th>
                                <th>Expense Title</th>
                                <th>Expense Cost</th>
                                <th>Expense Date</th>
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
        table = $('#expense_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('expense.report') }}",
                "data":function(e){
                    e.branch_id = $('#branch_id').val();
                    e.expense_date_start = $('#expense_date_start').val();
                    e.expense_date_end = $('#expense_date_end').val();
                    e.expense_category_id = $('#expense_category_id').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'branch_name', name: 'branch_name'},
                {data: 'expense_category_name', name: 'expense_category_name'},
                {data: 'expense_title', name: 'expense_title'},
                {data: 'expense_cost', name: 'expense_cost'},
                {data: 'created_at', name: 'created_at'},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#expense_table').DataTable().ajax.reload()
        })
    });
</script>
@endsection
