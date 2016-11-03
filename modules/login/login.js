angular.module('app')
.controller('LoginCtrl', function($scope) {
	
	$scope.user = {}

	$scope.login = function () {
		console.log($scope.user);
	}
});