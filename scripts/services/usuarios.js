angular.module('app')
.service('UsuariosSvc', function($http, $q, api) {

	var base_url = './php/api.php';

	var self = this;

	this.list = function () {
		return api.list('usuarios').then(function(r) {
			return r;
		});
	}

	this.get = function(id) {
		
		return api.get('usuarios', id).then(function(usuario) {

			return usuario;

		});

	}

	this.getBy = function(field, value) {

		return self.list().then(function(usuarios) {

			return usuarios.find(function(obj) {

				return obj[field] == value;

			});

		});

	}

	this.delete = function(id) {

		return api.delete('usuarios', id).then(function(r) {
			return r;
		});

	}

	this.insert = function(usuario) {

		return api.insert('usuarios', usuario).then(function(id) {

			return id;

		});
		
	}

	this.update = function(usuario) {

		return api.update('usuarios', usuario).then(function(response) {

			return response;

		});

	}

});