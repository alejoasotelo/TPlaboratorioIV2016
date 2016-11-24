angular.module('app')

.directive('topMenu', function() {

	return {
		restrict: 'E',
		templateUrl: 'scripts/directives/top-menu.html',
		controller: function ($scope, $auth, $state) {

			$scope.user = {};

			$scope.isAdmin = false;

			$scope.isAuthenticated = function() {
				var isAuthenticated = $auth.isAuthenticated();

				$scope.user = isAuthenticated ? $auth.getPayload() : {};
				$scope.isAdmin = angular.equals($scope.user, {}) ? false : $scope.user.tipo == 'administrador';

				return isAuthenticated;
			};

			$scope.logout = function() {

				$auth.logout().then(function(r){
					$state.go('auth.login');
				});

			}

		}
	}
	
});