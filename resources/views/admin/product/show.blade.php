
<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>{{ $product->product_name }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Product Category</td>
                <td>{{ $product->relationtocategory->category_name }}</td>
            </tr>
            <tr>
                <td>Product brand</td>
                <td>{{ $product->relationtobrand->brand_name }}</td>
            </tr>
            <tr>
                <td>Product Unit</td>
                <td>{{ $product->relationtounit->unit_name }}</td>
            </tr>
            <tr>
                <td>Purchase Quantity</td>
                <td>{{ $product->purchase_quantity }}</td>
            </tr>
            <tr>
                <td>Selling Quantity</td>
                <td>{{ $product->selling_quantity }}</td>
            </tr>
            <tr>
                <td>Purchase Price</td>
                <td>{{ $product->purchase_price }}</td>
            </tr>
            <tr>
                <td>Selling Price</td>
                <td>{{ $product->selling_price }}</td>
            </tr>
            <tr>
                <td>Product Photo</td>
                <td><img width="100" height="100" src="{{ asset('uploads/product_photo') }}/{{ $product->product_photo }}" alt="{{ $product->product_name }}"></td>
            </tr>
            <tr>
                <td>Status</td>
                <td><span class="badge bg-info">{{ $product->status }}</span></td>
            </tr>
            <tr>
                <td>Customer Join Date</td>
                <td>{{ $product->created_at->format('D d-M-Y h:s:m A') }}</td>
            </tr>
        </tbody>
    </table>
</div>
