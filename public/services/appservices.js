var AppServices = angular.module('AppServices', [])

.factory('loginService', ['LoginResource', 'LogoutResource', 'MessageService', '$rootScope', '$location', function (LoginResource, LogoutResource, MessageService, $rootScope, $location) {
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
			$rootScope.logged = false;
			LogoutResource.logout({}, function(response){
				
			});		
		}
	};
}])
.factory('MessageService', [function () {
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
}])
.factory('RESTService', ['$q', '$rootScope', function($q, $rootScope){
	var RESTService = function(resource){
		if(!resource) {
			console.error('Undefined resource!');
			return false;
		}

		$rootScope.carregando = false;

		var restResource = resource,
			restGetDeferred = $q.defer(),
			restSaveDeferred = $q.defer(),
			restRemoveDeferred = $q.defer();


		var get = function(data){
			$rootScope.carregando = true;
			restResource.get(data, function(result){
				$rootScope.carregando = false;
				restGetDeferred.resolve(result);
			});

			return restGetDeferred.promise;
		};

		var save = function(data){	
			if(data == null) {
				console.error('Undefined data!');
				return false;
			}

			$rootScope.carregando = true;
			restResource.save(data, function(result){
				$rootScope.carregando = false;
				restSaveDeferred.resolve(result);
			});

			return restSaveDeferred.promise;
		};

		var remove = function(condition){
			if(condition == null) {
				console.error('Undefined condition!');
				return false;
			}

			$rootScope.carregando = true;
			restResource.remove(condition, function(){
				$rootScope.carregando = false;
				restRemoveDeferred.resolve();
			});

			return restRemoveDeferred.promise;
		};

		return {
			get: get,
			save: save,
			remove: remove
		}
	};

	return RESTService;
}]);