angular.module('app', ['ui.router', 'ngMap', 'satellizer', 'angularFileUpload', 'ngSanitize'])

.constant('BASE_URL', '/lab4/tp/php')

.config(function (BASE_URL, $stateProvider, $urlRouterProvider, $authProvider) {

	$authProvider.loginUrl = BASE_URL + '/auth.php';
	$authProvider.tokenName = 'token_lab4';
	$authProvider.tokenPrefix = 'App';
	$authProvider.authHeader = 'data';

	$stateProvider
	.state('auth', {
		url: '/auth',
		abstract: true,
		templateUrl: 'scripts/modules/auth/auth.html' + nocache,
		controller:'AuthCtrl'
	})
	.state('auth.login', {
		url: '/login',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/auth/login.html' + nocache,
				controller:'AuthLoginCtrl'	
			} 
		}
	})
	.state('auth.register', {
		url: '/register',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/auth/register.html' + nocache,
				controller:'AuthRegisterCtrl'	
			} 
		}
	})

	// Usuarios
	.state('usuarios', {
		url: '/usuarios',
		abstract: true,
		templateUrl: 'scripts/modules/usuarios/usuarios.html' + nocache,
		controller:'UsuariosCtrl'
	})
	.state('usuarios.listar', {
		url: '/listar',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/usuarios/listar.html' + nocache,
				controller: 'UsuariosListarCtrl'
			} 
		}
	})
	.state('usuarios.nuevo', {
		url: '/nuevo',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/usuarios/nuevo.html' + nocache,
				controller: 'UsuariosNuevoCtrl'
			} 
		}
	})
	.state('usuarios.modificar', {
		url: '/modificar/:id',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/usuarios/modificar.html' + nocache,
				controller: 'UsuariosModificarCtrl'
			} 
		}
	})
	.state('usuarios.local', {
		url: '/local/:id',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/usuarios/local.html' + nocache,
				controller: 'UsuariosLocalCtrl'
			} 
		}
	})

	// Locales
	.state('locales', {
		url: '/locales',
		abstract: true,
		templateUrl: 'scripts/modules/locales/locales.html' + nocache,
		controller: 'LocalesCtrl'
	})
	.state('locales.listar', {
		url: '/listar',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/locales/listar.html' + nocache,
				controller: 'LocalesListarCtrl'
			} 
		}
	})
	.state('locales.nuevo', {
		url: '/nuevo',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/locales/nuevo.html' + nocache,
				controller: 'LocalesNuevoCtrl'
			} 
		}
	})
	.state('locales.modificar', {
		url: '/modificar/:id',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/locales/modificar.html' + nocache,
				controller: 'LocalesModificarCtrl'
			} 
		}
	})

	// Ofertas
	.state('ofertas', {
		url: '/ofertas',
		abstract: true,
		templateUrl: 'scripts/modules/ofertas/ofertas.html' + nocache,
		controller: 'OfertasCtrl'
	})
	.state('ofertas.listar', {
		url: '/listar',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/ofertas/listar.html' + nocache,
				controller: 'OfertasListarCtrl'
			} 
		}
	})
	.state('ofertas.nuevo', {
		url: '/nuevo',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/ofertas/nuevo.html' + nocache,
				controller: 'OfertasNuevoCtrl'
			} 
		}
	})
	.state('ofertas.modificar', {
		url: '/modificar/:id',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/ofertas/modificar.html' + nocache,
				controller: 'OfertasModificarCtrl'
			} 
		}
	})
	.state('ofertas.ver', {
		url: '/ver/:id',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/ofertas/ver.html' + nocache,
				controller: 'OfertasVerCtrl'
			} 
		}
	})

	// Propiedades
	.state('propiedades', {
		url: '/propiedades',
		abstract: true,
		templateUrl: 'scripts/modules/propiedades/propiedades.html' + nocache,
		controller: 'PropiedadesCtrl'
	})
	.state('propiedades.listar', {
		url: '/listar',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/propiedades/listar.html' + nocache,
				controller: 'PropiedadesListarCtrl'
			} 
		}
	})
	.state('propiedades.nuevo', {
		url: '/nuevo',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/propiedades/nuevo.html' + nocache,
				controller: 'PropiedadesNuevoCtrl'
			} 
		}
	})
	.state('propiedades.modificar', {
		url: '/modificar/:id',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/propiedades/modificar.html' + nocache,
				controller: 'PropiedadesModificarCtrl'
			} 
		}
	})
	.state('propiedades.ver', {
		url: '/ver/:id',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/propiedades/ver.html' + nocache,
				controller: 'PropiedadesVerCtrl'
			} 
		}
	})

	// Ventas & Alquileres
	.state('ventas_alquileres', {
		url: '/ventas_alquileres',
		abstract: true,
		templateUrl: 'scripts/modules/ventas_alquileres/ventas_alquileres.html' + nocache,
		controller: 'VentasAlquileresCtrl'
	})
	.state('ventas_alquileres.listar', {
		url: '/listar',
		views: {
			'contenido': {
				templateUrl: 'scripts/modules/ventas_alquileres/listar.html' + nocache,
				controller: 'VentasAlquileresListarCtrl'
			} 
		}
	})	

	$urlRouterProvider.otherwise('auth/login');

})
.run(function ($rootScope, $location, $state, $auth, PermisosSvc) {

	$rootScope.APP_NAME = 'Inmobiliaria SRL';	

	$rootScope.page = $state.current.name;

	$rootScope.$on('$locationChangeStart', function (event, next, current) {

		var nextPath = $location.path();
		var parts = nextPath.substr(1, nextPath.length-1).split('/');
		var module = parts[0];
		var view = parts.length > 1 ? parts[1] : null;
		var id = parts.length > 2 ? parts[2] : null;

		if ($auth.isAuthenticated()) {

			//$rootScope.isAuthenticated = true;
			$rootScope.user = $auth.getPayload();

			if (!PermisosSvc.puede(module+'.'+view+'.'+id)) {
				event.preventDefault();

				var page_default = PermisosSvc.getUserPageDefault();
				$state.go(page_default);
			}

		} else {

			//$rootScope.isAuthenticated = false;
			$rootScope.user = 'undefined';

			console.log(module + '.' + view);
			var state = module + '.' + view;
			if (state != 'auth.login' && state != 'auth.register') {
				$state.go('auth.login');
			}

		}

	});

});