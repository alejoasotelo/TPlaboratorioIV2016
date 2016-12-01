angular.module('app')
.controller('PropiedadesVerCtrl', function($scope, $auth, $state, $stateParams, PropiedadesSvc, VentasAlquileresSvc, $window) {

	$scope.ready = false;

	var id_propiedad = $stateParams.id;

	$scope.propiedad = {};

	$scope.venta_alquiler = {};

	var p1 = PropiedadesSvc.get(id_propiedad).then(function(propiedad) {

		$scope.propiedad = propiedad;

		$scope.venta_alquiler.tipo = propiedad.tipo;
		$scope.venta_alquiler.id_propiedad = propiedad.id_propiedad;
		$scope.venta_alquiler.id_usuario = $auth.getPayload().id_usuario;

		$scope.ready = true;

	});

	$scope.volver = function () {

		$state.go('propiedades.listar');

	}

	// tipo = 1: comprar, tipo = 2: alquilar.
	$scope.comprar_alquilar = function (tipo) {

		console.log($scope.venta_alquiler);

		VentasAlquileresSvc.insert($scope.venta_alquiler).then(function (r) {

			if (r.success) {
				$state.go('propiedades.listar');
			} else {
				$window.alert(r.msg);				
			}

		});

	}

});