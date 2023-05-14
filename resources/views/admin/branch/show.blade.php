<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
                <th>Branch Name</th>
                <th>{{ $branch->branch_name }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Branch Email</td>
                <td>{{ $branch->branch_email }}</td>
            </tr>
            <tr>
                <td>Branch Phone Number</td>
                <td>{{ $branch->branch_phone_number }}</td>
            </tr>
            <tr>
                <td>Branch Address</td>
                <td>{{ $branch->branch_address }}</td>
            </tr>
            <tr>
                <td>Branch Status</td>
                <td>{{ $branch->status }}</td>
            </tr>
            <tr>
                <td>Branch Join Date</td>
                <td>{{ $branch->created_at->format('D d-M-Y h:s:m A') }}</td>
            </tr>
        </tbody>
    </table>
</div>

