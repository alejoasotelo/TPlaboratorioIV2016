angular.module('app')
.controller('LocalesNuevoCtrl', function($scope, $state, $window, LocalesSvc) {

	$scope.local = {};

	$scope.guardar = function () {

		LocalesSvc.insert($scope.local).then(function(r) {

			if (r.success) {
				$state.go('locales.listar');
			} else {
				$window.alert(r.msg);
			}

		});

	}

	$scope.cancelar = function () {

		$state.go('locales.listar');

	}

	$scope.$on('guardar', function(v) {

		$scope.guardar();

	});

	$scope.$on('cancelar', function(v) {

		$scope.cancelar();

	});

});