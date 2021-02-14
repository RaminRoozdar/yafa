<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>وارد کردن رمز</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body dir="rtl" style="direction: rtl">
<div id="login">
    <h3 class="text-center text-white pt-5">وارد کردن رمز یکبار مصرف</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="{{ route('doVerify') }}" method="post">
                        {{ csrf_field() }}
                        <h3 class="text-center text-info">ورود</h3>
                        <div class="form-group">
                            <label style="float: right"  for="code" class="text-info">کد تایید:</label><br>
                            <input type="text" name="code" id="code" class="form-control">
                        </div>
                        <div class="form-group">
                            <input style="float: right" type="submit" name="submit" class="btn btn-info btn-md" value="وارد کردن">
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