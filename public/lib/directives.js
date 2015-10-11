angular.module('acadb.directives', []).
  value('version', '0.1')
  




.directive('post', function() {
  return {
    restrict: 'EA',
    scope: {
      param: '=',
      docparam:'=',
      parameter:'=',
    },
    templateUrl: '../partials/param.html',
    // link: function (scope, element, attr) {
		// scope.param = attr.param ;
		// scope.docparam= attr.docparam;
//     	
//    
    // }
  };
})







.directive('field', function($compile) {
    var linker= function(scope, element){
        
    var template = '<input type="text" name="{{fname}}" ng-model="model">'
    .replace('{{fname}}', scope.fname);
        element.html(template);
        $compile(element.contents())(scope);
    };
  return {
    restrict: 'E',
    scope: {
      fname: '=',
      model: '='
    },
    
    replace: true,
      link: linker
  };
})

.directive('edit_select_field', function($compile) {
    var linker= function(scope, element){
        
    var template = '<input type="text" name="{{fname}}" ng-model="model">'
    .replace('{{fname}}', scope.fname);
        element.html(template);
        $compile(element.contents())(scope);
    };
  return {
    restrict: 'E',
    scope: {
      fname: '=',
      model: '='
    },
    
    replace: true,
      link: linker
  };
})
.directive('edit_checkbox_field', function($compile) {
    var linker= function(scope, element){
        
    var template = '<input type="text" name="{{fname}}" ng-model="model">'
    .replace('{{fname}}', scope.fname);
        element.html(template);
        $compile(element.contents())(scope);
    };
  return {
    restrict: 'E',
    scope: {
      fname: '=',
      model: '='
    },
    
    replace: true,
      link: linker
  };
})
;
