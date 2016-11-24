angular.module('app')
.service('UsuariosSvc', function($http, $q) {

	var base_url = './php/api.php';

	var self = this;

	this.list = function () {
		return $http.post(base_url, {datos: {task: 'listarUsuarios'}}).then(function(r){
			return r.data;
		});
	}

	this.get = function(id) {
		
		return self.list().then(function(usuarios) {

			return usuarios.find(function(obj) {

				return obj.id == id;

			});

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

		return $q(function(resolve, reject) {

			setTimeout(function() {
				resolve(true);
			}, 100);

		});

	}

	this.insert = function(usuario) {

		return $http.post(base_url, {datos: {task: 'agregarUsuario', usuario: usuario}}).then(function(r) {

			return r.data;

		});
		
	}
});