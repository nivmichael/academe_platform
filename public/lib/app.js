
// Declare app level module which depends on filters, and services
angular.module('acadb', [	
  'ngRoute',
  'ngResource',
  'ui.bootstrap',
  'acadb.controllers',
  'acadb.services',
  'acadb.filters',
  'xeditable',

  
]).config(['$routeProvider' ,'$locationProvider', function($routeProvider ,$locationProvider) {
  
  $routeProvider.when('/', {templateUrl: 'partials/userHome.html',controller: 'UserHomeController' });
  $routeProvider.when('/param', {templateUrl: 'partials/db/param.html',controller: 'TController' });
  // $routeProvider.when('/type_user', {templateUrl: 'partials/db/type_user.html',controller: 'TController' });
  // $routeProvider.when('/type_user_params', {templateUrl: 'partials/db/type_user_params.html',controller: 'TController' });
  $routeProvider.otherwise({redirectTo: '/'});
  //$locationProvider.html5Mode(true);
  //$locationProvider.hashPrefix('!');

}]);	  