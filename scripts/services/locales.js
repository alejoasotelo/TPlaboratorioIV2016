angular.module('app')

.service('LocalesSvc', function($http, $q) {

	var base_url = './';

	var self = this;

	this.list = function () {
		return $http.get(base_url + 'data.json').then(function(r){
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
});