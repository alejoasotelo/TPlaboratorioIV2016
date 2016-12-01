angular.module('app')
.controller('VentasAlquileresListarCtrl', function($scope, $window, $auth, $state, VentasAlquileresSvc) {

	if (!$auth.isAuthenticated()){
		$state.go('auth.login');
	}

	$scope.ventas_alquileres = new Array();

	function cargar() {

		VentasAlquileresSvc.listByUser($auth.getPayload().id_usuario).then(function(ventas_alquileres){

			$scope.ventas_alquileres = ventas_alquileres;

		});

	}

	cargar();

});