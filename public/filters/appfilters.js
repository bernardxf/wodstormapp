var AppFilters = angular.module('AppFilters', []);

AppFilters.filter('StatusTranslate', function(){
	return function(status){
		var statusAsString = null;

		switch(status){
			case 'A':
				statusAsString = 'Ativo';
				break;
			case 'I':
				statusAsString = 'Inativo';
				break;
			case 'F':
				statusAsString = 'Finalizado';
				break;
			case 'T':
				statusAsString = 'Trancado';
				break;
		}

		return statusAsString;

	};
});

AppFilters.filter('SimNaoTranslate', function(){
	return function(status){
		var simNaoAsString = null;

		switch(status){
			case 'S':
				simNaoAsString = 'Sim';
				break;
			case 'N':
				simNaoAsString = 'Não';
				break;
		}

		return simNaoAsString;

	};
});

AppFilters.filter("startFrom", function() {
	return function(input, start) {
		start = +start;
		return input ? input.slice(start) : null;
	}
})