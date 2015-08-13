
<!DOCTYPE html>
<html ng-app="acadb" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/acadeMe.ico">
	<title>AcadeME</title>
		<!-- jquery -->
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<!-- angular -->
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular.min.js"></script>
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
		<!-- Fonts -->
		<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
<body>
	
	
	<!-- navbar end -->
	@yield('content')

	<!-- Scripts -->
	<script src="lib/app.js"></script>	
	<script src="lib/controllers.js"></script>
	<script src="lib/services.js"></script>
	<script src="lib/directives.js"></script>
	<script src="lib/angular-route.js"></script>
	<script src="lib/angular-resource.js"></script>
	<script src="lib/xeditable/js/xeditable.js"></script>
	<script src="lib/bootstrap.min.js"></script>
	<script src="lib/ui-bootstrap-tpls-0.12.1.min.js"></script>
	<script src="lib/ngFlow/ng-flow-standalone.min.js"></script>
	<script src="lib/checklist-model.js"></script>

	<script>angular.module("acadb").constant("CSRF_TOKEN", '[[ csrf_token() ]]');</script>
	
	
</body>
</html>
