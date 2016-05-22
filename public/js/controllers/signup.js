'use strict';
angular.module('acadb')
  .controller('SignupCtrl', function($scope, $rootScope, $state, $auth, $stateParams, $http, Form, $element) {

      $scope.docParam  = $stateParams.doc;
      $scope.next_keys = Form.next_form();
      $scope.groups = {};

      $scope.educationStatuses = [
        {value: 'student',  text: 'Student'},
        {value: 'graduate', text: 'Graduate'},
        {value: 'intern',   text: 'Intern'},
      ];

      var type              = $stateParams.type;
      var sub_type          = $stateParams.sub_type;
      $scope.type           = $stateParams.type;
      $scope.jobseeker_type = $stateParams.sub_type;
      $scope.steps          = $rootScope.steps;

      $scope.getForms = function() {

          Form.getForms().then(function(form){
              $scope.form = angular.copy(form);
              $scope.user = form;
              $scope.user['personal_information']['education_status'] = $stateParams.sub_type;
              $scope.user['personal_information']['subtype']          = $stateParams.type;
              //next line should be conditional
              $scope.user['personal_information']['status']           = 'active';
              $scope.loadGroups();

          })
      }

      $scope.loadGroups = function() {
          Form.getAllOptionValues().then(function(options){
          $scope.groups = options.data;
        });
      };

      $scope.validate = function(param) {

          Form.validate($scope.user['personal_information'], param).then(function(response){
            console.log(response);
              $scope.errors = response.data;
          })
      }


      $scope.signup = function() {
        $scope.sent=true;
        $auth.signup($scope.user)
            .success(function(response) {
              $auth.setToken(response.token);
              $state.go('register.' + Form.nextDoc());
            })
            .error(function(response) {
              $scope.errors = response;
            });
      };

      $scope.add = function(docParam,$index) {
           $scope.inserted = angular.copy($scope.form[docParam][0]);
           $scope.user[docParam].push($scope.inserted);
      };

      $scope.move = function(array, fromIndex, toIndex){
          console.log(array);
            array.splice(toIndex, 0, array.splice(fromIndex, 1)[0] )
      };

      $scope.remove = function(array,index,user_id) {
        Form.remove(array,index,user_id);
        array.splice(index,1);
      };



      $scope.getForms();

      //console.log($scope.main);



  });