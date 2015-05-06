var crossfitApp = angular.module('crossfitApp', ['ngRoute', 'ui.select2','AppControllers','AppDirectives', 'AppFilters', 'AppServices', 'ngResource']);

crossfitApp.config(['$routeProvider',function($routeProvider){
	$routeProvider.when('/', {
		templateUrl:'views/login.html',
		controller: 'LoginController'
	}).when('/dashboard', {
		templateUrl: 'views/dashboard.html',
		controller: 'DashboardController'
	}).when('/plano', {
		templateUrl: 'views/plano.html',
		controller: 'PlanoController'
	}).when('/cad_plano/:plano?', {
		templateUrl: 'views/cad_plano.html',
		controller: 'PlanoController'
	}).when('/formapagamento', {
		templateUrl: 'views/formapagamento.html',
		controller: 'FormaPagamentoController'
	}).when('/cad_formapagamento/:formapagamento?', {
		templateUrl: 'views/cad_formapagamento.html',
		controller: 'FormaPagamentoController'
	}).when('/desconto', {
		templateUrl: 'views/desconto.html',
		controller: 'DescontoController'
	}).when('/cad_desconto/:desconto?', {
		templateUrl: 'views/cad_desconto.html',
		controller: 'DescontoController'
	}).when('/estacionamento', {
		templateUrl: 'views/estacionamento.html',
		controller: 'EstacionamentoController'
	}).when('/cad_estacionamento/:estacionamento?', {
		templateUrl: 'views/cad_estacionamento.html',
		controller: 'EstacionamentoController'
	}).when('/aulaexp', {
		templateUrl: 'views/aulaexp.html',
		controller: 'AulaExpController'
	}).when('/cad_aulaexp/:aulaexp?', {
		templateUrl: 'views/cad_aulaexp.html',
		controller: 'AulaExpController'
	}).when('/aluno', {
		templateUrl: 'views/aluno.html',
		controller: 'AlunoController'
	}).when('/cad_aluno/:aluno?', {
		templateUrl: 'views/cad_aluno.html',
		controller: 'AlunoController'
	}).when('/contrato/:aluno', {
		templateUrl: 'views/contrato.html',
		controller: 'ContratoController'
	}).when('/cad_contrato/:aluno/:contrato?', {
		templateUrl: 'views/cad_contrato.html',
		controller: 'ContratoController'
	}).when('/relaluno', {
		templateUrl: 'views/relaluno.html',
		controller: 'RelAlunoController'
	}).when('/relalunosplano', {
		templateUrl: 'views/relalunosplano.html',
		controller: 'RelAlunosPlanoController'
	}).when('/relAniversariantes', {
		templateUrl: 'views/relatorio-template.html',
		controller: 'RelatorioController'
	}).when('/servico', {
		templateUrl: 'views/servico.html',
		controller: 'ServicoController'
	}).when('/relmetricacontrato', {
		templateUrl: 'views/relmetricacontrato.html',
		controller: 'RelMetricaContratoController'
	}).when('/relpresenca', {
		templateUrl: 'views/relpresenca.html',
		controller: 'RelPresencaController'
	}).when('/cad_servico/:servico?', {
		templateUrl: 'views/cad_servico.html',
		controller: 'ServicoController'
	}).when('/presenca', {
		templateUrl: 'views/presenca.html',
		controller: 'PresencaController'
	}).when('/cad_presenca/:aula?', {
		templateUrl: 'views/cad_presenca.html',
		controller: 'PresencaController'
	}).when('/relaula', {
		templateUrl: 'views/relaula.html',
		controller: 'RelAulaController'
	}).when('/relservico', {
		templateUrl: 'views/relservico.html',
		controller: 'RelServicoController'
	}).when('/perfil', {
		templateUrl: 'views/perfil.html',
		controller: 'PerfilController'
	}).when('/usuario', {
		templateUrl: 'views/usuario.html',
		controller: 'CadastroUsuarioController'
	}).when('/cad_usuario/:usuario?', {
		templateUrl: 'views/cad_usuario.html',
		controller: 'CadastroUsuarioController'
	}).when('/financeiro', {
		templateUrl: 'views/financeiro.html',
		controller: 'FinanceiroController'
	}).when('/financeiro/cad_movimento/:financeiro?', {
		templateUrl: 'views/cad_fin_movimento.html',
		controller: 'FinanceiroController'
	}).when('/leaderboard', {
		templateUrl: 'views/leaderboard.html',
		controller: 'LeaderboardController'
	}).when('/buscar_leaderboard', {
		templateUrl: 'views/buscar_leaderboard.html',
		controller: 'LeaderboardController'
	}).when('/consultaLeaderboard/:dataLeaderboard/:organizacao', {
		templateUrl: 'views/leaderboard_externo.html',
		controller: 'LeaderboardExternoController'
	}).when('/presenca_salao', {
		templateUrl: 'views/presenca_salao.html',
		controller: 'PresencaSalaoController'
	}).when('/configuracao', {
		templateUrl: 'views/configuracao.html',
		controller: 'ConfiguracaoController'
	}).when('/logout', {
		templateUrl: 'views/logout.html',
		controller: 'LogoutController'
	}).otherwise({ redirectTo: '/404', templateUrl: 'views/page404.html', controller: 'Page404Controller' });

}]);

