angular.module('starter.controllers')
.controller('ClientViewProductsCtrl', 
['$scope', '$state', '$ionicLoading', 'Product', '$localStorage', '$cart',
function($scope, $state, $ionicLoading, Product, $localStorage, $cart){
	$scope.products = [];
	$ionicLoading.show({
		template: 'Carregando...'
	});
	Product.query({}, function(data){
		$scope.products = data.data;
		$ionicLoading.hide();
	},
	function(){
		$ionicLoading.hide();
	});
	
	$scope.addItem = function(item){
		item.qtd = 1;
		$cart.addItem(item);
		$state.go('client.checkout',{},{reload: true});
	}
}])