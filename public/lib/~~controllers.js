angular.module('acadb.controllers', [])



    /*
    *
    * MainCtrl is called on `app.blade.php`
    * it is responsible for getting initial css and logos
    *
    * */

    .controller('MainCtrl', ['$scope', '$http', function ($scope, $http) {

        $scope.getLayout = function(){

            $http.get('/layout').
                then(function(response) {

                    $scope.layout = response.data;
                    $scope.main_color = $scope.layout.main_color;
                    $scope.logo = $scope.layout.logo;

                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
        }

        $scope.getLayout();
    }]);



