angular.module('app')
.service('PermisosSvc', function($auth) {

	var Roles = {

		ADMINISTRADOR: {
			page_default: 'locales.listar',
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
			},
			pedidos: {
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true
			},
			estadisticas: {
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true
			}
		},
		ENCARGADO: {
			page_default: 'propiedades.listar',
			usuarios: {
				tipo: {
					empleados: true,
					clientes: true
				},
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true
			},
			ofertas: {
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
			pedidos: {
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true
			}
		},
		EMPLEADO: {
			page_default: 'ofertas.listar',
			usuarios: {
				tipo: {
					clientes: true
				},
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true
			},
			ofertas: {
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true
			},
			pedidos: {
				listar: true
			}
		},
		CLIENTE: {
			page_default: 'ofertas.listar',
			ofertas: {
				listar: true
			},
			encuestas: {
				nuevo: true
			}
		}
	};

	function getUser() {

		return $auth.isAuthenticated() ? $auth.getPayload() : 'undefined';

	}

	this.getUserPageDefault = function() {

		var user = getUser();

		if (typeof user == 'undefined') {
			return 'auth.login';
		} else {
			var tipo = user.tipo.toUpperCase();
			return Roles[tipo].page_default;
		}

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