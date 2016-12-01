angular.module('app')
.service('PermisosSvc', function($auth) {

	var Roles = {

		ADMINISTRADOR: {
			page_default: 'locales.listar',
			ver_usuarios_tipo: 'todos',
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
				cambiar_estado: true,
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
			ver_usuarios_tipo: 'empleado,cliente',
			usuarios: {
				tipo: {
					empleados: true,
					clientes: true
				},
				cambiar_estado: true,
				listar: true,
				nuevo: true,
				modificar: true,
				eliminar: true,
				local: true
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
			ver_usuarios_tipo: 'cliente',
			usuarios: {
				tipo: {
					clientes: true
				},
				cambiar_estado: false,
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
			ver_usuarios_tipo: 'ninguno',
			ofertas: {
				listar: true
			},
			encuestas: {
				nuevo: true
			},
			propiedades: {
				listar: true,
				ver: true
			},
			ventas_alquileres: {
				listar: true
			}
		}
	};

	function getUser() {

		return $auth.isAuthenticated() ? $auth.getPayload() : undefined;

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


	// Devuelve los tipos de usuarios que puede ver el usuario logueado.
	this.getTiposDeUsuariosAVer = function() {

		var user = getUser();

		if (typeof user != 'undefined') {

			return Roles[user.tipo.toUpperCase()].ver_usuarios_tipo;

		} else {
			return '';
		}

	}

	// Devuelve true o false si el usuario puede ver el "tipo" de usuario.
	this.puedeVerTiposDeUsuario = function(tipo) {

		var user = getUser();

		if (typeof user != 'undefined') {

			return Roles[user.tipo.toUpperCase()].ver_usuarios_tipo.indexOf(tipo) >= 0;

		} else {
			return false
		}

	}

	this.puedeCambiarEstado = function() {

		var user = getUser();

		if (typeof user != 'undefined') {

			return Roles[user.tipo.toUpperCase()].usuarios.cambiar_estado;

		} else {
			return false
		}

	}

});