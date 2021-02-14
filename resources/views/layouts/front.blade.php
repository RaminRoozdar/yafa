<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">


        <title>@yield('title'){{ config('platform.name') }}</title>

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('front/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('front/assets/img/apple-touch-icon.png"') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->

    <!-- Template Main CSS File -->
    <link href="{{ asset('front/assets/css/app.css') }}" rel="stylesheet">
    @yield('css')

    <!-- =======================================================
    * Template Name: BizLand - v1.2.1
    * Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body style="direction: rtl">

<!-- ======= Top Bar ======= -->
<div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
    <div class="container d-flex">
        <div class="contact-info ml-auto">
            <i class="icofont-envelope"></i> <a href="mailto:contact@example.com">contact@example.com</a>
            <i class="icofont-phone"></i> 07143452020
        </div>
        <div class="social-links mr-auto">
            <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
            <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
            <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
            <a href="#" class="skype"><i class="icofont-skype"></i></a>
            <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
        </div>

    </div>
</div>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <h1 class="logo ml-5"><a href="index.html">عنوان سایت</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt=""></a>-->

        <nav class="nav-menu d-none d-lg-block ml-auto" style="direction: rtl">
            <ul>
                <li class="active"><a href="index.html">صفحه اصلی</a></li>
                <li><a href="#about">درباره ما</a></li>
                <li><a href="#services">خدمات</a></li>
                <li><a href="#portfolio">نمونه کارها</a></li>
                <li><a href="#team">تیم</a></li>
            </ul>
        </nav><!-- .nav-menu -->

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
@yield('content')

<!-- ======= Footer ======= -->
<footer id="footer">

    <div class="footer-newsletter">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h4>به خبرنامه ما بپیوندید</h4>
                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</p>
                    <form action="" method="post">
                        <input type="email" name="email"><input type="submit" value="عضویت">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-top">
        <div class="container">
            <div class="row text-right">

                <div class="col-lg-3 col-md-6 footer-contact">
                    <h3>{{ settings()->get('SITE_TITLE') }}</h3>
                    <p>
                        {{ settings()->get('ADDRESS') }}
                        <br>
                        <br>
                        <strong>تلفن :</strong> {{ settings()->get('SUPPORT_TEL') }}<br>
                        <strong>فکس :</strong> {{ settings()->get('FAX') }}<br>
                        <strong>ایمیل :</strong> {{ settings()->get('EMAIL') }}<br>
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>لینک های مفید</h4>
                    <ul>
                        <li><i class="bx bx-chevron-left"></i> <a href="#">خانه</a></li>
                        <li><i class="bx bx-chevron-left"></i> <a href="#">درباره ما</a></li>
                        <li><i class="bx bx-chevron-left"></i> <a href="#">خدمات</a></li>
                        <li><i class="bx bx-chevron-left"></i> <a href="#">شرایط استفاده از خدمات</a></li>
                        <li><i class="bx bx-chevron-left"></i> <a href="#">سیاست حفظ حریم خصوصی</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>دیگر خدمات ما</h4>
                    <ul>
                        <li><i class="bx bx-chevron-left"></i> <a href="#">طراحی وب سایت</a></li>
                        <li><i class="bx bx-chevron-left"></i> <a href="#">توسعه وب</a></li>
                        <li><i class="bx bx-chevron-left"></i> <a href="#">مدیریت تولید</a></li>
                        <li><i class="bx bx-chevron-left"></i> <a href="#">بازار یابی</a></li>
                        <li><i class="bx bx-chevron-left"></i> <a href="#">طراحی گرافیک</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>شبکه های اجتماعی ما</h4>
                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</p>
                    <div class="social-links mt-3">
                        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="copyright">
            &copy; کلیه حقوق این سایت متعلق <strong><span> {{ settings()->get('SITE_TITLE') }} </span></strong>می باشد.
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/bizland-bootstrap-business-template/ -->
            طراحی و برنامه نویسی <a href="https://sabanovin.com/">صبانوین جام جم</a>
        </div>
    </div>
</footer><!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<!-- Vendor JS Files -->

<script src="{{ asset('front/assets/js/app.js') }}"></script>
@yield('js')

</body>

</html>