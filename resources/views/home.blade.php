@extends('layouts.user')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>{{ config('app.name') }} DashBoard</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">DashBoard</li>
                    </ol>
                </div>
            </div>
            <hr>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @include('inc.alert')
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('view.user') }}">
                        <div class="info-box bg-danger-gradient">
                            <span class="info-box-icon"><i class="fa fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">System Users</span>
                                <span class="info-box-number">{{ number_format($users) }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('all.sells') }}">
                        <div class="info-box bg-success-gradient">
                            <span class="info-box-icon"><i class="fa fa-arrow-circle-o-up"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Sales(s)</span>
                                <span class="info-box-number">{{ number_format($sales) }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('view.stock') }}">
                        <div class="info-box bg-warning-gradient">
                            <span class="info-box-icon"><i class="fa fa-arrow-circle-o-down"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Stock(s)</span>
                                <span class="info-box-number">{{ number_format($stocks) }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('prices') }}">
                        <div class="info-box bg-primary-gradient">
                            <span class="info-box-icon"><i class="fa fa-laptop"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Items</span>
                                <span class="info-box-number">{{ number_format($items) }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-light">
                        <div class="card-header">
                            <h5 class="card-title">{{ env('B_NAME') }} Recent Sales</h5>

                            <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-wrench faa-wrench animated"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a href="{{ route('user.password') }}" class="dropdown-item">Change
                                            Password</a>
                                        <a class="dropdown-divider"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        @if(count($sells))
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
                                                            <td class="text-primary"><strong>{{ $count++  }}</strong>
                                                            </td>
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
                                        @else
                                            <center>
                                                <h5 class="text-danger text-center">No Recent Sales</h5>
                                                <a href="{{ route('sales') }}"><span
                                                            class="fa fa-shopping-basket"></span></a>
                                            </center>
                                        @endif
                                        {{--<canvas id="myChart" style="height: 390px;"></canvas>--}}
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->
                        <div class="card-footer">
                            <!-- /.row -->
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

