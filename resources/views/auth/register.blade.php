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
 <div class="container-fluid" ng-controller="UserHomeController">
 	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
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

					<!-- <form class="form-horizontal" role="form" method="POST" action="[[ url('/auth/register') ]]">
						<input type="hidden" name="_token" value="[[ csrf_token() ]]">
						
						
						

						<div class="form-group">
							<label class="col-md-4 control-label">Email</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="[[ old('email') ]]">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">first_name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="first_name" e-name="first_name" value="[[ old('first_name') ]]">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">last_name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="last_name" e-name="last_name" value="[[ old('last_name') ]]">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">street_1</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="street_1" e-name="street_1" value="[[ old('street_1') ]]">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">street_2</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="street_2" e-name="street_2" value="[[ old('street_2') ]]">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">city</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="city" e-name="city" value="[[ old('city') ]]">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">state</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="state" e-name="state" value="[[ old('state') ]]">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">zipcode</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="zipcode" e-name="zipcode" value="[[ old('zipcode') ]]">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">country</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="country" e-name="country" value="[[ old('country') ]]">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">phone_1</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="phone_1" e-name="phone_1" value="[[ old('phone_1') ]]">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">phone_2</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="phone_2" e-name="phone_2" value="[[ old('phone_2') ]]">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">mobile</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="mobile" e-name="mobile" value="[[ old('mobile') ]]">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">date_of_birth</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="date_of_birth" e-name="date_of_birth" value="[[ old('date_of_birth') ]]">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">registration</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="registration" e-name="registration" value="[[ old('registration') ]]">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">send_newsletters</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="last_login" e-name="last_login" value="[[ old('last_login') ]]">
							</div>
						</div>
						
						
						

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					</form> -->
					<div ng-model="user">
    		<form editable-form name="editableForm" onaftersave="saveUser()" class="form-horizontal" role="form" method="POST" action="[[ url('/auth/register') ]]">
			<input type="hidden" name="_token" value="[[ csrf_token() ]]">
		    <div>
		      <!-- editable username (text with validation) -->
		      <span class="title">First Name: </span>
		      <span e-class="form-control" editable-text="user.first_name" e-name="first_name" e-placeholder="First Name" e-required>{{ user.first_name }}</span>
		      <span e-class="form-control" editable-text="user.last_name"  e-name="last_name"  e-placeholder="Last Name" e-required>{{ user.last_name }}</span>
		    </div> 
		    
		    <div>
		      <!-- editable username (text with validation) -->
		      <span class="title">E-mail:</span>
		      <span e-class="form-control" editable-text="user.email" e-name="email" e-placeholder="E-mail" e-required>{{ user.email }}</span>
		    </div> 
		    
		    <div>
		      <!-- editable username (text with validation) -->
		      <span class="title">Address:</span>
		      <span e-class="form-control" editable-text="user.street_1" e-name="street_1" e-placeholder="Street 1" e-required>{{ user.street_1 }}</span>
		      <span e-class="form-control" editable-text="user.street_2" e-name="street_2" e-placeholder="Street 2">{{ user.street_2 }}</span>
		      <span e-class="form-control" editable-text="user.city" e-name="city" e-placeholder="City" e-required>{{ user.city }}</span>
		      <span e-class="form-control" editable-text="user.zipcode" e-name="zipcode" e-placeholder="Zip Code" e-required>{{ user.zipcode }}</span>
		      <span e-class="form-control" editable-text="user.state" e-name="state" e-typeahead="state for state in states | filter:$viewValue | limitTo:8" e-placeholder="State" e-required>{{ user.state }}</span>
		      <span e-class="form-control" editable-text="user.country" e-name="country" e-typeahead="country for country in countries | filter:$viewValue | limitTo:8" e-placeholder="Country" e-required>{{ user.country }}</span>
		    </div> 
		    
		    <div>
		      <!-- editable username (text with validation) -->
		      <span class="title">Phone:</span>
		      <span e-class="form-control" editable-text="user.phone_1" e-name="phone_1" e-placeholder="Phone 1">{{ user.phone_1  }}</span>
		      <span e-class="form-control" editable-text="user.phone_2" e-name="phone_2" e-placeholder="Phone 2">{{ user.phone_2 || empty}}</span>
		      <span e-class="form-control" editable-text="user.mobile" e-name="mobile"   e-placeholder="Mobile" e-required>{{ user.mobile }}</span>
		    </div> 
		    
		    <div>
		      <!-- editable username (text with validation) -->
		      <span class="title">Birthday:</span>
		      <!-- <span e-class="form-control" editable-text="user.date_of_birth" e-name="date_of_birth" e-placeholder="Date Of Birth" e-required>{{ user.date_of_birth }}</span>
			 -->
              <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="dt" is-open="opened"  max-date="'2015-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Close" />
              <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
			  <button type="button" class="btn btn-sm btn-danger" ng-click="clear()">Clear</button>
  			  <hr />
		    </div> 
		    <div class="buttons">	
      			<button type="button" class="btn btn-default" ng-click="editableForm.$show()" ng-show="!editableForm.$visible">Edit</button>
	     		<span ng-show="editableForm.$visible">
		       		<button type="submit" class="btn btn-primary" ng-disabled="editableForm.$waiting">Register</button>
		       		<button type="button" class="btn btn-default" ng-disabled="editableForm.$waiting" ng-click="editableForm.$cancel()">Cancel</button>
	      		</span>
	    	</div>
	    	<!-- <div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button type="submit" class="btn btn-primary">
						Register
					</button>
				</div>
			</div> -->
	 	 </form>  
    	</div>
				</div>
			</div>
		</div>
	</div>
</div> 
<!-- <div ng-view=""></div> -->
</body>
<script src="../lib/app.js"></script>
	<script src="../lib/controllers.js"></script>
	<script src="../lib/services.js"></script>
	<script src="../lib/angular-route.js"></script>
	<script src="../lib/angular-resource.js"></script>
	<script src="../lib/xeditable/js/xeditable.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="../lib/ui-bootstrap-tpls-0.12.1.min.js"></script>
