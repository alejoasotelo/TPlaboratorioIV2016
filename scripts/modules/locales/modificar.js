angular.module('app')
.controller('LocalesModificarCtrl', function($scope, $window, $state, $stateParams, LocalesSvc, FileUploader) {

	var id_local = $stateParams.id;

	$scope.local = {};
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

	LocalesSvc.get(id_local).then(function(local) {

		$scope.local = local;

	});

	$scope.guardar = function () {

		var id = 0;

		LocalesSvc.update($scope.local).then(function(r) {

			// Si se inserto bien en la tabla entro.
					console.log('success');
			if (r.success) {
				id = r.id;

				//if ($scope.uploader.queue.length > 0) {
					console.log('uploading');
					// Subo las imagenes.
					$scope.uploader.uploadAll();					
				//}
				
			} else {
				$window.alert(r.msg);
			}

		});

		// Antes de subir la imagenes les cambio el nombre.
		$scope.uploader.onBeforeUploadItem = function(item) {
			item.alias = id;
		};

		$scope.uploader.onCompleteAll = function() {
					console.log($scope.uploader.queue);
			$state.go('locales.listar');
		}

	}

	$scope.cancelar = function () {

		$state.go('locales.listar');

	}

	$scope.removeImagen = function (imagen) {
		console.log(imagen);

		LocalesSvc.deleteImage(imagen.id_imagen).then(function(r){

			imagen.deleted = true;
			console.log(imagen);
			console.log(r);

		});

	}

	$scope.$on('guardar', function(v) {

		$scope.guardar();

	});

	$scope.$on('cancelar', function(v) {

		$scope.cancelar();

	});

});