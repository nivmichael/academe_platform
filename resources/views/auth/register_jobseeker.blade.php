


<html ng-app="acadb">
	
	
    <head>
        <title>Laravel</title>
		<script src="../../lib/jquery-1.11.3.min.js"></script>
		<!-- angular -->
		<script src="../../lib/angular.min.js"></script>
		<script src="../../../lib/ui-router.js"></script>
		<script src="../../lib/ng-underscore.min.js"></script>
		<!-- bootstrap css -->
		<link href="../../css/bootstrap.min.css" rel="stylesheet">
		<!-- laravel app css -->
		<link href="[[ asset('../../css/app.css') ]]" rel="stylesheet">
		<!-- x-editable css -->
		<link href="../../lib/xeditable/css/xeditable.css" rel="stylesheet">
		<!-- custom style css -->
		<link href="../../css/myStyle.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
		<script type="text/ng-template" id="customTemplate.html">
			<a style="float:left;">
			<img ng-src="http://upload.wikimedia.org/wikipedia/commons/thumb/{{match.model.flag}}" width="16">
			<span bind-html-unsafe="match.label | typeaheadHighlight:query"></span>
			</a>
		</script>
		 
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
									<li><a href="[[ url('/') ]]">Edit Profile</a></li>
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
	</pre> --> 	<div ui-view="" class="col-lg-12"></div>
 </body>
 

    <script src="../../../lib/register_jobseeker_app.js"></script>
	<script src="../../lib/controllers.js"></script>
	<script src="../../lib/filters.js"></script>
	<script src="../../lib/services.js"></script>
	<script src="../../lib/directives.js"></script>
	<script src="../../lib/angular-route.js"></script>
	<script src="../../lib/angular-resource.js"></script>
	<script src="../../lib/xeditable/js/xeditable.js"></script>
	<script src="../../lib/bootstrap.min.js"></script>
	<script src="../../lib/ui-bootstrap-tpls-0.12.1.min.js"></script>
	<script src="../../lib/ngFlow/ng-flow-standalone.min.js"></script>
	<script src="../../lib/checklist-model.js"></script>

	<script>angular.module("acadb").constant("CSRF_TOKEN", '[[ csrf_token() ]]');</script>
</html>


<!-- <div class="errors alert alert-danger" ng-if="errors">
<ul>
<li ng-repeat="(t,s) in errors">{{s}}</li>
</ul>
</div>
{{errors}}
<div class="">
<div ng-repeat="(key,val) in user[docParam]" class="formDiv" >
<span ng-hide="docParam == 'education'">
<span class="param_label col-md-2" ng-hide="docParam == 'files' ">
{{key}}
</span>
<span class="param_input col-md-10">
<input type='text' class="form-control" name="{{docParam + '__' + key}}" ng-model="user[docParam][key]">
</span>
</span>

<span ng-if="docParam == 'education' " ng-hide="user[docParam].length+1 > 1">
<span class="param_label col-md-2" ng-hide="docParam == 'files' ">
{{key}}

</span>
<span  class="param_input col-md-10">
<input type='text' class="form-control" name="user[docParam][key]" ng-model="user[docParam][key]">
</span>
<span ng-show="$last">
<button class="btn btn-default" ng-click="add1(docParam,key,$index)">+ Add a Record</button>
</span>
</span>

<span ng-if="docParam == 'education' && user[docParam].length+1 > 1">

<span ng-repeat="(m,n) in val" class="formDiv">
<span class="param_label col-md-2">
{{m}}
</span>
<span class="param_input col-md-10">
<input type='text' class="form-control" name=="user[docParam][key][m]" ng-model="user[docParam][key][m]">
</span>
</span>
<div class="iterationCtrls">
<span class="iterationCtrl" ng-click="remove(user[docParam],$index)">
X Delete
</span>
<span class="iterationCtrl" ng-click="move(user[docParam],$index,$index-1)">
Move Up
</span>
<span class="iterationCtrl" ng-click="move(user[docParam],$index,$index+1)">
Move Down
</span>
</div>
<span ng-show="$last">
<button class="btn btn-default" ng-click="add1(docParam,key,$index)">+ Add a Record</button>
</span>
</span>

