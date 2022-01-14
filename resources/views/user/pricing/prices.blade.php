@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>Item Pricing</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Pricing</li>
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
                    @if(count($prices))
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
                                Showing <strong>{{ count($prices) }}</strong> records
                                of <strong>{{ $prices->total() }}</strong></h3>
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $prices->links() }}
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12 table-responsive">
                                <table class="table table-hover biz">
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
                                        <th>Action</th>
                                        <th>Updated</th>
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
                                            <td>
                                                @if(count($price->supply))
                                                    <a href="{{ route('view.supplier') }}"
                                                       class="btn btn-success">Suppliers
                                                        [ {{ number_format(count($price->supply)) }} ]</a>
                                                @else
                                                    <a href="#"
                                                       class="btn btn-danger disabled"><span class="fa fa-eye"></span>
                                                        No Suppliers [ {{ number_format(count($price->supply)) }}
                                                        ]</a>
                                                @endif
                                            </td>
                                            <td>{{ number_format($price->stock()->sum('itemBQuantity')) }}</td>
                                            <td>
                                                @if(count($price->sale))
                                                    <a href="{{ route('all.sells') }}"
                                                       class="btn btn-success disabled">Sales
                                                        [ {{ number_format(count($price->sale)) }} ]</a>
                                                @else
                                                    <a href="#"
                                                       class="btn btn-danger disabled"><span class="fa fa-eye"></span>
                                                        No Sales [ {{ number_format(count($price->sale)) }} ]</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('edit.price',['id'=>$price->id]) }}"
                                                   class="btn btn-primary"><span class="fa fa-edit"></span> View</a>
                                            </td>
                                            <td>{{ \App\Http\Controllers\SystemController::elapsedTime($price->updated_at) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Item Name</th>
                                        <th>Item Buying Price [ KES ]</th>
                                        <th>Item Selling Price [ KES ]</th>
                                        <th>Reorder Level</th>
                                        <th>Supplier</th>
                                        <th>Stock</th>
                                        <th>Sales</th>
                                        <th>Action</th>
                                        <th>Updated</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-header no-print">
                                <h3 class="card-title pull-left">Showing <strong>{{ count($prices) }}</strong>
                                    records
                                    of <strong>{{ $prices->total() }}</strong></h3>
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $prices->links() }}
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
                                <h4 class="text-danger">No Item Prices Were Found</h4>
                                <h6>
                                    <hr>
                                    <a href="{{ route('pricing') }}">
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
