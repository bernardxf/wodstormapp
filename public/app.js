var crossfitApp = angular.module('crossfitApp', ['ngRoute', 'ui.select2','AppControllers','AppDirectives', 'AppServices', 'ngResource']);

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
		controller: 'CadPlanoController'
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
	}).otherwise({ redirectTo: '/404', templateUrl: 'app/views/page404.html', controller: 'Page404Controller' });

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
