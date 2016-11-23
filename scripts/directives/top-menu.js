angular.module('app')

.directive('topMenu', function() {

	return {
		restrict: 'E',
		templateUrl: 'scripts/directives/top-menu.html',
		controller: function ($scope, $auth, $state) {

			$scope.isAuthenticated = function() {
				return $auth.isAuthenticated();
			};

			$scope.logout = function() {

				$auth.logout().then(function(r){
					$state.go('auth.login');
				});

			}

		}
	}
	
});