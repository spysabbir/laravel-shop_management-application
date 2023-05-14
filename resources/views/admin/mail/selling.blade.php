<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Placed Succesfully</title>
</head>
<body>
    <p>Hello ,</p>

    <p>Thank You For Ordering!</p>

    <div>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Invoice No</td>
                    <td>{{ $selling_summary->selling_invoice_no }}</td>
                </tr>
                <tr>
                    <td>Sub Total</td>
                    <td>{{ $selling_summary->sub_total }}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>{{ $selling_summary->discount }}</td>
                </tr>
                <tr>
                    <td>Grand Total</td>
                    <td>{{ $selling_summary->grand_total }}</td>
                </tr>
                <tr>
                    <td>Payment Status</td>
                    <td>{{ $selling_summary->payment_status }}</td>
                </tr>
                <tr>
                    <td>Payment Amount</td>
                    <td>{{ $selling_summary->payment_amount }}</td>
                </tr>
            </tbody>
        </table>
    </div>


    <p>We look forward to communicating more with you. For more information visit our Site.</p>

    <a href="{{ env('APP_URL') }}" target="_blank">Visit Website</a>

    <p>© {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.</p>
</body>
</html>
