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


AppDirectives.directive('wsStackedNav', [function () {
	return {
		restrict: 'A',
		scope: {
			stackedid : '@'
		},
		link: function (scope, iElement, iAttrs) {
			iElement.on('click', function(){
				var activeNode = angular.element(document.querySelector('.stacked-content > .active'));
				var activeNav = angular.element(document.querySelector('.nav-stacked > .active'));
				if(activeNode.attr('id') !== scope.stackedid){
					activeNav.removeClass('active');
					angular.element(this).addClass('active');
					activeNode.removeClass('in active');
					var node = angular.element(document.getElementById(scope.stackedid));
					node.addClass('in active');
				}
			});
		}
	};
}]);

AppDirectives.directive('wsNavUsuario', [function () {
	return {
		restrict: 'A',
		templateUrl: 'views/partials/ws_nav_usuario.html',
		link: function (scope, iElement, iAttrs) {
			var dropdown = angular.element('.dropdown > .dropdown-toggle');
			dropdown.on('click', function(){
				dropdown.parent().toggleClass('open');
			});

			var dropdownMenuItens = angular.element('.dropdown-menu .dropdown-menu-item');
			dropdownMenuItens.on('click', function(){
				dropdown.parent().removeClass('open');
				angular.element('#main-nav .active').removeClass('active');
			});
		}
	};
}]);

AppDirectives.directive('wsSidebarMenu', [function () {
	return {
		restrict: 'A',
		templateUrl: 'views/partials/ws_sidebar_menu.html',
		link: function (scope, iElement, iAttrs) {
			
		}
	};
}])
