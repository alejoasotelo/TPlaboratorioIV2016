angular.module('app')
.controller('OfertasCtrl', function($scope, $auth, $state) {

	if (!$auth.isAuthenticated()){
		$state.go('auth.login');
	}

});