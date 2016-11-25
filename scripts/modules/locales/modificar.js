angular.module('app')
.controller('LocalesModificarCtrl', function($scope, $window, $state, $stateParams, LocalesSvc) {

	var id_local = $stateParams.id;

	$scope.local = {};

	LocalesSvc.get(id_local).then(function(local) {

		$scope.local = local;

	});

	$scope.guardar = function () {

		LocalesSvc.update($scope.local).then(function(r) {

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