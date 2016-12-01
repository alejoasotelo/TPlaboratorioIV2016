angular.module('app')
.directive('ngUsuario', function(){
	
	return {
		restrict: 'EA',
		transclude: true,
		templateUrl: 'scripts/directives/ng-usuario.html',
		scope: {
			usuario: '=usuario',
			mostrar_tipo: '=mostrarTipo'
		},
		controller: function($scope, UsuariosSvc, PermisosSvc) {

			$scope.mostrar = true;

			$scope.cambiarEstado = function(usuario, nuevo_estado) {

				if (PermisosSvc.puedeCambiarEstado()) {

					UsuariosSvc.changeState(usuario.id_usuario, nuevo_estado).then(function(r) {

						if (r.success) {
							usuario.estado = nuevo_estado;
						}

					});

				}

			}			

			// Filtro los usuarios.
			if ($scope.mostrar_tipo == 'todos') {
				$scope.mostrar = true;
			} else if($scope.mostrar_tipo == 'ninguno') {
				$scope.mostrar = false;
			} else if ($scope.mostrar_tipo.indexOf($scope.usuario.tipo) >=0) {
				$scope.mostrar = true;
			} else {
				$scope.mostrar = false;
			}

		}
	}

});