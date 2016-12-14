angular.module('app')
.controller('OfertasNuevoCtrl', function($scope, $state, $window, OfertasSvc, PropiedadesSvc, LocalesSvc, PermisosSvc, $q) {

	$scope.ready = false;

	$scope.oferta = {
		propiedad: {
		}
	};

	$scope.locales = [];
	$scope.propiedades = [];
	$scope.permisos = PermisosSvc;

	var user = PermisosSvc.getUser();

	var p1 = LocalesSvc.list();
	var p2 = PropiedadesSvc.listByIdLocal(user.local.id_local);

	$q.all([p1, p2]).then(function(data) {


		$scope.locales = data[0];
		$scope.propiedades = data[1];
		$scope.oferta.propiedad.id_local = user.local.id_local;
		$scope.ready = true;

	});

	$scope.guardar = function () {

		OfertasSvc.insert($scope.oferta).then(function(r) {

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

});