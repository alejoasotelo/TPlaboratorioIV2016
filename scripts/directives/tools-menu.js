angular.module('app')

.directive('toolsMenu', function() {

	return {
		restrict: 'E',
		templateUrl: 'scripts/directives/tools-menu.html' + nocache,
		scope: {
			modulo: '@modulo',
			vista: '@vista'
		},
		controller: function ($scope, PermisosSvc, $window) {
			$scope.Permisos = PermisosSvc;

			$scope.modificar = function () {
				$scope.$emit('modificar', '');
			}

			$scope.eliminar = function () {
				$scope.$emit('eliminar', '');
			}

			$scope.cancelar = function () {
				$scope.$emit('cancelar', '');
			}

			$scope.guardar = function () {
				$scope.$emit('guardar', '');
			}

			$scope.exportPDF = function() {

				var table = $('#table');

				if (table.find('tbody tr').length > 0) {
					domtoimage.toPng(table[0]).then(function (dataUrl) {
						console.log(dataUrl);
						var docDefinition = {
							content: [{
								image: dataUrl,
								width: 500,
							}]
						};
						pdfMake.createPdf(docDefinition).download("lista.pdf");
					})
					.catch(function (error) {
						console.error('Error al exportar PDF.', error);
					});

				} else {
					$window.alert('No hay datos para exportar.');
				}				
			}

			$scope.exportExcel = function () {

				var table = $('#table');

				if (table.find('tbody tr').length > 0) {
					$('#table').tableExport({type:'excel', escape:'false', ignoreColumn:'[0,6]'});
				} else {
					$window.alert('No hay datos para exportar.');
				}
			}

		}
	}
	
});