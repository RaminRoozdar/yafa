<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>  ورود به پنل </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
<div id="login">
    <h3 class="text-center text-white pt-5">ورود به پنل مدیریت</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="#" method="post">
                        {{ csrf_field() }}
                        <h3 class="text-center text-info">ورود</h3>
                        <div class="form-group">
                            <label style="float: right" for="mobile" class="text-info">شماره موبایل:</label><br>
                            <input type="text" name="mobile" id="mobile" class="form-control">
                        </div>
                        <div class="form-group" style="float: right">
                            <label for="remember_me" class="text-info"><span>مرا به خاطر بسپار</span> <span><input
                                            id="remember_me" name="remember_me" type="checkbox"></span></label><br>
                            <input type="submit" name="submit" class="btn btn-info btn-md" value="وارد کردن">
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>