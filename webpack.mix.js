const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');


mix.styles([

    'public/adminlte/plugins/font-awesome/css/font-awesome.min.css',
    'public/adminlte/dist/css/ionicons.min.css',
    'public/adminlte/dist/css/adminlte.min.css',
    'public/adminlte/plugins/iCheck/flat/blue.css',
    'public/adminlte/plugins/morris/morris.css',
    'public/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
    'public/adminlte/plugins/datepicker/datepicker3.css',
    'public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css',
    'public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
    'public/adminlte/dist/css/bootstrap-rtl.min.css',
    'public/adminlte/dist/css/custom-style.css',


], 'public/adminlte/app.css');

mix.styles([

    'public/front/assets/vendor/bootstrap/css/bootstrap.min.css',
    'public/front/assets/vendor/icofont/icofont.min.css',
    'public/front/assets/vendor/boxicons/css/boxicons.min.css',
    'public/front/assets/vendor/owl.carousel/assets/owl.carousel.min.css',
    'public/front/assets/vendor/venobox/venobox.css',
    'public/front/assets/vendor/aos/aos.css',
    'public/front/assets/css/style.css',


], 'public/front/assets/css/app.css');

mix.babel([

    'public/adminlte/plugins/jquery/jquery.min.js',
    'public/adminlte/plugins/jquery/jquery-ui.min.js',
    'public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'public/adminlte/plugins/morris/morris.min.js',
    'public/adminlte/plugins/sparkline/jquery.sparkline.min.js',
    'public/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
    'public/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
    'public/adminlte/plugins/knob/jquery.knob.js',
    'public/adminlte/plugins/daterangepicker/daterangepicker.js',
    'public/adminlte/plugins/datepicker/bootstrap-datepicker.js',
    'public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
    'public/adminlte/plugins/slimScroll/jquery.slimscroll.min.js',
    'public/adminlte/plugins/fastclick/fastclick.js',
    'public/adminlte/dist/js/adminlte.js',
    'public/adminlte/dist/js/pages/dashboard.js',
    'public/adminlte/dist/js/demo.js',
], 'public/adminlte/app.js');

mix.babel([

    'public/front/assets/vendor/jquery/jquery.min.js',
    'public/front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
    'public/front/assets/vendor/jquery.easing/jquery.easing.min.js',
    'public/front/assets/vendor/php-email-form/validate.js',
    'public/front/assets/vendor/waypoints/jquery.waypoints.min.js',
    'public/front/assets/vendor/counterup/counterup.min.js',
    'public/front/assets/vendor/owl.carousel/owl.carousel.min.js',
    'public/front/assets/vendor/isotope-layout/isotope.pkgd.min.js',
    'public/front/assets/vendor/venobox/venobox.min.js',
    'public/front/assets/vendor/aos/aos.js',
    'public/front/assets/js/main.js',

], 'public/front/assets/js/app.js');
