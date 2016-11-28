angular.module('app')
.controller('PropiedadesNuevoCtrl', function($scope, $state, $window, PropiedadesSvc, LocalesSvc, $q) {

	$scope.ready = false;

	$scope.propiedad = {};
	$scope.locales = [];

	LocalesSvc.list().then(function(locales) {

		$scope.locales = locales;

		$scope.ready = true;

	});

	$scope.guardar = function () {

		PropiedadesSvc.insert($scope.propiedad).then(function(r) {

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