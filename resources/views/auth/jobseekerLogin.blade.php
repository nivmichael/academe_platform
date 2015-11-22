<!DOCTYPE html>
<html lang="en" ng-app="acadb">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <script src="../../lib/jquery-1.11.3.min.js"></script>
    <!-- angular -->
    <script src="../../lib/angular.1.4.7.min.js"></script>

    <script src="../../lib/ui-router.js"></script>
    <title>AcadeME</title>
    <!-- Bootstrap core CSS -->

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../css/login.css" rel="stylesheet">


    <div class="container" style="text-align: center;" ng-controller="UserHomeController">

        <img ng-src="{{logo}}" style="width:500px;">
        <form class="form-signin" method="POST" action="/auth/login">
            {!! csrf_field() !!}
            <!--<h2 class="form-signin-heading">Please sign in</h2>-->
            <h6>Email</h6>
            <input type="email" class="form-control login-form" name="email" value="[[ old('email') ]]" required>
            <h6>Password</h6>
            <input type="password" class="form-control login-form" name="password" id="password">

            <div>
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <button type="submit" class="btn btn-lg  btn-block loginButton login-form"></button>
            <a type="button"  href="/auth/register_jobseeker/" class="btn btn-lg  btn-block registerButton login-form"></a>
            <a type="button" href="" class="btn btn-lg  btn-block loginFacebook login-form"></a>
            <a type="button" href="" class="btn btn-lg  btn-block loginLinkedIn login-form"></a>
        </form>

    </div>
    <!-- /container -->

    </body>
    <script src="../../lib/jobseeker_app.js"></script>
    <script src="../../lib/controllers.js"></script>
    <script src="../../lib/filters.js"></script>
    <script src="../../lib/services.js"></script>
    <script src="../../lib/directives.js"></script>
    <script src="../../lib/angular-route.js"></script>
    <script src="../../lib/angular-resource.js"></script>
    <script src="../../lib/angular-animate.min.js"></script>
    <script src="../../lib/xeditable/js/xeditable.js"></script>
    <script src="../../lib/bootstrap.min.js"></script>
    <script src="../../lib/angular-aside.min.js"></script>

    <script src="../../lib/moment.js"></script>
    <script src="../../lib/angular_moment.min.js"></script>

    <script src="../../lib/ui-bootstrap-tpls-0.14.2.min.js"></script>
    <script src="../../lib/ngFlow/ng-flow-standalone.min.js"></script>
    <script src="../../lib/checklist-model.js"></script>

    <script>angular.module("acadb").constant("CSRF_TOKEN", '[[ csrf_token() ]]');</script>
</html>


<!--

<form method="POST" action="/auth/login">
    {!! csrf_field() !!}

    <div>
        Email
        <input type="email" name="email" value="[[ old('email') ]]">
    </div>

    <div>
        Password
        <input type="password" name="password" id="password">
    </div>

    <div>
        <input type="checkbox" name="remember"> Remember Me
    </div>

    <div>
        <button type="submit">Login</button>
    </div>
     <div>
         <a class="btn" href="/auth/register_jobseeker/">Register</a>
    </div>
</form>



-->