angular.module('starter.controllers')
.controller('LoginCtrl', ['$scope', '$rootScope', 'OAuth', 'OAuthToken', '$state', '$ionicPopup', 'UserData', 'User', '$ionicPush', '$localStorage',
function($scope, $rootScope, OAuth, OAuthToken, $state, $ionicPopup, UserData, User, $ionicPush, $localStorage){
	$scope.user = {
		username: '',
		password: ''
	};
	
	$ionicPush.register().then(function(t) {
	    return $ionicPush.saveToken(t);
	  }).then(function(t) {
	      $localStorage.set('device_token', t.token);
	  });
	
	$rootScope.$on('cloud:push:notification', function(event, data) {
	    var msg = data.message;
	    alert(msg.title + ': ' + msg.text);
	  });
	
	$scope.login = function(){
		var promise = OAuth.getAccessToken($scope.user);
		promise
			.then(
			function(data){
				return User.updateDeviceToken({}, {device_token: $localStorage.get('device_token')}).$promisse;
			})
			.then(
			function(data){
				return User.authenticated({include: 'client'}).$promise;
			})
			.then(function(data){
				UserData.set(data.data);
				if(UserData.get().role == 'deliveryman'){
					$state.go('deliveryman.order');
				}else{
					$state.go('client.view_products');
				}
			}, function(responseError){
				UserData.set(null);
				OAuthToken.removeToken();
				$ionicPopup.alert({
					title: 'Advertência',
					template: 'Login e/ou senha inválidos.'
				});
			});
	};
}])