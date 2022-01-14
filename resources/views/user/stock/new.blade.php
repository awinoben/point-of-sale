@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>Add New Stock For {{ $price->itemName }}</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">New Stock</li>
                    </ol>
                </div>
            </div>
            <hr>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><a href="{{ route('select.item.page') }}" class="btn btn-link"><span
                                        class="fa fa-arrow-left"></span></a> {{ $price->itemName }} New Stock</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <form role="form" action="{{ route('new.stock') }}" method="post"
                                      id="{{ config('app.env') }}">
                                    @csrf
                                    <input type="hidden" name="price_id" id="price_id" value="{{ $price->id }}">
                                    <div class="card-body">
                                        @include('inc.alert')
                                        <div class="form-group">
                                            <label for="itemBPrice">{{ $price->itemName }} Buying Price</label>
                                            <input type="number"
                                                   class="form-control @error('itemBPrice') is-invalid @enderror"
                                                   id="itemBPrice" name="itemBPrice" value="{{ $price->itemBPrice }}"
                                                   placeholder="Enter BP" required>
                                            @error('itemName')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="itemBQuantity">{{ $price->itemName }} Quantity</label>
                                            <input type="number"
                                                   class="form-control @error('itemBQuantity') is-invalid @enderror"
                                                   id="itemBQuantity" name="itemBQuantity"
                                                   value="{{ old('itemBQuantity') }}"
                                                   placeholder="Enter Quantity" required>
                                            @error('itemBQuantity')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="payment">Supplier Payment</label>
                                            <input type="number" readonly
                                                   class="form-control @error('payment') is-invalid @enderror"
                                                   id="payment" name="payment" value="{{ old('payment') }}"
                                                   placeholder="Payment To Be Done To Supplier" required>
                                            @error('payment')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="supplier_id">Select Supplier</label>
                                            <select name="supplier_id" id="supplier_id"
                                                    class="form-control @error('supplier_id') is-invalid @enderror">
                                                <option value="-- Select Supplier --" selected disabled>-- Select
                                                    Supplier --
                                                </option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->supplier->id }}">
                                                        -- {{ $supplier->supplier->name }}
                                                        | {{ $supplier->supplier->phoneNumber }}--
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>Please select supplier.</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <button type="submit" class="btn btn-primary btn-block"><span
                                                    class="fa-plus-square fa"></span> Add New Item
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('scripts')
    <script>
        document.querySelector('#{{ config('app.env') }}').addEventListener('submit', function (e) {
            let form = this;
            e.preventDefault(); // <--- prevent form from submitting
            $('button').attr('disabled', true);

            swal({
                title: "Add New Stock For {{ $price->itemName }}",
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
            }).then((willPromote) => {
                e.preventDefault();
                if (willPromote.value) {
                    $('#loading').show();
                    form.submit(); // <--- submit form programmatically
                } else {
                    swal("Cancelled :)", "", "success");
                    e.preventDefault();
                    $('button').attr('disabled', false);
                    return false;
                }
            })
        });

        // set the calculations here
        $("#itemBQuantity").keyup(function () {
            let buyingPrice = $("#itemBPrice").val();
            let quantity = $("#itemBQuantity").val();
            $("#payment").val((buyingPrice * quantity));
        });
    </script>
@endsection
