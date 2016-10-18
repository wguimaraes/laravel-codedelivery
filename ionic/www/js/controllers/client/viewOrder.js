angular.module('starter.controllers')
.controller('ClientViewOrderCtrl', 
['$scope', '$stateParams', '$ionicLoading', 'Order', '$localStorage',
function($scope, $stateParams, $ionicLoading, Order, $localStorage){
	$scope.order = {};
	$ionicLoading.show({
		template: 'Carregando...'
	});
	Order.get({id: $stateParams.id, include: 'items,cupom'}, function(data){
		$scope.order = data.data;
		$ionicLoading.hide();
	},
	function(){
		$ionicLoading.hide();
	});
	
}])