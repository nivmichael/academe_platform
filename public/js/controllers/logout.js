'use strict';
angular.module('acadb')
  .controller('LogoutCtrl', function($scope, $location, $auth) {
    if (!$auth.isAuthenticated()) { return; }

      $scope.logout = function(){
        $auth.logout()
            .then(function() {
              // toastr.info('You have been logged out');
              $location.path('/');
            });
      }


  });