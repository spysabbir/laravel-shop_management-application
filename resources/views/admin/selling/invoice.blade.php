<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Selling Invoice</title>
    <style>
        * {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}

body {
	font-family: Arial, sans-serif;
}

.container {
	max-width: 820px;
	margin: 0 auto;
	padding: 20px;
	border: 1px solid #ccc;
}

header {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 40px;
}

.logo img {
	max-height: 75px;
}

.company-info h2 {
	font-size: 24px;
}

.company-info p {
	font-size: 16px;
	margin-top: 10px;
	line-height: 1.5;
}

.invoice-info h1 {
	font-size: 36px;
	margin-bottom: 10px;
}

.invoice-info p {
	font-size: 18px;
	line-height: 1.5;
}

.details {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
	margin-bottom: 40px;
}

.details h3 {
	font-size: 24px;
	margin-bottom: 10px;
}

.customer-info p, .payment-info p {
	font-size: 16px;
	margin-top: 10px;
	line-height: 1.5;
}

.invoice-table {
	margin-bottom: 40px;
}

table {
	width: 100%;
	border-collapse: collapse;
}

thead {
	background-color: #ccc;
}

thead th {
	padding: 10px;
	text-align: left;
}

tbody td {
	padding: 10px;
	text-align: left;
	border-bottom: 1px solid #ccc;
}

tfoot td {
	padding: 10px;
	text-align: right;
	border-top: 1px solid #ccc;
	font-weight: bold;
}

tfoot td:first-child {
	text-align: left;
}

@media only screen and (max-width: 600px) {
	.company-info, .invoice-info {
		text-align: center;
		margin-bottom: 20px;
	}
	.invoice-info h1 {
		font-size: 28px;
	}
	.customer-info, .payment-info {
		margin-top: 20px;
	}
}
    </style>
</head>
<body>
	<div class="container">
		<header>
			<div class="company-info">
				<h2>{{ $default_setting->app_name }}</h2>
				<p>{{ $default_setting->address }}<br> {{ $default_setting->support_email }}<br> {{ $default_setting->support_phone }}</p>
			</div>
			<div class="invoice-info">
				<h1>Invoice: #{{ $selling_summary->selling_invoice_no }}</h1>
				<p>Date: {{ $selling_summary->selling_date }}</p>
			</div>
		</header>
		<section class="details">
			<div class="customer-info">
				<h3>Customer </h3>
				<p>{{ $selling_summary->relationtocustomer->customer_name }}<br>{{ $selling_summary->relationtocustomer->customer_address }}</p>
				<p>{{ $selling_summary->relationtocustomer->customer_phone_number }}<br>{{ $selling_summary->relationtocustomer->customer_email }}</p>
			</div>
			<div class="payment-info">
				<h3>Payment Details</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Date:</th>
                            <th>Method:</th>
                            <th>Status:</th>
                            <th>Amount:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment_summaries as $payment_summary)
                        <tr>
                            <td>{{ $payment_summary->created_at->format('d-M,Y') }}</td>
                            <td>{{ $payment_summary->payment_method }}</td>
                            <td>{{ $payment_summary->payment_status }}</td>
                            <td>{{ $payment_summary->payment_amount }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
			</div>
		</section>
		<section class="invoice-table">
			<table>
				<thead>
					<tr>
						<th>Item</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
                    @foreach ($selling_details as $selling_detail)
					<tr>
						<td>{{ $selling_detail->relationtoproduct->product_name }}</td>
						<td>{{ $selling_detail->selling_quantity }}</td>
						<td>{{ $selling_detail->selling_price }}</td>
						<td>{{ $selling_detail->selling_quantity * $selling_detail->selling_price }}</td>
					</tr>
                    @endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3">Subtotal</td>
						<td>{{ $selling_summary->sub_total }}</td>
					</tr>
					<tr>
						<td colspan="3">Discount</td>
						<td>{{ $selling_summary->discount }}</td>
					</tr>
					<tr>
						<td colspan="3">Total</td>
						<td>{{ $selling_summary->grand_total }}</td>
					</tr>
				</tfoot>
			</table>
		</section>
	</div>
</body>
</html>
