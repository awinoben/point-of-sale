@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>Store Stock</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Current Stock</li>
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
                    @if(count($stocks))
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
                                Showing <strong>{{ count($stocks) }}</strong> records
                                of <strong>{{ $stocks->total() }}</strong></h3>
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $stocks->links() }}
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12 table-responsive">
                                <table class="table table-hover biz">
                                    <thead>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Stock Name</th>
                                        <th>SKU</th>
                                        <th>BPrice [ KES ]</th>
                                        <th>Stock In</th>
                                        <th>Total BPrice [ KES ]</th>
                                        <th>Stock Out</th>
                                        <th>Total SPrice [ KES ]</th>
                                        <th>Total Revenue</th>
                                        <th>Action</th>
                                        <th>Updated</th>
                                        <th>Stocked On</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($count = 1)
                                    @foreach($stocks as $stock)
                                        <tr>
                                            <td class="text-primary"><strong>{{ $count++  }}</strong></td>
                                            <td>{{ $stock->price->itemName }}</td>
                                            <td>{{ $stock->SKU }}</td>
                                            <td>{{ number_format($stock->itemBPrice,2) }}</td>
                                            <td>{{ number_format($stock->itemBQuantity) }}</td>
                                            <td>{{ number_format($stock->itemTBPrice,2) }}</td>
                                            <td>{{ number_format($stock->itemSQuantity) }}</td>
                                            <td>{{ number_format($stock->itemTSBPrice,2) }}</td>
                                            <td>
                                                @if($stock->itemRevenue > 0)
                                                    <p class="text-success">{{ number_format($stock->itemRevenue,2) }}</p>
                                                @else
                                                    <p class="text-danger">{{ number_format($stock->itemRevenue,2) }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if($stock->itemBQuantity <= $stock->itemSQuantity)
                                                    <a href="{{ route('past.stock',['id'=>$stock->id]) }}"
                                                       class="btn btn-danger"><span class="fa fa-close"></span>
                                                        Mark As Past</a>
                                                @else
                                                    <a href="#" class="btn btn-danger disabled"><span
                                                                class="fa fa-close"></span>
                                                        Mark
                                                        As Past</a>
                                                @endif
                                            </td>
                                            <td>{{ \App\Http\Controllers\SystemController::elapsedTime($stock->updated_at) }}</td>
                                            <td>{{ date('F d, Y H:i a', strtotime($stock->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Stock Name</th>
                                        <th>SKU</th>
                                        <th>BPrice [ KES ]</th>
                                        <th>Stock In</th>
                                        <th>Total BPrice [ KES ]</th>
                                        <th>Stock Out</th>
                                        <th>Total SPrice [ KES ]</th>
                                        <th>Total Revenue</th>
                                        <th>Action</th>
                                        <th>Updated</th>
                                        <th>Stocked On</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-header no-print">
                                <h3 class="card-title pull-left">Showing <strong>{{ count($stocks) }}</strong>
                                    records
                                    of <strong>{{ $stocks->total() }}</strong></h3>
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $stocks->links() }}
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
                                <h4 class="text-danger">No Stocks Were Found</h4>
                                <h6>
                                    <hr>
                                    <a href="{{ route('select.item.page') }}">
                                        <strong><span class="fa fa-plus-square"></span> Add</strong>
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
