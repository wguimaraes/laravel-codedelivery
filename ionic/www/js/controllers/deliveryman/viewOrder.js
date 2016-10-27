angular.module('starter.controllers')
.controller('DeliveryManViewOrderCtrl', 
['$scope', '$stateParams', '$ionicLoading', 'DeliveryManOrder', '$localStorage', '$cordovaGeolocation',
 '$ionicPopup',
function($scope, $stateParams, $ionicLoading, DeliveryManOrder, $localStorage, $cordovaGeolocation,
		$ionicPopup){
	var watch, lat = null, long;
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
						if(!lat){
							lat = position.coords.latitude;
							long = position.coords.longitude;
						}else{
							lat -= 0.0001;
						}
						DeliveryManOrder.geo({id: $stateParams.id},{
							lat: lat,
							long: long
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