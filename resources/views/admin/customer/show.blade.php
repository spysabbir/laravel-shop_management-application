<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>{{ $customer->customer_name }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Customer Email</td>
                <td>{{ $customer->customer_email }}</td>
            </tr>
            <tr>
                <td>Customer Phone Number</td>
                <td>{{ $customer->customer_phone_number }}</td>
            </tr>
            <tr>
                <td>Customer Address</td>
                <td>{{ $customer->customer_address }}</td>
            </tr>
            <tr>
                <td>Customer Status</td>
                <td>{{ $customer->status }}</td>
            </tr>
            <tr>
                <td>Customer Join Date</td>
                <td>{{ $customer->created_at->format('D d-M-Y h:s:m A') }}</td>
            </tr>
        </tbody>
    </table>
</div>
