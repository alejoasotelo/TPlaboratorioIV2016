angular.module('app')

.directive('toolsMenu', function() {

	return {
		restrict: 'E',
		templateUrl: 'scripts/directives/tools-menu.html',
		scope: {
			modulo: '@modulo',
			vista: '@vista'
		},
		controller: function ($scope) {

			$scope.modificar = function () {
				$scope.$emit('modificar', '');
			}

			$scope.eliminar = function () {
				$scope.$emit('eliminar', '');
			}

			$scope.cancelar = function () {
				$scope.$emit('cancelar', '');
			}

			$scope.guardar = function () {
				$scope.$emit('guardar', '');
			}

		}
	}
	
});