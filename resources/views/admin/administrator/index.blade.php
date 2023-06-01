@extends('admin.layouts.admin_master')

@section('title', 'Administrator')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Administrator</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">
                    <a href="{{ route('register') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Status</label>
                            <select class="form-control filter_data" id="filter_status">
                                <option value="">All</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Role</label>
                            <select class="form-control filter_data" id="filter_role">
                                <option value="">All</option>
                                <option value="Admin">Admin</option>
                                <option value="Manager">Manager</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="all_administrator_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Join Date</th>
                                <th>Profile Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Phone Number</th>
                                <th>Role</th>
                                <th>Branch</th>
                                <th>Last Active</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Modal -->
                            <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Update</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" method="POST" id="edit_form">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="" id="administrator_id">
                                                <div class="mb-3">
                                                    <label class="form-label">Role</label>
                                                    <select class="form-select role_status" name="role" id="role">
                                                        <option value="">Select Role</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Manager">Manager</option>
                                                    </select>
                                                    <span class="text-danger error-text update_role_error"></span>
                                                </div>
                                                <div class="mb-3" id="branch_div">
                                                    <label class="form-label">Branch</label>
                                                    <select class="form-select" name="branch_id" id="branch_id">
                                                        <option value="">Select Branch</option>
                                                        @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text update_branch_id_error"></span>
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
        table = $('#all_administrator_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('all.administrator') }}",
                "data":function(e){
                    e.status = $('#filter_status').val();
                    e.role = $('#filter_role').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'created_at', name: 'created_at'},
                {data: 'profile_photo', name: 'profile_photo'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'gender', name: 'gender'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'role', name: 'role'},
                {data: 'branch_name', name: 'branch_name'},
                {data: 'last_active', name: 'last_active'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#all_administrator_table').DataTable().ajax.reload()
        })

        // Edit Form
        $(document).on('click', '.editBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('administrator.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#role").val(response.role);
                    $("#branch_id").val(response.branch_id);
                    $('#administrator_id').val(response.id)
                    if(response.role == 'Manager'){
                        $('#branch_div').show();
                    }else{
                        $('#branch_div').hide();
                    }
                }
            });
        })

        // Select Branch
        $(document).on('change', '.role_status', function(e){
            e.preventDefault();
            if($('.role_status').find(":selected").val() == 'Manager'){
                $('#branch_div').show();
            }else{
                $('#branch_div').hide();
            }
        })

        // Update Data
        $('#edit_form').on('submit', function(e){
            e.preventDefault();
            var id = $('#administrator_id').val();
            var url = "{{ route('administrator.update', ":id") }}";
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
                        table.ajax.reload();
                        toastr.success(response.message);
                    }
                }
            });
        });

        // Status Change
        $(document).on('click', '.statusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('administrator.status', ":id") }}";
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
    });
</script>
@endsection
