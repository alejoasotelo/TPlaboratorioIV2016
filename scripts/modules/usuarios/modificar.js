angular.module('app')
.controller('UsuariosModificarCtrl', function($scope, $window, $state, $stateParams, UsuariosSvc, PermisosSvc) {

	var id_usuario = $stateParams.id;

	$scope.usuario = {};
	$scope.Permisos = PermisosSvc;

	UsuariosSvc.get(id_usuario).then(function(usuario) {

		$scope.usuario = usuario;

	});

	$scope.guardar = function () {

		UsuariosSvc.update($scope.usuario).then(function(r) {

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