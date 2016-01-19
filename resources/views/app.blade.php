<html ng-app="acadb" ng-controller="MainCtrl">
<head>
	<title>AcadeME</title>
	<!-- jquery -->
	{!! Html::script('lib/jquery-1.11.3.min.js') !!}
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
	<!-- angular -->
	{!! Html::script('lib/angular.1.4.7.min.js') !!}
	<!-- ui-router -->
	{!! Html::script('../lib/ui-router.js') !!}
	<!-- underscore -->
	{!! Html::script('../lib/ng-underscore.min.js') !!}

	<!-- css -->

	<!--Laravel default-->
	<link href="{!! asset('/css/app.css') !!}" rel="stylesheet">
	<!-- x-editable css -->
	{!! Html::style('lib/xeditable/css/xeditable.css') !!}
	<!-- bootstrap css -->

	{!! Html::style('css/bootstrap.min.css') !!}
	<!-- custom style css -->

	{!! Html::style('../../css/login.css') !!}



	{!! Html::style('../../css/ripple.css') !!}

<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css">-->

	{!! Html::style('css/materialize_fix.css')!!}




	{!! Html::script('../../lib/angular-ui-switch.js') !!}

	{!! Html::script('../../lib/sortable.js') !!}
	{!! Html::style('css/materialize.css')!!}
	{!! Html::style('css/angular-materialize.css')!!}

	{!! Html::style('../../css/main.css') !!}
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

	<style>
		body {
			font-family: 'Roboto', serif;

		}
	</style>

</head>

<body ng-cloak>

<?php
$path = Route::getCurrentRoute()->getPath();

?>

@if(Auth::check())
	@if(Auth::user()->type == 'tech-admin' && strpos($path,'admin') === true )
		<div class="navbar navbar-default" style="background-color:#4E75AD;">
			<div class="container-fluid">
				<div class="navbar-header">

					<button type="button" class="navbar-toggle collapsed " data-toggle="collapse"  data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<i class="glyphicon glyphicon-cog"></i>
					</button>

					<button type="button" class="menu navbar-toggle button-collapse" data-activates="nav-mobile" data-sidenav="left"  data-closeonclick="true"><i class="glyphicon glyphicon-th-list"></i></button>


						<a class="navbar-brand" href="admin">Admin</a>


				</div>

				<div class="input-group searchText">
							  <span class="input-group-btn">
								<button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search" style="padding:3px;"></i></button>
							  </span>
					<input type="text" class="form-control searchTextInput" ng-model="searchText"  placeholder="Search Jobs">
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

					<ul class="nav navbar-nav">

					</ul>

					<ul class="nav navbar-nav navbar-right">

					</ul>
				</div>
			</div>
		</div>
	@endif
@endif



@if($path != '/' )
	@if(strpos($path,'login') === false)
		<div class="navbar navbar-default" style="background-color:{{main_color}};">
			<div class="container-fluid">
				<div class="navbar-header">

					<button type="button" class="navbar-toggle collapsed " data-toggle="collapse"  data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<i class="glyphicon glyphicon-cog"></i>
					</button>

					<button type="button" class="menu navbar-toggle button-collapse" data-activates="nav-mobile" data-sidenav="left"  data-closeonclick="true"><i class="glyphicon glyphicon-th-list"></i></button>
					@if(Auth::check())
						@if (Auth::user()->subtype == 'jobseeker')
							<a class="navbar-brand" ui-sref="jobseeker.profile">My Profile </a>
						@elseif (Auth::user()->subtype == 'employer')
							<a class="navbar-brand" href="employer#/jobs">My Profile </a>

						@endif
					@endif


				</div>
				<!--
				<div class="input-group searchText">
							  <span class="input-group-btn">
								<button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search" style="padding:3px;"></i></button>
							  </span>
					<input type="text" class="form-control searchTextInput" ng-model="searchText"  placeholder="Search Jobs">
				</div>
				-->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

					<ul class="nav navbar-nav">
						@if (Auth::user())

						@endif
					</ul>

					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
							<li><a href=""><i class="glyphicon glyphicon-user"></i></a></li>
							<li><a href=""><i class="glyphicon glyphicon-education"></i></a></li>
							<li><a type="button" class="" ng-click="dev()"><i class="glyphicon glyphicon-tower"></i></a></li>
						@else
							<li>
								<a type="button" class="meetingsLabel" ng-click="isCollapsed = !isCollapsed">Meetings <span class="new badge">4</span></a>
							</li>
							<li>
								<a href="#"><img class="envelope" ng-src="https://secure.wanted.co.il/en.demo.wanted.co.il/images/en_demo/messages_icon.png"> <span class="new badge">4</span></a>
							</li>









							<li class="" ng-controller="UserHomeController">

									@if (Auth::user()->subtype == 'jobseeker')


										<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{user.personal_information.first_name}}<span class="caret"></span></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="[[ url('/jobseeker#/profile') ]]">My Profile</a></li>
											<li><a href="[[ url('/auth/logout') ]]">Logout</a></li>
										</ul>
									@elseif (Auth::user()->subtype == 'employer')
										<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{user.company.company_name.paramValue}}<span class="caret"></span></a>
										<ul class="dropdown-menu" role="menu">
											<li><a ui-sref="employer.edit">Edit Profile</a></li>
											<li><a href="[[ url('/auth/logout') ]]">Logout</a></li>
											@if(Auth::user()->type != 'user')
												<li role="separator" class="divider"></li>
												<li><a ui-sref="admin.stats">Administrator</a></li>
											@endif()


										</ul>
									@endif

							</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	@endif
@endif






@yield('content')


</body>




<!--
* getting the corrct app.js :
*
* default with css only
* admin
* registering a jobseeker
* registering an employer
* jobseeker home
* employer home
*/
-->
<?php
$path = Route::getCurrentRoute()->getPath();
$subtype = explode('/', $path);
if(isset($subtype[1])){
	$subtype = $subtype[1];
}
?>
@if(Auth::guest())


	@if($subtype == 'register_jobseeker')
		{!! Html::script('lib/register_jobseeker_app.js')!!}
	@elseif($subtype == 'register_employer')
		{!! Html::script('lib/register_employer_app.js')!!}
	@else
		{!! Html::script('lib/app.js')!!}
	@endif

@elseif(Auth::check())

	@if (!in_array(Auth::user()->type,['tech-admin','system-admin','system-manager']))

		@if (Auth::user()->subtype == 'employer')
			{!! Html::script('lib/employer_app.js')!!}
		@elseif(Auth::user()->subtype == 'jobseeker')
			{!! Html::script('lib/jobseeker_app.js')!!}
		@endif

	@elseif(in_array(Auth::user()->type,['tech-admin','system-admin','system-manager']))
		{!! Html::script('lib/admin_app.js')!!}
	@endif

@else

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
{!! Html::script('lib/toArrayFilter.js')!!}
{!! Html::script('lib/angular-ripple.js')!!}
{!! Html::script('lib/angular-file-upload.js')!!}
{!! Html::script('lib/pdf.js')!!}
{!! Html::script('lib/pdf.worker.js')!!}
{!! Html::script('lib/angular-pdf.js')!!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js"></script>
{!! Html::script('lib/angular-materialize.js') !!}



<!--
*cross domain token csrf
-->

<script>angular.module("acadb").constant("CSRF_TOKEN", '{!! csrf_token() !!}');</script>

</html>
