@if(count($prices))
    <table class="table">
        <thead>
        <tr class="text-primary">
            <th>NO</th>
            <th>Item Name</th>
            <th>Item Buying Price [ KES ]</th>
            <th>Item Selling Price [ KES ]</th>
            <th>Reorder Level</th>
            <th>Supplier</th>
            <th>Stock</th>
            <th>Sales</th>
        </tr>
        </thead>
        <tbody>
        @php($count = 1)
        @foreach($prices as $price)
            <tr>
                <td class="text-primary"><strong>{{ $count++  }}</strong></td>
                <td>{{ $price->itemName }}</td>
                <td>{{ number_format($price->itemBPrice,2) }}</td>
                <td>{{ number_format($price->itemPrice,2) }}</td>
                <td>{{ number_format($price->lowest) }}</td>
                <td>{{ number_format(count($price->supply)) }}</td>
                <td>{{ number_format($price->stock()->sum('itemBQuantity')) }}</td>
                <td>{{ number_format(count($price->sale)) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <table>
        <thead>
        <tr>
            <th>Item(s) Report</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>No items were found.</td>
        </tr>
        </tbody>
    </table>
@endif
