@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>{{ $sells->first()->purchase->purchaseNO }} Sales</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Sales</li>
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
                    @if(count($sells))
                        <br>
                        <div class="card-header no-print">
                            <div class="row">
                                <div class="col-md-1">
                                    <a href="{{ url()->previous() }}" class="btn btn-link"><span
                                                class="fa fa-arrow-left"></span></a>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" onkeyup="myFunction()"
                                           placeholder="Search..."
                                           title="Type to search..."
                                           class="form-control tableInput">
                                </div>
                                <div class="col-md-2">
                                    <button disabled class="btn btn-primary">T.Qty
                                        [ {{ number_format($sells->sum('qty')) }} ]
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <button disabled class="btn btn-primary">T.Price
                                        [ {{ number_format($sells->sum('total')) }}]
                                    </button>
                                </div>
                            </div>
                            <br>
                            <h3 class="card-title pull-left">
                                Showing <strong>{{ count($sells) }}</strong> records
                                of <strong>{{ $sells->total() }}</strong></h3>
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $sells->links() }}
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12 table-responsive">
                                <table class="table table-hover biz">
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
                                    <tfoot>
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
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-header no-print">
                                <h3 class="card-title pull-left">Showing <strong>{{ count($sells) }}</strong>
                                    records
                                    of <strong>{{ $sells->total() }}</strong></h3>
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $sells->links() }}
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
                                <h4 class="text-danger">No Sales Were Found</h4>
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
