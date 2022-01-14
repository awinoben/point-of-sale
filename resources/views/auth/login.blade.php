@extends('layouts.forms')
@section('forms')
    <div class="login-logo">
        <a href="{{ url('/') }}">{{ config('app.name') }}</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{ route('login') }}" method="post">
                @csrf
                @include('inc.alert')
                <div class="form-group">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="text" class="form-control @error('phoneNumber') is-invalid @enderror"
                           placeholder="07xxxxxxxxx" name="phoneNumber" id="phoneNumber"
                           value="{{ old('phoneNumber') }}" required>
                    @error('phoneNumber')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="xxxxxxxx" name="password"
                           id="password " required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
                <a href="{{ route('reset.credentials') }}" class="btn btn-block btn-primary">
                    <i class="fa fa-unlock  mr-2"></i> {{ __('Forgot Your Password?') }}
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
