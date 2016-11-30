angular.module('app')
.controller('LocalesModificarCtrl', function($scope, $window, $state, $stateParams, 
	LocalesSvc, EncargadosSvc, EmpleadosSvc, FileUploader, $q) {

	var id_local = $stateParams.id;

	$scope.ready = false;
	$scope.local = {
		ofertas: [],
		empleados: [],
		encargado: {}
	};
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

	$scope.encargados = [];
	$scope.empleados = [];
	$scope.selectedEmpleado = null;
	$scope.tab_active = 'encargado';

	// Cargo la info del local.
	LocalesSvc.get(id_local).then(function(local) {

		$scope.local = local;

		// Cargo el listado de encargados para el select.
		var p1 = EncargadosSvc.listWithoutAssign(id_local);

		// Cargo el listado de empleados para el select.
		var p2 = EmpleadosSvc.listWithoutAssign(id_local);

		$q.all([p1, p2]).then(function(data){ 
			$scope.encargados = data[0];
			$scope.empleados = data[1];

			$scope.ready = true;
		});

	});

	$scope.guardar = function () {

		var id = 0;

		LocalesSvc.update($scope.local).then(function(r) {

			// Si se inserto bien en la tabla entro.
			console.log('success');
			if (r.success) {
				id = r.id;

				if ($scope.uploader.queue.length > 0) {
					console.log('uploading');
					// Subo las imagenes.
					$scope.uploader.uploadAll();					
				} else {
					$state.go('locales.listar');
				}
				
			} else {
				$window.alert(r.msg);
			}

		});

		// Antes de subir la imagenes les cambio el nombre.
		$scope.uploader.onBeforeUploadItem = function(item) {
			item.alias = 'locales_' + id;
		};

		$scope.uploader.onCompleteAll = function() {
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

	$scope.agregarEmpleado = function (id_empleado) {

		var empleado = null

		for(var i = 0; i < $scope.empleados.length; i++) {

			if ($scope.empleados[i].id_usuario == id_empleado) {
				empleado = $scope.empleados[i];
				break;
			}

		}

		if (empleado != null) {

			var existe = false;
			var len = $scope.local.empleados.length;
			for(var i = 0; i < len; i++) {

				if ($scope.local.empleados[i].id_usuario == empleado.id_usuario) {
					existe = true;
					break;
				}

			}

			if (!existe) {
				console.log(empleado);
				$scope.local.empleados.push(empleado);
			}
		}
	}

	$scope.removeEmpleado = function (empleado) {

		var index = -1;
		var len = $scope.local.empleados.length;

		for(var i = 0; i < len; i++) {

			if ($scope.local.empleados[i].id_usuario == empleado.id_usuario) {
				index = i;
				break;
			}

		}


		if (index >= 0) {
			$scope.local.empleados.splice(index, 1);
		}

	}

	$scope.$on('guardar', function(v) {

		$scope.guardar();

	});

	$scope.$on('cancelar', function(v) {

		$scope.cancelar();

	});

});