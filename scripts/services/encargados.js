angular.module('app')
.service('EncargadosSvc', function($http, UsuariosSvc, api) {

	var base_url = './php/api.php';

	var self = this;

	this.list = function () {

		return api.list('encargados').then(function(r) {

			return r;
			
		});

	}

	this.get = function(id) {
		
		return api.get('encargados', id).then(function(usuario) {

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