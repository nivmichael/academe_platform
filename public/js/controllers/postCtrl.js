'use strict';
angular.module('acadb')
  .controller('PostCtrl', function($scope, $auth, Account, $http, $rootScope, $filter, SelectOptions) {



        $scope.getJobPostFields = function(){
            $http.get('api/columns/jobPost').
                success(function(data, status, headers, config) {
                    $scope.jobPost = data;
                    $scope.loadGroups();
                }).error(function(data, status, headers, config){
                });
        };

        $scope.savePost = function(post) {
            console.log(post);
            $http.post('api/savePost', {
                post:post,

            }).success(function(errors){
                $scope.allJobs.push(post);
                return post;

            }).error(function(err) {



            });
        };

        $scope.groups={};
        $scope.loadGroups = function() {
            SelectOptions.getAllOptionValues().then(function(options){
                $scope.groups = options.data;
            });
        };





        $scope.getJobPostFields();
  });
