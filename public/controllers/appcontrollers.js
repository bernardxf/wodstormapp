var AppControllers = angular.module('AppControllers', []);

AppControllers.controller('LoginController', ['$scope', 'loginService', function ($scope, loginService) {
	$scope.login = function(){
		loginService.login($scope.loginDataset);
	}
}]);

AppControllers.controller('DashboardController', ['$scope', 'DashboardResource', function ($scope, DashboardResource) {
	$scope.dashboardDataset = null;
	$scope.loadDashboard = function(){
		DashboardResource.get({}, function(response){
			$scope.dashboardDataset = response.data;
		});
	}
}]);

AppControllers.controller('Page404Controller', ['$scope', '$rootScope', function($scope, $rootScope){
	
}]);

AppControllers.controller('PlanoController', ['$scope','$routeParams', '$location', 'PlanoResource', function ($scope, $routeParams, $location, PlanoResource) {
	$scope.planoDataset = null;

	$scope.carregaPlano = function(){
		PlanoResource.get({},function(response){
			$scope.planoDataset = response.data;
		});
	};

	$scope.carregaCadPlano = function(){
		PlanoResource.get({id_plano : $routeParams.plano}, function(response){
			if(!angular.isArray(response.data)){
				$scope.planoDataset = response.data;
			}
		});
	};

	$scope.salvaPlano = function(){
		var plano = $scope.planoDataset;
		PlanoResource.save(plano, function(response){
			$location.path('/plano');
		});
	};

	$scope.cancelaEdicaoPlano = function(){
		$location.path('/plano');
	};

	$scope.deletaPlano = function(plano){
		PlanoResource.remove({id_plano: plano.id_plano}, function(response){
			$scope.carregaPlano();
		});
	};

}]);

AppControllers.controller('FormaPagamentoController', ['$scope', '$routeParams', '$location', 'FormaPagamentoResource', function($scope, $routeParams, $location, FormaPagamentoResource){
	$scope.formapagamentoDataset = null;
	
	$scope.carregaFormaPagamento = function(){
		FormaPagamentoResource.get({id_forma_pagamento : $routeParams.formapagamento},function(response){
			$scope.formapagamentoDataset = response.data;
		});
	};

	$scope.carregaCadFormaPagamento = function(){
		FormaPagamentoResource.get({id_forma_pagamento : $routeParams.formapagamento}, function(response){
			if(!angular.isArray(response.data)){
				$scope.formapagamentoDataset = response.data;
			}
		});
	};

	$scope.salvaFormaPagamento = function(){
		var formapagamento = $scope.formapagamentoDataset;
		FormaPagamentoResource.save(formapagamento, function(response){
			$location.path('/formapagamento');
		});
	};

	$scope.cancelaEdicaoFormaPagamento = function(){
		$location.path('/formapagamento');
	};

	$scope.deletaFormaPagamento = function(formapagamento){
		FormaPagamentoResource.remove({id_forma_pagamento: formapagamento.id_forma_pagamento}, function(response){
			$scope.carregaFormaPagamento();
		});
	};
}]);

AppControllers.controller('DescontoController', ['$scope','$routeParams', '$location', 'DescontoResource', function ($scope, $routeParams, $location, DescontoResource) {
	$scope.descontoDataset = null;

	$scope.carregaDesconto = function(){
		DescontoResource.get({}, function(response){
			$scope.descontoDataset = response.data;
		});
	};

	$scope.carregaCadDesconto = function(){
		DescontoResource.get({id_desconto: $routeParams.desconto}, function(response){
			if(!angular.isArray(response.data)){
				$scope.descontoDataset = response.data;	
			}
		});
	};

	$scope.salvaDesconto = function(){
		var desconto = $scope.descontoDataset;
		DescontoResource.save(desconto, function(response){
			$location.path('/desconto');
		});
	};

	$scope.cancelaEdicaoDesconto = function(){
		$location.path('/desconto');
	};

	$scope.deletaDesconto = function(desconto){
		DescontoResource.remove({id_desconto : desconto.id_desconto}, function(response){
			$scope.carregaDesconto();
		});
	};
}]);

AppControllers.controller('EstacionamentoController', ['$scope','$routeParams', '$location', 'EstacionamentoResource', function ($scope, $routeParams, $location, EstacionamentoResource) {
	$scope.estacionamentoDataset = null;
	$scope.cadEstacionamentoDataset = null;
	$scope.selectAluno = null;

	$scope.carregaEstacionamento = function(){
		EstacionamentoResource.get({}, function(response){
			$scope.estacionamentoDataset = response.data.estacionamento;
		});
	};

	$scope.carregaCadEstacionamento = function(){
		EstacionamentoResource.get({id_estacionamento: $routeParams.estacionamento}, function(response){
			if(!angular.isArray(response.data.estacionamento)){
				$scope.cadEstacionamentoDataset = response.data.estacionamento;	
			}
			$scope.selectAluno = response.data.selectAluno;	
		});
	};

	$scope.salvaEstacionamento = function(){
		var estacionamento = $scope.cadEstacionamentoDataset;
		EstacionamentoResource.save(estacionamento, function(response){
			$location.path('/estacionamento');
		});
	};

	$scope.cancelaEdicaoEstacionamento = function(){
		$location.path('/estacionamento');
	};

	$scope.deletaEstacionamento = function(estacionamento){
		EstacionamentoResource.remove({id_estacionamento : estacionamento.id_estacionamento}, function(response){
			$scope.carregaEstacionamento();
		});
	};
}]);

AppControllers.controller('AulaExpController', ['$scope', '$routeParams', '$location', 'AulaExpResource', function($scope, $routeParams, $location, AulaExpResource){
	$scope.aulaexpDataset = null;
	
	$scope.carregaAulaExp = function(){
		AulaExpResource.get({id_aulaexp : $routeParams.aulaexp},function(response){
			$scope.aulaexpDataset = response.data;
		});
	};

	$scope.carregaCadAulaExp = function(){
		AulaExpResource.get({id_aulaexp : $routeParams.aulaexp}, function(response){
			if(!angular.isArray(response.data)){
				$scope.aulaexpDataset = response.data;
			}
		});
	};

	$scope.salvaAulaExp = function(){
		var aulaexp = $scope.aulaexpDataset;
		AulaExpResource.save(aulaexp, function(response){
			$location.path('/aulaexp');
		});
	};

	$scope.cancelaEdicaoAulaExp = function(){
		$location.path('/aulaexp');
	};

	$scope.deletaAulaExp = function(aulaexp){
		AulaExpResource.remove({id_aulaexp: aulaexp.id_aulaexp}, function(response){
			$scope.carregaAulaExp();
		});
	};
}]);

AppControllers.controller('RelAlunoController', ['$scope', function($scope){
	$scope.relalunoDataset = null;
	$scope.selectAluno = null;
	
	$scope.carregaRelAluno = function(){
		$scope.selectAluno = response.data.selectAluno;	
	};
}]);