<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
                <th>Staff Name</th>
                <th>{{ $staff->staff_name }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Staff Designation</td>
                <td>{{ $staff->relationtostaffdesignation->designation_name }}</td>
            </tr>
            <tr>
                <td>Staff Email</td>
                <td>{{ $staff->staff_email }}</td>
            </tr>
            <tr>
                <td>Staff Phone Number</td>
                <td>{{ $staff->staff_phone_number }}</td>
            </tr>
            <tr>
                <td>Staff Gender</td>
                <td>{{ $staff->staff_gender }}</td>
            </tr>
            <tr>
                <td>Staff Nid No</td>
                <td>{{ $staff->staff_nid_no }}</td>
            </tr>
            <tr>
                <td>Staff Date of Birth</td>
                <td>{{ $staff->staff_date_of_birth }}</td>
            </tr>
            <tr>
                <td>Staff Address</td>
                <td>{{ $staff->staff_address }}</td>
            </tr>
            <tr>
                <td>Staff Salary</td>
                <td>{{ $staff->staff_salary }}</td>
            </tr>
            <tr>
                <td>Staff Status</td>
                <td>{{ $staff->status }}</td>
            </tr>
            <tr>
                <td>Staff Join Date</td>
                <td>{{ $staff->created_at->format('D d-M,Y h:n:s A') }}</td>
            </tr>
        </tbody>
    </table>
</div>

