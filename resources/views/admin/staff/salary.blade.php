@extends('admin.layouts.admin_master')

@section('title', 'Staff Salary')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Staff Salary</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">All</option>
                                <option value="Active" selected>Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="active_staff_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Join Date</th>
                                <th>Profile Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Modal -->
                            <div class="modal fade" id="paymentSalaryDetailsModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="model_body">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="paymentSalaryModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Payment Salary</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" method="POST" id="payment_form">
                                                @csrf
                                                <input type="hidden" name="" id="staff_id">
                                                <div class="mb-3">
                                                    <label class="form-label">Salary Year</label>
                                                    <select name="salary_year" class="form-select">
                                                        <option value="">Select Year</option>
                                                        @for ($year = 2023; $year < 3023; $year++)
                                                        <option value="{{ $year }}" @selected(date('Y') == ((date('m')==12) ? $year-1 : $year) )>{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                    <span class="text-danger error-text salary_year_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Salary Month</label>
                                                    <select name="salary_month" class="form-select">
                                                        <option value="">Select Year</option>
                                                        <option value="January" @selected(date('m')-1 == 1)>January</option>
                                                        <option value="February" @selected(date('m')-1 == 2)>February</option>
                                                        <option value="March" @selected(date('m')-1 == 3)>March</option>
                                                        <option value="April" @selected(date('m')-1 == 4)>April</option>
                                                        <option value="May" @selected(date('m')-1 == 5)>May</option>
                                                        <option value="June" @selected(date('m')-1 == 6)>June</option>
                                                        <option value="July" @selected(date('m')-1 == 7)>July</option>
                                                        <option value="August" @selected(date('m')-1 == 8)>August</option>
                                                        <option value="September" @selected(date('m')-1 == 9)>September</option>
                                                        <option value="October" @selected(date('m')-1 == 10)>October</option>
                                                        <option value="November" @selected(date('m')-1 == 11)>November</option>
                                                        <option value="December" @selected(date('m')+11 == 12)>December</option>
                                                    </select>
                                                    <span class="text-danger error-text salary_month_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Payment Salary</label>
                                                    <input type="number" name="payment_salary" class="form-control" id="staff_salary" />
                                                    <span class="text-danger error-text payment_salary_error"></span>
                                                </div>
                                                <button type="submit" id="update_btn" class="btn btn-primary">Payment</button>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Read Data
        table = $('#active_staff_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('staff.salary') }}",
                "data":function(e){
                    e.status = $('#status').val();
                    e.staff_gender = $('#staff_gender').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'created_at', name: 'created_at'},
                {data: 'profile_photo', name: 'profile_photo'},
                {data: 'staff_name', name: 'staff_name'},
                {data: 'staff_email', name: 'staff_email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#active_staff_table').DataTable().ajax.reload()
        })

        // View Details
        $(document).on('click', '.paymentSalaryDetailsBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('staff.salary.payment.details', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#model_body").html(response);
                }
            });
        })

        // Edit Form
        $(document).on('click', '.paymentSalaryBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('staff.salary.payment.form', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#staff_salary").val(response.staff_salary);
                    $('#staff_id').val(response.id)
                }
            });
        })

        // Update Data
        $('#payment_form').on('submit', function(e){
            e.preventDefault();
            var id = $('#staff_id').val();
            var url = "{{ route('staff.salary.payment.store', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#update_btn").text('Updating...');
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
                            if(response.status == 402){
                                toastr.warning(response.message);
                            }else{
                                $("#update_btn").text('Updated');
                                $('.btn-close').trigger('click');
                                table.ajax.reload()
                                toastr.success(response.message);
                            }
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
