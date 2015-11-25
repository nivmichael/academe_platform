
<html ng-app="acadb">
    <head>
        <title>AcadeME</title>
		<script src="lib/jquery-1.11.3.min.js"></script>
		<!-- angular -->
		<script src="lib/angular.1.4.7.min.js"></script>

		<script src="../lib/ui-router.js"></script>
		<script src="lib/ng-underscore.min.js"></script>
		<!-- bootstrap css -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- laravel app css -->
		<link href="[[ asset('/css/app.css') ]]" rel="stylesheet">
		<!-- x-editable css -->
		<link href="lib/xeditable/css/xeditable.css" rel="stylesheet">
		<!-- custom style css -->
		<link href="css/angular-aside.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/myStyle.css"/>
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
					<div>
						<button type="button" class="navbar-toggle collapsed "   ng-click="openEmployerAside('left')"  style="z-index:9999999999999;">
							<i class="glyphicon glyphicon-align-justify" style="color:white";></i>
						</button>
					</div>
					<a class="navbar-brand col-md-2" href="jobseeker#/">My Profile </a>
				</div>
				<div class="col-lg-3 searchText">
					<div class="input-group">
							  <span class="input-group-btn">
								<button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search" style="padding:3px;"></i></button>
							  </span>
						<input type="text" class="form-control" ng-model="searchText"  placeholder="Search Jobs">
					</div><!-- /input-group -->
				</div><!-- /.col-lg-6 -->



				<span type="button" class="col-lg-1 meetingsLabel" ng-click="isCollapsed = !isCollapsed">Meetings</span>





				<!---
				<div class="col-lg-1 meetingsLabel">
					Meetings
				</div>
				-->

				<div class="col-lg-1 envelope">
					<a href=""><img ng-src="https://secure.wanted.co.il/en.demo.wanted.co.il/images/en_demo/messages_icon.png"></a>
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
								<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{user.company.company_name.paramValue}}<span class="caret"></span></a>
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
		<div uib-collapse="isCollapsed">
			<div class="">
				<h1>
					Meetings Console
				</h1>
				<div>

				</div>
			</div>

			<button type="button" class="btn btn-default" ng-click="isCollapsed = !isCollapsed">close</button>
		</div>





		<div ui-view=""></div>
	</body>
	<script src="lib/employer_app.js"></script>
	<script src="lib/controllers.js"></script>
	<script src="lib/filters.js"></script>

	<script src="lib/services.js"></script>
	<script src="lib/directives.js"></script>
	<script src="lib/angular-route.js"></script>
	<script src="lib/angular-resource.js"></script>
	<script src="lib/xeditable/js/xeditable.js"></script>
	<script src="lib/bootstrap.min.js"></script>
	<script src="lib/angular-animate.min.js"></script>
	<script src="lib/moment.js"></script>
	<script src="lib/angular_moment.min.js"></script>
	<script src="lib/ui-bootstrap-tpls-0.14.2.min.js"></script>
	<script src="lib/angular-aside.min.js"></script>
	<script src="lib/ngFlow/ng-flow-standalone.min.js"></script>
	<script src="lib/checklist-model.js"></script>

	<script>angular.module("acadb").constant("CSRF_TOKEN", '[[ csrf_token() ]]');</script>
</html>
