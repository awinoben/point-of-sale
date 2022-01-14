@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>{{ $purchase->purchase->purchaseNO }} Payment</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Credit Payment</li>
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
                            <h3 class="card-title"><a href="{{ route('all.credit.purchases') }}"
                                                      class="btn btn-link"><span
                                            class="fa fa-arrow-left"></span></a>
                                Pay {{ $purchase->purchase->purchaseNO }}
                                Purchase</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <form role="form" action="{{ route('pay.credit.purchase') }}" method="post"
                                      id="{{ config('app.env') }}">
                                    @csrf
                                    <input type="hidden" name="credit_id" id="credit_id"
                                           value="{{ $purchase->id }}">
                                    <div class="card-body">
                                        @include('inc.alert')
                                        <div class="form-group">
                                            <label for="name">Customer/Project Name</label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" value="{{ $purchase->name }}"
                                                   placeholder="Enter Supplier Name" disabled>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="phoneNumber">Phone Number</label>
                                            <input type="text"
                                                   class="form-control @error('phoneNumber') is-invalid @enderror"
                                                   id="phoneNumber" name="phoneNumber"
                                                   value="{{ $purchase->phoneNumber }}"
                                                   placeholder="Enter Supplier Phone Number" disabled>
                                            @error('phoneNumber')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="qty">Qty</label>
                                            <input type="text"
                                                   class="form-control @error('qty') is-invalid @enderror"
                                                   id="qty" name="qty"
                                                   value="{{ number_format($purchase->qty) }}"
                                                   placeholder="Enter Supplier Location" disabled>
                                            @error('qty')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Total Amount [ KES ]</label>
                                            <input type="text"
                                                   class="form-control @error('amount') is-invalid @enderror"
                                                   id="amount" name="amount"
                                                   value="{{ number_format($purchase->price) }}"
                                                   placeholder="Enter Supplier Location" disabled>
                                            @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="paid">Amount Paid [ KES ]</label>
                                            <input type="text"
                                                   class="form-control @error('paid') is-invalid @enderror"
                                                   id="paid" name="paid" value="{{ number_format($purchase->paid) }}"
                                                   placeholder="Enter Supplier Location" disabled>
                                            @error('paid')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="payment">Enter Amount To Pay [ KES ]</label>
                                            <input type="number"
                                                   class="form-control @error('payment') is-invalid @enderror"
                                                   id="payment" name="payment" value="{{ old('payment') }}"
                                                   placeholder="Enter Amount {{ ($purchase->price - $purchase->paid) }}"
                                                   required min="1"
                                                   max="{{ ($purchase->price - $purchase->paid) }}">
                                            @error('payment')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <button type="submit" class="btn btn-primary btn-block"><span
                                                        class="fa-product-hunt fa"></span>
                                                Pay {{ $purchase->purchase->purchaseNO }} Purchase
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
                title: "Credit Purchase {{ $purchase->purchase->purchaseNO }} Payment",
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
            });
        });
    </script>
@endsection
