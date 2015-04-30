

// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('acadb.services', []).
  value('version', '0.1')

.factory('ParamData', ['$resource',
	function($resource) {
		return $resource('params/:id', {id: '@id'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'},
			 
		});
}])

.factory('UsersData', ['$resource',
	function($resource) {
		return $resource('users/:id', {id: '@id'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'}
		});
}])

.factory('ColumnData', ['$resource',
	function($resource) {
		return $resource('columns/:id', {id: '@id'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'}
		});
}]);
