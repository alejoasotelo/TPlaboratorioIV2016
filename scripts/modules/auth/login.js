angular.module('app')
.controller('AuthLoginCtrl', function($scope, $state, $auth, PermisosSvc) {
	
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
		$state.go(PermisosSvc.getUserPageDefault());
		return false;
	}

	$scope.login = function () {
		
		$scope.mensajes = '';

		$auth.login($scope.user).then(function(response) {

			console.log('login.success', response);

			if (response.data.token_lab4 != false) {
				console.log('token_lab4 != false');

    			// Redirect user here after a successful log in.
    			$scope.isAuthenticated = $auth.isAuthenticated();
				$scope.user = $auth.getPayload();
				$state.go(PermisosSvc.getUserPageDefault());

			} else {
				$scope.mensajes = 'No se pudo iniciar sesión.';
			}

    	}).catch(function(response) {

		    console.error(response);
			$scope.mensajes = 'No se pudo iniciar sesión.';
		
		});

	}

	$scope.loginTest = function(user_test) {

		$scope.user = user_test;

	}
});