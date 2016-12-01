angular.module('app')
.controller('VentasAlquileresCtrl', function($scope, $auth, $state) {

	if (!$auth.isAuthenticated()){
		$state.go('auth.login');
	}

});