<h3>{{ $staff->staff_name }}</h3>

<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
                <th>Payment Type</th>
                <th>Payment Month & Year</th>
                <th>Payment Amount</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($staff_payments as $staff_payment)
            <tr>
                <td>{{ $staff_payment->payment_type  }}</td>
                <td>{{ $staff_payment->payment_month ."-". $staff_payment->payment_year }}</td>
                <td>{{ $staff_payment->payment_amount }}</td>
                <td>{{ date('d-M-Y h:m:s A', strtotime($staff_payment->payment_at)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
