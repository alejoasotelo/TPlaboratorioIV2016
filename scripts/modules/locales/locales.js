angular.module('app')
.controller('LocalesCtrl', function($scope, $auth, $state, UsuariosSvc) {

	$scope.isAuthenticated = $auth.isAuthenticated();

	if (!$scope.isAuthenticated) {		
		$state.go('auth.login');
	}

});