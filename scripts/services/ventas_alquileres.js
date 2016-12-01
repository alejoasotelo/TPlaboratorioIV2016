angular.module('app')

.service('VentasAlquileresSvc', function($http, $q, api) {

	var self = this;

	this.list = function () {
		return api.list('ventas_alquileres').then(function(r) {
			return r;
		});
	}

	this.listByUser = function (id) {
		return api.listByUser('ventas_alquileres', id).then(function(r) {
			return r;
		});

	}

	this.get = function(id) {
		
		return api.get('ventas_alquileres', id).then(function(local) {

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

		return api.delete('ventas_alquileres', id).then(function(r) {
			console.log(r);
			return r;
		});

	}

	this.insert = function(venta_alquiler) {

		return api.insert('ventas_alquileres', venta_alquiler).then(function(id) {

			return id;

		});
		
	}

	this.update = function(venta_alquiler) {

		return api.update('ventas_alquileres', venta_alquiler).then(function(response) {

			return response;

		});

	}

});