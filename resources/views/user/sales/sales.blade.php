@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>For Sell</h5>
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
                    @if(count($prices))
                        <br>
                        <div class="card-header no-print">
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="text" onkeyup="myFunction()"
                                           placeholder="Search..."
                                           title="Type to search..."
                                           class="form-control tableInput">
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ route('view.cart') }}" class="btn btn-success"><span
                                                class="fa fa-shopping-basket"></span> [ {{ number_format($cartItems) }}
                                        ]</a>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('view.cart') }}" class="btn btn-success">KES {{ $subtotal }}</a>
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
                                        <th>Available</th>
                                        <th>Item Price [ KES ]</th>
                                        <th>Qty</th>
                                        <th>Action</th>
                                        <th>Updated</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($count = 1)
                                    @foreach($prices as $price)
                                        <form role="form" action="{{ route('sell') }}" method="post" class="cartMine">
                                            @csrf
                                            <input type="hidden" value="{{ $price->id }}"
                                                   name="price_id" id="price_id">
                                            <input type="hidden" value="{{ $price->itemName }}"
                                                   name="itemName" id="itemName">
                                            <tr>
                                                <td class="text-primary"><strong>{{ $count++  }}</strong></td>
                                                <td>{{ $price->itemName }}</td>
                                                <td>
                                                    @if(count($price->stock))
                                                        <a href="#"
                                                           class="btn btn-success disabled">Stock
                                                            [ {{ number_format($price->stock->sum('counter')) }}
                                                            ]</a>
                                                    @else
                                                        <a href="#"
                                                           class="btn btn-danger disabled"><span
                                                                    class="fa fa-eye"></span>
                                                            No Stock [ {{ number_format(count($price->stock)) }} ]</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="number" name="price" id="price"
                                                           min="{{ $price->itemPrice }}" value="{{ $price->itemPrice }}"
                                                           class="form-control"
                                                           required>
                                                </td>
                                                <td>
                                                    <input type="number" name="qty" id="qty" min="1" value="1"
                                                           max="{{ $price->stock->sum('counter') }}"
                                                           class="form-control"
                                                           required>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary">Add <span
                                                                class="fa fa-shopping-basket"></span></button>
                                                </td>
                                                <td>{{ \App\Http\Controllers\SystemController::elapsedTime($price->updated_at) }}</td>
                                            </tr>
                                        </form>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Item Name</th>
                                        <th>Available</th>
                                        <th>Item Price [ KES ]</th>
                                        <th>Qty</th>
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
                                <h4 class="text-danger">No Stock Was Found</h4>
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
        $(".cartMine").submit(function (e) {
            e.preventDefault();
            let form = this;

            swal({
                title: "Add To Cart",
                text: "Are you sure you want to proceed?",
                type: "question",
                showCancelButton: true,
                // confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false,
                dangerMode: true,
            }).then((willPromote) = > {
                e.preventDefault();
            if (willPromote.value) {
                $('#loading').show();
                form.submit(); // <--- submit form programmatically
            } else {
                swal("Cancelled :)", "", "success");
                e.preventDefault();
                return false;
            }
        })
        });

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
