@extends('app')

@section('content')
<!-- navbar -->
<div >	
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">My Profile</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<!-- <ul class="nav navbar-nav">
					<li><a ui-sref="type_user">type_user</a></li>
					<li><a ui-sref="doc_type">doc_type</a></li>
					<li><a ui-sref="doc_param">doc_param</a></li>
					<li><a ui-sref="param">param</a></li>
					<li><a ui-sref="param_type">param_type</a></li>
					<li><a ui-sref="param_value">param_value</a></li>
					<li><a ui-sref="sys_param_values">sys_param_values</a></li>
				</ul> -->

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="[[ url('/auth/login') ]]">Login</a></li>
						<li><a href="[[url('/auth/register') ]]">Register</a></li>
					@else
						<li class="dropdown">
							<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">[[ Auth::user()->first_name ]] <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="[[ url('/') ]]">Edit Profile</a></li>
								<li><a href="[[ url('/auth/logout') ]]">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	
	
	<div>
		<a ui-sref="param_manager">Manage Parameters</a>	
	</div>	
		
		<!-- <ul class="nav navbar-nav">
			<li><a ui-sref="type_user">Users</a></li>
			<li><a ui-sref="param">Parameters</a></li>
			<li><a ui-sref="sys_param_values">sys_param_values</a></li>
			<li><a ui-sref="doc_type">doc_type</a></li>
			<li><a ui-sref="doc_param">doc_param</a></li>
			<li><a ui-sref="param_type">param_type</a></li>
			<li><a ui-sref="param_value">param_value</a></li>
		</ul>	 -->
	 <div ui-view="param_manager" ></div>
	
	
	 
	  
</div>	

@endsection
	
			              
			