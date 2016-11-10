angular.module('app', ['ui.router', 'ngMap'])
.config(function ($stateProvider, $urlRouterProvider) {

	$stateProvider
	.state('login', {
		url: '/login',
		templateUrl: 'modules/login/login.html',
		controller:'LoginCtrl'
	})
	.state('usuarios', {
		url: '/usuarios',
		abstract: true,
		templateUrl: 'modules/usuarios/usuarios.html',
		controller:'UsuariosCtrl'
	})
	.state('usuarios.listar', {
		url: '/listar',
		views: {
			'contenido': {
				templateUrl: 'modules/usuarios/listar.html',
				controller: 'UsuariosListarCtrl'
			} 
		}
	})
	.state('usuarios.nuevo', {
		url: '/nuevo',
		views: {
			'contenido': {
				templateUrl: 'modules/usuarios/nuevo.html',
				controller: 'UsuariosNuevoCtrl'
			} 
		}
	})
	.state('usuarios.modificar', {
		url: '/modificar/:id',
		views: {
			'contenido': {
				templateUrl: 'modules/usuarios/modificar.html',
				controller: 'UsuariosModificarCtrl'
			} 
		}
	})

	$urlRouterProvider.otherwise('login');

})
.run(function ($rootScope) {

	$rootScope.APP_NAME = 'Inmobiliaria SRL';

});