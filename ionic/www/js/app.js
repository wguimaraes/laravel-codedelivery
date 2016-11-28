// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
angular.module('starter.controllers', []);
angular.module('starter.services', []);
angular.module('starter.filters', []);

angular.module('starter', ['ionic', 'ionic.cloud', 'angular-oauth2', 'ngResource', 'starter.controllers',
                           'starter.services', 'ngCordova', 'starter.filters', 'uiGmapgoogle-maps',
                           'pusher-angular'])
.constant('appConfig', {
	baseUrl: 'http://192.168.1.101:8000',
	pusherKey: '5dbe347d07d599a21b3a'
})
.run(function($ionicPlatform, $window, appConfig) {
  $window.client = new Pusher(appConfig.pusherKey);
  $ionicPlatform.ready(function() {
    if(window.cordova && window.cordova.plugins.Keyboard) {
      // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
      // for form inputs)
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);

      // Don't remove this line unless you know what you are doing. It stops the viewport
      // from snapping when text inputs are focused. Ionic handles this internally for
      // a much nicer keyboard experience.
      cordova.plugins.Keyboard.disableScroll(true);
    }
    if(window.StatusBar) {
      StatusBar.styleDefault();
    }
  });
})
.config(['$ionicConfigProvider', '$stateProvider', '$urlRouterProvider', 'OAuthProvider', 'OAuthTokenProvider',
         'appConfig', '$provide', '$ionicCloudProvider',
         function($ionicConfigProvider, $stateProvider, $urlRouterProvider, OAuthProvider, OAuthTokenProvider,
        	  appConfig, $provide, $ionicCloudProvider){
		  $ionicConfigProvider.views.maxCache(0);
		  OAuthProvider.configure({
		      baseUrl: appConfig.baseUrl,
		      clientId: 'appid1',
		      clientSecret: 'secret', // optional
		      grantPath: '/oauth/access_token'
		  });
		  OAuthTokenProvider.configure({
		      name: 'token',
		      options: {
			    secure: false
		      }
		  });
		  
		  $ionicCloudProvider.init({
		  	"core": {
		  	    "app_id": "ea2ddd86"
		  	},
		  	"push": {
		  	    "sender_id": "749443376509",
		  	    "pluginConfig":{
		  		"ios": {
		  		    "badge": true,
		  		    "sound": true
		  		},
		  		"android": {
		  		    "iconColor": "#343434"
			  	}
		  	    }
		  	}
		  });

		$stateProvider
		.state('login',{
			url: '/login',
			templateUrl: 'templates/login.html',
			controller: 'LoginCtrl'
		})
		.state('home',{
			url: '/home',
			templateUrl: 'templates/home.html',
			controller: function($scope){
			}
		})
		.state('client',{
			abstract: true,
			url: '/client',
			templateUrl: 'templates/client/menu.html',
			controller: 'ClientMenuCtrl'
		})
			.state('client.checkout', {
				url: '/checkout',
				templateUrl: 'templates/client/checkout.html',
				controller: 'ClientCheckoutCtrl'
			})
			.state('client.order', {
				url: '/order',
				templateUrl: 'templates/client/order.html',
				controller: 'ClientOrderCtrl'
			})
			.state('client.view_order', {
				url: '/view_order/:id',
				templateUrl: 'templates/client/view_order.html',
				controller: 'ClientViewOrderCtrl'
			})
			.state('client.view_delivery', {
				url: '/view_delivery/:id',
				templateUrl: 'templates/client/view_delivery.html',
				controller: 'ClientViewDeliveryCtrl'
			})
			.state('client.checkout_detail', {
				url: '/checkout/details/:index',
				templateUrl: 'templates/client/checkout_detail.html',
				controller: 'ClientCheckoutDetailCtrl'
			})
			.state('client.checkout_successful', {
				url: '/checkout/successful',
				templateUrl: 'templates/client/checkout_successful.html',
				controller: 'ClientCheckoutSuccessfullCtrl'
			})
			.state('client.view_products', {
				url: '/view/products',
				templateUrl: 'templates/client/view_products.html',
				controller: 'ClientViewProductsCtrl'
			})
		.state('deliveryman', {
			abstract: true,
			url: '/deliveryman',
			templateUrl: 'templates/deliveryman/menu.html',
			controller: 'DeliveryManMenuCtrl'
		})
			.state('deliveryman.order', {
				url: '/order',
				templateUrl: 'templates/deliveryman/order.html',
				controller: 'DeliveryManOrderCtrl'
			})
			.state('deliveryman.view_order', {
				url: '/view_order/:id',
				templateUrl: 'templates/deliveryman/view_order.html',
				controller: 'DeliveryManViewOrderCtrl'
			})
		$urlRouterProvider.otherwise('/login');
			$provide.decorator('OAuthToken', ['$localStorage', '$delegate', function($localStorage, $delegate){
			Object.defineProperties($delegate, {
				setToken: {
					value: function(data){
						return $localStorage.setObject('token', data);
					},
					enumerable:true,
					configurable: true,
					writable: true
				},
				getToken: {
					value: function(){
						return $localStorage.getObject('token');
					},
					enumerable:true,
					configurable: true,
					writable: true
				},
				removeToken: {
					value: function(){
						return $localStorage.setObject('token', null);
					},
					enumerable:true,
					configurable: true,
					writable: true
				},
			});
			return $delegate;
		}]);
	}])
