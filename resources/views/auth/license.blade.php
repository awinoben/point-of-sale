@extends('layouts.forms')
@section('forms')
    <div class="login-logo">
        <a href="{{ url('/') }}">{{ config('app.name') }}</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">System License</p>
            <div class="social-auth-links text-center mb-3">
                <h1 class="text-center"><img src="{{ asset('img/logo.png') }}" alt="serve"
                                             style="width: 200px; height: 200px;">
                </h1>
                <div class="alert alert-info alert-dismissible">
                    <b>Hello !! {{ env('B_NAME') }}</b> we are sorry for the inconvenience. But your license period has
                    expired.
                    Help Line - 0713255791
                </div>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
