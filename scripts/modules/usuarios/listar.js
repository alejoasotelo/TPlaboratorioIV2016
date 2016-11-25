angular.module('app')
.controller('UsuariosListarCtrl', function($scope, $window, $auth, $state, UsuariosSvc) {

	if (!$auth.isAuthenticated()){
		$state.go('auth.login');
	}

	$scope.usuarios = new Array();

	function cargar() {

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
		
		UsuariosSvc.delete(id).then(function(data){

			console.log(data);

			if (data.successs) {

				cargar();
				//deleteFromArray($scope.usuarios, id);
				
			}

		});

	}

	$scope.$on('modificar', function(v) {

		var usuario = $scope.usuarios.find(function(element, index, arr) {

			return element.selected;

		});

		if (typeof usuario != 'undefined') {
			$state.go('usuarios.modificar', {id: usuario.id_usuario});
		} else {
			$window.alert('Tienes que elegir un item para modificar.');
		}

	});

	$scope.$on('eliminar', function(v) {

		var usuarios = new Array();

		angular.forEach($scope.usuarios, function(value, index) {
			if (value.selected) {
				usuarios.push(value.id_usuario);
			}
		});

		if (usuarios.length > 0) {
			$scope.eliminar(usuarios);
		} else {
			$window.alert('Tienes que elegir un item para eliminar.');
		}

	});

	$scope.selectAllChange = function () {

		if ($scope.tools.selectAll) {
			angular.forEach($scope.usuarios, function(value, index) {
				value.selected = true;
			});
		} else {

			angular.forEach($scope.usuarios, function(value, index) {
				value.selected = false;
			});
		}

	}

	cargar();

});