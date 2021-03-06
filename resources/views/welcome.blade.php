@extends('app')
@section('content')

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;

            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>
	<div class="container">

	    <div class="welcomeIcons">


            <img ng-src="{{logo}}" style="width:300px;">


            <div class="clearfix"></div>
            <!--
            <a href="jobseeker"><img class="col-md-3 col-sm-3 col-xs-3" src="../img/index/student_login_hover.png"></a>
            <a href="jobseeker"><img class="col-md-3 col-sm-3 col-xs-3" src="../img/index/interns_login_hover.png"></a>
            <a href="jobseeker"><img class="col-md-3 col-sm-3 col-xs-3" src="../img/index/graduate_login_hover.png"></a>
            <a href="employer"><img class="col-md-3 col-sm-3 col-xs-3" src="../img/index/employer_login_hover.png"></a>
            -->
            <div class="welcomeIcon col-md-3" >
               <div class="welcomeIconInner" style="background-color:{{ main_color }}">
                    <a href="jobseeker"><img  src="../img/index/icons-01.png"></a>
                    <p>
                        Student
                    </p>
               </div>
            </div>
            <div class="welcomeIcon col-md-3">
                <div class="welcomeIconInner" style="background-color:{{ main_color }}">
                    <a href="jobseeker"><img src="../img/index/icons-02.png"></a>
                    <p>
                        Graduate
                    </p>
                </div>
            </div>
            <div class="welcomeIcon col-md-3">
                <div class="welcomeIconInner" style="background-color:{{ main_color }}">
                    <a href="jobseeker"><img src="../img/index/icons-03.png"></a>
                    <p>
                        Intern
                    </p>
                </div>
            </div>
            <div class="welcomeIcon col-md-3">
                <div class="welcomeIconInner" style="background-color:{{ main_color }}">
                    <a href="employer" ><img src="../img/index/icons-04.png"></a>
                    <p>
                        Employer
                    </p>
                </div>
            </div>
        </div>
	</div>
	
	<footer class="footer">
		<div class="container-fluid">
			<div class="col-md-2 col-sm-2 col-xs-2">
				<a href="admin"><img class="col-md-8 col-sm-8 col-xs-8" src="../img/Menu-Logo.png"></a>	
			</div>
		</div>
	</footer>

@endsection
