angular.module('app')

.service('PropiedadesSvc', function($http, $q, api) {

	var base_url = './';

	var self = this;

	this.list = function () {
		return api.list('propiedades').then(function(r) {
			return r;
		});
	}

	this.get = function(id) {
		
		return api.get('propiedades', id).then(function(local) {

			return local;

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

		return api.delete('propiedades', id).then(function(r) {
			console.log(r);
			return r;
		});

	}

	this.insert = function(local) {

		return api.insert('propiedades', local).then(function(id) {

			return id;

		});
		
	}

	this.deleteImage = function (id) {

		return api.delete('imagenes', id).then(function(r) {
			return r;
		});

	}

	this.update = function(local) {

		return api.update('propiedades', local).then(function(response) {

			return response;

		});

	}

});