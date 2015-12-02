<html ng-app="acadb" ng-controller="MainCtrl">
<head>
	<title>AcadeME</title>
	<!-- jquery -->
	{!! Html::script('lib/jquery-1.11.3.min.js') !!}
	<!-- angular -->
	{!! Html::script('lib/angular.1.4.7.min.js') !!}

	<!-- ui-router -->
	{!! Html::script('../lib/ui-router.js') !!}

	<!-- underscore -->
	{!! Html::script('../lib/ng-underscore.min.js') !!}

	<!-- bootstrap css -->
	{!! Html::style('css/bootstrap.min.css') !!}

	<!-- laravel app css -->

	<link href="{!! asset('/css/app.css') !!}" rel="stylesheet">

	<!-- x-editable css -->
	{!! Html::style('lib/xeditable/css/xeditable.css') !!}

	<!-- angular-aside css -->
	{!! Html::style('../css/angular-aside.min.css') !!}

	<!-- custom style css -->


	{!! Html::style('../../css/login.css') !!}
	{!! Html::style('../../css/default.css') !!}


	<!-- fonts -->
	{!! Html::style('https://fonts.googleapis.com/css?family=Lato:100') !!}


</head>

<body ng-cloak>

<?php
	$path = Route::getCurrentRoute()->getPath();

?>
@if($path != '/' )
	@if(strpos($path,'login') === false)

		<nav class="navbar navbar-default" style="background-color:{{main_color}};">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed "   ng-click="openAside('left')" ng-show="true">
						<span class="sr-only"></span>
					</button>
					@if(Auth::guest())
						<a class="navbar-brand col-md-2" href="/">

							<!--<img ng-src="{{logo}}" style="width:30px;">-->
						</a>
					@elseif(Auth::user())
						<a class="navbar-brand col-md-2" href="jobseeker#/">My Profile </a>
					@endif

				</div>

				<div class="col-lg-3 searchText">
					<div class="input-group">
							  <span class="input-group-btn">
								<button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search" style="padding:3px;"></i></button>
							  </span>
						<input type="text" class="form-control searchTextInput" ng-model="searchText"  placeholder="Search Jobs">
					</div>
				</div>

				@if (Auth::user())
					<span type="button" class="col-lg-1 meetingsLabel" ng-click="isCollapsed = !isCollapsed">Meetings</span>
					<div class="col-lg-1 envelope">
						<div class="notificationsCircle"><span class="notificationsNum">{{1}}</span></div>
						<a href=""><img ng-src="https://secure.wanted.co.il/en.demo.wanted.co.il/images/en_demo/messages_icon.png"></a>
					</div>
				@endif

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">

					</ul>
					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
							<li><a href="">Option</a></li>
							<li><a href="">Another</a></li>
						@else
							<li class="dropdown">
								@if (Auth::user()->subtype == 'jobseeker')
									<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{user.personal_information.first_name}}<span class="caret"></span></a>
								@elseif (Auth::user()->subtype == 'employer')
									<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{user.company.company_name.paramValue}}<span class="caret"></span></a>
								@endif


								@if (Auth::user()->subtype == 'jobseeker')
									<ul class="dropdown-menu" role="menu">
										<li><a href="[[ url('/jobseeker#/profile') ]]">My Profile</a></li>
										<li><a href="[[ url('/auth/logout') ]]">Logout</a></li>
									</ul>
								@elseif (Auth::user()->subtype == 'employer')
									<ul class="dropdown-menu" role="menu">
										<li><a ui-sref="employer.edit">Edit Profile</a></li>
										<li><a href="[[ url('/auth/logout') ]]">Logout</a></li>
									</ul>
								@endif
							</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>
	@endif
@endif

	@yield('content')


</body>
@if(Auth::user())

	@if (Auth::user()->subtype == 'employer')
	{!! Html::script('lib/employer_app.js')!!}
	@elseif (Auth::user()->subtype == 'jobseeker')
	{!! Html::script('lib/jobseeker_app.js')!!}
	@endif

@elseif(Auth::guest())
	<?php

		$path = Route::getCurrentRoute()->getPath();
		$subtype = explode('/', $path);
		$subtype = $subtype[1];
	?>
	@if($subtype == 'register_jobseeker')
		{!! Html::script('lib/register_jobseeker_app.js')!!}
	@elseif($subtype == 'register_employer')
		{!! Html::script('lib/register_employer_app.js')!!}
	@else
		<!--need to add an empty app template just for angular to init-->
		{!! Html::script('lib/app.js')!!}
	@endif

@endif

{!! Html::script('lib/controllers.js')!!}
{!! Html::script('lib/filters.js')!!}
{!! Html::script('lib/services.js')!!}
{!! Html::script('lib/directives.js')!!}
{!! Html::script('lib/angular-route.js')!!}
{!! Html::script('/lib/angular-resource.js') !!}
{!! Html::script('lib/xeditable/js/xeditable.js')!!}
{!! Html::script('lib/bootstrap.min.js')!!}
{!! Html::script('lib/angular-animate.min.js')!!}
{!! Html::script('lib/moment.js')!!}
{!! Html::script('lib/angular_moment.min.js')!!}
{!! Html::script('lib/ui-bootstrap-tpls-0.14.2.min.js')!!}
{!! Html::script('lib/angular-aside.min.js')!!}
{!! Html::script('lib/ngFlow/ng-flow-standalone.min.js')!!}
{!! Html::script('lib/checklist-model.js')!!}
{!! Html::script('lib/showErrors.js')!!}

<script>angular.module("acadb").constant("CSRF_TOKEN", '{!! csrf_token() !!}');</script>
</html>
