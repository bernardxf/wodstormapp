angular.module('AppControllers')
.controller('ConfiguracaoController', ['$scope', 'PlanoResource', 'FormaPagamentoResource', 'DescontoResource', 'RESTService', function ($scope, PlanoResource, FormaPagamentoResource, DescontoResource, RESTService){
	var restPlano = new RESTService(PlanoResource),
		restFormaPagamento = new RESTService(FormaPagamentoResource);
		restDesconto = new RESTService(DescontoResource);

	$scope.planoDataset = null;
	$scope.formaPagamentoDataset = null;
	$scope.descontoDataset = null;

	$scope.TAB_DESCONTO = 1;
	$scope.TAB_PAGAMENTOS = 2;
	$scope.TAB_PLANOS = 3;

	$scope.tabAtiva = $scope.TAB_DESCONTO;

	/**
	 * Metodo para alterar qual tab esta ativa.
	 */
	$scope.setTabAtiva = function(tab){
		$scope.tabAtiva = tab;		
	};

	/**
	 * Carregando todos os dados dos grids.
	 */
	$scope.carregarDados = function() {
		restPlano.get({}).then(function(response){
			$scope.planoDataset = response.data;
		});

		restFormaPagamento.get({}).then(function(response){
			$scope.formaPagamentoDataset = response.data;
		});

		restDesconto.get({}).then(function(response){
			$scope.descontoDataset = response.data;
		});
	}
}]);