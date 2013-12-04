var AppDirectives = angular.module('AppDirectives', []);

AppDirectives.directive('wsMenu', [function () {
	return {
		restrict: 'A',
		link: function (scope, iElement, iAttrs) {
			var elements = iElement.children();
			angular.forEach(elements, function(item, key){
				angular.element(item).on('click', function(){
					var activeNode = angular.element(document.querySelector('.active'));
					activeNode.removeClass('active');
					if(activeNode.hasClass('dropdown')){
						activeNode.find('ul').css('display', 'none');
					}

					var newActiveNode = angular.element(this);
					newActiveNode.addClass('active');
					if(newActiveNode.hasClass('dropdown')){
						newActiveNode.find('ul').css('display', 'block');
					}
				});
			});
		}
	};
}]);

AppDirectives.directive('wsData', ["$filter", function ($filter) {
	return {
		restrict: 'A',
		require: 'ngModel',
		link: function (scope, iElement, iAttrs, ctrl) {
			ctrl.$parsers.unshift(function(viewValue){
				if(viewValue){
					var values = viewValue.split('/');
					return values[2]+"-"+values[1]+"-"+values[0];
				}
				return '';
			});

			ctrl.$formatters.unshift(function(modelValue){
				if(modelValue == '0000-00-00'){
					return '';
				} else {
					$filter('date')(modelValue, 'dd/MM/yyyy');
				}
			});
		}
	};
}]);
