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

AppControllers.controller('EstacionamentoController', ['$scope','$routeParams', '$location', 'EstacionamentoResource','$timeout', function ($scope, $routeParams, $location, EstacionamentoResource, $timeout) {
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
			$scope.selectAluno = response.data.selectAluno;	
			$timeout(function(){
				if(!angular.isArray(response.data.estacionamento)){
					$scope.cadEstacionamentoDataset = response.data.estacionamento;	
				}
			});
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

AppControllers.controller('RelAlunoController', ['$scope', 'RelAlunoResource', function ($scope, RelAlunoResource) {
	$scope.relalunoDataset = null;
	$scope.relAlunoResponseDataset = null;
	$scope.selectAluno = null;
	
	$scope.carregaRelAluno = function(){
		RelAlunoResource.get({},function(response){
			$scope.selectAluno = response.data;	
		});
	};

	$scope.pesquisaRelAluno = function(){
		var pesquisa = $scope.relalunoDataset;
		RelAlunoResource.pesquisa(pesquisa,function(response){
			$scope.relAlunoResponseDataset = response.data;
		});	
	};
}]);


AppControllers.controller('AlunoController', ['$scope', 'AlunoResource', '$location', '$routeParams', function ($scope, AlunoResource, $location, $routeParams) {
	$scope.alunoDataset = null;
	$scope.cadAlunoDataset = null;

	$scope.carregaAluno = function(){
		AlunoResource.get({}, function(response){
			$scope.alunoDataset = response.data;
		});
	};

	$scope.carregaCadAluno = function(){
		AlunoResource.get({id_aluno : $routeParams.aluno}, function(response){
			if(!angular.isArray(response.data)){
				$scope.cadAlunoDataset = response.data;
			}
		});
	};

	$scope.salvaAluno = function(){
		var aluno = $scope.cadAlunoDataset;
		AlunoResource.save(aluno, function(response){
			$location.path('/aluno');
		});
	};

	$scope.cancelaEdicaoAluno = function(){
		$location.path('/aluno');
	};

	$scope.deletaAluno = function(aluno){
		AlunoResource.remove({id_aluno : aluno.id_aluno}, function(){
			$scope.carregaAluno();
		});
	};

}]);

AppControllers.controller('ContratoController', ['$scope', 'ContratoResource', '$location', '$routeParams', '$timeout', function ($scope, ContratoResource, $location, $routeParams, $timeout) {
	$scope.aluno = $routeParams.aluno;
	$scope.contratoDataset = null;
	$scope.cadContratoDataset = null;

	$scope.carregaContrato = function(){
		ContratoResource.get({id_aluno : $routeParams.aluno}, function(response){
			$scope.contratoDataset = response.data.contrato;
		});
	};

	$scope.carregaCadContrato = function(){
		ContratoResource.get({id_aluno : $routeParams.aluno, id_contrato : $routeParams.contrato}, function(response){
			$scope.selectPlano = response.data.selectPlano;
			$scope.selectDesconto = response.data.selectDesconto;
			$scope.selectFormaPagamento = response.data.selectFormaPagamento;
			$timeout(function(){
				if(!angular.isArray(response.data.contrato)){
					$scope.cadContratoDataset = response.data.contrato;
				}	
			});
		});
	};

	$scope.salvaContrato = function(){
		var contrato = $scope.cadContratoDataset;
		contrato.id_aluno = $routeParams.aluno;
		ContratoResource.save(contrato, function(response){
			$location.path('/contrato/'+contrato.id_aluno);
		});
	};

	$scope.cancelaEdicaoContrato = function(){
		var contrato = $scope.cadContratoDataset;
		$location.path('/contrato/'+contrato.id_aluno);
	};

	$scope.deletaContrato = function(contrato){
		ContratoResource.remove({id_aluno : contrato.id_aluno, id_contrato : contrato.id_contrato}, function(){
			$scope.carregaContrato();
		});
	};

}]);

AppControllers.controller('ServicoController', ['$scope','$routeParams', '$location', 'ServicoResource', '$timeout', function ($scope, $routeParams, $location, ServicoResource, $timeout) {
	$scope.servicoDataset = null;
	$scope.selectAluno = null;

	$scope.carregaServico = function(){
		ServicoResource.get({}, function(response){
			$scope.servicoDataset = response.data;
		});
	};

	$scope.carregaCadServico = function(){
		ServicoResource.get({id_servico: $routeParams.servico}, function(response){
			$scope.selectAluno = response.data.selectAluno;	
			$timeout(function(){
				if(!angular.isArray(response.data.servico)){
					$scope.servicoDataset = response.data.servico;	
				}
			});
		});
	};

	$scope.salvaServico = function(){
		var servico = $scope.servicoDataset;
		ServicoResource.save(servico, function(response){
			$location.path('/servico');
		});
	};

	$scope.cancelaEdicaoServico = function(){
		$location.path('/servico');
	};

	$scope.deletaServico = function(servico){
		ServicoResource.remove({id_servico : servico.id_servico}, function(response){
			$scope.carregaServico();
		});
	};
}]);

AppControllers.controller('RelAulaController', ['$scope', 'RelAulaResource', function ($scope, RelAulaResource) {
	$scope.relaulaDataset = null;
	$scope.relAulaResponseDataset = null;
	
	$scope.pesquisaRelAula = function(){
		var pesquisa = $scope.relaulaDataset;
		RelAulaResource.pesquisa(pesquisa,function(response){
			$scope.relAulaResponseDataset = response.data;
			// $scope.loadChart();
		});	
	};

	$scope.loadChart = function(){
		var dataValues = $scope.processData("num_presentes");
		var dataValuesExc = $scope.processData("excedente");
		var labelValues = $scope.processLabel("data");
		var lineChartData = {
			element: 'bar-chart',
			data: [
				{ y: '2006', p: 100, e: 90 },
				{ y: '2007', p: 75,  e: 65 },
				{ y: '2008', p: 50,  e: 40 },
				{ y: '2009', p: 75,  e: 65 },
				{ y: '2010', p: 50,  e: 40 },
				{ y: '2011', p: 75,  e: 65 }
			],
			xkey: 'y',
			ykeys: ['p', 'e'],
			labels: ['Presentes', 'Excedentes'],
			barColors: ['#444','#e5412d']
		}
		var myLine = new Morris.Bar(lineChartData);
	};
	$scope.processData = function(key){
		var values = new Array();
		angular.forEach($scope.relAulaResponseDataset, function(item){
			values.push(parseInt(item[key]));
		});
		return values;
	};
	$scope.processLabel = function(key){
		var values = new Array();
		angular.forEach($scope.relAulaResponseDataset, function(item){
			values.push(item[key]);
		});
		return values;	
	}

}]);