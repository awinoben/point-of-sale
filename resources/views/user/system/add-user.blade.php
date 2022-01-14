@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>Add New System User</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">New User</li>
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
                            <h3 class="card-title"><span class="fa fa-user-plus"></span> New User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <form role="form" action="{{ route('add.user') }}" method="post"
                                      id="{{ config('app.env') }}">
                                    @csrf
                                    <div class="card-body">
                                        @include('inc.alert')
                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name"
                                                   placeholder="Enter Full Name" required>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   id="email" name="email"
                                                   placeholder="Enter Email Address" required>
                                            @error('email')
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
                                                   placeholder="Enter Phone Number" required>
                                            @error('phoneNumber')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="level">User Level</label>
                                            <select name="level" id="level"
                                                    class="form-control @error('level') is-invalid @enderror">
                                                <option value="-- User Level --" selected disabled>-- Level --</option>
                                                <option value="admin">-- Admin --</option>
                                                <option value="user">-- Normal User --</option>
                                            </select>
                                            @error('level')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <button type="submit" class="btn btn-primary btn-block"><span
                                                        class="fa-plus-square fa"></span> Add New User
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
                title: "Add New System User",
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
