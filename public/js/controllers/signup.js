'use strict';
angular.module('acadb')
  .controller('SignupCtrl', function($scope, $rootScope, $state, $location, $auth, $stateParams, $http, Form) {
      'use strict';
      console.log('signupCtrl');
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
              $scope.user = form;
              $scope.user['personal_information']['education_status'] = $stateParams.sub_type;
              $scope.user['personal_information']['subtype']          = $stateParams.type;
              $scope.loadGroups();
          })
      }

      $scope.groups={};
      $scope.loadGroups = function() {
          Form.getAllOptionValues().then(function(options){
          $scope.groups = options.data;
        });
      };

      $scope.signup = function() {
        $auth.signup($scope.user)
            .success(function(response) {
              $auth.setToken(response.token);
              $state.go('register.' + $scope.nextDoc($scope.docParam));
            })
            .error(function(response) {
              $scope.errors = response;

            });
      };

      $scope.next_keys = Form.next_form();
      $scope.nextDoc   = Form.nextDoc();
      //$scope.nextDoc = function(doc){
      //      console.log(doc);
      //    return Form.nextDoc(doc);
      //};
        //$scope.nextDoc = function(doc){
        //    if($scope.next_keys[doc]){
        //        $scope.doc = $scope.next_keys[doc];
        //        return $scope.doc ;
        //    }else{
        //        return false ;
        //    }
        //};


        //$scope.next_keys =Array();
        //var prev_key = false;
        //for (var key in $scope.steps) {
        //    if($scope.steps[key]['belongsTo'] ==  $scope.type){
        //        if (!prev_key) {
        //            prev_key = $scope.steps[key].value;
        //        } else {
        //            $scope.next_keys[prev_key] = $scope.steps[key].value;
        //            prev_key = $scope.steps[key].value;
        //            $scope.next = $scope.steps[key].value;
        //            $scope.nextDoc();
        //        }
        //    }
        //}

      $scope.getForms();




      /*
      *
      * make a service
      *
      * add record
      * move
      * remove
      * loadoptions already working
      * show options
      *
      *
      * */



      $scope.addRecordJobSeeker =function(docParam,$index) {
			$http.get('api/forms/register_jobseeker')
				.success(function(data, status, headers, config) {

                    $scope.inserted = data[docParam][0];
                    $scope.user[docParam].push($scope.inserted);

                })
				.error(function(){
					alert('ERROR!!');
				});
	  };



  });