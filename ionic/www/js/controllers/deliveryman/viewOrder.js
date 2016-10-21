angular.module('starter.controllers')
.controller('DeliveryManViewOrderCtrl', 
['$scope', '$stateParams', '$ionicLoading', 'DeliveryManOrder', '$localStorage', '$cordovaGeolocation',
 '$ionicPopup',
function($scope, $stateParams, $ionicLoading, DeliveryManOrder, $localStorage, $cordovaGeolocation,
		$ionicPopup){
	var watch;
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
	
	$scope.goToDelivery = function(){
		$ionicPopup.alert({
			title: 'Aviso',
			template: 'Para parar a localização aperte Ok'
		}).then(function(){
			stopWatchPostion();
		});
		DeliveryManOrder.updateStatus({id: $stateParams.id, status: 1},function(data){
			var watchOptions = {
					timeOut: 3000,
					enableHighAccuracy: false,
					
			};
			watch = $cordovaGeolocation.watchPosition(watchOptions);
			watch
				.then(null,
					function(errorResponse){
						//Error
					}, function(position){
						DeliveryManOrder.geo({id: $stateParams.id},{
							lat: position.coords.latitude,
							long: position.coords.longitude
						});
					});
		}, function(errorResponse){
			console.log('Errou!');
		});
	}
	
	function stopWatchPostion(){
		if(watch && typeof watch == 'object' && watch.hasOwnProperty('watchID')){
			$cordovaGeolocation.clearWatch(watch.watchID);
		}
	}
}])