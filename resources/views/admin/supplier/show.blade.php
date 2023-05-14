<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
                <th>Supplier Name</th>
                <th>{{ $supplier->supplier_name }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Supplier Email</td>
                <td>{{ $supplier->supplier_email }}</td>
            </tr>
            <tr>
                <td>Supplier Phone Number</td>
                <td>{{ $supplier->supplier_phone_number }}</td>
            </tr>
            <tr>
                <td>Supplier Address</td>
                <td>{{ $supplier->supplier_address }}</td>
            </tr>
            <tr>
                <td>Supplier Status</td>
                <td>{{ $supplier->status }}</td>
            </tr>
            <tr>
                <td>Supplier Join Date</td>
                <td>{{ $supplier->created_at->format('D d-M-Y h:s:m A') }}</td>
            </tr>
        </tbody>
    </table>
</div>

