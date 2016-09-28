angular.module('starter.controllers')
.controller('ClientCheckoutDetailCtrl', 
['$scope', '$state', '$stateParams', '$cart',
function($scope, $state, $stateParams, $cart){
	$scope.product = $cart.getItem($stateParams.index);
	
	$scope.updateQtd = function(){
		$scope.product.qtd = ($scope.product.qtd < 1 ? 1 : $scope.product.qtd);
		$cart.updateQtd($stateParams.index, $scope.product.qtd);
		$state.go('client.checkout');
	};
	
}])