angular.module('app')
.controller('AuthRegisterCtrl', function($scope, $auth, UsuariosSvc, $timeout, $state, $sce) {
	
	$scope.usuario = {};

	$scope.isAuthenticated = $auth.isAuthenticated();

	if ($scope.isAuthenticated) {
		$scope.user = $auth.getPayload();
	}

	$scope.register = function () {
		
		$scope.mensajes = '';

		$scope.usuario.tipo = 'cliente';

		$scope.usuario.estado = 1;

		UsuariosSvc.insert($scope.usuario).then(function(r) {

			if (r.success) {
				$scope.mensajes = 'Se ha creado tu usuario correctamente. Seras redirigido al login en unos segundos.';

				$timeout(function(){
					$state.go('auth.login');
				}, 2000);
				
			} else {
				console.log(r.msg);
				console.log($sce.trustAsHtml(r.msg));
				$scope.mensajes =  r.msg;
			}

		});		

	}
});