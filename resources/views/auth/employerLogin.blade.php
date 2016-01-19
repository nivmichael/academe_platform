@extends('app')

@section('content')

    <div class="container" style="text-align: center; margin-top:100px;">


        <img ng-src="{{logo}}" style="width:200px;">
        <form class="form-signin" method="POST" action="/auth/login">
            {!! csrf_field() !!}
                    <!--<h2 class="form-signin-heading">Please sign in</h2>-->
            <p>Email</p>
            <input type="email" class="form-control login-form" name="email" value="[[ old('email') ]]" required>
            <h6>Password</h6>
            <input type="password" class="form-control login-form" name="password" id="password">

            <div>
                <input type="checkbox" name="remember"> Remember Me
                <a href="/password/email" class="" style="float:right;">Reset</a>
            </div>

            <button type="submit" class="btn btn-lg  btn-block loginButton login-form">Login</button>

            <a type="button" href="/auth/register_employer/" class="btn btn-lg  btn-block registerButton login-form">New User</a>

            <a type="button" href="" class="btn btn-lg  btn-block loginFacebook login-form"></a>
            <a type="button" href="" class="btn btn-lg  btn-block loginLinkedIn login-form"></a>
        </form>
    </div>
@endsection