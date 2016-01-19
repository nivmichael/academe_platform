@extends('app')
@section('content')
	<main>
		<div uib-collapse="isCollapsed" class="">
			<div class="">
				<h1>
					Meetings Console
				</h1>
				<div>
					meeting meeting
				</div>
			</div>
			<button type="button" class="btn btn-default" ng-click="isCollapsed = !isCollapsed">close</button>
		</div>
	</main>
	<div ui-view=""></div>
@endsection