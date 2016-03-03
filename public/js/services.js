


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
	}])

.factory('SelectOptions', ['$http','$q',
	function($http, $q) {
		//var promise;
		var options;
		return {
			getOptions: function(paramName, docParamId) {
				if ( !options[paramName] ) {
					if (typeof options[paramName] == 'undefined') options[paramName] = [];
					options[paramName] =  options[paramName].length ? null : $http.get('/param/'+ paramName + '/' + docParamId).then(function(response) {
						options[paramName] = response;
							return $q.when(options[paramName]);
						});
				}
				return $q.when(options[paramName]);
			},
			getAllOptionValues: function(){
				if ( !options ) {
					if (typeof options == 'undefined') options = [];
					options =  options.length ? null : $http.get('api/getAllOptionValues').then(function(response) {
						options = response;
						console.log(options);
						return $q.when(options);
					});
									}
				return $q.when(options);
			}
		};
	}])
//.factory('FormService', ['$http','$q',
//	function($http, $q) {
//
//
//
//
//
//
//
//
//
//
//
//	}])
.factory('Account', function($http, $rootScope) {

	var promise;
	return {
		getProfile: function() {
			if ( !promise ) {
				// $http returns a promise, which has a then function, which also returns a promise
				promise = $http.get('/api/me').then(function (response) {
					// The then function here is an opportunity to modify the response

					// The return value gets picked up by the then in the controller.
					return response.data;
				});
			}
			// Return the promise to the controller
			return promise;
		},
		updateProfile: function(profileData) {
			return $http.post('/api/me',profileData);
		},
		broadcast: function(user) {
			$rootScope.$broadcast('handleBroadcast', user);
		},
		logout: function(){

			return promise = null;
		}
	};



		//return {
		//	broadcast: function(user) {
		//		$rootScope.$broadcast('handleBroadcast', user);
		//	},
		//	getProfile: function() {
		//		return $http.get('/api/me');
		//	},
		//	updateProfile: function(profileData) {
		//		return $http.post('/api/me',profileData);
		//	},
		//	getType: function() {
		//		$http.get('/api/me')
		//			.success(function(data){
		//				return data.personal_information.subtype;
		//			})
		//			.error(function(){
        //
		//			})
        //
		//	},
		//};
	})
	.factory('verifyToken', function($http) {
		return {
			verify: function(stateParams){
				console.log('verifyToken');
				var verify = $http.post('verifyToken',{token:token});
					verify.success()
					verify.error()
			}
		};
	})
	.factory("FlashService", function($rootScope) {
		return {
			show: function(message) {
				$rootScope.flash = message;
			},
			clear: function() {
				$rootScope.flash = "";
			}
		};
	})

	.factory("SessionService", function() {
		return {
			get: function(key) {
				return sessionStorage.getItem(key);
			},
			set: function(key, val) {
				return sessionStorage.setItem(key, val);
			},
			unset: function(key) {
				return sessionStorage.removeItem(key);
			}
		};
	})

	.factory("AuthenticationService", function($http, $q, $timeout, $sanitize, SessionService, FlashService, CSRF_TOKEN ) {
		var _identity = undefined, _authenticated = false;

		var cacheSession   = function() {
			SessionService.set('authenticated', true);
		};

		var uncacheSession = function() {
			SessionService.unset('authenticated');
		};

		var loginError = function(response) {
			FlashService.show(response.flash);
		};
		/* not sure this sanitation is necessary, but it d'oesnt hurt*/
		var sanitizeCredentials = function(credentials) {
			return {
				email: $sanitize(credentials.email),
				password: $sanitize(credentials.password),
				_token :CSRF_TOKEN
			};
		};

		return {
			login: function(credentials) {
				var login = $http.post("/auth/login", angular.extend(sanitizeCredentials(credentials , CSRF_TOKEN)) );
				login.success(cacheSession);
				login.success(FlashService.clear);
				login.error(loginError);

				return login;
			},
			logout: function() {
				var logout = $http.get("/auth/logout");
				logout.success(uncacheSession);
				return logout;
			},
			isLoggedIn: function() {
				return SessionService.get('authenticated');
			},
			isIdentityResolved: function() {
				return angular.isDefined(_identity);
			},
			isAuthenticated: function() {
				return _authenticated;
			},
			isInRole: function(role) {
				if (!_authenticated || !_identity.roles) return false;

				return _identity.roles.indexOf(role) != -1;
			},
			isInAnyRole: function(roles) {
				if (!_authenticated || !_identity.roles) return false;

				for (var i = 0; i < roles.length; i++) {
					if (this.isInRole(roles[i])) return true;
				}

				return false;
			},
			authenticate: function(identity) {
				_identity = identity;
				_authenticated = identity != null;
			},
			identity: function(force) {
				var deferred = $q.defer();

				if (force === true) _identity = undefined;

				// check and see if we have retrieved the identity data from the server. if we have, reuse it by immediately resolving
				if (angular.isDefined(_identity)) {
					deferred.resolve(_identity);

					return deferred.promise;
				}

				 //otherwise, retrieve the identity data from the server, update the identity object, and then resolve.
				 //                  $http.get('/svc/account/identity', { ignoreErrors: true })
				 //                       .success(function(data) {
				 //                           _identity = data;
				 //                           _authenticated = true;
				 //                           deferred.resolve(_identity);
				 //                       })
				 //                       .error(function () {
				 //                           _identity = null;
				 //                           _authenticated = false;
				 //                           deferred.resolve(_identity);
				 //                       });

				// for the sake of the demo, fake the lookup by using a timeout to create a valid
				// fake identity. in reality,  you'll want something more like the $http request
				// commented out above. in this example, we fake looking up to find the user is
				// not logged in

				//var self = this;
				//$timeout(function() {
				//	//self.authenticate({
				//	//	user:{personal_information:{first_name:'dor'}},
				//	//	roles: ['user']
				//	//});
                //
				//	deferred.resolve(_identity);
				//	console.log('identity: '+_identity);
				//	//console.log(_identity);
				//}, 1000);
                //
				deferred.resolve(_identity);
				return deferred.promise;
			}
		};

	})

	.factory('authorization', ['$rootScope', '$state', 'AuthenticationService',
		function($rootScope, $state, AuthenticationService) {
			return {

				handle: function(){

					return AuthenticationService.isLoggedIn();
				},

				authorize: function() {


					return AuthenticationService.identity()

						.then(function() {
							var isAuthenticated = AuthenticationService.isAuthenticated();



							if ($rootScope.toState.data.roles && $rootScope.toState.data.roles.length > 0 && !AuthenticationService.isInAnyRole($rootScope.toState.data.roles)) {
								if (isAuthenticated) $state.go('401'); // user is signed in but not authorized for desired state
								else {
									// user is not authenticated. stow the state they wanted before you
									// send them to the signin state, so you can return them when you're done
									$rootScope.returnToState = $rootScope.toState;
									$rootScope.returnToStateParams = $rootScope.toStateParams;

									// now, send them to the signin state so they can log in
									$state.go('login');
								}
							}

						});
				}
			};
		}
	]);

	//.factory('principal', ['$q', '$http', '$timeout',
	//	function($q, $http, $timeout) {
	//		var _identity = undefined,
	//			_authenticated = false;
    //
	//		return {
	//			isIdentityResolved: function() {
	//				return angular.isDefined(_identity);
	//			},
	//			isAuthenticated: function() {
	//				return _authenticated;
	//			},
	//			isInRole: function(role) {
	//				if (!_authenticated || !_identity.roles) return false;
    //
	//				return _identity.roles.indexOf(role) != -1;
	//			},
	//			isInAnyRole: function(roles) {
	//				if (!_authenticated || !_identity.roles) return false;
    //
	//				for (var i = 0; i < roles.length; i++) {
	//					if (this.isInRole(roles[i])) return true;
	//				}
    //
	//				return false;
	//			},
	//			authenticate: function(identity) {
	//				_identity = identity;
	//				_authenticated = identity != null;
	//			},
	//			identity: function(force) {
	//				var deferred = $q.defer();
    //
	//				if (force === true) _identity = undefined;
    //
	//				// check and see if we have retrieved the identity data from the server. if we have, reuse it by immediately resolving
	//				if (angular.isDefined(_identity)) {
	//					deferred.resolve(_identity);
    //
	//					return deferred.promise;
	//				}
    //
	//				// otherwise, retrieve the identity data from the server, update the identity object, and then resolve.
	//				//                   $http.get('/svc/account/identity', { ignoreErrors: true })
	//				//                        .success(function(data) {
	//				//                            _identity = data;
	//				//                            _authenticated = true;
	//				//                            deferred.resolve(_identity);
	//				//                        })
	//				//                        .error(function () {
	//				//                            _identity = null;
	//				//                            _authenticated = false;
	//				//                            deferred.resolve(_identity);
	//				//                        });
    //
	//				// for the sake of the demo, fake the lookup by using a timeout to create a valid
	//				// fake identity. in reality,  you'll want something more like the $http request
	//				// commented out above. in this example, we fake looking up to find the user is
	//				// not logged in
	//				var self = this;
	//				$timeout(function() {
	//					self.authenticate(null);
	//					deferred.resolve(_identity);
	//				}, 1000);
    //
	//				return deferred.promise;
	//			}
	//		};
	//	}
	//])
