angular.module('app')
.controller('PropiedadesNuevoCtrl', function($scope, $state, $auth, $window, PropiedadesSvc, LocalesSvc, FileUploader, $q) {

	$scope.ready = false;

	$scope.propiedad = {};
	$scope.locales = [];

	$scope.uploader = new FileUploader({ 
		url: '/lab4/tp/php/upload.php'
	});

	$scope.uploader.filters.push({
		name: 'imageFilter',
		fn: function(item /*{File|FileLikeObject}*/, options) {
			var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
			return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
		}
	});

	LocalesSvc.list().then(function(locales) {

		$scope.locales = locales;

		var user = $auth.getPayload();
		$scope.propiedad = {
			usuario : {
				id_usuario: user.id_usuario
			}
		}

		$scope.ready = true;

	});

	$scope.guardar = function () {
		var id = 0;

		PropiedadesSvc.insert($scope.propiedad).then(function(r) {

			// Si se inserto bien en la tabla entro.
			if (r.success) {
				id = r.id;
				// Subo las imagenes.
				$scope.uploader.uploadAll();
				
			} else {
				$window.alert(r.msg);
			}

		});

		// Antes de subir la imagenes les cambio el nombre.
		$scope.uploader.onBeforeUploadItem = function(item) {
			item.alias = 'propiedades_' + id;
		};

		$scope.uploader.onCompleteAll = function() {
			$state.go('propiedades.listar');
		}

	}

	$scope.cancelar = function () {

		$state.go('propiedades.listar');

	}

	$scope.$on('guardar', function(v) {

		$scope.guardar();

	});

	$scope.$on('cancelar', function(v) {

		$scope.cancelar();

	});

});