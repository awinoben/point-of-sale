@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>{{ $payments->first()->credit->purchase->purchaseNO }} Payments</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Credit Payments</li>
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
                    @if(count($payments))
                        <br>
                        <div class="card-header no-print">
                            <div class="row">
                                <div class="col-md-1">
                                    <a href="{{ url()->previous() }}" class="btn btn-link"><span
                                                class="fa fa-arrow-left"></span></a>
                                </div>
                                <div class="col-md-11">
                                    <input type="text" onkeyup="myFunction()"
                                           placeholder="Search..."
                                           title="Type to search..."
                                           class="form-control tableInput">
                                </div>
                            </div>
                            <br>
                            <h3 class="card-title pull-left">
                                Showing <strong>{{ count($payments) }}</strong> records
                                of <strong>{{ $payments->total() }}</strong></h3>
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $payments->links() }}
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12 table-responsive">
                                <table class="table table-hover biz">
                                    <thead>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Paid By</th>
                                        <th>PurchaseNO</th>
                                        <th>InvoiceNo</th>
                                        <th>Amount [ KES ]</th>
                                        <th>Paid On</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($count = 1)
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td class="text-primary"><strong>{{ $count++  }}</strong></td>
                                            <td>{{ $payment->user->name }}</td>
                                            <td>{{ $payment->credit->purchase->purchaseNO }}</td>
                                            <td>{{ $payment->invoiceNumber }}</td>
                                            <td>{{ number_format($payment->amount,2) }}</td>
                                            <td>{{ date('F d, Y', strtotime($payment->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Paid By</th>
                                        <th>PurchaseNO</th>
                                        <th>InvoiceNo</th>
                                        <th>Amount [ KES ]</th>
                                        <th>Paid On</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-header no-print">
                                <h3 class="card-title pull-left">Showing <strong>{{ count($payments) }}</strong>
                                    records
                                    of <strong>{{ $payments->total() }}</strong></h3>
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $payments->links() }}
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
                                <h4 class="text-danger">No Payment Have Were Found</h4>
                                <h6>
                                    <hr>
                                    <a href="{{ route('pending.supplier.arrears') }}">
                                        <strong><span class="fa fa-arrow-left"></span> Back</strong>
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
