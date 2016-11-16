angular.module('app')
.controller('UsuariosCtrl', function($scope, $auth, $state, UsuariosSvc) {

	$scope.isAuthenticated = $auth.isAuthenticated();

	if (!$scope.isAuthenticated) {		
		$state.go('auth.login');
	}

	$scope.logout = function() {

		$auth.logout().then(function(r){
			$scope.isAuthenticated = $auth.isAuthenticated();
			//$scope.user = $auth.getPayload();
			$state.go('auth.login');
		});
		
	}

});