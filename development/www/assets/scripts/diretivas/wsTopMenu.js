angular.module('AppDirectives')
.controller('wsTopMenuCtrl', ['$scope', 'loginService', function ($scope, loginService) {
	$scope.sair = function(){
		loginService.logout();
	}

	$scope.acessarMenuUsuario = function() {

	}
}])
.directive('wsTopMenu', [function(){
	return {
		restrict:'E',
		templateUrl: 'www/componentes/wsTopMenu.html',
		scope: {
			usuario: '='
		},
		controller: 'wsTopMenuCtrl',
		require: ['?ngModel'],
		link: function(scope, element, attrs, ctrls){

		}
	}
}]);