angular.module('app')
.controller('OfertasNuevoCtrl', function($scope, $state, $window, OfertasSvc, PropiedadesSvc) {

	$scope.ready = false;

	$scope.oferta = {
		propiedad: {}
	};

	$scope.propiedades = {};

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

	PropiedadesSvc.list().then(function(propiedades) {

		$scope.propiedades = propiedades;

		$scope.ready = true;

	});

});