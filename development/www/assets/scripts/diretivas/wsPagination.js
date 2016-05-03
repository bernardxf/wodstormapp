angular.module('AppDirectives')
.controller('wsPaginationController', ['$scope', '$attrs', '$parse', function($scope, $attrs, $parse) {
	var self = this,
		ngModelCtrl = { $setViewValue: angular.noop };

	this.init = function(_ngModel){
	 	ngModelCtrl = _ngModel;
	 	ngModelCtrl.$setViewValue(1);
		ngModelCtrl.$render = function() {
			self.render();
		};

		ngModelCtrl.$render();

	 	if ($attrs.itemsPerPage) {
			$scope.$parent.$watch($parse($attrs.itemsPerPage), function(value) {
				self.itemsPerPage = parseInt(value, 10);
				$scope.totalPaginas = self.calcularNumPaginas();
			});
	    } else {
	      this.itemsPerPage = config.itemsPerPage;
	    }

		$scope.$watch('totalItems', function(newTotal, oldTotal) {
			if (angular.isDefined(newTotal) || newTotal !== oldTotal) {
				$scope.totalPaginas = self.calcularNumPaginas();
			}
			ngModelCtrl.$render();
		});
	}

	this.calcularNumPaginas = function(){
		var totalPaginas = this.itemsPerPage < 1 ? 1 : Math.ceil($scope.totalItems / this.itemsPerPage);
	    return Math.max(totalPaginas || 0, 1);
	}

	this.render = function() {
		$scope.pagina = parseInt(ngModelCtrl.$viewValue, 10) || 1;
	}

	$scope.paginaProxima = function() {
		if(ngModelCtrl.$viewValue < $scope.totalPaginas) ngModelCtrl.$setViewValue(parseInt(ngModelCtrl.$viewValue)+1);
		ngModelCtrl.$render();
	}

	$scope.paginaAnterior = function(){
		if(ngModelCtrl.$viewValue > 1) ngModelCtrl.$setViewValue(parseInt(ngModelCtrl.$viewValue)-1);
		ngModelCtrl.$render();
	}
}])
.directive('wsPagination', [
	function() {
		return {
			restrict: 'E',
			templateUrl: 'www/componentes/wsPagination.html',
			scope: {
				totalItems: '=',
				itemsPerPage: '='
			},
			controller: 'wsPaginationController',
			require: ['wsPagination', '?ngModel'],
			link: function(scope, element, attrs, ctrls) {
				var paginationCtrl = ctrls[0], ngModelCtrl = ctrls[1];

				if(!ngModelCtrl) return;
				paginationCtrl.init(ngModelCtrl);
			}
		}
	}
]);