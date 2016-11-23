angular.module('app')
.controller('LocalesModificarCtrl', function($scope, $stateParams) {

	var user_id = $stateParams.id;

	alert(user_id);

});