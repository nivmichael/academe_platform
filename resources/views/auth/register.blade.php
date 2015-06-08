
<html ng-app="acadb">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../img/acadeMe.ico">
	<title>Academe</title>
		
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
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
<body>
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
	 <div class="container-fluid" >
 	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">Register</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>[[ $error ]]</li>
								@endforeach
							</ul>
						</div>
					@endif


<div ng-model="user" ng-controller="AuthController">


  <!-- <label class="checkbox">
    <input type="checkbox" ng-model="oneAtATime">
    Open only one at a time
  </label> -->
  <accordion close-others="oneAtATime">

    
    <accordion-group ng-repeat="(key, val) in user" class='active' is-open="status.isOpen[$index]">
	    
	     <accordion-heading is-open="status.isOpen[$index]" is-disabled="status.isOpen[$index]">
	            {{ key }}<i class="pull-right glyphicon" ng-class="{'fa-chevron-down': status.isOpen[$index], 'fa-chevron-right': !status.isOpen[$index]}"></i>
	     </accordion-heading>
    
    	<div>
    		
    	 <form editable-form name="editableForm" onaftersave="saveUser(user)" shown="true">
	 	     <div class="col-md-12">
		 	     <div ng-repeat="(k,v) in val" class="formParameter col-md-6" class="">
		 	     	<span >
			 	     	<span class="param_label">
			 	     	   {{k}}:
			 	     	</span>
		 	     	</span>
		 	     	 <span e-class="form-control"  editable-text="user.{{key}}.{{k}}" e-name="{{k}}">{{v}}</span>
		 	     </div>	 
	 	     </div>		
	 	     	 
	 	     		
	 	     		
	 	     		 	
			 	 <div class="buttons">
	      			<button type="button" class="btn btn-default" ng-click="editableForm.$show()" ng-show="!editableForm.$visible">Edit</button>
		     		<span ng-show="editableForm.$visible">
			       		<button type="submit" class="btn btn-primary" ng-disabled="editableForm.$waiting">Save</button>
			       	
		      		</span>
		    	</div>
		    </form>
    		
    	
    	</div>
    </accordion-group>
    
    
   </accordion>
 
</div>



</body>
	<script src="../lib/app.js"></script>
	<script src="../lib/controllers.js"></script>
	<script src="../lib/services.js"></script>
	<script src="../lib/directives.js"></script>
	<script src="../lib/angular-route.js"></script>
	<script src="../lib/angular-resource.js"></script>
	<script src="../lib/xeditable/js/xeditable.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="../lib/ui-bootstrap-tpls-0.12.1.min.js"></script>







