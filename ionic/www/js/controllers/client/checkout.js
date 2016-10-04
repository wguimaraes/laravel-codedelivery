angular.module('starter.controllers')
.controller('ClientCheckoutCtrl', 
['$scope', '$state', '$localStorage', '$cart', '$ionicLoading', '$ionicPopup', 'Order', 'Cupom',
function($scope, $state, $localStorage, $cart, $ionicLoading, $ionicPopup, Order, Cupom){
	var cart = $cart.get();
	$scope.cupom = cart.cupom;
	$scope.items = cart.items;
	$scope.total = $cart.getTotalFinal();
	
	$scope.removeItem = function(index){
		$cart.removeItem(index);
		$scope.items.splice(index, 1);
		$scope.total = $cart.getTotalFinal();
	};
	
	$scope.openProductDetail = function(i){
		$state.go('client.checkout_detail', {index: i});
	};
	
	$scope.openListProducts = function(){
		$state.go('client.view_products');
	}
	
	$scope.save = function(){
		var o = {items: angular.copy($scope.items)};
		
		angular.forEach(o.items, function(item){
			item.product_id = item.id;
		});
		$ionicLoading.show({
			template: 'Salvando pedido...'
		});
		
		if($scope.cupom.value){
			o.cupom_code = $scope.cupom.code;
		}
		
		Order.save({id: null}, o, function(data){
			$ionicLoading.hide();
			$state.go('client.checkout_successful');
		}, function(responseError){
			$ionicLoading.hide();
			$ionicPopup.alert({
				title: 'Advertência',
				template: 'Erro, pedido não realizado.'
			});
		});
		
	};
	
	$scope.readBarCode = function(){
		getValueCupom(1589);
	};
	
	$scope.removeCupom = function(){
		$cart.removeCupom();
		$scope.cupom = $cart.get().cupom;
		$scope.total = $cart.getTotalFinal();
	};
	
	function getValueCupom(code){
		$ionicLoading.show({
			template: 'Carregando...'
		});
		var cupom = Cupom.get({code: code},function(data){
			$ionicLoading.hide();
			$cart.setCupom(data.data.code, data.data.value);
			$scope.cupom = $cart.get().cupom;
			$scope.total = $cart.getTotalFinal();
		},function(responseError){
			$ionicLoading.hide();
			$ionicPopup.alert({
				title: 'Advertência',
				template: 'Cupom não encontrado.'
			});
		});
	};
	
}])