<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ config('platform.name') }} </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- style -->
    <link rel="stylesheet" href="{{ asset('adminlte/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" rel="stylesheet">
@yield('css')
    <!-- Google Font: Source Sans Pro -->

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">خانه</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">تماس</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="جستجو" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav mr-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-comments-o"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ asset('adminlte/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 ml-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    حسام موسوی
                                    <span class="float-left text-sm text-danger"><i class="fa fa-star"></i></span>
                                </h3>
                                <p class="text-sm">با من تماس بگیر لطفا...</p>
                                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 ساعت قبل</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ asset('adminlte/dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle ml-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    پیمان احمدی
                                    <span class="float-left text-sm text-muted"><i class="fa fa-star"></i></span>
                                </h3>
                                <p class="text-sm">من پیامتو دریافت کردم</p>
                                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 ساعت قبل</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{asset('adminlte/dist/img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle ml-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    سارا وکیلی
                                    <span class="float-left text-sm text-warning"><i class="fa fa-star"></i></span>
                                </h3>
                                <p class="text-sm">پروژه اتون عالی بود مرسی واقعا</p>
                                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>4 ساعت قبل</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">مشاهده همه پیام‌ها</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell-o"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                    <span class="dropdown-item dropdown-header">15 نوتیفیکیشن</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-envelope ml-2"></i> 4 پیام جدید
                        <span class="float-left text-muted text-sm">3 دقیقه</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-users ml-2"></i> 8 درخواست دوستی
                        <span class="float-left text-muted text-sm">12 ساعت</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-file ml-2"></i> 3 گزارش جدید
                        <span class="float-left text-muted text-sm">2 روز</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">مشاهده همه نوتیفیکیشن</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle-o"></i> {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-user"></i> مشخصات کاربری
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-key"></i>  تغییر رمز عبور
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}">

                        <i class="fa fa-sign-out"></i> خروج
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">پنل مدیریت</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar" style="direction: ltr">
            <div style="direction: rtl">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ Auth()->user()->Avatar }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth()->user()->name }}</a>

                    </div>
                </div>

                <!-- Sidebar Menu -->
               @include('admin.sidebar')
                <!-- /.sidebar-menu -->
            </div>
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @yield('head_content')
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong><a href="/">{{ settings()->get('SITE_TITLE') }}</a></strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script src="{{ asset('adminlte/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
{{--<script src="https://unpkg.com/izitoast@1.4.0/dist/js/iziToast.js"></script>--}}
<script>
    iziToast.settings({
        rtl: true,
        zindex: 99999999999,
        position: 'bottomLeft',
    });
</script>
<script>
    if('{{ Session::has('message') }}') {
        iziToast['{{ Session::get('color') }}']({message:'{{ Session::get('message') }}'});
    }
    '@if(!$errors->isEmpty())'
    '@foreach ($errors->all() as $error)'
    iziToast['error']({message:'{{ $error }}'});
    '@endforeach'
    '@endif'
</script>
@yield('js')

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
</body>
</html>