crossfitApp.run(function($rootScope, $location, LoginResource, $templateCache, $interval){
	$rootScope.logged = false;
	$rootScope.loggedUserData = null;
	$rootScope.carregando = false;
	$rootScope.timerLogado = null;
	$rootScope.controleTimer = null;
	$rootScope.$on("$routeChangeStart", function(event, next, current) {
		if (($rootScope.logged == false || $rootScope.logged == null) && next.controller != 'LeaderboardExternoController') {
			LoginResource.get({}, function(response){
				if(response.data.usuario){
					$rootScope.logged = true;
					$rootScope.loggedUserData = response.data.usuario;
					$rootScope.sisConfig = response.data.configuracao;
					if(next.originalPath == '/') {
						if(parseInt($rootScope.loggedUserData.grupoUsuario) < 3) $location.path('/dashboard');			
						else $location.path('/leaderboard');
					}
				} else {
					$location.path('/');		
				}
			});
		} else {
			// Removendo qualquer timer($interval) que esteja sendo executado dentro da aplicacao.
			if($rootScope.controleTimer) {
				$interval.cancel($rootScope.controleTimer);
				$rootScope.controleTimer = null;
			}
		}

		// Timer verificando se a sessão ainda esta ativa e se o usuario continua logado.
		if(!$rootScope.timerLogado && $rootScope.logged) {
			$rootScope.timerLogado = $interval(function() {
				LoginResource.get({}, function(response){
					if(!response.data) {
						$location.path('/');
						$rootScope.logged = false;
						$rootScope.loggedUserData = null;
						$rootScope.sisConfig = null;
					}
					else {
						$rootScope.logged = true;
						$rootScope.loggedUserData = response.data.usuario;
						$rootScope.sisConfig = response.data.configuracao;
					}
				});
			}, 1000*60*5);
		}
	});
	$rootScope.$on('$viewContentLoaded', function() {
      $templateCache.removeAll();
   });
});

crossfitApp.factory('LoginResource', ['$resource', function ($resource) {
	return $resource('api/login',{},{login: {method: 'POST'}});
}]);

crossfitApp.factory('LogoutResource', ['$resource', function ($resource) {
	return $resource('api/logout',{},{logout: {method: 'POST'}});
}]);

crossfitApp.factory('DashboardResource', ['$resource', function ($resource) {
	return $resource('api/dashboard', {}, {
		relAniversariantes : {method: 'GET', url : 'api/relAniversariantes'},
		alunos : {method: 'GET', url : 'api/dashboard/alunos'}
	});
}]);

crossfitApp.factory('PlanoResource', ['$resource', function ($resource) {
	return $resource('api/plano/:id_plano',{id_plano:'@id_plano'});
}]);

crossfitApp.factory('FormaPagamentoResource', ['$resource', function ($resource) {
	return $resource('api/formapagamento/:id_forma_pagamento',{id_forma_pagamento:'@id_forma_pagamento'});
}]);

crossfitApp.factory('DescontoResource', ['$resource', function ($resource) {
	return $resource('api/desconto/:id_desconto',{id_desconto:'@id_desconto'});
}]);

crossfitApp.factory('EstacionamentoResource', ['$resource', function ($resource) {
	return $resource('api/estacionamento/:id_estacionamento',{id_estacionamento:'@id_estacionamento'});
}]);

