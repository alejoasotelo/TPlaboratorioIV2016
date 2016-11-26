function configureTemplateFactory($provide) {
    // Set a suffix outside the decorator function 
    var cacheBuster = Date.now().toString();

    function templateFactoryDecorator($delegate) {
        var fromUrl = angular.bind($delegate, $delegate.fromUrl);
        $delegate.fromUrl = function (url, params) {
            if (url !== null && angular.isDefined(url) && angular.isString(url)) {
                url += (url.indexOf("?") === -1 ? "?" : "&");
                url += "v=" + cacheBuster;
            }

            return fromUrl(url, params);
        };

        return $delegate;
    }

    $provide.decorator('$templateFactory', ['$delegate', templateFactoryDecorator]);
}


angular.module('app', ['ui.router', 'ngMap', 'satellizer', 'angularFileUpload'])

.constant('BASE_URL', '/lab4/tp/php')

.config(function (BASE_URL, $provide, $stateProvider, $urlRouterProvider, $authProvider) {

	configureTemplateFactory($provide);

	$authProvider.loginUrl = BASE_URL + '/auth.php';
	$authProvider.tokenName = 'token_lab4';
	$authProvider.tokenPrefix = 'App';
	$authProvider.authHeader = 'data';

	$stateProvider
	.state('auth', {
		url: '/auth',
		abstract: true,
		templateUrl: 'scripts/modules/auth/auth.html',
		controller:'AuthCtrl'
	})
	.state('auth.login', {
		url: '/login',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/auth/login.html',
				controller:'AuthLoginCtrl'	
			} 
		}
	})
	.state('auth.register', {
		url: '/register',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/auth/register.html',
				controller:'AuthRegisterCtrl'	
			} 
		}
	})

	// Usuarios
	.state('usuarios', {
		url: '/usuarios',
		abstract: true,
		templateUrl: 'scripts/modules/usuarios/usuarios.html',
		controller:'UsuariosCtrl'
	})
	.state('usuarios.listar', {
		url: '/listar',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/usuarios/listar.html',
				controller: 'UsuariosListarCtrl'
			} 
		}
	})
	.state('usuarios.nuevo', {
		url: '/nuevo',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/usuarios/nuevo.html',
				controller: 'UsuariosNuevoCtrl'
			} 
		}
	})
	.state('usuarios.modificar', {
		url: '/modificar/:id',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/usuarios/modificar.html',
				controller: 'UsuariosModificarCtrl'
			} 
		}
	})

	// Locales
	.state('locales', {
		url: '/locales',
		abstract: true,
		templateUrl: 'scripts/modules/locales/locales.html',
		controller: 'LocalesCtrl'
	})
	.state('locales.listar', {
		url: '/listar',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/locales/listar.html',
				controller: 'LocalesListarCtrl'
			} 
		}
	})
	.state('locales.nuevo', {
		url: '/nuevo',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/locales/nuevo.html',
				controller: 'LocalesNuevoCtrl'
			} 
		}
	})
	.state('locales.modificar', {
		url: '/modificar/:id',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/locales/modificar.html',
				controller: 'LocalesModificarCtrl'
			} 
		}
	})

	$urlRouterProvider.otherwise('auth/login');

})
.run(function ($rootScope) {

	$rootScope.APP_NAME = 'Inmobiliaria SRL';

});