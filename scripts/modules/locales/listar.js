angular.module('app')
.controller('LocalesListarCtrl', function($scope, $auth, $state, LocalesSvc) {

	if (!$auth.isAuthenticated()){
		$state.go('auth.login');
	}

	$scope.locales = new Array();

	function cargar() {

		LocalesSvc.list().then(function(locales){

			$scope.locales = locales;

		});

	}

	function deleteFromArray(list, id) {

		for (var i = 0; i < list.length; i++) {

			if (list[i].id == id) {
				list.splice(i, 1);
				break;
			}

		}

	}


	$scope.eliminar = function(id) {
		
		LocalesSvc.delete(id).then(function(deleted){

			if (deleted) {

				deleteFromArray($scope.locales, id);
				
			}

		});

	}

	cargar();

});