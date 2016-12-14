angular.module('app')
.controller('PropiedadesVerCtrl', function($scope, $auth, $state, $stateParams, PropiedadesSvc, VentasAlquileresSvc, $window, NgMap, $q) {

	$scope.ready = false;

	var id_propiedad = $stateParams.id;

	$scope.propiedad = {};

	$scope.venta_alquiler = {};

	$scope.usuario = $auth.getPayload();

	$scope.map = {};
	$scope.propiedades = [];

	var p1 = PropiedadesSvc.get(id_propiedad);
	var p2 = PropiedadesSvc.listAndExcludeById(id_propiedad);

	$q.all([NgMap.getMap(), p1, p2]).then(function(data){ 
		$scope.map = data[0];

		var propiedad = data[1];
		$scope.propiedad = propiedad;

		$scope.venta_alquiler.tipo = propiedad.tipo;
		$scope.venta_alquiler.id_propiedad = propiedad.id_propiedad;
		$scope.venta_alquiler.id_usuario = $scope.usuario.id_usuario;

		// listAndExcludeById
		$scope.propiedades = data[2];
		console.log(data);

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