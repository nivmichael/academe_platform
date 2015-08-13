
var $stateProviderRef = null;
var $urlRouterProviderRef = null;

var acadb = angular.module('acadb', [
  'ngRoute', 
  'ui.router',
  'ui.bootstrap',
  'flow',
  'acadb.controllers',
  'acadb.services',
  'acadb.filters',
  'acadb.directives',
  'xeditable',
  'ngResource',
  'checklist-model',
])


.run(['$rootScope', '$state', '$stateParams',
  function($rootScope, $state, $stateParams) {
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
   
  }
])

.config(['$locationProvider', '$stateProvider', '$urlRouterProvider', '$httpProvider',
    function($locationProvider, $stateProvider, $urlRouterProvider, $httpProvider) {

      // XSRF token naming
      $httpProvider.defaults.xsrfHeaderName = 'x-dt-csrf-header';
      $httpProvider.defaults.xsrfCookieName = 'X-CSRF-TOKEN';

      //$httpProvider.interceptors.push('httpInterceptor');
      $urlRouterProvider.otherwise("/");
       
      $stateProvider
      .state('home', {
          url: "/home",
          controller: 'UserHomeController',
          views:{
          	'home':{
          		 templateUrl: '../partials/userHome.html',
          		 controller: 'UserHomeController',       			 
          	}
          }
        })
        .state('employer', {
          url: "/employer",
          controller: 'UserHomeController',
          views:{
          	'employer':{
          		 templateUrl: '../partials/employerHome.html',
          		 controller: 'UserHomeController',       			 
          	}
          }
        })
        .state('registerEmployer', {
          url: "/registerEmployer",         
          controller: 'RegisterController', 
          views:{
          	"form":{         		
          		 templateUrl: '../partials/employer/form.html',
          		} 
          	}       
        })
        .state('registerJobSeeker', {
          url: "/registerJobSeeker",         
          controller: 'RegisterController', 
          views:{
          	"form":{
          		
          		 templateUrl: '../partials/form/form.html',
          		
          		} 
          	}       
        });
        
      $urlRouterProvider.deferIntercept();

    

      $locationProvider.html5Mode({
        enabled: false
      });
      $stateProviderRef = $stateProvider;
      $urlRouterProviderRef = $urlRouterProvider;
      
}])

.run(['$q', '$rootScope', '$http', '$urlRouter', function($q, $rootScope, $http, $urlRouter) {
  
    var $state = $rootScope.$state;
    
    $http
      .get("../lib/modules.json")
      .success(function(data) {
        angular.forEach(data, function(value, key) {
          
          var getExistingState = $state.get(value.name);

          if(getExistingState !== null){
            return; 
          }
          
          var state = {
            "url": value.url,
            "parent": value.parent,
            "abstract": value.abstract,
            "views": {}
          };

          angular.forEach(value.views, function(view) {
            state.views[view.name] = {
              templateUrl: view.templateUrl,
            	controller: view.controller,
            };
          });

          $stateProviderRef.state(value.name, state);
       
        });
        // Configures $urlRouter's listener *after* your custom listener
 
      });
  }
]);


















// var $urlRouterProviderRef = null;
// var $stateProviderRef = null;
// // Declare app level module which depends on filters, and services
// angular.module('acadb', [	
  // // 'ngUnderscore',
//  
  // 'ui.router',
  // 'ui.bootstrap',
  // 'flow',
  // 'acadb.controllers',
  // 'acadb.services',
  // 'acadb.filters',
  // 'acadb.directives',
  // 'xeditable',
  // 'ngResource',
// 
// 
// 
// 
//   
// ])
// // .config(['$routeProvider' ,'$locationProvider', function($routeProvider ,$locationProvider) {
// //   
  // // $routeProvider.when('/', {templateUrl: 'partials/userHome.html',controller: 'UserHomeController' });
  // // $routeProvider.when('/education', {templateUrl: 'partials/register/education.html',controller: 'RegisterController' });
  // // $routeProvider.when('/param', {templateUrl: 'partials/db/param.html',controller: 'TController' });
  // // $routeProvider.when('/type_user', {templateUrl: 'partials/db/type_user.html',controller: 'TController' });
  // // $routeProvider.when('/doc_param', {templateUrl: 'partials/db/doc_param.html',controller: 'TController' });
  // // $routeProvider.when('/doc_type', {templateUrl: 'partials/db/doc_type.html',controller: 'TController' });
  // // $routeProvider.when('/param_type', {templateUrl: 'partials/db/param_type.html',controller: 'TController' });
  // // $routeProvider.when('/param_value', {templateUrl: 'partials/db/param_value.html',controller: 'TController' });
  // // $routeProvider.when('/sys_param_values', {templateUrl: 'partials/db/sys_param_values.html',controller: 'TController' });
