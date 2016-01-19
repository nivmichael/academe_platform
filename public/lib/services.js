

// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('acadb.services', []).
  value('version', '0.1')

.factory('ParamData', ['$resource',
	function($resource) {
		return $resource('../params/:id', {id: '@id'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'},
			'query': {method: 'GET', isArray: true }


			 
		});
}])

.factory('UsersData', ['$resource',
	function($resource) {
		return $resource('../users/:id', {id: '@id'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'},
			'query': {method: 'GET', isArray: true }
		});
}])

.factory('DocParamData', ['$resource',
	function($resource) {
		return $resource('../docParam/:id', {id: '@id'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'}
		});
}])

.factory('DocTypeData', ['$resource',
	function($resource) {
		return $resource('../docType/:id', {id: '@id'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'}
		});
}])

.factory('ParamTypeData', ['$resource',
	function($resource) {
		return $resource('../paramType/:id', {id: '@id'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'}
		});
}])


.factory('ColumnData', ['$resource',
	function($resource) {
		return $resource('../columns/:name', {id: '@name'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'},
			 'query':{method:'GET', transformRequest: function(data, headerFn){
			 	return JSON.stringify(data);
			 	}
			 }
			
			 
		});
}])
.factory('ParamValueData', ['$resource',
	function($resource) {
		return $resource('../paramValue/:id', {id: '@id'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'},
			 	
		});
			
			 
		
}])
.factory('SysParamValuesData', ['$resource',
	function($resource) {
		return $resource('../sysParamValues/:id', {id: '@id'}, {
			 'update': { method:'PUT' },
			 'insertNew': { method:'POST' },
			 'delete':{method:'DELETE'},
			 	
		});
}]);