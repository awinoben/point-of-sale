@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>Suppliers</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Item Suppliers</li>
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
                    @if(count($suppliers))
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
                                Showing <strong>{{ count($suppliers) }}</strong> records
                                of <strong>{{ $suppliers->total() }}</strong></h3>
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $suppliers->links() }}
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
                                        <th>Supplier Email</th>
                                        <th>Supplier Phone Number</th>
                                        <th>Supplier Location</th>
                                        <th>Supplier Items</th>
                                        <th>Action</th>
                                        <th>Updated</th>
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
                                            <td>
                                                @if(count($supplier->supply))
                                                    <a href="{{ route('view.supplier.items',['id'=>$supplier->id]) }}"
                                                       class="btn btn-success">View
                                                        Items [ {{ number_format(count($supplier->supply)) }} ]</a>
                                                @else
                                                    <a href="#"
                                                       class="btn btn-danger disabled"><span class="fa fa-eye"></span>
                                                        No Items [ {{ number_format(count($supplier->supply)) }} ]</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('edit.supplier',['id'=>$supplier->id]) }}"
                                                   class="btn btn-primary"><span class="fa fa-edit"></span> View</a>
                                            </td>
                                            <td>{{ date('F d, Y', strtotime($supplier->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Supplier Name</th>
                                        <th>Supplier Email</th>
                                        <th>Supplier Phone Number</th>
                                        <th>Supplier Location</th>
                                        <th>Supplier Items</th>
                                        <th>Action</th>
                                        <th>Updated</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-header no-print">
                                <h3 class="card-title pull-left">Showing <strong>{{ count($suppliers) }}</strong>
                                    records
                                    of <strong>{{ $suppliers->total() }}</strong></h3>
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $suppliers->links() }}
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
                                <h4 class="text-danger">No Suppliers Were Found</h4>
                                <h6>
                                    <hr>
                                    <a href="{{ route('new.supplier') }}">
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
