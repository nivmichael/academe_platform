'use strict';
angular.module('acadb')
  .controller('PostCtrl', function($scope, $auth, Account, $http, $rootScope, $filter, Form, $state, PostData) {

        $scope.getJobPostFields = function(){
           Form.getJobPostForm().then(function(form){
                $scope.form = angular.copy(form);
                $scope.jobPost = form;
                $scope.loadGroups();
            })
        };
        $scope.savePost = function(post) {
            PostData.save(post).$promise
                .then(function(res) {

                })
                .catch(function(err) {
                    $scope.errors = err.data;
                    console.log(err.data)
                    Account.broadcast(err.data);
                })
        };
        //$scope.savePost = function(post) {
        //    $http.post('api/savePost', {
        //        post:post,
        //    }).success(function(errors){
        //        Account.broadcast(errors);
        //        console.log(errors);
        //
        //    }).error(function(err) {
        //
        //    }).then(function(){
        //        $state.go('employer.company');
        //    });
        //};
        $scope.add = function(docParamName,index) {
            $scope.inserted = angular.copy($scope.form[docParamName][0]);
            $scope.jobPost[docParamName].push($scope.inserted);
        };
        $scope.move = function(array, fromIndex, toIndex){
            console.log(array);
            array.splice(toIndex, 0, array.splice(fromIndex, 1)[0] )
        };

        $scope.remove = function(array,index,user_id) {
            Form.remove(array,index,user_id);
            array.splice(index,1);
        };

        $scope.groups={};
        $scope.loadGroups = function() {
            Form.getAllOptionValues().then(function(options){
                $scope.groups = options.data;
                $scope.groups['job_title'] = [
                    {value: '', text: ''},
                    {value: 'non_managerial', text: 'Non Managerial'},
                    {value: 'manager',        text: 'Manager'},
                    {value: 'executive',      text: 'Executive'},
                ];
            });
        };

        $scope.getJobPostFields();
  });
