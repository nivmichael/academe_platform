angular.module('acadb.directives', []).
  value('version', '0.1')
  
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
.directive('ngDynamicController', ['$compile', '$parse',function($compile, $parse) {
  return {
      scope: {
          name: '=ngDynamicController'
      },
      restrict: 'A',
      terminal: true,
      priority: 100000,
      link: function(scope, elem, attrs) {
          elem.attr('ng-controller', scope.name);
          elem.removeAttr('ng-dynamic-controller');

          $compile(elem)(scope);
      }
  };
}]);