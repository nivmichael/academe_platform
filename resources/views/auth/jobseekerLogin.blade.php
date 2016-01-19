@extends('app')
{!! session('status') !!}
@section('content')

    <div class="container" class="login-form" style="text-align: center;">


        <img ng-src="{{logo}}" style="width:200px; margin-top:100px;">
        <form class="form-signin" method="POST" action="/auth/login">
            {!! csrf_field() !!}
            <!--<h2 class="form-signin-heading">Please sign in</h2>-->
            <p class="left login-form">
                E-mail
            </p>
            <input type="email" class="form-control login-form" name="email" value="[[ old('email') ]]" required>

            <p class="left login-form">
                Password
            </p>
            <input type="password" class="form-control login-form" name="password" id="password">

            <div class="left login-form">
                <input type="checkbox" name="remember" class="left"> Remember Me
                <a href="/password/email" class="" style="float:right;">Reset</a>
            </div>

            <div class="">

            </div>
            <div class="login-form">
                <button type="submit" class="btn btn-lg  btn-block loginButton login-form">Login</button>
                <a type="button"  href="/auth/register_jobseeker/{!! session('status') !!}" class="btn btn-lg  btn-block registerButton login-form">New User</a>
                <a type="button" href="" class="btn btn-lg  btn-block loginFacebook login-form">Facebook</a>
                <a type="button" href="" class="btn btn-lg  btn-block loginLinkedIn login-form">LinkedIn</a>
            </div>

        </form>
    </div>
@endsection


