
<?php
    header("Access-Control-Allow-Origin: *");
?>


<html ng-app="acadb">
<head>
    <meta charset="utf-8">
    <title>AcadeME Smart & Simple</title>

    <!--jQuery & jQuery-ui-->
    {!! Html::script('lib/jquery-1.11.3.min.js') !!}
    {!! Html::script('lib/jquery-ui.min.js') !!}
    <!--CSS Libraries: bootstrap, materialize, angular-materialize-->
    {!! Html::style('lib/xeditable/css/xeditable.css') !!}
    {!! Html::style('css/bootstrap.min.css') !!}

    {!! Html::style('css/materialize.css') !!}
    {!! Html::style('css/angular-materialize.css') !!}
    <!--Custom CSS-->
    {!! Html::style('css/statevis.css') !!}
    {!! Html::style('css/rerouting.css') !!}
    {!! Html::style('css/jquery.rateyo.css') !!}
    <!--Fonts-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

    <!-- Bootstrap Material Design

   <!--    <link href="css/bootstrap-material-design.css" rel="stylesheet">-->
    <!--    <link href="css/ripples.min.css" rel="stylesheet">-->
</head>


<body  ng-cloak>

        <div class="wrapper">

            <div ui-view></div>


            <div  ng-show="ToolbarModel.IsVisible" ui-view="sideNav"></div>
            <div  ui-view="nav"></div>
            <div  ui-view="main" id="main" style="padding-top:10px;" ></div>
            <div  ui-view="footer" class=""></div>
        </div>


</body>

<!-- Application Dependencies -->

{!! Html::script('lib/angular.js') !!}
{!! Html::script('lib/angular-ui-router.min.js') !!}
{!! Html::script('lib/ui-extra.js') !!}
{!! Html::script('lib/satellizer.min.js') !!}
{!! Html::script('js/app.js') !!}
{!! Html::script('js/controllers.js') !!}
{!! Html::script('js/services.js') !!}
{!! Html::script('js/filters.js') !!}
{!! Html::script('js/directives.js') !!}
{!! Html::script('/lib/angular-resource.js') !!}

{!! Html::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js') !!}

{!! Html::script('lib/ui-bootstrap-tpls-0.14.2.min.js') !!}

{!! Html::script('lib/angular-route.js') !!}
{!! Html::script('lib/moment.js')!!}
{!! Html::script('lib/angular_moment.min.js')!!}

{!! Html::script('lib/materialize.js') !!}
{!! Html::script('lib/angular-sanitize.min.js') !!}

{!! Html::script('lib/underscore.js') !!}
{!! Html::script('lib/angular-materialize.js') !!}
{!! Html::script('lib/angular-animate.min.js') !!}
{!! Html::script('lib/toArrayFilter.js') !!}
{!! Html::script('lib/rating/jquery.rateyo.js')!!}
{!! Html::script('lib/rating/angular-rating-yo.js')!!}
{!! Html::script('lib/xeditable/js/xeditable.js')!!}
{!! Html::script('js/controllers/home.js') !!}
{!! Html::script('js/controllers/login.js') !!}
{!! Html::script('js/controllers/logout.js') !!}
{!! Html::script('js/controllers/navbar.js') !!}
{!! Html::script('js/controllers/profile.js') !!}
{!! Html::script('js/controllers/signup.js') !!}
{!! Html::script('js/controllers/postCtrl.js') !!}
{!! Html::script('js/controllers/companyCtrl.js') !!}




<script>angular.module("acadb").constant("CSRF_TOKEN", '{!! csrf_token() !!}');</script>


<!-- Application Scripts





-->




</html>
