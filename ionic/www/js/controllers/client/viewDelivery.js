angular.module('starter.controllers')
.controller('ClientViewDeliveryCtrl', 
['$scope', '$stateParams', '$ionicLoading', 'ClientOrder', '$localStorage', '$ionicPopup', 'UserData',
 '$pusher', '$window',
function($scope, $stateParams, $ionicLoading, ClientOrder, $localStorage, $ionicPopup, UserData,
		 $pusher, $window){
	$scope.order = {};
	$scope.map = {
		center: {
			latitude: -30.0806133,
			longitude: -51.1729395
		},
		zoom: 16
	};
	$scope.markers = [];
	$ionicLoading.show({
		template: 'Carregando...'
	});
	ClientOrder.get({id: $stateParams.id, include: 'items,cupom'}, function(data){
		$scope.order = data.data;
		if($scope.order.status == 1){
			initMarkers($scope.order);
		}else{
			$ionicPopup.alert({
				title: 'Advertência',
				template: 'Pedido não está em status de entrega.'
			});
		}
		$ionicLoading.hide();
	},
	function(){
		$ionicLoading.hide();
	});
	
	function initMarkers(order){
		var client = UserData.get('user').client.data;
		var address = client.zipcode + ', ' + client.address + ', ' + 
					  client.city + ' - ' + client.state;
		createMarkerClient(address);
		watchPositionDeliveryMan(order.hash);
	};
	function createMarkerClient(address){
		var geoCoder = new google.maps.Geocoder();
		var iconUrl = 'http://maps.google.com/mapfiles/kml/pal2/';
		geoCoder.geocode({
				address: address
			}, function(results, status){
				if(status == google.maps.GeocoderStatus.OK){
					var lat = results[0].geometry.location.lat(),
						long = results[0].geometry.location.lng();
					$scope.markers.push({
						id: 'client',
						coords: {
							latitude: lat,
							longitude: long
						},
						options: {
							title: 'Local de entrega.',
							icon: iconUrl + 'icon2.png'
						}
					});
				}else{
					$ionicPopup.alert({
						title: 'Advertência',
						template: 'Endereço não encontrado.'
					});
				}
			});
		
	};
	
	function watchPositionDeliveryMan(channel){
		var pusher = $pusher($window.client),
			channel = pusher.subscribe(channel);
		var handler = function(data){
			console.log(data);
		};
		channel.bind('CodeDelivery\\Events\\GetLocationDeliveryMan', handler);
	}
	
}])