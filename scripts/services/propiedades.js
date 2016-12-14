angular.module('app')

.service('PropiedadesSvc', function($http, $q, api) {

	var base_url = './';

	var self = this;

	this.list = function (tipo) {

		tipo = tipo || 0;

		return api.list('propiedades', tipo).then(function(r) {
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

	this.listByIdLocal = function(id_local) {

		return self.list().then(function(propiedades) {

			return propiedades.filter(function(propiedad, index, _array) {

				return propiedad.id_local == id_local;

			});

		});

	}

	this.listAndExcludeById = function (id_propiedad) {

		return self.list().then(function(propiedades) {

			return propiedades.filter(function(propiedad, index, _array) {

				return propiedad.id_propiedad != id_propiedad;

			});

		});

	}

});