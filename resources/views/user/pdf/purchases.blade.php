@extends('layouts.print-purchases')
@section('receipt')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <img src="{{ asset('img/logo.png') }}" alt="logo"
                                         style="width: 60px;height: 50px;"> {{ env('B_NAME') }}
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>{{ env('B_NAME') }}</strong><br>
                                    {{ env('B_LOCATION') }}, {{ env('B_CITY') }}<br>
                                    {{ env('B_LOCATION') }} {{ env('B_Z1P') }}<br>
                                    Phone: {{ env('B_NUMBER') }}<br>
                                    Email: {{ env('B_EMAIL') }}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                Served By
                                <address>
                                    <strong>{{ $purchase->user->name }}</strong><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>PurchaseNO #{{ $purchase->purchaseNO }}</b>
                                <br>
                                <br>
                                <b>Payment Mode <b class="text-primary">{{ $purchase->payment_mode->mode }}</b></b>
                                <br>
                                <br>
                                <b>Purchase Date:</b> {{ date('F d, Y h:m a', strtotime($purchase->created_at)) }}<br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Price [ KES ]</th>
                                        <th>Qty</th>
                                        <th>Total [ KES ]</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($count = 1)
                                    @foreach($prices as $price)
                                        @php($sale = $purchase->sale()->where('price_id',$price->id)->where('purchase_id',$purchase->id)->get())
                                        @if(count($sale))
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td>{{ $price->itemName }}</td>
                                                <td>{{ number_format($sale->first()->price,2) }}</td>
                                                <td>{{ number_format($sale->sum('qty')) }}</td>
                                                <td>{{ number_format($sale->sum('total'),2) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                    Keep this receipt save.
                                </p>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{ number_format($purchase->price -\App\Http\Controllers\SystemController::taxRate($purchase->price,false)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tax ({{ env('NO_TAX_RATE') }}%)</th>
                                            <td>{{ number_format(\App\Http\Controllers\SystemController::taxRate($purchase->price,false)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td>{{ number_format($purchase->price) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="{{ route('sales') }}" class="btn btn-success"><i
                                        class="fa fa-shopping-basket"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
