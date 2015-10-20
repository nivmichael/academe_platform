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


    .directive('resize', function ($window) {
        return function (scope, element) {
            var w = angular.element($window);
            scope.getWindowDimensions = function () {
                return {
                    'h': w.height(),
                    'w': w.width()
                };
            };
            scope.$watch(scope.getWindowDimensions, function (newValue, oldValue) {
                scope.windowHeight = newValue.h;
                scope.windowWidth = newValue.w;

                scope.style = function () {
                    return {
                        'height': (newValue.h - 100) + 'px',
                        'width': (newValue.w - 100) + 'px'
                    };
                };

            }, true);

            w.bind('resize', function () {
                scope.$apply();
            });
        }
        console.log('sizer');
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
