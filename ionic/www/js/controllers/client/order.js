angular.module('starter.controllers')
.controller('ClientOrderCtrl', 
['$scope', '$state', '$localStorage', '$cart', '$ionicLoading', '$ionicPopup',
 'Order', 'Cupom', 'User',
function($scope, $state, $localStorage, $cart, $ionicLoading, $ionicPopup,
		 Order, Cupom, User){
	$scope.items = [];
	$ionicLoading.show({
		template: 'Carregando...'
	});
	Order.query({id: null}, function(data){
		$scope.items = data.data;
		$ionicLoading.hide();
	},
	function(errorResponse){
		$ionicLoading.hide();
	});
}])