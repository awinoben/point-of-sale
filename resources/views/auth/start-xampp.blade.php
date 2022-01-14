@extends('layouts.forms')
@section('forms')
    <div class="login-logo">
        <a href="{{ url('/') }}">{{ config('app.name') }}</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Start the server</p>
            <div class="social-auth-links text-center mb-3">
                <h1 class="text-center"><img src="{{ asset('img/server.gif') }}" alt="serve"
                                             style="width: 200px; height: 200px;"></h1>
                <a href="{{ route('start.xampp') }}" class="btn btn-block btn-primary">
                    <i class="fa fa-clock-o  mr-2"></i> {{ __('Start Server First') }}
                </a>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
