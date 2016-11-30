angular.module('app')
.service('PermisosSvc', function($auth) {

	var Roles = {

		ADMINISTRADOR: {
			ofertas: {
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true
			},
			locales: {
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true
			},
			propiedades: {
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true
			},
			usuarios: {
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true
			}
		},
		ENCARGADO: {
			username: 'encargado', 
			password: 'encargado'
		},
		EMPLEADO: {
			username: 'empleado', 
			password: 'empleado'
		},
		CLIENTE: {
			ofertas: {
				listar: true
			},
			locales: {
				listar: true
			}
		}
	};

	function getUser() {

		return $auth.getPayload();

	}
	
	this.puede = function(state) {
		var user = getUser();
		
		if (typeof user != 'undefined') {
			var tipo = user.tipo.toUpperCase();

			var parts = state.split('.');
			var view = parts[0];
			var task = parts.length > 1 ? parts[1] : false;

			if (task != false) {
				var rol = typeof Roles[tipo][view] == 'undefined' ? false : Roles[tipo][view][task];

				return typeof rol == 'undefined' ? false : rol;

			} else {
				var rol = Roles[tipo][view];

				return typeof rol == 'undefined' ? false : rol;
			}
		} else {
			return false;
		}
	}

});