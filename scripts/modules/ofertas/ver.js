angular.module('app')
.controller('OfertasVerCtrl', function($scope, $auth, $state, $stateParams, OfertasSvc, PropiedadesSvc, VentasAlquileresSvc, $window, NgMap, $q) {

	$scope.ready = false;

	var id_oferta = $stateParams.id;

	$scope.propiedad = {};

	$scope.venta_alquiler = {};

	$scope.usuario = $auth.getPayload();

	$scope.map = {};
	$scope.propiedades = [];

	var p1 = OfertasSvc.get(id_oferta);

	$q.all([NgMap.getMap(), p1]).then(function(data){ 
		$scope.map = data[0];

		var oferta = data[1];
		var propiedad = oferta.propiedad;
		$scope.oferta = oferta;

		$scope.venta_alquiler.tipo = propiedad.tipo;
		$scope.venta_alquiler.id_propiedad = propiedad.id_propiedad;
		$scope.venta_alquiler.id_usuario = $scope.usuario.id_usuario;
		$scope.venta_alquiler.precio = propiedad.precio * (1-(oferta.descuento /100));

		// listAndExcludeById
		PropiedadesSvc.listAndExcludeById(propiedad.id_propiedad).then(function(propiedades) {
			$scope.propiedades = propiedades;
			$scope.ready = true;
		});

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