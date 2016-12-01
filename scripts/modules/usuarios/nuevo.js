angular.module('app')
.controller('UsuariosNuevoCtrl', function($scope, $state, $window, UsuariosSvc, PermisosSvc) {

	$scope.usuario = {};
	$scope.Permisos = PermisosSvc;

	$scope.guardar = function () {

		UsuariosSvc.insert($scope.usuario).then(function(r) {

			if (r.success) {
				$state.go('usuarios.listar');
			} else {
				$window.alert(r.msg);
			}

		});

	}

	$scope.cancelar = function () {

		$state.go('usuarios.listar');

	}

	$scope.$on('guardar', function(v) {

		$scope.guardar();

	});

	$scope.$on('cancelar', function(v) {

		$scope.cancelar();

	});

});