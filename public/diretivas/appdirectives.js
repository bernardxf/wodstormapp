var AppDirectives = angular.module('AppDirectives', []);

AppDirectives.directive('wsMenu', [function () {
	return {
		restrict: 'A',
		link: function (scope, iElement, iAttrs) {
			var elements = iElement.children();
			angular.forEach(elements, function(item, key){
				angular.element(item).on('click', function(){
					var activeNode = angular.element(document.querySelector('.active'));
					activeNode.removeClass('active');
					if(activeNode.hasClass('dropdown')){
						activeNode.find('ul').css('display', 'none');
					}

					var newActiveNode = angular.element(this);
					newActiveNode.addClass('active');
					if(newActiveNode.hasClass('dropdown')){
						newActiveNode.find('ul').css('display', 'block');
					}
				});
			});
		}
	};
}]);

AppDirectives.directive('wsData', ["$filter", function ($filter) {
	return {
		restrict: 'A',
		require: 'ngModel',
		link: function (scope, iElement, iAttrs, ctrl) {
			ctrl.$parsers.unshift(function(viewValue){
				if(viewValue){
					var values = viewValue.split('/');
					return values[2]+"-"+values[1]+"-"+values[0];
				}
				return '';
			});

			ctrl.$formatters.unshift(function(modelValue){
				if(modelValue == '0000-00-00'){
					return '';
				} else {
					$filter('date')(modelValue, 'dd/MM/yyyy');
				}
			});
		}
	};
}]);


AppDirectives.directive('wsStackedNav', [function () {
	return {
		restrict: 'A',
		scope: {
			stackedid : '@'
		},
		link: function (scope, iElement, iAttrs) {
			iElement.on('click', function(){
				var activeNode = angular.element(document.querySelector('.stacked-content > .active'));
				var activeNav = angular.element(document.querySelector('.nav-stacked > .active'));
				if(activeNode.attr('id') !== scope.stackedid){
					activeNav.removeClass('active');
					angular.element(this).addClass('active');
					activeNode.removeClass('in active');
					var node = angular.element(document.getElementById(scope.stackedid));
					node.addClass('in active');
				}
			});
		}
	};
}]);

AppDirectives.directive('wsNavUsuario', [function () {
	return {
		restrict: 'A',
		templateUrl: 'views/partials/ws_nav_usuario.html',
		link: function (scope, iElement, iAttrs) {
			var dropdown = angular.element('.dropdown > .dropdown-toggle');
			dropdown.on('click', function(){
				dropdown.parent().toggleClass('open');
			});

			var dropdownMenuItens = angular.element('.dropdown-menu .dropdown-menu-item');
			dropdownMenuItens.on('click', function(){
				dropdown.parent().removeClass('open');
				angular.element('#main-nav .active').removeClass('active');
			});
		}
	};
}]);

AppDirectives.directive('wsSidebarMenu', [function () {
	return {
		restrict: 'A',
		templateUrl: 'views/partials/ws_sidebar_menu.html',
		link: function (scope, iElement, iAttrs) {
			
		}
	};
}]);

AppDirectives.directive('modalDialog', function() {
  	return {
	    restrict: 'E',
	    scope: {
	    	show: '='
	    },
	    replace: true, // Replace with the template below
	    transclude: true, // we want to insert custom content inside the directive
	    link: function(scope, element, attrs) {
	    	scope.dialogStyle = {};
	    	if (attrs.width)
	    		scope.dialogStyle.width = attrs.width;
	    	if (attrs.height)
	    		scope.dialogStyle.height = attrs.height;
	    	scope.hideModal = function() {
	    		scope.show = false;
	      	};
	    },
	    templateUrl: 'views/partials/ws_modal.html'
  };
});

AppDirectives.directive('wsGrid', [
    function() {
        return {
            restrict: "EA",
            templateUrl: "views/partials/ws_grid.html",
            link: function(scope, element, attrs) {
            	scope.titulo                = attrs.titulo;
            	scope.buttons               = attrs.buttons;
            	scope.gridData              = /*attrs.dataGrid; //*/[{"nome":"Ana Carolina Sette da Silveira","data_nasc":"01/04"},{"nome":"Jose Henrique Diniz Junior","data_nasc":"01/04"},{"nome":"Rafaella Salviano Fernandes","data_nasc":"01/04"},{"nome":"Ranveer Kunal","data_nasc":"01/04"},{"nome":"Daniel Silva Marques Vilela","data_nasc":"02/04"},{"nome":"Gabriella Cristina Silva Vilela","data_nasc":"02/04"},{"nome":"Leandro Lopes Morais","data_nasc":"04/04"},{"nome":"Natália Nery Soares","data_nasc":"07/04"},{"nome":"Luiz Flavio Oliveira Bini","data_nasc":"11/04"},{"nome":"Ângela Cordeiro Tupynambá","data_nasc":"12/04"},{"nome":"Paulo Cézar Klausing de Oliveira","data_nasc":"12/04"},{"nome":"Francisco Drummond Junior","data_nasc":"13/04"},{"nome":"Simone Eulália Costa Ferraz","data_nasc":"14/04"},{"nome":"Linda Léticia Thereza Luciano Lavalle Romano Cruz Ferber","data_nasc":"17/04"},{"nome":"Flavio Lucio Silva de Jesus","data_nasc":"17/04"},{"nome":"Thiago Maldonado Martins","data_nasc":"20/04"},{"nome":"Anderson Diniz Peixoto","data_nasc":"21/04"},{"nome":"Ana Elisa Souza Jorge","data_nasc":"21/04"},{"nome":"Thadeu Viana Madeira","data_nasc":"21/04"},{"nome":"Carolina Souza Jorge","data_nasc":"21/04"},{"nome":"Marina dos Santos Camargo","data_nasc":"22/04"},{"nome":"Raul Felipe Borelli","data_nasc":"22/04"},{"nome":"Andre Mariani Prado","data_nasc":"23/04"},{"nome":"Rodrigo Silva Guedes","data_nasc":"23/04"},{"nome":"Cristiano Ullmann Lambertucci","data_nasc":"25/04"},{"nome":"Robson Tiago Domingues","data_nasc":"26/04"},{"nome":"Rafael Costa de Souza","data_nasc":"27/04"},{"nome":"Hellen Greco","data_nasc":"28/04"},{"nome":"Alexander Sousa Sol","data_nasc":"28/04"},{"nome":"Matheus Testa Saab","data_nasc":"28/04"},{"nome":"Cristina Pinheiro de Lima","data_nasc":"28/04"},{"nome":"Fernanda Mara Alves Linhares","data_nasc":"30/04"}];
            	scope.currentPage           = 1;
            	scope.itemsPerPage          = 5;
            	scope.showInputItemsPerPage = attrs.showInputItemsPerPage;
            	scope.columns               = JSON.parse(attrs.columns);
            }
        };
    }]);