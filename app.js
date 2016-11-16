angular.module('app', ['ui.router', 'ngMap', 'satellizer'])
.config(function ($stateProvider, $urlRouterProvider, $authProvider) {

	$authProvider.loginUrl = '/lab4/TPlaboratorioIV2016/php/auth.php';
	$authProvider.tokenName = 'token_lab4';
	$authProvider.tokenPrefix = 'App';
	$authProvider.authHeader = 'data';

	$stateProvider
	.state('auth', {
		url: '/auth',
		abstract: true,
		templateUrl: 'modules/auth/auth.html',
		controller:'AuthCtrl'
	})
	.state('auth.login', {
		url: '/login',
		views: {
			'contenido': {
				templateUrl: 'modules/auth/login.html',
				controller:'AuthLoginCtrl'	
			} 
		}
	})
	.state('auth.register', {
		url: '/register',
		views: {
			'contenido': {
				templateUrl: 'modules/auth/register.html',
				controller:'AuthRegisterCtrl'	
			} 
		}
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

	$urlRouterProvider.otherwise('auth/login');

})
.run(function ($rootScope) {

	$rootScope.APP_NAME = 'Inmobiliaria SRL';

});