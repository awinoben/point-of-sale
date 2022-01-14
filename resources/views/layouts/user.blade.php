<?php


use App\Http\Controllers\SystemController;
use Note\Note;

$userLatestMails = Note::latestNotifications('web');
$cartItems = count(SystemController::shoppingCart()[0]);
?>
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', env('APP_NAME')) }}</title>
    <!--favicon-->
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toggle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/flat/blue.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @toastr_css
</head>
<body>
<div id="loading"></div>
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-dark navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="{{ route('home') }}#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
    {{--        <form class="form-inline ml-3">--}}
    {{--            <div class="input-group input-group-sm">--}}
    {{--                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
    {{--                <div class="input-group-append">--}}
    {{--                    <button class="btn btn-navbar" type="submit">--}}
    {{--                        <i class="fa fa-search"></i>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </form>--}}

    <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Cart -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('view.cart') }}">
                    <i class="fa fa-shopping-basket"></i>
                    <span class="badge badge-success navbar-badge">{{ number_format($cartItems) }}</span>
                </a>
            </li>
            <!-- Messages Notifications -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('user.latest.mailbox') }}">
                    <i class="fa fa-comments-o"></i>
                    <span class="badge badge-danger navbar-badge">{{ number_format(count($userLatestMails)) }}</span>
                </a>
            </li>

            {{--user profile--}}
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i><img src="{{ asset('img/logo.png') }}" alt="" class="img-circle"
                            style="height: 30px;width: 30px;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-item">
                        <!-- Message Start -->
                        <div class="clearfix">
                            <a href="{{ route('user.profile') }}" class="btn btn-default btn-md pull-left bg-primary"
                               style="margin-left: 20px; margin-bottom: 20px; margin-top: 20px;"><strong>My
                                    Profile</strong></a>
                            <a href="{{ route('user.logout') }}" class="btn btn-danger btn-md pull-right"
                               style="margin-right: 20px; margin-bottom: 20px; margin-top: 20px;">
                                <strong>Logout</strong></a>
                        </div>
                        <!-- Message End -->
                    </div>
                    <div class="dropdown-divider"></div>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="brand-link">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('img/logo.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('home') }}" class="d-block">{{ auth()->user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @if(auth()->user()->admin || auth()->user()->superAdmin)
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="nav-icon fa fa-dashboard"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item has-treeview">
                        <a href="{{ route('home') }}#" class="nav-link">
                            <i class="nav-icon fa fa-user-secret"></i>
                            <p>
                                Account
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('user.profile') }}" class="nav-link">
                                    <i class="fa fa-user-circle nav-icon"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.password') }}" class="nav-link">
                                    <i class="fa fa-lock nav-icon"></i>
                                    <p>Change Password</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    @if(auth()->user()->admin || auth()->user()->superAdmin)
                        <li class="nav-item has-treeview">
                            <a href="{{ route('home') }}#" class="nav-link">
                                <i class="nav-icon fa fa-connectdevelop"></i>
                                <p>
                                    Setups
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth()->user()->superAdmin)
                                    <li class="nav-item">
                                        <a href="{{ route('add.user') }}" class="nav-link">
                                            <i class="fa fa-user-plus nav-icon"></i>
                                            <p>Add User</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('pricing') }}" class="nav-link">
                                            <i class="fa fa-plus-square nav-icon"></i>
                                            <p>Add Item</p>
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{ route('new.supplier') }}" class="nav-link">
                                        <i class="fa fa-plus-square nav-icon"></i>
                                        <p>Add Supplier</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('assign.supplier') }}" class="nav-link">
                                        <i class="fa fa-black-tie nav-icon"></i>
                                        <p>Assign Suppliers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('select.item.page') }}" class="nav-link">
                                        <i class="fa fa-plus-square nav-icon"></i>
                                        <p>Add Stock</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="{{ route('home') }}#" class="nav-link">
                                <i class="nav-icon fa fa-empire"></i>
                                <p>
                                    Manage
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth()->user()->superAdmin)
                                    <li class="nav-item">
                                        <a href="{{ route('view.user') }}" class="nav-link">
                                            <i class="fa fa-users nav-icon"></i>
                                            <p>Users</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('prices') }}" class="nav-link">
                                            <i class="fa fa-file-archive-o nav-icon"></i>
                                            <p>Items</p>
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{ route('view.supplier') }}" class="nav-link">
                                        <i class="fa fa-handshake-o nav-icon"></i>
                                        <p>Suppliers</p>
                                    </a>
                                </li>
                                @if(auth()->user()->superAdmin)
                                    <li class="nav-item">
                                        <a href="{{ route('view.stock') }}" class="nav-link">
                                            <i class="fa fa-arrow-circle-o-down text-success nav-icon"></i>
                                            <p>Current Stock</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view.past.stock') }}" class="nav-link">
                                            <i class="fa fa-arrow-circle-o-down text-danger nav-icon"></i>
                                            <p>Past Stock</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="{{ route('home') }}#" class="nav-link">
                                <i class="nav-icon fa fa-product-hunt"></i>
                                <p>
                                    Payments
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pending.credit.purchases') }}" class="nav-link">
                                        <i class="fa fa-leaf text-danger nav-icon"></i>
                                        <p>Pending Credits</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cleared.credit.purchases') }}" class="nav-link">
                                        <i class="fa fa-leaf text-success nav-icon"></i>
                                        <p>Cleared Credits</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pending.supplier.arrears') }}" class="nav-link">
                                        <i class="fa fa-leaf text-danger nav-icon"></i>
                                        <p>Supplier Pending Arrears</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cleared.supplier.arrears') }}" class="nav-link">
                                        <i class="fa fa-leaf text-success nav-icon"></i>
                                        <p>Supplier Cleared Arrears</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('all.credit.purchases') }}" class="nav-link">
                                        <i class="fa fa-clone nav-icon"></i>
                                        <p>All Credits</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="{{ route('home') }}#" class="nav-link">
                                <i class="nav-icon fa fa-google-wallet"></i>
                                <p>
                                    Purchases
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('today.purchases') }}" class="nav-link">
                                        <i class="fa fa-leanpub nav-icon"></i>
                                        <p>Today Purchases</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('all.purchases') }}" class="nav-link">
                                        <i class="fa fa-leaf nav-icon"></i>
                                        <p>All Purchases</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="{{ route('home') }}#" class="nav-link">
                                <i class="nav-icon fa fa-clock-o"></i>
                                <p>
                                    Daily Sales
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('today.sells') }}" class="nav-link">
                                        <i class="fa fa-calendar-times-o nav-icon"></i>
                                        <p>Today Sales</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('all.sells') }}" class="nav-link">
                                        <i class="fa fa-file-excel-o nav-icon"></i>
                                        <p>All Sales</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('generate.report') }}" class="nav-link">
                                <i class="fa fa-cloud-download nav-icon text-success"></i>
                                <p>Report(s)</p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a href="{{ route('sales') }}" class="nav-link">
                            <i class="fa fa-handshake-o nav-icon text-success"></i>
                            <p>Sell</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('view.cart') }}" class="nav-link">
                            <i class="fa fa-shopping-basket nav-icon text-success"></i>
                            <p>Cart
                                <span class="badge badge-success right">{{ number_format($cartItems) }}</span>
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.latest.mailbox') }}" class="nav-link">
                            <i class="fa fa-inbox nav-icon"></i>
                            <p>Inbox
                                <span
                                    class="badge badge-danger right">{{ number_format(count($userLatestMails)) }}</span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.logout') }}" class="nav-link">
                            <i class="fa fa-lock nav-icon text-danger"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        @yield('content')
    </div>

@include('inc.dashboardFooter')

<!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('js/raphael-min.js') }}"></script>
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
@yield('scripts')
@include('sweet::alert')
<script>
    //Date picker
    $('.date').datepicker({
        format: 'yyyy-mm-dd'
    });
    CKEDITOR.replace('article-ckeditor');
</script>
<script src="{{ asset('js/loader.js') }}"></script>
<script>
    function hideLoader() {
        $('#loading').hide();
    }

    $(window).ready(hideLoader);
    // Strongly recommended: Hide loader after 20 seconds, even if the page hasn't finished loading
    setTimeout(hideLoader, 50 * 1000);
</script>
</body>
@jquery
@toastr_js
@toastr_render
</html>
