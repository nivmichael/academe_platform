'use strict';
angular.module('acadb')
  .controller('CompanyCtrl', function($scope, $auth, Account, $http, $rootScope, $filter, Form, $stateParams) {

        $scope.reverse = true;
        $scope.orderByFilter = 'match';


        $scope.getProfile = function() {
            Account.getProfile()
                .then(function(response) {
                    $scope.user  = response.user;
                    $scope.allJobs = response.posts;
                    $scope.status  = $scope.user.personal_information.status;
                    Account.broadcast(response);
                })
                .catch(function(response) {
                    //toastr.error(response.data.message, response.status);
                });
        };

        $scope.getProfile();
  });