</div>
<div ng-repeat="(key,val) in user['files']" class="formDiv">
<span ng-show="docParam == 'files' ">
<span class="param_label col-md-2" >
{{key}}
</span>

<div style="height:200px;">
<img ng-src="{{val}}" style="width:200px;">
</div>
<div flow-init="flowOp(key)"
flow-files-submitted="$flow.upload()"
flow-file-added="!!{png:1,gif:1,jpg:1,jpeg:1}[$file.getExtension()]"
class="" >
<br/>

<div class="drop galleryDiv col-md-12" flow-drop ng-class="dropClass" flow-drag-enter="style={border:'1px solid #4E75AD'}" flow-drag-leave="style={border:'1px dashed blue'}" ng-style="style">

<p class="dragNdrop">Drag & Drop JPG, GIF or PNG Files Here!</p>

<div ng-repeat="file in $flow.files" class="gallery-box col-md-2">

<span class="thumbnail_title">{{file.name}}</span>
<div class="thumbnail" ng-show="$flow.files.length">
<img flow-img="file" />
<div class="progress progress-striped" ng-class="{active: file.isUploading()}">
<div class="progress-bar" role="progressbar"
aria-valuenow="{{file.progress() * 100}}"
aria-valuemin="0"
aria-valuemax="100"
ng-style="{width: (file.progress() * 100) + '%'}">
<span class="sr-only">{{file.progress()}}% Complete</span>
</div>
</div>
<div class="btn-group">
<a class="btn btn-xs btn-danger delBtnBtn" ng-click="file.cancel()">
<i class="delBtnIcon btn btn-default btn-xs glyphicon glyphicon-trash"></i>
</a>
</div>
</div>

</div>

<div class="clear"></div>
</div>
</div>
</span>
</div>
</div>

<div class="col-md-3 col-md-offset-3" ng-if="nextDoc(docParam)">

<a ng-click="saveUser(user,docParam)" class="btn btn-block btn-info">
Proceed To {{nextDoc(docParam)}} &nbsp <span class="glyphicon glyphicon-circle-arrow-right"></span>
</a>

</div>

<div class="col-md-3 col-md-offset-3" ng-if="nextDoc(docParam)==false">

<a href="/home#/home" class="btn btn-block btn-info">
Save &nbsp <span class="glyphicon glyphicon-circle-arrow-right"></span>
</a>

</div>

<div class="errors alert alert-danger" ng-if="errors">
<ul>
<li ng-repeat="(t,s) in errors">{{s}}</li>
</ul>
</div>

<div ng-repeat="(paramKey,paramValues) in user[docParam]" class="formDiv" >

<span ng-if="docParam == 'personalInfo'">
<span class="param_label col-md-2">
{{paramKey}}
</span>
<span class="param_input col-md-10">
<input type='text' class="form-control" name="" ng-model="user[docParam][paramKey]">
</span>
</span>

<span ng-if="docParam != 'personalInfo'">
<span class="param_label col-md-2">
{{paramKey}}
</span>

<span class="param_input col-md-10">
<input type='text' class="form-control" name="user[docParam][paramKey]['paramValue']" ng-model="user[docParam][paramKey]['paramValue']">
</span>
</span>

</div>
<div ng-hide="docParam == 'personalInfo'">
<button type="button" class="btn btn-default" ng-click="addRecordJobSeeker(docParam,$index)">+ Add a Record</button>
</div>

<div class="col-md-3 col-md-offset-3" ng-if="nextDoc(docParam)">

<a ng-click="saveUser(user,docParam)" class="btn btn-block btn-info">
Proceed To {{nextDoc(docParam)}} &nbsp <span class="glyphicon glyphicon-circle-arrow-right"></span>
</a>

</div>

<div class="col-md-3 col-md-offset-3" ng-if="nextDoc(docParam)==false">

<a href="/home#/home" class="btn btn-block btn-info">
Save &nbsp <span class="glyphicon glyphicon-circle-arrow-right"></span>
</a>

</div>

