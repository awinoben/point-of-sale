@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>System Users</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Users</li>
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
                    @if(count($users))
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
                                Showing <strong>{{ count($users) }}</strong> records
                                of <strong>{{ $users->total() }}</strong></h3>
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $users->links() }}
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12 table-responsive">
                                <table class="table table-hover biz">
                                    <thead>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Access Level</th>
                                        <th>Action</th>
                                        <th>Joined On</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($count = 1)
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="text-primary"><strong>{{ $count++  }}</strong></td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phoneNumber }}</td>
                                            <td>
                                                @if($user->superAdmin)
                                                    <b>Super Admin</b>
                                                @elseif($user->admin)
                                                    <b>Admin</b>
                                                @else
                                                    <b>Normal User</b>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('block.user') }}" method="POST"
                                                      class="block">
                                                    @csrf
                                                    <input type="hidden" value="{{ $user->id }}"
                                                           name="id">
                                                    @if($user->blocked)
                                                        <button type="submit"
                                                                class="btn btn-md btn-danger">
                                                            <span class="fa fa-warning"></span> UnBlock
                                                        </button>
                                                    @else
                                                        <button type="submit"
                                                                class="btn btn-md btn-success">
                                                            <span class="fa fa-user"></span> Enabled
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td>{{ date('F d, Y', strtotime($user->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="text-primary">
                                        <th>NO</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Access Level</th>
                                        <th>Action</th>
                                        <th>Joined On</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-header no-print">
                                <h3 class="card-title pull-left">Showing <strong>{{ count($users) }}</strong>
                                    records
                                    of <strong>{{ $users->total() }}</strong></h3>
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $users->links() }}
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
                                <h4 class="text-danger">No System Users Were Found</h4>
                                <h6>
                                    <hr>
                                    <a href="{{ route('add.user') }}">
                                        <strong><span class="fa fa-user-plus"></span> Add</strong>
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

        $('.block').click(function (e) {
            e.preventDefault();
            let form = this;

            swal({
                title: "System Access",
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
                    return false;
                }
            });
        });
    </script>
@endsection
