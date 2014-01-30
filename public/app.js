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
	}).when('/servico', {
		templateUrl: 'views/servico.html',
		controller: 'ServicoController'
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
		controller: 'RelServicoController'
	}).when('/financeiro', {
		templateUrl: 'views/financeiro.html',
		controller: 'FinanceiroController'
	}).when('/financeiro/cad_movimento/:movimento?', {
		templateUrl: 'views/cad_fin_movimento.html',
		controller: 'FinanceiroController'
	}).when('/financeiro/categoria', {
		templateUrl: 'views/fin_categoria.html',
		controller: 'FinanceiroController'
	}).when('/financeiro/cad_categoria/:categoria?', {
		templateUrl: 'views/cad_fin_categoria.html',
		controller: 'FinanceiroController'
	}).otherwise({ redirectTo: '/404', templateUrl: 'views/page404.html', controller: 'Page404Controller' });

}]);

crossfitApp.run(function($rootScope, $location){
	$rootScope.$on("$routeChangeStart", function(event, next, current) {
		if ($rootScope.logged == null) {
			$location.path('/');
		}
	});
});

crossfitApp.factory('LoginResource', ['$resource', function ($resource) {
	return $resource('/api/login',{},{login: {method: 'POST'}});
}]);

crossfitApp.factory('DashboardResource', ['$resource', function ($resource) {
	return $resource('/api/dashboard');
}]);

crossfitApp.factory('PlanoResource', ['$resource', function ($resource) {
	return $resource('/api/plano/:id_plano',{id_plano:'@id_plano'});
}]);

crossfitApp.factory('FormaPagamentoResource', ['$resource', function ($resource) {
	return $resource('/api/formapagamento/:id_forma_pagamento',{id_forma_pagamento:'@id_forma_pagamento'});
}]);

crossfitApp.factory('DescontoResource', ['$resource', function ($resource) {
	return $resource('/api/desconto/:id_desconto',{id_desconto:'@id_desconto'});
}]);

crossfitApp.factory('EstacionamentoResource', ['$resource', function ($resource) {
	return $resource('/api/estacionamento/:id_estacionamento',{id_estacionamento:'@id_estacionamento'});
}]);

crossfitApp.factory('AulaExpResource', ['$resource', function ($resource) {
	return $resource('/api/aulaexp/:id_aulaexp',{id_aulaexp:'@id_aulaexp'});
}]);

crossfitApp.factory('RelAlunoResource', ['$resource', function ($resource) {
	return $resource('/api/relaluno', {}, {pesquisa: {method: 'POST'}});
}]);

crossfitApp.factory('AlunoResource', ['$resource', function ($resource) {
	return $resource('/api/aluno/:id_aluno',{id_aluno:'@id_aluno'});
}]);

crossfitApp.factory('ContratoResource', ['$resource', function ($resource) {
	return $resource('/api/contrato/:id_aluno/:id_contrato',{id_aluno:'@id_aluno', id_contrato:'@id_contrato'});
}]);

crossfitApp.factory('ServicoResource', ['$resource', function ($resource) {
	return $resource('/api/servico/:id_servico',{id_servico:'@id_servico'});
}]);

crossfitApp.factory('PresencaResource', ['$resource', function ($resource) {
	return $resource('/api/presenca/:id_aula',{id_aula:'@id_aula'});
}]);

crossfitApp.factory('AulaResource', ['$resource', function ($resource) {
	return $resource('/api/aula/:id_aula',{id_aula:'@id_aula'});
}]);

crossfitApp.factory('RelAulaResource', ['$resource', function ($resource) {
	return $resource('/api/relaula', {}, {pesquisa: {method: 'POST'}});
}]);

crossfitApp.factory('RelServicoResource', ['$resource', function ($resource) {
	return $resource('/api/relservico', {}, {pesquisa: {method: 'POST'}});
}]);

//Servico para busca de cep
crossfitApp.factory('ConsultaCepResource', ['$resource', function ($resource) {
	return $resource('http://cep.correiocontrol.com.br/:cep.json',{cep:'@cep'});
}]);

crossfitApp.factory('FinanceiroResource', ['$resource', function ($resource) {
	return $resource('/api/financeiro/:id_movimento/:id_categoria',{id_movimento:'@id_movimento', id_categoria:'@id_categoria'});
}]);