angular.module('AppControllers')
.controller('DashboardController', ['$scope', 'DashboardResource', function ($scope, DashboardResource) {
	$scope.dashboardDataset = null;
	$scope.paginaAtual = {
		aniversario: 1,
		planoVencendo: 1
	};
	$scope.itensPorPagina = 5;

	$scope.loadDashboard = function(){
		DashboardResource.get({}, function(response){
			$scope.dashboardDataset = response.data;
		});
	};
}]);