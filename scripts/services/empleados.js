angular.module('app')
.service('EmpleadosSvc', function($http, UsuariosSvc, api) {

	var base_url = './php/api.php';

	var self = this;

	this.list = function () {

		return api.list('empleados').then(function(r) {

			return r;
			
		});

	}

	this.listWithoutAssign = function (id) {

		return api.listWithoutAssign('empleados', id).then(function(r) {

			return r;
			
		});
	}

	this.get = function(id) {
		
		return api.get('empleados', id).then(function(usuario) {

			return usuario;

		});

	}

	this.delete = function(id) {

		return UsuariosSvc.delete(id).then(function(r) {
			return r;
		});

	}

	this.insert = function(usuario) {

		return UsuariosSvc.insert(usuario).then(function(id) {

			return id;

		});
		
	}

	this.update = function(usuario) {

		return UsuariosSvc.update(usuario).then(function(response) {

			return response;

		});

	}

});