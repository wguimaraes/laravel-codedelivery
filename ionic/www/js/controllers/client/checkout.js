angular.module('starter.controllers')
.controller('ClientCheckoutCtrl', 
['$scope', '$state', '$localStorage', '$cart',
function($scope, $state, $localStorage, $cart){
	var cart = $cart.get();
	$scope.items = cart.items;
	$scope.total = cart.total;
	
	$scope.removeItem = function(index){
		$cart.removeItem(index);
		$scope.items.splice(index, 1);
		$scope.total = $cart.get().total;
	}
}])