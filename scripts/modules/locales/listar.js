angular.module('app')
.controller('LocalesListarCtrl', function($scope, $auth, $state, LocalesSvc) {

	if (!$auth.isAuthenticated()){
		$state.go('auth.login');
	}

	$scope.locales = new Array();

	function cargar() {

		LocalesSvc.list().then(function(locales){

			$scope.locales = locales;

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
		
		LocalesSvc.delete(id).then(function(deleted){

			if (deleted) {

				deleteFromArray($scope.locales, id);
				
			}

		});

	}

	$scope.$on('modificar', function(v) {

		var local = $scope.locales.find(function(element, index, arr) {

			return element.selected;

		});

		if (typeof local != 'undefined') {
			$state.go('locales.modificar', {id: local.id_local});
		}

	});

	$scope.$on('eliminar', function(v) {

		var locales = new Array();

		angular.forEach($scope.locales, function(value, index) {
			if (value.selected) {
				locales.push(value.id_local);
			}
		});

		if (locales.length > 0) {
			$scope.eliminar(locales);
		}

	});

	$scope.selectAllChange = function () {

		if ($scope.tools.selectAll) {
			angular.forEach($scope.locales, function(value, index) {
				value.selected = true;
			});
		} else {

			angular.forEach($scope.locales, function(value, index) {
				value.selected = false;
			});
		}

	}

	cargar();

});