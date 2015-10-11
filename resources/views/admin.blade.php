<?php

//var_dump(Auth::user());

?>
<html ng-app="acadb">
    <head>
        <title>Laravel</title>
				<script src="lib/jquery-1.11.3.min.js"></script>
		<!-- angular -->
		<script src="lib/angular.min.js"></script>
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
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    	        <style>
            /*html, body {
                height: 100%;
            }

        	h1,th,.btn{
        		font-family: 'Lato';
        		font-size:14px;
        	}

            .container {
                text-align: center;
    
                vertical-align: middle;
                 
            }*/

            .content {
            	
                text-align: center;
                display: inline-block;
            }

            /*.title {
            	font-family: 'Lato';
                font-size: 96px;
            }*/
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <!-- <div class="title">Admininstrator</div>
                	

<pre>
{{$state.current.name}}
</pre> -->
                <div ui-view=""></div>
            </div>
        </div>
    </body>
    <script src="lib/admin_app.js"></script>	
	<script src="lib/controllers.js"></script>
	<script src="lib/filters.js"></script>
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
</html>
