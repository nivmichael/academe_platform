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
            font-family: 'Roboto';
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

        <img ng-src="{{logo}}" style="width:300px;margin-top:100px;">
        <div class="welcomeIcons">




            <div class="clearfix"></div>
            <!--
            <a href="jobseeker"><img class="col-md-3 col-sm-3 col-xs-3" src="../img/index/student_login_hover.png"></a>
            <a href="jobseeker"><img class="col-md-3 col-sm-3 col-xs-3" src="../img/index/interns_login_hover.png"></a>
            <a href="jobseeker"><img class="col-md-3 col-sm-3 col-xs-3" src="../img/index/graduate_login_hover.png"></a>
            <a href="employer"><img class="col-md-3 col-sm-3 col-xs-3" src="../img/index/employer_login_hover.png"></a>
            -->
            <div class="welcomeIcon col-md-3" >
               <div class="welcomeIconInner" style="background-color:{{ main_color }}">
                    <a href="jobseeker/student" class="waves-effect waves-light"><img  src="../img/index/icons-01.png">
                        <p>
                            Student
                        </p>
                    </a>
               </div>
            </div>
            <div class="welcomeIcon col-md-3">
                <div class="welcomeIconInner" style="background-color:{{ main_color }}">
                    <a href="jobseeker/graduate" class="waves-effect waves-light"><img src="../img/index/icons-02.png">
                        <p>
                            Graduate
                        </p>
                    </a>
                </div>
            </div>
            <div class="welcomeIcon col-md-3">
                <div class="welcomeIconInner" style="background-color:{{ main_color }}">
                    <a href="jobseeker/intern" class="waves-effect waves-light"><img src="../img/index/icons-03.png">
                        <p>
                            Intern
                        </p>
                    </a>
                </div>
            </div>
            <div class="welcomeIcon col-md-3">
                <div class="welcomeIconInner" style="background-color:{{ main_color }}">
                    <a href="employer" class="waves-effect waves-light"><img src="../img/index/icons-04.png">
                        <p>
                            Employer
                        </p>
                    </a>
                </div>
            </div>
        </div>
	</div>

	<footer class="footer">


			<a href="admin"><img class="" src="../img/academe_logo.jpg"></a><label><a href="http://www.acade-me.com">&copy; 2015 AcadeME</a></label>

	</footer>

@endsection
