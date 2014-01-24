var AppControllers = angular.module('AppControllers', []);

AppControllers.controller('LoginController', ['$scope', 'loginService', function ($scope, loginService) {
	var loginStorage = JSON.parse(localStorage.getItem('wodStormLogin'));
	if(loginStorage){
		$scope.loginDataset = {usuario:loginStorage.usuario, organizacao:loginStorage.organizacao};
	}

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
		if(confirm('Realmente deseja apagar?')){
			PlanoResource.remove({id_plano: plano.id_plano}, function(response){
				$scope.carregaPlano();
			});			
		}
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
		if(confirm('Realmente deseja apagar?')){
			FormaPagamentoResource.remove({id_forma_pagamento: formapagamento.id_forma_pagamento}, function(response){
				$scope.carregaFormaPagamento();
			});
		}
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
		if(confirm('Realmente deseja apagar?')){
			DescontoResource.remove({id_desconto : desconto.id_desconto}, function(response){
				$scope.carregaDesconto();
			});
		}
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
		if(confirm('Realmente deseja apagar?')){
			EstacionamentoResource.remove({id_estacionamento : estacionamento.id_estacionamento}, function(response){
				$scope.carregaEstacionamento();
			});
		}
	};
}]);

AppControllers.controller('AulaExpController', ['$scope', '$routeParams', '$location', 'AulaExpResource', function($scope, $routeParams, $location, AulaExpResource){
	$scope.aulaexpDataset = null;
	$scope.aulaexpFilter = null;

	$scope.$watch('aulaexpFilter', function(newValue){
		if(newValue){
			localStorage.setItem('wsAulaExpFilter', JSON.stringify(newValue));	
		}
	}, true);

	$scope.carregaAulaExp = function(){
		var aulaexpFilter = localStorage.getItem('wsAulaExpFilter') ? JSON.parse(localStorage.getItem('wsAulaExpFilter')) : {};
		$scope.aulaexpFilter = aulaexpFilter;

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
		if(confirm('Realmente deseja apagar?')){
			AulaExpResource.remove({id_aulaexp: aulaexp.id_aulaexp}, function(response){
				$scope.carregaAulaExp();
			});
		}
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


AppControllers.controller('AlunoController', ['$scope', 'AlunoResource', 'ConsultaCepResource', '$location', '$routeParams', function ($scope, AlunoResource, ConsultaCepResource,$location, $routeParams) {
	$scope.alunoDataset = null;
	$scope.cadAlunoDataset = null;
	$scope.alunoFilter = null;

	$scope.$watch('alunoFilter', function(newValue){
		if(newValue){
			localStorage.setItem('wsAlunoFilter', JSON.stringify(newValue));	
		}
	}, true);

	$scope.carregaAluno = function(){
		var alunoFilter = localStorage.getItem('wsAlunoFilter') ? JSON.parse(localStorage.getItem('wsAlunoFilter')) : {};
		$scope.alunoFilter = alunoFilter;

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
			$location.path('/cad_aluno/'+response.data.id_aluno);
		});
	};

	$scope.cancelaEdicaoAluno = function(){
		$location.path('/aluno');
	};

	$scope.deletaAluno = function(aluno){
		if(confirm('Realmente deseja apagar?')){
			AlunoResource.remove({id_aluno : aluno.id_aluno}, function(){
				$scope.carregaAluno();
			});
		}
	};

	$scope.consultaCep = function(){
		var cep = $scope.cadAlunoDataset.cep.replace('-','');
		ConsultaCepResource.get({cep:cep}, function(response){
			$scope.cadAlunoDataset['bairro'] = response.bairro;
			$scope.cadAlunoDataset['uf'] = response.uf;
			$scope.cadAlunoDataset['cidade'] = response.localidade;
			$scope.cadAlunoDataset['logradouro'] = response.logradouro;
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
		var aluno = $routeParams.aluno;
		ContratoResource.get({id_aluno : $routeParams.aluno, id_contrato : $routeParams.contrato}, function(response){
			$scope.selectPlano = response.data.selectPlano;
			$scope.selectDesconto = response.data.selectDesconto;
			$scope.selectFormaPagamento = response.data.selectFormaPagamento;
			$timeout(function(){
				if(!angular.isArray(response.data.contrato)){
					$scope.cadContratoDataset = response.data.contrato;
				} else {
					$scope.cadContratoDataset = {'id_aluno' : aluno};	
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
		if(confirm('Realmente deseja apagar?')){
			ContratoResource.remove({id_aluno : contrato.id_aluno, id_contrato : contrato.id_contrato}, function(){
				$scope.carregaContrato();
			});
		}
	};

}]);

AppControllers.controller('ServicoController', ['$scope','$routeParams', '$location', 'ServicoResource', '$timeout', function ($scope, $routeParams, $location, ServicoResource, $timeout) {
	$scope.servicoDataset = null;
	$scope.selectAluno = null;

	$scope.carregaServico = function(){
		ServicoResource.get({}, function(response){
			$scope.servicoDataset = response.data.servico;
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
		if(confirm('Realmente deseja apagar?')){
			ServicoResource.remove({id_servico : servico.id_servico}, function(response){
				$scope.carregaServico();
			});
		}
	};
}]);

AppControllers.controller('PresencaController', ['$scope','$routeParams', '$location', 'PresencaResource', 'AlunoResource', function ($scope, $routeParams, $location, PresencaResource, AlunoResource) {
	var today = new Date();
	var year = today.getFullYear();
	var month = today.getMonth()<9?''+today.getMonth()+1:today.getMonth()+1;
	var day = (today.getDate()<10?'0':'') + today.getDate();
	$scope.pesquisaAulaDataset = {data:year+'-'+month+'-'+day};
	$scope.aulaDataset = null;
	$scope.cadPesquisaAluno = null;
	$scope.cadAlunoDataset = null;
	$scope.cadPresencaDataset = {data:year+'-'+month+'-'+day, presentes : new Array()};

	$scope.pesquisaAulas = function(){
		var pesquisaAulaDataset = $scope.pesquisaAulaDataset;
		PresencaResource.get(pesquisaAulaDataset, function(response){
			$scope.aulaDataset = response.data;
		});
	};

	$scope.carregaCadPresenca = function(){
		PresencaResource.get({id_aula: $routeParams.aula}, function(response){	
			if(!angular.isArray(response.data)){
				$scope.cadPresencaDataset = response.data.aula;	
				$scope.cadPresencaDataset.presentes = response.data.presenca;
			}
		});
	};

	$scope.presquisaAluno = function(){
		AlunoResource.get($scope.cadPesquisaAluno, function(response){
			$scope.cadAlunoDataset = response.data;
		});
	};

	$scope.adicionaAlunoPresente = function(aluno){
		var jaPresente = $scope.cadPresencaDataset.presentes.filter(function(item){
			if(item.id_aluno === aluno.id_aluno){
				return true
			}
			return false;
		});

		if(jaPresente.length === 0){
			aluno.senha = $scope.cadPresencaDataset.presentes.length+1;
			$scope.cadPresencaDataset.presentes.push(aluno);
		}
	};

	$scope.removeAlunoPresente = function(aluno){
		var index = $scope.cadPresencaDataset.presentes.indexOf(aluno);
		$scope.cadPresencaDataset.presentes.splice(index,1);

		$scope.cadPresencaDataset.presentes.forEach(function(item, key){
			item.senha = key+1;
		});
	};

	$scope.salvaPresenca = function(){
		var presenca = $scope.cadPresencaDataset;
		PresencaResource.save(presenca, function(response){
			$location.path('/presenca');
		});
	};

	$scope.cancelaEdicaoPresenca = function(){
		$location.path('/presenca');
	};

	$scope.deletaPresenca = function(presenca){
		if(confirm('Realmente deseja apagar?')){
			PresencaResource.remove({id_aula : presenca.id_aula}, function(response){
				$scope.pesquisaAulas();
			});
		}
	};
}]);

AppControllers.controller('RelAulaController', ['$scope', 'RelAulaResource', function ($scope, RelAulaResource) {
	$scope.relaulaDataset = null;
	$scope.relAulaResponseDataset = null;
	$scope.chart = null;
	
	$scope.pesquisaRelAula = function(){
		$('#bar-chart svg, .morris-hover').remove();
		var pesquisa = $scope.relaulaDataset;
		RelAulaResource.pesquisa(pesquisa,function(response){
			$scope.relAulaResponseDataset = response.data;
				$scope.loadChart();
		});	
	};

	$scope.loadChart = function(){
		var dataValues = $scope.processData("num_presentes");
		var dataValuesExc = $scope.processData("excedente");
		var labelValues = $scope.processLabel("data");
		var lineChartData = {
			element: 'bar-chart',
			data: $scope.relAulaResponseDataset,
			xkey: 'data',
			ykeys: ['num_presentes', 'excedente'],
			labels: ['Presentes', 'Excedentes'],
			barColors: ['#444','#e5412d'],
			stacked: true
		}
		$scope.chart = new Morris.Bar(lineChartData);
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

AppControllers.controller('RelServicoController', ['$scope', 'RelServicoResource', function ($scope, RelServicoResource) {
	$scope.relservicoDataset = null;
	$scope.relServicoResponseDataset = null;
	$scope.chart = null;
	
	$scope.pesquisaRelServico = function(){
		$('#bar-chart svg, .morris-hover').remove();
		var pesquisa = $scope.relservicoDataset;
		RelServicoResource.pesquisa(pesquisa,function(response){
			$scope.relServicoResponseDataset = response.data;
				$scope.loadChart();
		});	
	};

	$scope.loadChart = function(){
		var dataValues = $scope.processData("valor");
		var labelValues = $scope.processLabel("data");
		var lineChartData = {
			element: 'bar-chart',
			data: $scope.relServicoResponseDataset,
			xkey: 'data',
			ykeys: ['valor'],
			labels: ['Valor'],
			barColors: ['#444','#e5412d'],
			stacked: true
		}
		$scope.chart = new Morris.Bar(lineChartData);
	};
	$scope.processData = function(key){
		var values = new Array();
		angular.forEach($scope.relServicoResponseDataset, function(item){
			values.push(item[key]);
		});
		return values;
	};
	$scope.processLabel = function(key){
		var values = new Array();
		angular.forEach($scope.relServicoResponseDataset, function(item){
			values.push(item[key]);
		});
		return values;	
	}
}]);