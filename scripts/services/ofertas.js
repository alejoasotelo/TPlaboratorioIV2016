angular.module('app')

.service('OfertasSvc', function($http, $q, api) {

	var base_url = './';

	var self = this;

	this.list = function () {
		return api.list('ofertas').then(function(r) {
			return r;
		});
	}

	this.listByIdLocal = function (id_local) {

		id_local = id_local || 0;

		return self.list().then(function(ofertas) {

			return ofertas.filter(function(oferta, index, _array) {

				return id_local > 0 ? oferta.id_local == id_local : true;

			});

		});
	}

	this.get = function(id) {
		
		return api.get('ofertas', id).then(function(local) {

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

		return api.delete('ofertas', id).then(function(r) {
			console.log(r);
			return r;
		});

	}

	this.deleteImage = function (id) {

		return api.delete('imagenes', id).then(function(r) {
			return r;
		});

	}

	this.insert = function(local) {

		return api.insert('ofertas', local).then(function(id) {

			return id;

		});
		
	}

	this.update = function(local) {

		return api.update('ofertas', local).then(function(response) {

			return response;

		});

	}

});