
var $stateProviderRef = null;
var $urlRouterProviderRef = null;

var acadb = angular.module('acadb', [
    'ngRoute',
    'ui.router',
    'ngAnimate',
    'ui.bootstrap',
    'ngAside',
    'flow',
    'acadb.controllers',
    'acadb.services',
    'acadb.filters',
    'acadb.directives',
    'xeditable',
    'ngResource',
    'checklist-model',
    'ui.bootstrap.modal',
    'angularMoment',
    'ui.bootstrap.showErrors'
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
      $urlRouterProvider.otherwise("/personal_information");
       
      $stateProvider
	
    
        .state('register', {
         url: "/",
         templateUrl: '../../partials/register/register.html',
         controller: 'RegisterController',
        })
        .state('register.personal_information', {
          url: "^/personal_information",
       	  controller: 'formController',
          templateUrl: '../../partials/register/jobseeker/personalInfo.html',
              reloadOnSearch: false
        });
        $locationProvider.html5Mode({
            enabled: false
        });
        $stateProviderRef = $stateProvider;
        $urlRouterProviderRef = $urlRouterProvider;
      
}])

.run(['$q', '$rootScope', '$http', '$urlRouter', function($q, $rootScope, $http, $urlRouter) {
    var stateList = [];
    var $state = $rootScope.$state;
    /*
    * this func here gets the docParam steps for registration.
    *
    * stateList is for the ui router
    * steps is for the navbar in the view
    *
    * */
    $http
      .get("/jobseekerSteps")
      .success(function(data) {

          angular.forEach(data, function(value, key) {

            var step = {
              "name":"register."+value.name,
              "url": '^/'+value.name,
              "templateUrl":'../../partials/register/personalInfo.html',
              "controller":'formController',
              "value":value.name

            }
            stateList.push(step);

          });
          $rootScope.steps = stateList;
          $rootScope.steps.unshift({name:'register.personal_information',value:'personal_information'});
          angular.forEach(stateList, function(value, key) {
              var getExistingState = $state.get(value.name);
              if(getExistingState !== null){
                return;
              }

              var state = {
                "name":"register."+value.name,
                "url": '^/'+value.value,
                "templateUrl":'../../partials/register/jobseeker/personalInfo.html'  ,
                "controller":'formController',
                  reloadOnSearch: false

              };
              $stateProviderRef.state(value.name, state);
          });
      });
  }
]);










