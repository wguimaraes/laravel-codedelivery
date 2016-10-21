angular.module('starter.controllers')
.controller('ClientViewDeliveryCtrl', 
['$scope', '$stateParams', '$ionicLoading', 'ClientOrder', '$localStorage', '$ionicPopup', 'UserData',
function($scope, $stateParams, $ionicLoading, ClientOrder, $localStorage, $ionicPopup, UserData){
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
			initMarkers();
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
	
	function initMarkers(){
		var client = UserData.get('user').client.data;
		var address = client.zipcode + ', ' + client.address + ', ' + 
					  client.city + ' - ' + client.state;
		createMarkerClient(address);
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
	
}])