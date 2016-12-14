angular.module('app')
.controller('AuthCtrl', function($scope, $auth, $state) {

	$scope.isLogin = function () { return $state.$current.url == '/auth/login'};
	$scope.isRegister = function () { return $state.$current.url == '/auth/register'};	
	
});