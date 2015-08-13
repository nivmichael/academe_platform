
<html ng-app="acadb">
<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../img/acadeMe.ico">
	<title>Academe</title>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular.min.js"></script>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		
 		<script src="../lib/ui-router.js"></script>
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
		
		<link href="../lib/xeditable/css/xeditable.css" rel="stylesheet">
		<link href="../css/myStyle.css" rel="stylesheet">
		

	<!-- <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> -->

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<pre>
			<ul>
				@foreach ($errors->all() as $error)
					<li>[[ $error ]]</li>
				@endforeach
			</ul>
			</pre>
		</div>
	@endif
<body ng-controller="RegisterController">
	
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
				<a class="navbar-brand" href="/">My Profile </a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
				
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="[[ url('/auth/login') ]]">Login</a></li>
						
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


		<div ng-model="user" class="col-sm-3 col-md-9">
 	 				<div ui-view="form">
 	 					form
 	 				</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
</body>

	<script src="../lib/app.js"></script>
	<script src="../lib/controllers.js"></script>
	<script src="../lib/services.js"></script>
	<script src="../lib/directives.js"></script>
	<script src="../lib/angular-route.js"></script>
	<script src="../lib/angular-resource.js"></script>
	<script src="../lib/xeditable/js/xeditable.js"></script>
	<script src="../lib/ngFlow/ng-flow-standalone.min.js"></script>
	<script src="../lib/checklist-model.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="../lib/ui-bootstrap-tpls-0.12.1.min.js"></script>
	<script>angular.module("acadb").constant("CSRF_TOKEN", '[[ csrf_token() ]]');</script>