crossfitApp.factory('AulaExpResource', ['$resource', function ($resource) {
	return $resource('api/aulaexp/:id_aulaexp',{id_aulaexp:'@id_aulaexp'});
}]);

crossfitApp.factory('RelAlunoResource', ['$resource', function ($resource) {
	return $resource('api/relaluno', {filtro: '@filtro'}, {
		pesquisa: {method: 'POST'}, 
		idade: {method: 'POST', url: 'api/relaluno/idade', params: {data_ini: '@data_ini',data_fim: '@data_fim'}}
	});
}]);

crossfitApp.factory('RelAlunosPlanoResource', ['$resource', function ($resource) {
	return $resource('api/relalunosplano', {});
}]);

crossfitApp.factory('AlunoResource', ['$resource', function ($resource) {
	return $resource('api/aluno/:id_aluno',{id_aluno:'@id_aluno'}, {
		alunosPresenca : {method : 'GET', url: 'api/alunos/presenca', params: {nome:null, data: null}}
	});
}]);

crossfitApp.factory('ContratoResource', ['$resource', function ($resource) {
	return $resource('api/contrato/:id_aluno/:id_contrato',{id_aluno:'@id_aluno', id_contrato:'@id_contrato'});
}]);

crossfitApp.factory('ServicoResource', ['$resource', function ($resource) {
	return $resource('api/servico/:id_servico',{id_servico:'@id_servico'});
}]);

crossfitApp.factory('PresencaResource', ['$resource', function ($resource) {
	return $resource('api/presenca/:id_aula',{id_aula:'@id_aula'}, {
		presencaAtiva: {method: 'GET', url: 'api/presencaativa'},
		presencaSalao: {method: 'POST', url: 'api/presenca/salao/:id_aula'}
	});
}]);

crossfitApp.factory('AulaResource', ['$resource', function ($resource) {
	return $resource('api/aula/:id_aula',{id_aula:'@id_aula'});
}]);

crossfitApp.factory('RelAulaResource', ['$resource', function ($resource) {
	return $resource('api/relaula', {}, {pesquisa: {method: 'POST'}});
}]);

crossfitApp.factory('RelServicoResource', ['$resource', function ($resource) {
	return $resource('api/relservico', {}, {pesquisa: {method: 'POST'}});
}]);

crossfitApp.factory('PerfilResource', ['$resource', function ($resource) {
	return $resource('api/perfil/:id_usuario', {id_usuario: '@id_usuario'}, {
		atualizaSenha: { method: 'POST', params: {changePassword: true}}
	});
}]);

crossfitApp.factory('UsuarioResource', ['$resource', function ($resource) {
	return $resource('api/usuario/:id_usuario',{id_usuario:'@id_usuario'});
}]);

crossfitApp.factory("controleAcessoResource", ["$resource", function($resource) {
	return $resource('api/controleAcesso');
}]);

//Servico para busca de cep
crossfitApp.factory('ConsultaCepResource', ['$resource', function ($resource) {
	return $resource('http://cep.correiocontrol.com.br/:cep.json',{cep:'@cep'});
}]);

crossfitApp.factory('FinanceiroResource', ['$resource', function ($resource) {
	return $resource('api/financeiro/:id_financeiro',{id_financeiro:'@id_financeiro', ano:'@ano'});
}]);

crossfitApp.factory('AgrupadorResource', ['$resource', function ($resource) {
	return $resource('api/agrupador/:id_agrupador',{id_agrupador:'@id_agrupador'});
}]);

crossfitApp.factory('RelMetricaContratoResource', ['$resource', function ($resource) {
	return $resource('api/relmetricacontrato', {}, {pesquisa: {method: 'POST'}});
}]);

crossfitApp.factory('RelPresencaResource', ['$resource', function ($resource) {
	return $resource('api/relpresenca', {}, {pesquisa: {method: 'POST'}});
}]);

crossfitApp.factory('LeaderboardResource', ['$resource', function ($resource) {
	return $resource('api/leaderboard/:dataLeaderboard', {dataLeaderboard: '@dataLeaderboard', organizacao: '@organizacao'});
}]);

crossfitApp.factory('ConfiguracaoResource', ['$resource', function ($resource) {
	return $resource('api/configuracao', {});
}]);

