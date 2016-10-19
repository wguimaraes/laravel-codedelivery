angular.module('starter.controllers')
.controller('DeliveryManMenuCtrl', 
['$scope', '$state', '$ionicLoading', 'User',
function($scope, $state, $ionicLoading, User){
	$ionicLoading.show({
		template: 'Carregando...'
	});
	$scope.user = {
		name: ''
	};
	User.authenticated({}, function(data){
		$scope.user = data.data;
		$ionicLoading.hide();
	}, function(errorResponse){
		$ionicLoading.hide();
	});
}])