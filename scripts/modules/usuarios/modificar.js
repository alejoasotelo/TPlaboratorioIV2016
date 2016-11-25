angular.module('app')
.controller('UsuariosModificarCtrl', function($scope, $stateParams) {

	var id_usuario = $stateParams.id;

	alert(id_usuario);

});