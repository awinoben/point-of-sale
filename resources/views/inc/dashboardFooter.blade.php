<footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ route('home') }}">{{ env('APP_NAME') }}</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Powered By</b> {{ config('company.companyName') }}
    </div>
</footer>
