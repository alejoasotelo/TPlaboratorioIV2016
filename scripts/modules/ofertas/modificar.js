angular.module('app')
.controller('OfertasModificarCtrl', function($scope, $window, $state, $stateParams, OfertasSvc, PropiedadesSvc, LocalesSvc, PermisosSvc, $q) {

	$scope.ready = false;

	var id_oferta = $stateParams.id;

	$scope.oferta = {
		propiedad: {
		}
	};

	$scope.permisos = PermisosSvc;

	var user = PermisosSvc.getUser();

	var p1 = OfertasSvc.get(id_oferta);
	var p2 = PropiedadesSvc.listByIdLocal(user.local.id_local);
	var p3 = LocalesSvc.list();

	$q.all([p1, p2, p3]).then(function(data) {

		$scope.propiedades = data[1];
		$scope.locales = data[2];
		$scope.oferta = data[0];

		$scope.ready = true;

	});

	$scope.cargarPropiedades = function() {

		$scope.propiedades = [];
		$scope.cargandoPropiedades = true;

		if ($scope.oferta.propiedad.id_local > 0) {

			PropiedadesSvc.listByIdLocal($scope.oferta.propiedad.id_local).then(function(propiedades) {
				$scope.cargandoPropiedades = false;
				$scope.propiedades = propiedades;

			});

		} else {
			$scope.cargandoPropiedades = false;
		}		

	}

	$scope.guardar = function () {

		OfertasSvc.update($scope.oferta).then(function(r) {

			if (r.success) {
				$state.go('ofertas.listar');
			} else {
				$window.alert(r.msg);
			}

		});

	}

	$scope.cancelar = function () {

		$state.go('ofertas.listar');

	}

	$scope.$on('guardar', function(v) {

		$scope.guardar();

	});

	$scope.$on('cancelar', function(v) {

		$scope.cancelar();

	});

});