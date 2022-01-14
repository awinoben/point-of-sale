@if(count($sells))
    <table class="table table-hover">
        <thead>
        <tr class="text-primary">
            <th>NO</th>
            <th>Served By</th>
            <th>Payment Mode</th>
            <th>PurchaseNO</th>
            <th>Item Name</th>
            <th>SKU</th>
            <th>Sold Qty</th>
            <th>Selling Price [ KES ]</th>
            <th>Total Price [ KES ]</th>
            <th>Sold On</th>
        </tr>
        </thead>
        <tbody>
        @php($count = 1)
        @foreach($sells as $sell)
            <tr>
                <td class="text-primary"><strong>{{ $count++  }}</strong></td>
                <td>{{ $sell->user->name }}</td>
                <td>{{ $sell->payment_mode->mode }}</td>
                <td>{{ $sell->purchase->purchaseNO }}</td>
                <td>{{ $sell->stock->price->itemName }}</td>
                <td>{{ $sell->stock->SKU }}</td>
                <td>{{ number_format($sell->qty) }}</td>
                <td>{{ number_format($sell->price,2) }}</td>
                <td>{{ number_format($sell->total,2) }}</td>
                <td>{{ date('F d, Y', strtotime($sell->created_at)) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <table>
        <thead>
        <tr>
            <th>Sales(s) Report</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>No items were found.</td>
        </tr>
        </tbody>
    </table>
@endif
