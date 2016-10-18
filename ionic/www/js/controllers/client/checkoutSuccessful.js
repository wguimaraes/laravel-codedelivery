angular.module('starter.controllers')
.controller('ClientCheckoutSuccessfullCtrl', 
['$scope', '$state', '$cart',
function($scope, $state, $cart){
	var cart = $cart.get();
	$scope.items = cart.items;
	$scope.total = $cart.getTotalFinal();
	$scope.cupom = $cart.get().cupom;
	console.log($scope.cupom);
	$cart.clear();
	
	$scope.openListOrder = function(){
		$state.go('client.order');
	};
}])