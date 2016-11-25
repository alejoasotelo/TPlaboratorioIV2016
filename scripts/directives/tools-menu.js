angular.module('app')

.directive('toolsMenu', function() {

	return {
		restrict: 'E',
		templateUrl: 'scripts/directives/tools-menu.html',
		scope: {
			para: '@para'
		},
		controller: function ($scope) {

			$scope.modificar = function () {
				$scope.$emit('modificar', '');
			}

			$scope.eliminar = function () {
				$scope.$emit('eliminar', '');
			}

		}
	}
	
});