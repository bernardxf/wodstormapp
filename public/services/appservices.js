var AppServices = angular.module('AppServices', []);

AppServices.factory('loginService', ['LoginResource', 'MessageService', '$rootScope', '$location', function (LoginResource, MessageService, $rootScope, $location) {
	return {
		login : function(loginDataset){
			LoginResource.login(loginDataset, function(response){
				if(response){
					if(response.success){
						$rootScope.logged = true;
						$rootScope.loggedUserData = response.data;
						$location.path('/dashboard');

						var storage = {usuario:loginDataset.usuario, organizacao: loginDataset.organizacao};
						localStorage.setItem('wodStormLogin', JSON.stringify(storage));
					} else {
						MessageService.processMessages(response.messages);
					}
				}
			});

		},
		logout : function(){
			LoginResource.logout({}, function(response){
				$rootScope.loggedUser = null;
				$location.path('/');
			});		
		}
	};
}]);

AppServices.factory('MessageService', [function () {
	return {
		processMessages: function(messages){
			angular.forEach(messages, function(message){
				$.howl ({
					type: message.type //sucess, warning, danger, info
					, title: message.title
					, content: message.message
					, lifetime: 4500
				});
			});
		}
	};
}]);