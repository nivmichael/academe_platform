'use strict';
angular.module('acadb')
  .controller('SignupCtrl', function($scope, $rootScope, $state, $location, $auth, $stateParams, SelectOptions, $http) {
      'use strict';
      $scope.educationStatuses = [
        {value: 'student', text: 'Student'},
        {value: 'graduate', text: 'Graduate'},
        {value: 'intern', text: 'Intern'},
      ];

      /*parameterSetup*/
      var type = $stateParams.type;
      var sub_type = $stateParams.sub_type;
      $scope.type = $stateParams.type;
      $scope.jobseeker_type = $stateParams.sub_type;
      $scope.steps = $rootScope.steps;
      /**/
      $scope.nextDoc = function(doc){
        if($scope.next_keys[doc]){
          $scope.doc = $scope.next_keys[doc];
          return $scope.doc ;
        }else{
          return false ;
        }
      };

      $scope.next_keys =Array();
      var prev_key = false;
      for (var key in $scope.steps) {
        if($scope.steps[key]['belongsTo'] ==  $scope.type){
          if (!prev_key) {
            prev_key = $scope.steps[key].value;
          } else {
            $scope.next_keys[prev_key] = $scope.steps[key].value;
            prev_key = $scope.steps[key].value;
            $scope.next = $scope.steps[key].value;
            $scope.nextDoc();
          }
        }
      }

      $scope.getForms = function() {
        $http.get('api/forms/register_' + $stateParams.type).
            success(function (data, status, headers, config) {
              $scope.user = data;
              $scope.user['personal_information']['education_status'] = $stateParams.sub_type;
              $scope.user['personal_information']['subtype'] = $stateParams.type;
              $scope.loadGroups();
            });
      }

      $scope.groups={};
      $scope.loadGroups = function() {
        SelectOptions.getAllOptionValues().then(function(options){
          $scope.groups = options.data;
        });
      };

      $scope.signup = function() {
        $auth.signup($scope.user)
            .success(function(response) {
              $auth.setToken(response.token);
              $state.go(prefix+'.'+$scope.nextDoc($scope.docParam));
              //$location.path('/');
              //toastr.info('You have successfully created a new account and have been signed-in');
            })
            .error(function(response) {
              $scope.errors = response;
              console.log(response)
              //toastr.error(response.data.message);
            });
      };
      $scope.getForms();

  });