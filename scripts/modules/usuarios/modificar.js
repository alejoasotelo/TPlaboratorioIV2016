angular.module('app')
.controller('UsuariosModificarCtrl', function($scope, $stateParams) {

	var user_id = $stateParams.id;

	alert(user_id);

});