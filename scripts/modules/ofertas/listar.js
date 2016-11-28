angular.module('app')
.controller('OfertasListarCtrl', function($scope, $window, $auth, $state, OfertasSvc) {

	if (!$auth.isAuthenticated()){
		$state.go('auth.login');
	}

	$scope.ofertas = new Array();

	function cargar() {

		OfertasSvc.list().then(function(ofertas){

			$scope.ofertas = ofertas;

		});

	}

	function deleteFromArray(list, id) {

		for (var i = 0; i < list.length; i++) {

			if (list[i].id == id) {
				list.splice(i, 1);
				break;
			}

		}

	}	

	$scope.eliminar = function(id) {

		if ($window.confirm('Esta seguro que desea eliminar?')) {

			OfertasSvc.delete(id).then(function(data){

				if (data.success) {

					cargar();

				}

			});

		}

	}

	$scope.$on('modificar', function(v) {

		var oferta = $scope.ofertas.find(function(element, index, arr) {

			return element.selected;

		});

		if (typeof oferta != 'undefined') {
			$state.go('ofertas.modificar', {id: oferta.id_oferta});
		} else {
			$window.alert('Tienes que elegir un item para modificar.');
		}

	});

	$scope.$on('eliminar', function(v) {

		var ofertas = new Array();

		angular.forEach($scope.ofertas, function(value, index) {
			if (value.selected) {
				ofertas.push(value.id_oferta);
			}
		});

		if (ofertas.length > 0) {
			$scope.eliminar(ofertas);
		} else {
			$window.alert('Tienes que elegir un item para eliminar.');
		}

	});

	$scope.selectAllChange = function () {

		if ($scope.tools.selectAll) {
			angular.forEach($scope.ofertas, function(value, index) {
				value.selected = true;
			});
		} else {

			angular.forEach($scope.ofertas, function(value, index) {
				value.selected = false;
			});
		}

	}

	cargar();

});