<!-- <div class="errors alert alert-danger" ng-if="errors">
<ul>
<li ng-repeat="(t,s) in errors">{{s}}</li>
</ul>
</div>
{{errors}}
<div class="">
<div ng-repeat="(key,val) in user[docParam]" class="formDiv" >
<span ng-hide="docParam == 'education'">
<span class="param_label col-md-2" ng-hide="docParam == 'files' ">
{{key}}
</span>
<span class="param_input col-md-10">
<input type='text' class="form-control" name="{{docParam + '__' + key}}" ng-model="user[docParam][key]">
</span>
</span>

<span ng-if="docParam == 'education' " ng-hide="user[docParam].length+1 > 1">
<span class="param_label col-md-2" ng-hide="docParam == 'files' ">
{{key}}

</span>
<span  class="param_input col-md-10">
<input type='text' class="form-control" name="user[docParam][key]" ng-model="user[docParam][key]">
</span>
<span ng-show="$last">
<button class="btn btn-default" ng-click="add1(docParam,key,$index)">+ Add a Record</button>
</span>
</span>

<span ng-if="docParam == 'education' && user[docParam].length+1 > 1">

<span ng-repeat="(m,n) in val" class="formDiv">
<span class="param_label col-md-2">
{{m}}
</span>
<span class="param_input col-md-10">
<input type='text' class="form-control" name=="user[docParam][key][m]" ng-model="user[docParam][key][m]">
</span>
</span>
<div class="iterationCtrls">
<span class="iterationCtrl" ng-click="remove(user[docParam],$index)">
X Delete
</span>
<span class="iterationCtrl" ng-click="move(user[docParam],$index,$index-1)">
Move Up
</span>
<span class="iterationCtrl" ng-click="move(user[docParam],$index,$index+1)">
Move Down
</span>
</div>
<span ng-show="$last">
<button class="btn btn-default" ng-click="add1(docParam,key,$index)">+ Add a Record</button>
</span>
</span>

</div>
<div ng-repeat="(key,val) in user['files']" class="formDiv">
<span ng-show="docParam == 'files' ">
<span class="param_label col-md-2" >
{{key}}
</span>

<div style="height:200px;">
<img ng-src="{{val}}" style="width:200px;">
</div>
<div flow-init="flowOp(key)"
flow-files-submitted="$flow.upload()"
flow-file-added="!!{png:1,gif:1,jpg:1,jpeg:1}[$file.getExtension()]"
class="" >
<br/>

<div class="drop galleryDiv col-md-12" flow-drop ng-class="dropClass" flow-drag-enter="style={border:'1px solid #4E75AD'}" flow-drag-leave="style={border:'1px dashed blue'}" ng-style="style">

<p class="dragNdrop">Drag & Drop JPG, GIF or PNG Files Here!</p>

<div ng-repeat="file in $flow.files" class="gallery-box col-md-2">

<span class="thumbnail_title">{{file.name}}</span>
<div class="thumbnail" ng-show="$flow.files.length">
<img flow-img="file" />
<div class="progress progress-striped" ng-class="{active: file.isUploading()}">
<div class="progress-bar" role="progressbar"
aria-valuenow="{{file.progress() * 100}}"
aria-valuemin="0"
aria-valuemax="100"
ng-style="{width: (file.progress() * 100) + '%'}">
<span class="sr-only">{{file.progress()}}% Complete</span>
</div>
</div>
<div class="btn-group">
<a class="btn btn-xs btn-danger delBtnBtn" ng-click="file.cancel()">
<i class="delBtnIcon btn btn-default btn-xs glyphicon glyphicon-trash"></i>
</a>
</div>
</div>

</div>

<div class="clear"></div>
</div>
</div>
</span>
</div>
</div>

<div class="col-md-3 col-md-offset-3" ng-if="nextDoc(docParam)">

<a ng-click="saveUser(user,docParam)" class="btn btn-block btn-info">
Proceed To {{nextDoc(docParam)}} &nbsp <span class="glyphicon glyphicon-circle-arrow-right"></span>
</a>

</div>

<div class="col-md-3 col-md-offset-3" ng-if="nextDoc(docParam)==false">

<a href="/home#/home" class="btn btn-block btn-info">
Save &nbsp <span class="glyphicon glyphicon-circle-arrow-right"></span>
</a>

</div> -->

