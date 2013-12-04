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
					} else {
						MessageService.processMessages(response.messages);
					}
				}
			});

		},
		logout : function(){
			$rootScope.loggedUser = null;
			$location.path('/');
		}
	};
}]);

AppServices.factory('MessageService', [function () {
	return {
		processMessages: function(messages){
			angular.forEach(messages, function(message){
				alert(message);	
			});
		}
	};
}]);