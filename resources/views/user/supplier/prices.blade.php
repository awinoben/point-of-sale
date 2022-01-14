@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>{{ $supplies->first()->supplier->name }} Items</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Items</li>
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
                                <div class="col-md-1">
                                    <a href="{{ route('view.supplier') }}" class="btn btn-link"><span
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
                                        <th>Item Name</th>
                                        <th>Item Price [ KES ]</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                        <th>Updated</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($count = 1)
                                    @foreach($supplies as $supply)
                                        <tr>
                                            <td class="text-primary"><strong>{{ $count++  }}</strong></td>
                                            <td>{{ $supply->price->itemName }}</td>
                                            <td>{{ number_format($supply->price->itemPrice,2) }}</td>
                                            <td>
                                                @if(count($supply->price->stock))
                                                    <a href="#"
                                                       class="btn btn-success">View
                                                        Stock [ {{ number_format(count($supply->price->stock)) }} ]</a>
                                                @else
                                                    <a href="#"
                                                       class="btn btn-danger disabled"><span class="fa fa-eye"></span>
                                                        No Stock [ {{ number_format(count($supply->price->stock)) }}
                                                        ]</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('edit.price',['id'=>$supply->price->id]) }}"
                                                   class="btn btn-primary"><span class="fa fa-edit"></span> View</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('remove.supplier',['id'=>$supply->id]) }}"
                                                   class="btn btn-danger"><span class="fa fa-close"></span> NOT SUPPLIER</a>
                                            </td>
                                            <td>{{ \App\Http\Controllers\SystemController::elapsedTime($supply->price->updated_at) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Item Name</th>
                                        <th>Item Price [ KES ]</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                        <th>Updated</th>
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
