angular.module('app', ['ui.router', 'ngMap'])
.config(function ($stateProvider, $urlRouterProvider) {

	$stateProvider
	.state('login', {
		url: '/login',
		templateUrl: 'modules/login/login.html',
		controller:'LoginCtrl'
	})

	$urlRouterProvider.otherwise('login');

})
.run(function ($rootScope) {

	$rootScope.APP_NAME = 'ABM';

});