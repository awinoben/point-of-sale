@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>{{ $price->itemName }} Details</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Item Update</li>
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
                            <h3 class="card-title"><a href="{{ route('prices') }}" class="btn btn-link">
                                    <span class="fa fa-arrow-left"></span></a> Update {{ $price->itemName }} Details
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <form role="form" action="{{ route('update.price') }}" method="post"
                                      id="{{ config('app.env') }}">
                                    @csrf
                                    <input type="hidden" name="price_id" id="price_id" value="{{ $price->id }}">
                                    <div class="card-body">
                                        @include('inc.alert')
                                        <div class="form-group">
                                            <label for="itemName">Item Name</label>
                                            <input type="text"
                                                   class="form-control @error('itemName') is-invalid @enderror"
                                                   id="itemName" name="itemName" value="{{ $price->itemName }}"
                                                   placeholder="Enter New item Name" required>
                                            @error('itemName')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="itemBPrice">Item Buying Price</label>
                                            <input type="number"
                                                   class="form-control @error('itemBPrice') is-invalid @enderror"
                                                   id="itemBPrice" name="itemBPrice" value="{{ $price->itemBPrice }}"
                                                   placeholder="Enter New item Buying Price" required>
                                            @error('itemBPrice')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="itemPrice">Item Selling Price</label>
                                            <input type="number"
                                                   class="form-control @error('itemPrice') is-invalid @enderror"
                                                   id="itemPrice" name="itemPrice" value="{{ $price->itemPrice }}"
                                                   placeholder="Enter New item Selling Price" required>
                                            @error('itemPrice')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="lowest">Reorder Level <i class="text-info">This is the lowest value the stock should be, which the system will use to trigger a notification to you.</i></label>
                                            <input type="number"
                                                   class="form-control @error('lowest') is-invalid @enderror"
                                                   id="lowest" name="lowest" value="{{ $price->lowest }}"
                                                   placeholder="Enter Reorder Level" required>
                                            @error('lowest')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <button type="submit" class="btn btn-primary btn-block"><span
                                                    class="fa-refresh fa"></span> Update {{ $price->itemName }}
                                                Details
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
                title: "Edit {{ $price->itemName }} details",
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
