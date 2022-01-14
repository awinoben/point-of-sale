@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>Cleared Credit Purchases</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active"> Cleared Credits</li>
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
                    @if(count($purchases))
                        <br>
                        <div class="card-header no-print">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" onkeyup="myFunction()"
                                           placeholder="Search..."
                                           title="Type to search..."
                                           class="form-control tableInput">
                                </div>
                                <div class="col-md-2">
                                    <button disabled class="btn btn-primary">T.Qty [ {{ $purchases->sum('qty') }}]
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <button disabled class="btn btn-primary">T.Price [ {{ $purchases->sum('price') }}]
                                    </button>
                                </div>
                            </div>
                            <br>
                            <h3 class="card-title pull-left">
                                Showing <strong>{{ count($purchases) }}</strong> records
                                of <strong>{{ $purchases->total() }}</strong></h3>
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $purchases->links() }}
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12 table-responsive">
                                <table class="table table-hover biz">
                                    <thead>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Customer/Project Name</th>
                                        <th>Phone Number</th>
                                        <th>PurchaseNO</th>
                                        <th>Sold Qty</th>
                                        <th>Price [ KES ]</th>
                                        <th>Paid [ KES ]</th>
                                        <th>Balance [ KES ]</th>
                                        <th>Pay</th>
                                        <th>Payments</th>
                                        <th>Sold On</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($count = 1)
                                    @foreach($purchases as $purchase)
                                        <tr>
                                            <td class="text-primary"><strong>{{ $count++  }}</strong></td>
                                            <td>{{ $purchase->name }}</td>
                                            <td>{{ $purchase->phoneNumber }}</td>
                                            <td>{{ $purchase->purchase->purchaseNO }}</td>
                                            <td>{{ number_format($purchase->qty) }}</td>
                                            <td>{{ number_format($purchase->price,2) }}</td>
                                            <td>{{ number_format($purchase->paid,2) }}</td>
                                            <td>{{ number_format($purchase->balance,2) }}</td>
                                            <td>
                                                @if(($purchase->balance) > 0)
                                                    <a href="{{ route('credit.purchase.payment',['id'=>$purchase->id]) }}"
                                                       class="btn btn-primary"><span class="fa fa-product-hunt"></span>
                                                        Pay</a>
                                                @else
                                                    <a href="#"
                                                       class="btn btn-success disabled"><span
                                                                class="fa fa-check"></span> Cleared</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if(count($purchase->credit_payment))
                                                    <a href="{{ route('credit.payment.statements',['id'=>$purchase->id]) }}"
                                                       class="btn btn-success">Payments
                                                        [ {{ number_format(count($purchase->credit_payment)) }} ]</a>
                                                @else
                                                    <a href="#"
                                                       class="btn btn-danger disabled"><span class="fa fa-eye"></span>
                                                        No Payments
                                                        [ {{ number_format(count($purchase->credit_payment)) }} ]</a>
                                                @endif
                                            </td>
                                            <td>{{ date('F d, Y', strtotime($purchase->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Customer/Project Name</th>
                                        <th>Phone Number</th>
                                        <th>PurchaseNO</th>
                                        <th>Sold Qty</th>
                                        <th>Price [ KES ]</th>
                                        <th>Paid [ KES ]</th>
                                        <th>Balance [ KES ]</th>
                                        <th>Pay</th>
                                        <th>Payments</th>
                                        <th>Sold On</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-header no-print">
                                <h3 class="card-title pull-left">Showing <strong>{{ count($purchases) }}</strong>
                                    records
                                    of <strong>{{ $purchases->total() }}</strong></h3>
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $purchases->links() }}
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
                                <h4 class="text-danger">No Cleared Credit Purchases Were Found</h4>
                                <h6>
                                    <hr>
                                    <a href="{{ route('sales') }}">
                                        <strong><span class="fa fa-shopping-basket"></span></strong>
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
