angular.module('app')
.controller('PropiedadesListarCtrl', function($scope, $window, $auth, $state, $window, PropiedadesSvc, PermisosSvc) {

	if (!$auth.isAuthenticated()){
		$state.go('auth.login');
	}

	$scope.esTipoCliente = PermisosSvc.getTipoUsuario() == 'cliente';
	$scope.propiedades = new Array();

	function cargar() {

		PropiedadesSvc.list().then(function(propiedades) {

			$scope.propiedades = propiedades;

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

		if ($window.confirm('Esta seguro que desea eliminar?')) {

			PropiedadesSvc.delete(id).then(function(data) {

				if (data.success) {

					cargar();

				}

			});

		}

	}

	$scope.$on('modificar', function(v) {

		var propiedad = $scope.propiedades.find(function(element, index, arr) {

			return element.selected;

		});

		if (typeof propiedad != 'undefined') {
			$state.go('propiedades.modificar', {id: propiedad.id_propiedad});
		} else {
			$window.alert('Tienes que elegir un item para modificar.');
		}

	});

	$scope.$on('eliminar', function(v) {

		var propiedades = new Array();

		angular.forEach($scope.propiedades, function(value, index) {
			if (value.selected) {
				propiedades.push(value.id_propiedad);
			}
		});

		if (propiedades.length > 0) {
			$scope.eliminar(propiedades);
		} else {
			$window.alert('Tienes que elegir un item para eliminar.');
		}

	});

	$scope.selectAllChange = function () {

		if ($scope.tools.selectAll) {
			angular.forEach($scope.propiedades, function(value, index) {
				value.selected = true;
			});
		} else {

			angular.forEach($scope.propiedades, function(value, index) {
				value.selected = false;
			});
		}

	}

	cargar();

});