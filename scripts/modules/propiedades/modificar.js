angular.module('app')
.controller('PropiedadesModificarCtrl', function($scope, $auth, $window, $state, $stateParams, PropiedadesSvc, LocalesSvc, FileUploader, $q) {

	$scope.ready = false;

	var id_propiedad = $stateParams.id;

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

	var p1 = PropiedadesSvc.get(id_propiedad);
	var p2 = LocalesSvc.list();

	$q.all([p1, p2]).then(function(data) {

		$scope.propiedad = data[0];
		$scope.locales = data[1];

		if (!$scope.propiedad.usuario) {
			var user = $auth.getPayload();
			$scope.propiedad.usuario = {id_usuario: user.id_usuario};
		}

		$scope.ready = true;

	});

	$scope.guardar = function () {

		PropiedadesSvc.update($scope.propiedad).then(function(r) {

			if (r.success) {
				id = r.id;

				if ($scope.uploader.queue.length > 0) {
					console.log('uploading');
					// Subo las imagenes.
					$scope.uploader.uploadAll();					
				} else {
					$state.go('propiedades.listar');
				}

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

	$scope.removeImagen = function (imagen) {

		PropiedadesSvc.deleteImage(imagen.id_imagen).then(function(r){

			imagen.deleted = true;

		});

	}

	$scope.$on('guardar', function(v) {

		$scope.guardar();

	});

	$scope.$on('cancelar', function(v) {

		$scope.cancelar();

	});

});