@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>Suppliers Cleared Arrears</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Cleared Arrears</li>
                    </ol>
                </div>
            </div>
            <hr>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('inc.alert')
                <div class="card">
                    @if(count($supplies))
                        <br>
                        <div class="card-header no-print">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" onkeyup="myFunction()"
                                           placeholder="Search..."
                                           title="Type to search..."
                                           class="form-control tableInput">
                                </div>
                            </div>
                            <br>
                            <h3 class="card-title pull-left">
                                Showing <strong>{{ count($supplies) }}</strong> records
                                of <strong>{{ $supplies->total() }}</strong></h3>
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $supplies->links() }}
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12 table-responsive">
                                <table class="table table-hover biz">
                                    <thead>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Supplier Name</th>
                                        <th>Supplier Phone Number</th>
                                        <th>Item Name</th>
                                        <th>SKU</th>
                                        <th>Arrears [ KES ]</th>
                                        <th>Paid [ KES ]</th>
                                        <th>Balance [ KES ]</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                        <th>Since</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($count = 1)
                                    @foreach($supplies as $supply)
                                        <tr>
                                            <td class="text-primary"><strong>{{ $count++  }}</strong></td>
                                            <td>{{ $supply->supplier->name }}</td>
                                            <td>{{ $supply->supplier->phoneNumber }}</td>
                                            <td>{{ $supply->stock->price->itemName }}</td>
                                            <td>{{ $supply->stock->SKU }}</td>
                                            <td>{{ number_format($supply->amount,2) }}</td>
                                            <td>{{ number_format($supply->paid,2) }}</td>
                                            <td>{{ number_format($supply->amount - $supply->paid,2) }}</td>
                                            <td>
                                                @if(($supply->amount - $supply->paid) > 0)
                                                    <a href="{{ route('arrears.payment',['id'=>$supply->id]) }}"
                                                       class="btn btn-primary"><span class="fa fa-product-hunt"></span>
                                                        Pay</a>
                                                @else
                                                    <a href="#"
                                                       class="btn btn-success disabled"><span
                                                                class="fa fa-check"></span> Cleared</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if(count($supply->supplier_payment))
                                                    <a href="{{ route('view.arrear.payment',['id'=>$supply->id]) }}"
                                                       class="btn btn-success">Payments
                                                        [ {{ number_format(count($supply->supplier_payment)) }} ]</a>
                                                @else
                                                    <a href="#"
                                                       class="btn btn-danger disabled"><span class="fa fa-eye"></span>
                                                        No Payments
                                                        [ {{ number_format(count($supply->supplier_payment)) }} ]</a>
                                                @endif
                                            </td>
                                            <td>{{ \App\Http\Controllers\SystemController::elapsedTime($supply->updated_at) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Supplier Name</th>
                                        <th>Supplier Phone Number</th>
                                        <th>Item Name</th>
                                        <th>SKU</th>
                                        <th>Arrears [ KES ]</th>
                                        <th>Paid [ KES ]</th>
                                        <th>Balance [ KES ]</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                        <th>Since</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-header no-print">
                                <h3 class="card-title pull-left">Showing <strong>{{ count($supplies) }}</strong>
                                    records
                                    of <strong>{{ $supplies->total() }}</strong></h3>
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $supplies->links() }}
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    @else
                        <center>
                            <div class="col-md-6">
                                <br>
                                <br>
                                <br>
                                <h4 class="text-danger">No Supplier Cleared Arrears Were Found</h4>
                                <h6>
                                    <hr>
                                    <a href="{{ route('view.supplier') }}">
                                        <strong><span class="fa fa-hand-paper-o"></span> View Suppliers</strong>
                                    </a>
                                    <hr>
                                </h6>
                                <br>
                                <br>
                                <br>
                            </div>
                        </center>
                    @endif
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection


@section('scripts')
    <script>
        function myFunction() {
            $(document).ready(function () {
                $(".tableInput").on("keyup", function () {
                    let value = $(this).val().toLowerCase();
                    $(".biz  tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        }
    </script>
@endsection
