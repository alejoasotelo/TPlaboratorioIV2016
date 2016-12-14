angular.module('app')

.factory('api', function(BASE_URL, $http) {

	var base_url = BASE_URL + '/api.php';

	return {

		setBaseUrl: function(url) {
			base_url = url;
		},

		list: function (endpoint, param) {

			param = param || null;

			return $http.post(base_url, {
				datos: {
					endpoint: endpoint,
					task: 'listar',
					param: param
				}
			}).then(function(r){

				return r.data;

			});

		},

		listByUser: function (endpoint, id) {

			return $http.post(base_url, {
				datos: {
					endpoint: endpoint,
					task: 'listarPorIdUsuario',
					id: id
				}
			}).then(function(r){

				return r.data;

			});

		},

		listWithoutAssign: function (endpoint, id) {

			return $http.post(base_url, {
				datos: {
					endpoint: endpoint,
					task: 'listarSinAsignar',
					id: id
				}
			}).then(function(r){

				return r.data;

			});

		},

		get: function(endpoint, id) {

			return $http.post(base_url, {
				datos: {
					endpoint: endpoint,
					task: 'get',
					id: id
				}
			}).then(function(r) {

				return r.data;

			});

		},

		insert: function (endpoint, obj) {

			return $http.post(base_url, {
				datos: {
					endpoint: endpoint,
					task: 'insert',
					object: obj
				}
			}).then(function(r){

				return r.data;

			});
		},

		update: function (endpoint, obj) {

			return $http.post(base_url, {
				datos: {
					endpoint: endpoint,
					task: 'update',
					object: obj
				}
			}).then(function(r) {

				return r.data;

			});

		},

		delete: function (endpoint, id) {

			return $http.post(base_url, {
				datos: {
					endpoint: endpoint,
					task: 'delete',
					id: id
				}
			}).then(function(r){

				return r.data;

			});

		},

		changeState: function (endpoint, id, state) {

			return $http.post(base_url, {
				datos: {
					endpoint: endpoint,
					task: 'changeState',
					id: id,
					state: state
				}
			}).then(function(r){

				return r.data;

			});

		}


	}

});