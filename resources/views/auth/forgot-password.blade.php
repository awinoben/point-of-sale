@extends('layouts.forms')
@section('forms')
    <div class="login-logo">
        <a href="{{ url('/') }}">{{ config('app.name') }}</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Reset Password</p>

            <form action="{{ route('reset.credentials') }}" method="post">
                @csrf
                @include('inc.alert')
                <div class="form-group">
                    <label for="pin">Enter PIN</label>
                    <input type="text" class="form-control @error('pin') is-invalid @enderror"
                           placeholder="Enter PIN..." name="pin" id="pin"
                           value="{{ old('pin') }}" required>
                    @error('pin')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password" name="password"
                           id="password " required minlength="8">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password"
                           name="password_confirmation" required autocomplete="new-password">
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-block btn-flat">Reset Password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
                <a href="{{ route('login') }}" class="btn btn-block btn-primary">
                    <i class="fa fa-sign-in  mr-2"></i> {{ __('Login Instead?') }}
                </a>
            </div>
        </div>

        <div class="card-footer">
            <center>
                <p>
                    Licensed to <i>{{ env('B_NAME') }}</i>
                    <br>
                    Powered By <b class="text-primary">{{ config('company.companyName') }}</b></p>
            </center>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
