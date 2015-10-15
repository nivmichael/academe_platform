<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>AcadeME</title>
    <!-- Bootstrap core CSS -->

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../css/login.css" rel="stylesheet">


    <div class="container" style="text-align: center;">

        <img src="https://secure.wanted.co.il/en.demo.wanted.co.il/images/global/bgu-backround_760x760.png" >
        <form class="form-signin" method="POST" action="/auth/login">
            {!! csrf_field() !!}
            <!--<h2 class="form-signin-heading">Please sign in</h2>-->
            <p>Email</p>
            <input type="email" class="form-control login-form" name="email" value="[[ old('email') ]]" required>
            <h6>Password</h6>
            <input type="password" class="form-control login-form" name="password" id="password">

            <div>
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <button type="submit" class="btn btn-lg  btn-block loginButton login-form"></button>
            <a type="button"  href="/auth/register_employer/" class="btn btn-lg  btn-block registerButton login-form"></a>
            <a type="button" href="" class="btn btn-lg  btn-block loginFacebook login-form"></a>
            <a type="button" href="" class="btn btn-lg  btn-block loginLinkedIn login-form"></a>
        </form>

    </div>
    <!-- /container -->

    </body>
</html>

<!--
{{--<form method="POST" action="/auth/login">--}}
    {{--{!! csrf_field() !!}--}}

    {{--<div>--}}
        {{--Email--}}
        {{--<input type="email" name="email" value="[[ old('email') ]]">--}}
    {{--</div>--}}

    {{--<div>--}}
        {{--Password--}}
        {{--<input type="password" name="password" id="password">--}}
    {{--</div>--}}

    {{--<div>--}}
        {{--<input type="checkbox" name="remember"> Remember Me--}}
    {{--</div>--}}

    {{--<div>--}}
        {{--<button type="submit">Login</button>--}}
    {{--</div>--}}
    {{--<div>--}}
        {{--<a class="btn" href="/auth/register_employer/">Register</a>--}}
    {{--</div>--}}
{{--</form>--}}



-->