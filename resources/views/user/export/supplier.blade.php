@if(count($suppliers))
    <table class="table table-hover">
        <thead>
        <tr class="text-primary">
            <th>NO</th>
            <th>Supplier Name</th>
            <th>Supplier Email</th>
            <th>Supplier Phone Number</th>
            <th>Supplier Location</th>
            <th>Supplier Items</th>
            <th>Arrears [ KES ]</th>
            <th>Paid [ KES ]</th>
            <th>Balance [ KES ]</th>
        </tr>
        </thead>
        <tbody>
        @php($count = 1)
        @foreach($suppliers as $supplier)
            <tr>
                <td class="text-primary"><strong>{{ $count++  }}</strong></td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->phoneNumber }}</td>
                <td>{{ $supplier->location }}</td>
                <td>{{ number_format(count($supplier->supply)) }}</td>
                <td>{{ number_format($supplier->supplier_arrear()->sum('amount'),2) }}</td>
                <td>{{ number_format($supplier->supplier_arrear()->sum('paid'),2) }}</td>
                <td>{{ number_format($supplier->supplier_arrear()->sum('amount') - $supplier->supplier_arrear()->sum('paid'),2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <table>
        <thead>
        <tr>
            <th>Supplier(s) Report</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>No items were found.</td>
        </tr>
        </tbody>
    </table>
@endif
