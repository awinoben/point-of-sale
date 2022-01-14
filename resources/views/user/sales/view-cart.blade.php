@extends('layouts.user')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>{{ config('app.name') }} Cart</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fa fa-home"></span></a>
                        </li>
                        <li class="breadcrumb-item active">Cart</li>
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
                @if(count($cartItems))
                    <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <form role="form" action="{{ route('update.cart') }}" method="post">
                                        @csrf
                                        <table class="table table-hover biz">
                                            <thead>
                                            <tr class="text-primary">
                                                <th>NO</th>
                                                <th>Item Name</th>
                                                <th>Item Price [ KES ]</th>
                                                <th>Qty</th>
                                                <th>Total Price [ KES ]</th>
                                                <th>
                                                    <center>Action</center>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php($count = 1)
                                            @foreach($cartItems as $cartItem)
                                                @foreach($prices as $price)
                                                    @if($cartItem->id == $price->id)
                                                        <tr>
                                                            <td class="text-primary"><strong>{{ $count++  }}</strong>
                                                            </td>
                                                            <td>{{ $price->itemName }}</td>
                                                            <td>{{ number_format($price->itemPrice,2) }}</td>
                                                            <td>
                                                                <input type="hidden" name="rowId[]"
                                                                       value="{{ $cartItem->rowId }}">
                                                                <input type="number" name="qty[]" id="qty[]" min="1"
                                                                       value="{{ $cartItem->qty }}"
                                                                       max="{{ $price->stock->sum('itemBQuantity') - $price->stock->sum('itemSQuantity') }}"
                                                                       class="form-control"
                                                                       required>
                                                            </td>
                                                            <td>{{ $cartItem->subtotal }}</td>
                                                            <td>
                                                                <center><a
                                                                            href="{{ route('delete.item.cart',['id'=>$cartItem->rowId]) }}"
                                                                            class="btn btn-danger"><span
                                                                                class="fa fa-trash"></span></a></center>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            <tr>
                                                <td><a href="{{ route('sales') }}" class="btn btn-link"><span
                                                                class="fa fa-arrow-left"></span><b> Continue Selling</b></a>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td><a href="{{ route('clear.cart') }}" class="btn btn-danger"><span
                                                                class="fa fa-trash"></span><b> Clear Cart</b></a>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary"><span
                                                                class="fa fa-refresh"></span><b> Update Cart</b>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            &nbsp;
                                            </tfoot>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8"></div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body shadow-lg">
                                            <form action="{{ route('complete.purchase') }}"
                                                  id="{{ config('app.env') }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="subtotal">Subtotal</label>
                                                    <input type="text" class="form-control" name="subtotal"
                                                           id="subtotal" value="{{ $subtotal }}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="payment_mode_id">Select Payment Mode</label>
                                                    <select name="payment_mode_id" id="payment_mode_id"
                                                            class="form-control @error('payment_mode_id') is-invalid @enderror">
                                                        <option value="-- Select Payment Mode --" disabled selected>--
                                                            Select Payment Mode --
                                                        </option>
                                                        @foreach($modes as $mode)
                                                            <option value="{{ $mode->id }}">-- {{ $mode->mode }}--
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('payment_mode_id')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>Please select mode of payment.</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-block">Complete
                                                        Purchase
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    @else
                        <center>
                            <div class="col-md-6">
                                <br>
                                <br>
                                <br>
                                <h4 class="text-danger">No Cart Items Were Found</h4>
                                <h6>
                                    <hr>
                                    <a href="{{ route('sales') }}">
                                        <strong><span class="fa fa-shopping-basket"></span></strong>
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
        document.querySelector('#{{ config('app.env') }}').addEventListener('submit', function (e) {
            let form = this;
            e.preventDefault(); // <--- prevent form from submitting
            $('button').attr('disabled', true);

            swal({
                title: "Complete The Purchase",
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
