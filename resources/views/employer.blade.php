@extends('app')

@section('content')
<!-- navbar -->

<div ng-controller="UserHomeController">
<pre>
{{$state.current.name}}
</pre>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/home#/">My Account</a>
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
							<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{user.company.company_name}}</span><span class="caret"></span></a>
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
<div class="container-fluid" >
	

<div ui-view="employer">
 	 	 	{{user.personalInfo.first_name}} please wait...							
</div>

 	

</div>
</div>
@endsection
