angular.module('app')
.controller('AuthRegisterCtrl', function($scope, $auth) {
	
	$scope.user = {};

	$scope.UsuariosTest = {

		ADMINISTRADOR: {
			username: 'administrador', 
			password: 'administrador'
		},
		ENCARGADO: {
			username: 'encargado', 
			password: 'encargado'
		},
		EMPLEADO: {
			username: 'empleado', 
			password: 'empleado'
		},
		CLIENTE: {
			username: 'cliente', 
			password: 'cliente'
		}
	};

	$scope.isAuthenticated = $auth.isAuthenticated();

	if ($scope.isAuthenticated) {
		$scope.user = $auth.getPayload();
	}

	$scope.register = function () {
		
		$scope.mensajes = '';

		

	}
});