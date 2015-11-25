@extends('app')
@section('content')
	<div uib-collapse="isCollapsed" class="well">
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

	<div ui-view=""></div>
@endsection