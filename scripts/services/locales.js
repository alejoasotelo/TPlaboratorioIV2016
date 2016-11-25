angular.module('app')

.service('LocalesSvc', function($http, $q, api) {

	var base_url = './';

	var self = this;

	this.list = function () {
		return api.list('locales').then(function(r) {
			return r;
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

		return api.delete('locales', id).then(function(r) {
			console.log(r);
			return r;
		});

	}

	this.insert = function(usuario) {

		return $http.post(base_url, {datos: {task: 'agregarUsuario', usuario: usuario}}).then(function(r) {

			return r.data;

		});
		
	}

});