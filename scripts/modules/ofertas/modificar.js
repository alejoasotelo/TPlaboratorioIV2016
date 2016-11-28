angular.module('app')
.controller('OfertasModificarCtrl', function($scope, $window, $state, $stateParams, OfertasSvc, PropiedadesSvc, $q) {

	$scope.ready = false;

	var id_oferta = $stateParams.id;

	$scope.oferta = {
		propiedad: {}
	};

	var p1 = OfertasSvc.get(id_oferta);
	var p2 = PropiedadesSvc.list();

	$q.all([p1, p2]).then(function(data) {

		$scope.propiedades = data[1];
		$scope.oferta = data[0];

		$scope.ready = true;

	});

	$scope.guardar = function () {

		OfertasSvc.update($scope.oferta).then(function(r) {

			if (r.success) {
				$state.go('ofertas.listar');
			} else {
				$window.alert(r.msg);
			}

		});

	}

	$scope.cancelar = function () {

		$state.go('ofertas.listar');

	}

	$scope.$on('guardar', function(v) {

		$scope.guardar();

	});

	$scope.$on('cancelar', function(v) {

		$scope.cancelar();

	});

});