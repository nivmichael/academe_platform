
<html ng-app="acadb">
    <head>
        <title>Laravel</title>
				<script src="lib/jquery-1.11.3.min.js"></script>
		<!-- angular -->
		<script src="lib/angular.min.js"></script>
		<script src="../lib/ui-router.js"></script>
		<script src="lib/ng-underscore.min.js"></script>
		<!-- bootstrap css -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- laravel app css -->
		<link href="[[ asset('/css/app.css') ]]" rel="stylesheet">
		<!-- x-editable css -->
		<link href="lib/xeditable/css/xeditable.css" rel="stylesheet">
		<!-- custom style css -->
		<link href="css/myStyle.css" rel="stylesheet">
        
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <!-- <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style> -->
    </head>
    <body ng-controller="UserHomeController">
    	<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand col-md-2" href="jobseeker#/">My Profile </a>
				</div>
	
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
					
					</ul>
	
					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
							<li><a href="[[ url('/auth/login') ]]">Login</a></li>
							<li><a href="[[url('/auth/register') ]]">Register</a></li>
						@else
							<li class="dropdown">
								<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{user.personalInfo.first_name}}<span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a ui-sref="employer.edit">Edit Profile</a></li>
									<li><a href="[[ url('/auth/logout') ]]">Logout</a></li>
								</ul>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>
        
            	<!-- <pre>
{{$state.current.name}}
</pre>
                <div class="title">EMPLOYER</div> -->
                <div ui-view=""></div>
     
    </body>
    <script src="lib/employer_app.js"></script>	
	<script src="lib/controllers.js"></script>
	<script src="lib/services.js"></script>
	<script src="lib/filters.js"></script>
	<script src="lib/directives.js"></script>
	<script src="lib/angular-route.js"></script>
	<script src="lib/angular-resource.js"></script>
	<script src="lib/xeditable/js/xeditable.js"></script>
	<script src="lib/bootstrap.min.js"></script>
	<script src="lib/ui-bootstrap-tpls-0.12.1.min.js"></script>
	<script src="lib/ngFlow/ng-flow-standalone.min.js"></script>
	<script src="lib/checklist-model.js"></script>

	<script>angular.module("acadb").constant("CSRF_TOKEN", '[[ csrf_token() ]]');</script>
</html>