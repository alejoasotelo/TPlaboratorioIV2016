angular.module('app')

.directive('topMenu', function() {

	return {
		restrict: 'E',
		templateUrl: 'scripts/directives/top-menu.html',
		controller: function ($scope, $auth, $state, PermisosSvc) {

			$scope.user = {};

			$scope.isAdmin = false;
			$scope.Permisos = PermisosSvc;

			$scope.isAuthenticated = function() {
				var isAuthenticated = $auth.isAuthenticated();

				$scope.user = isAuthenticated ? $auth.getPayload() : 'undefined';
				$scope.isAdmin = angular.equals($scope.user, {}) ? false : $scope.user.tipo == 'administrador';

				/*if (!isAuthenticated){
					$state.go('auth.login');
				}*/

				return isAuthenticated;
			};

			$scope.logout = function() {

				$auth.logout().then(function(r){
					$state.go('auth.login');
				});

			}

			$scope.current_url = function() {
				return $state.$current.url;
			};

			$scope.modificarLocal = function() {

				if ($scope.user.local != false) {
					$state.go('usuarios.locales.modificar', {id: $scope.user.local.id_local});
				}

			}

		}
	}
	
});