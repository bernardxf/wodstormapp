angular.module('AppControllers')
.controller('AlunoController', ['$scope', 'AlunoResource', 'ConsultaCepResource', '$location', '$routeParams', 'RESTService', function ($scope, AlunoResource, ConsultaCepResource,$location, $routeParams, RESTService) {
	var rest = new RESTService(AlunoResource);
	$scope.alunoDataset = null;
	$scope.cadAlunoDataset = null;
	$scope.alunoFilter = null;

	$scope.paginaAtual = 1;
	$scope.itensPorPagina = 10;

	$scope.$watch('alunoFilter', function(newValue){
		if(newValue){
			localStorage.setItem('wsAlunoFilter', JSON.stringify(newValue));	
		}
	}, true);

	$scope.carregaAluno = function(){
		var alunoFilter = localStorage.getItem('wsAlunoFilter') ? JSON.parse(localStorage.getItem('wsAlunoFilter')) : {};
		$scope.alunoFilter = alunoFilter;

		// AlunoResource.get({}, function(response){
		// 	$scope.alunoDataset = response.data;
		// });

		rest.get({}).then(function(result){
			$scope.alunoDataset = result.data;
		});
	};

	$scope.carregaCadAluno = function(){
		// AlunoResource.get({id_aluno : $routeParams.aluno}, function(response){
		// 	if(!angular.isArray(response.data)){
		// 		$scope.cadAlunoDataset = response.data;
		// 	}
		// });

		rest.get({id_aluno : $routeParams.aluno}).then(function(result){
			if(!angular.isArray(result.data)){
				$scope.cadAlunoDataset = result.data;
			}
		});
	};

	$scope.salvaAluno = function(){
		var aluno = $scope.cadAlunoDataset;
		data_nasc = aluno.data_nasc;
		if (data_nasc instanceof Date) {
			data_nasc = data_nasc.getFullYear() + "-" + ("00"+(data_nasc.getMonth()+1)).substr(-2) + "-" + data_nasc.getDate();
		}

		aluno.data_nasc = data_nasc;
		// AlunoResource.save(aluno, function(response){
		// 	$location.path('/cad_aluno/'+response.data.id_aluno);
		// });

		rest.save(aluno).then(function(result){
			$location.path('/cad_aluno/'+result.data.id_aluno);
		});
	};

	$scope.cancelaEdicaoAluno = function(){
		$location.path('/aluno');
	};

	$scope.deletaAluno = function(aluno){
		if(confirm('Realmente deseja apagar?')){
			// AlunoResource.remove({id_aluno : aluno.id_aluno}, function(){
			// 	$scope.carregaAluno();
			// });

			rest.remove({id_aluno : aluno.id_aluno}).then(function(){
				// $scope.carregaAluno();
				var index = $scope.alunoDataset.indexOf(aluno);
				delete($scope.alunoDataset[index]);
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