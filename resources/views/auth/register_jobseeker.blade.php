

@extends('auth.register')

@section('content')
	<main>
		<div uib-collapse="devDashboard" class="">
			<button ng-click="testfunc()">force validate devFunction</button>
			<button ng-click="resetValidation()">reset validate devFunction</button>
		</div>
	</main>
	<div ui-view="" class=""></div>
@endsection