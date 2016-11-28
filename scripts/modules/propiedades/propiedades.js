angular.module('app')
.controller('PropiedadesCtrl', function($scope, $auth, $state) {

	$scope.isAuthenticated = $auth.isAuthenticated();

	if (!$scope.isAuthenticated) {		
		$state.go('auth.login');
	}

});