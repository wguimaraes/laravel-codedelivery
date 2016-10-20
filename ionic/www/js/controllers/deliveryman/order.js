angular.module('starter.controllers')
.controller('DeliveryManOrderCtrl', 
['$scope', '$state', '$localStorage', '$cart', '$ionicLoading', '$ionicPopup',
 'DeliveryManOrder', 'Cupom', 'User',
function($scope, $state, $localStorage, $cart, $ionicLoading, $ionicPopup,
		DeliveryManOrder, Cupom, User){
	$scope.items = [];
	$ionicLoading.show({
		template: 'Carregando...'
	});
	
	$scope.doRefresh = function(){
		getOrders().then(function(data){
			$scope.items = data.data;
			$scope.$broadcast('scroll.refreshComplete');
		}, function(errorResponse){
			$scope.$broadcast('scroll.refreshComplete');
		});
	};
	
	$scope.openOrderDetail = function(order){
		$state.go('deliveryman.view_order', {id: order.id});
	};
	
	function getOrders(){
		return DeliveryManOrder.query({
				id: null,
				orderBy: 'created_at',
				sortedBy: 'desc'
			}).$promise;
	};
	getOrders().then(function(data){
		$scope.items = data.data;
		$ionicLoading.hide();
	},
	function(errorResponse){
		$ionicLoading.hide();
	});
}])