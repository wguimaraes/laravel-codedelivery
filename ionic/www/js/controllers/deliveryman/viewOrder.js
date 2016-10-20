angular.module('starter.controllers')
.controller('DeliveryManViewOrderCtrl', 
['$scope', '$stateParams', '$ionicLoading', 'DeliveryManOrder', '$localStorage',
function($scope, $stateParams, $ionicLoading, DeliveryManOrder, $localStorage){
	$scope.order = {};
	$ionicLoading.show({
		template: 'Carregando...'
	});
	DeliveryManOrder.get({id: $stateParams.id, include: 'items,cupom'}, function(data){
		$scope.order = data.data;
		$ionicLoading.hide();
	},
	function(){
		$ionicLoading.hide();
	});
	
}])