// // 
// // 
// // 
// // 
  // // // $routeProvider.when('/type_user_params', {templateUrl: 'partials/db/type_user_params.html',controller: 'TController' });
  // // $routeProvider.otherwise({redirectTo: '/'});
  // // //$locationProvider.html5Mode(true);
  // // //$locationProvider.hashPrefix('!');
// // 
// // }])
// // 
// // ;
// .config(function($locationProvider,$stateProvider, $urlRouterProvider) {
//     
     // $urlRouterProviderRef = $urlRouterProvider;
//     
    // $locationProvider.html5Mode(false);
    // $stateProviderRef = $stateProvider;
//     
//     
        // // route to show our basic form (/form)
        // // .state('form', {
            // // url: '/form',
            // // templateUrl: '../partials/form/form.html',
            // // controller: 'formController'
        // // })
// //         
        // // // nested states 
        // // // each of these sections will have their own view
        // // // url will be nested (/form/profile)
        // // .state('form.personalInfo', {
            // // url: '/personalInfo',
            // // templateUrl: '../partials/form/personalInfo.html'
        // // })
// //         
        // // // url will be /form/interests
        // // .state('form.education', {
            // // url: '/education',
            // // templateUrl: '../partials/form/education.html'
        // // })
// //         
        // // // url will be /form/payment
        // // .state('form.skills', {
            // // url: '/skills',
            // // templateUrl: '../partials/form/skills.html'
        // // });
// //         
    // // catch all route
    // // send users to the form page 
    // //$urlRouterProvider.otherwise('/form/personalInfo');
// 
// })
// .run(['$q', '$rootScope', '$state', '$http','$stateParams',function ($q, $rootScope, $state, $http, $stateParams) 
  // {
  	// $rootScope.$state = $state;
    // $rootScope.$stateParams = $stateParams;
//   
// }])  
// .config(function($locationProvider,$stateProvider, $urlRouterProvider) {
//     
     // $urlRouterProviderRef = $urlRouterProvider;
//     
    // $locationProvider.html5Mode(false);
    // $stateProviderRef = $stateProvider;
//     
//     
        // // route to show our basic form (/form)
        // // .state('form', {
            // // url: '/form',
            // // templateUrl: '../partials/form/form.html',
            // // controller: 'formController'
        // // })
// //         
        // // // nested states 
        // // // each of these sections will have their own view
        // // // url will be nested (/form/profile)
        // // .state('form.personalInfo', {
            // // url: '/personalInfo',
            // // templateUrl: '../partials/form/personalInfo.html'
        // // })
// //         
        // // // url will be /form/interests
        // // .state('form.education', {
            // // url: '/education',
            // // templateUrl: '../partials/form/education.html'
        // // })
// //         
        // // // url will be /form/payment
        // // .state('form.skills', {
            // // url: '/skills',
            // // templateUrl: '../partials/form/skills.html'
        // // });
// //         
    // // catch all route
    // // send users to the form page 
    // //$urlRouterProvider.otherwise('/form/personalInfo');
// 
// }).run(['$q', '$rootScope', '$http', '$urlRouter','$state', function($q, $rootScope, $http, $urlRouter,$state) {
// 	
    // var $state = $rootScope.$state;
//    
    // $http.get("/columns/user")
    // .success(function(data)
    // {
//     	
//     	
		// var data = [{
			  // "name": "form",
			  // "url": "/form",
			  // "controller": 'formController',
			  // "parent": "",
			  // "abstract": false,
			  // "templateUrl": '../partials/form/form.html',
			  // "views": [{
			    // "name": "personalInfo",
// 			
			    // "url": '/personalInfo',
			    // "templateUrl": '../partials/form/personalInfo.html'
			  // }, {
			    // "name": "education",
// 			  
			    // "url": '/education',
			    // "templateUrl": '../partials/form/education.html'
			  // }]
			// }];
// 	 
// 		
      // angular.forEach(data, function (value, key) 
      // { 
//     	
//       	
      	   // var getExistingState = $state.get(value.name);
// 
	          // if(getExistingState !== null){
	            // return; 
	          // }
          // var state = {
//           
          	// "templateUrl":value.templateUrl,
            // "url": value.url,
            // "parent" : value.parent,
			// "controller":'formController' ,
            // "abstract": value.abstract,
            // "views": {}
          // };
//           	
          // angular.forEach(value.views, function (view) 
          // {
//           	
            // state.views[view.name] = {
              // templateUrl : view.templateUrl,
//               
              // controller:'formController',
//               
//               
            // };
          // });
// 
          // $stateProviderRef.state(value.name, state);
          // console.log( state);
      // });
       // $rootScope.$state =  $state;
    // });
// 
// }]);

