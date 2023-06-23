@extends('admin.layouts.admin_master')

@section('title', 'Staff')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Staff</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">
                    <!-- createModal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Create</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="#" method="POST" id="create_form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Staff Profile Photo</label>
                                            <input type="file" name="profile_photo" class="form-control" />
                                            <span class="text-danger error-text profile_photo_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Staff Name</label>
                                            <input type="text" name="staff_name" class="form-control" placeholder="Enter staff name" />
                                            <span class="text-danger error-text staff_name_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Staff Designation</label>
                                            <select class="form-select" name="staff_designation_id">
                                                <option value="">-- Select Designation --</option>
                                                @foreach ($staff_designations as $designation)
                                                    <option value="{{ $designation->id }}">{{ $designation->designation_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text staff_designation_id_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Staff Email</label>
                                            <input type="email" name="staff_email" class="form-control" placeholder="Enter staff email" />
                                            <span class="text-danger error-text staff_email_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Staff Phone Number</label>
                                            <input type="text" name="staff_phone_number" class="form-control" placeholder="Enter staff phone number" />
                                            <span class="text-danger error-text staff_phone_number_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Staff Gender</label>
                                            <div class="form-group">
                                                <label class="fancy-radio mx-2">
                                                    <input name="staff_gender" value="Male" type="radio">
                                                    <span>Male</span>
                                                </label>
                                                <label class="fancy-radio mx-2">
                                                    <input name="staff_gender" value="Female" type="radio">
                                                    <span>Female</span>
                                                </label>
                                                <label class="fancy-radio mx-2">
                                                    <input name="staff_gender" value="Other" type="radio">
                                                    <span>Other</span>
                                                </label>
                                            </div>
                                            <span class="text-danger error-text staff_gender_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Staff Nid No</label>
                                            <input type="number" name="staff_nid_no" class="form-control" placeholder="Enter nid no"/>
                                            <span class="text-danger error-text staff_nid_no_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Staff Date Of Birth</label>
                                            <input type="date" name="staff_date_of_birth" class="form-control" />
                                            <span class="text-danger error-text staff_date_of_birth_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Staff Address</label>
                                            <textarea name="staff_address" class="form-control" placeholder="Enter staff address"></textarea>
                                            <span class="text-danger error-text staff_address_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Staff Salary</label>
                                            <input type="number" name="staff_salary" class="form-control" placeholder="Enter staff salary"/>
                                            <span class="text-danger error-text staff_salary_error"></span>
                                        </div>
                                        <button type="submit" id="create_btn" class="btn btn-primary">Create</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- trashedModal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#trashedModal">
                        <i class="fa-solid fa-recycle"></i>
                    </button>
                    <div class="modal fade" id="trashedModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Recycle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-primary" id="trashed_staff_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>staff Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">All</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Gender</label>
                            <select class="form-control filter_data" id="staff_gender">
                                <option value="">All</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="all_staff_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                {{-- <th>Join Date</th> --}}
                                <th>Profile Photo</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Phone Number</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Assign Salary Modal -->
                            <div class="modal fade" id="assignSalaryModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Assign Salary</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form">
                                                <form action="#" method="POST" id="assign_salary_form">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="hidden" name="staff_id" id="assign_salary_staff_id">
                                                        <div class="col-4 mb-3">
                                                            <label class="form-label">New Salary</label>
                                                            <input type="number" name="new_salary" class="form-control" placeholder="Enter salary"/>
                                                            <span class="text-danger error-text new_salary_error"></span>
                                                        </div>
                                                        <div class="col-5 mb-3">
                                                            <label class="form-label">Assign Date</label>
                                                            <input type="date" name="assign_date" class="form-control"/>
                                                            <span class="text-danger error-text assign_date_error"></span>
                                                        </div>
                                                        <div class="col-3 mb-3">
                                                            <button type="submit" id="assign_salary_btn" class="btn btn-primary mt-4">Assign</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <h5 class="text-center text-info">Salary List</h5>
                                            <div class="list" id="send_staff_salary_data">

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- View Modal -->
                            <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
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
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Update</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" method="POST" id="edit_form" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="" id="staff_id">
                                                <div class="mb-3">
                                                    <label class="form-label">Staff Profile Photo</label>
                                                    <input type="file" name="profile_photo" class="form-control" />
                                                    <span class="text-danger error-text update_profile_photo_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Staff Name</label>
                                                    <input type="text" name="staff_name" id="staff_name" class="form-control" />
                                                    <span class="text-danger error-text update_staff_name_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Staff Designation</label>
                                                    <select class="form-select" name="staff_designation_id" id="staff_designation_id">
                                                        <option value="">-- Select Designation --</option>
                                                        @foreach ($staff_designations as $designation)
                                                            <option value="{{ $designation->id }}">{{ $designation->designation_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text update_staff_designation_id_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Staff Email</label>
                                                    <input type="text" name="staff_email" id="staff_email" class="form-control" />
                                                    <span class="text-danger error-text update_staff_email_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Staff Phone Number</label>
                                                    <input type="text" name="staff_phone_number" id="staff_phone_number" class="form-control" />
                                                    <span class="text-danger error-text update_staff_phone_number_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Staff Gender</label>
                                                    <div class="form-group">
                                                        <label class="fancy-radio mx-2">
                                                            <input name="staff_gender" id="staff_gender" value="Male" type="radio">
                                                            <span>Male</span>
                                                        </label>
                                                        <label class="fancy-radio mx-2">
                                                            <input name="staff_gender" id="staff_gender" value="Female" type="radio">
                                                            <span>Female</span>
                                                        </label>
                                                        <label class="fancy-radio mx-2">
                                                            <input name="staff_gender" id="staff_gender" value="Other" type="radio">
                                                            <span>Other</span>
                                                        </label>
                                                    </div>
                                                    <span class="text-danger error-text update_staff_gender_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Staff Nid No</label>
                                                    <input type="number" name="staff_nid_no" class="form-control" id="staff_nid_no" />
                                                    <span class="text-danger error-text update_staff_nid_no_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Staff Date Of Birth</label>
                                                    <input type="date" name="staff_date_of_birth" class="form-control staff_date_of_birth" />
                                                    <span class="text-danger error-text update_staff_date_of_birth_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Staff Address</label>
                                                    <textarea name="staff_address" id="staff_address" class="form-control"></textarea>
                                                    <span class="text-danger error-text update_staff_address_error"></span>
                                                </div>
                                                <button type="submit" id="update_btn" class="btn btn-primary">Update</button>
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
        table = $('#all_staff_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('staff.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                    e.staff_gender = $('#staff_gender').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                // {data: 'created_at', name: 'created_at'},
                {data: 'profile_photo', name: 'profile_photo'},
                {data: 'staff_name', name: 'staff_name'},
                {data: 'staff_designation', name: 'staff_designation'},
                {data: 'staff_email', name: 'staff_email'},
                {data: 'staff_gender', name: 'staff_gender'},
                {data: 'staff_phone_number', name: 'staff_phone_number'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#all_staff_table').DataTable().ajax.reload()
        })

        // Store Data
        $('#create_form').on('submit', function(e){
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_btn").text('Creating...');
            $.ajax({
                url: '{{ route('staff.store') }}',
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
                        $("#create_btn").text('Created');
                        $("#create_form")[0].reset();
                        $('.btn-close').trigger('click');
                        table.ajax.reload();
                        toastr.success(response.message);
                    }
                }
            });
        });

        // View Details
        $(document).on('click', '.viewBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('staff.show', ":id") }}";
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
        $(document).on('click', '.editBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('staff.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#staff_name").val(response.staff_name);
                    $("#staff_designation_id").val(response.staff_designation_id);
                    $("#staff_email").val(response.staff_email);
                    $("#staff_phone_number").val(response.staff_phone_number);
                    $("#staff_nid_no").val(response.staff_nid_no);
                    $(".staff_date_of_birth").val(response.staff_date_of_birth);
                    $("#staff_address").val(response.staff_address);
                    $("#staff_salary").val(response.staff_salary);
                    $('#staff_id').val(response.id)

                    if (response.staff_gender == "Male") {
                        $("input:radio[value='Male']").prop('checked',true);
                    }
                    if(response.staff_gender == "Female"){
                        $("input:radio[value='Female']").prop('checked',true);
                    }
                    if(response.staff_gender == "Other"){
                        $("input:radio[value='Other']").prop('checked',true);
                    }
                }
            });
        })

        // Update Data
        $('#edit_form').on('submit', function(e){
            e.preventDefault();
            var id = $('#staff_id').val();
            var url = "{{ route('staff.update', ":id") }}";
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
                            $('span.update_'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        $("#update_btn").text('Updated');
                        $('.btn-close').trigger('click');
                        table.ajax.reload()
                        toastr.success(response.message);
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('staff.destroy', ":id") }}";
            url = url.replace(':id', id)
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
                        url: url,
                        method: 'DELETE',
                        success: function(response) {
                            table.ajax.reload();
                            trashed_table.ajax.reload();
                            toastr.warning(response.message);
                        }
                    });
                }
            })
        })

        // Trashed Data
        trashed_table = $('#trashed_staff_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('staff.trashed') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'staff_name', name: 'staff_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Restore Data
        $(document).on('click', '.restoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('staff.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    table.ajax.reload();
                    trashed_table.ajax.reload();
                    $('.btn-close').trigger('click');
                    toastr.success(response.message);
                }
            });
        })

        // Force Delete
        $(document).on('click', '.forceDeleteBtn', function(e){
            e.preventDefault();
            $('.btn-close').trigger('click');
            let id = $(this).attr('id');
            var url = "{{ route('staff.forcedelete', ":id") }}";
            url = url.replace(':id', id)
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
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        trashed_table.ajax.reload();
                        $('.btn-close').trigger('click');
                        toastr.error(response.message);
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.statusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('staff.status', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    table.ajax.reload();
                    toastr.info(response.message);
                }
            });
        })

        // Assign Salary Form
        $(document).on('click', '.assignSalaryBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('assign.staff.salary', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $('#assign_salary_staff_id').val(response.staff.id);
                    $('#send_staff_salary_data').html(response.send_staff_salary_data);
                }
            });
        })

        // Assign Salary Store
        $('#assign_salary_form').on('submit', function(e){
            e.preventDefault();
            const form_data = new FormData(this);
            $("#assign_salary_btn").text('Creating...');
            $.ajax({
                url: '{{ route('assign.staff.salary.store') }}',
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
                        $("#assign_salary_btn").text('Created');
                        $("#assign_salary_form")[0].reset();
                        $('.btn-close').trigger('click');
                        toastr.success(response.message);
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.assign_staff_salary_delete_btn', function(e){
            e.preventDefault();
            $('.btn-close').trigger('click');
            let id = $(this).attr('id');
            var url = "{{ route('assign.staff.salary.destroy', ":id") }}";
            url = url.replace(':id', id)
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
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            toastr.warning(response.message);
                        }
                    });
                }
            })
        })

    });
</script>
@endsection
