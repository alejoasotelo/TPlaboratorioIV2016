angular.module('app')
.controller('UsuariosListarCtrl', function($scope, $auth, $state, UsuariosSvc) {

	if (!$auth.isAuthenticated()){
		$state.go('auth.login');
	}

	$scope.usuarios = new Array();

	function cargarUsuarios() {

		UsuariosSvc.list().then(function(usuarios){

			$scope.usuarios = usuarios;

		});

	}

	function deleteFromArray(list, id) {

		for (var i = 0; i < list.length; i++) {

			if (list[i].id == id) {
				list.splice(i, 1);
				break;
			}

		}

	}


	$scope.eliminar = function(id) {
		
		UsuariosSvc.delete(id).then(function(deleted){

			if (deleted) {

				deleteFromArray($scope.usuarios, id);
				
			}

		});

	}

	cargarUsuarios();

});