angular.module('app')
.controller('LocalesNuevoCtrl', function($scope, $state, $window, LocalesSvc, FileUploader) {

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

	$scope.guardar = function () {

		var id = 0;

		LocalesSvc.insert($scope.local).then(function(r) {

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
			item.alias = id;
		};

		$scope.uploader.onCompleteAll = function() {
			$state.go('locales.listar');
		}

	}

	$scope.cancelar = function () {

		$state.go('locales.listar');

	}

	$scope.$on('guardar', function(v) {

		$scope.guardar();

	});

	$scope.$on('cancelar', function(v) {

		$scope.cancelar();

	});

});