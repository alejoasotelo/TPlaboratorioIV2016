angular.module('app')
.controller('PropiedadesModificarCtrl', function($scope, $window, $state, $stateParams, PropiedadesSvc, LocalesSvc, $q) {

	$scope.ready = false;

	var id_propiedad = $stateParams.id;

	$scope.propiedad = {};
	$scope.locales = [];

	var p1 = PropiedadesSvc.get(id_propiedad);
	var p2 = LocalesSvc.list();

	$q.all([p1, p2]).then(function(data) {

		$scope.propiedad = data[0];
		$scope.locales = data[1];

		$scope.ready = true;

	});

	$scope.guardar = function () {

		PropiedadesSvc.update($scope.propiedad).then(function(r) {

			if (r.success) {
				$state.go('propiedades.listar');
			} else {
				$window.alert(r.msg);
			}

		});

	}

	$scope.cancelar = function () {

		$state.go('propiedades.listar');

	}

	$scope.$on('guardar', function(v) {

		$scope.guardar();

	});

	$scope.$on('cancelar', function(v) {

		$scope.cancelar();

	});

});