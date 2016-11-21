angular.module('starter.controllers')
.controller('ClientViewDeliveryCtrl',
['$scope', '$stateParams', '$ionicLoading', 'ClientOrder', '$localStorage', '$ionicPopup', 'UserData',
 '$pusher', '$window', '$map', 'uiGmapGoogleMapApi',
function($scope, $stateParams, $ionicLoading, ClientOrder, $localStorage, $ionicPopup, UserData,
		 $pusher, $window, $map, uiGmapGoogleMapApi){
	$scope.order = {};
	$scope.map = $map;
	$scope.markers = [];
	$ionicLoading.show({
		template: 'Carregando...'
	});
	
	uiGmapGoogleMapApi.then(function(map){
	    //Fazer alguma coisa quando a instância do google maps é totalmente carregada
	}, function(){
	  //Fazer alguma coisa quando ocorre erro ao carregar a instância do google maps
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

	$scope.$watch('markers.length', function(value){
		if(value == 2){
			createBounds();
		}
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
			var iconUrl = 'http://maps.google.com/mapfiles/kml/pal2/';
			var lat = data.geo.lat, long = data.geo.long;
			if($scope.markers.length == 1 || $scope.markers.length == 0){
				$scope.markers.push({
					id: 'entregador',
					coords: {
						latitude: lat,
						longitude: long
					},
					options: {
						title: 'Localização do etregador.',
						icon: iconUrl + 'icon47.png'
					}
				});
				return;
			}

			for(var key in $scope.markers){
				if($scope.markers[key].id == 'entregador'){
					$scope.markers[key].coords = {
							latitude: lat,
							longitude: long
					}
				}
			}
		};
		channel.bind('CodeDelivery\\Events\\GetLocationDeliveryMan', handler);
	};

	function createBounds(){
		var bounds = new google.maps.LatLngBounds(),
			latlng;
		angular.forEach($scope.markers, function(value){
			latlng = new google.maps.LatLng(Number(value.coords.latitude), Number(value.coords.longitude));
			bounds.extend(latlng);
		});
		$scope.map.bounds = {
			northeast: {
				latitude: bounds.getNorthEast().lat(),
				longitude: bounds.getNorthEast().lng()
			},
			southwest: {
				latitude: bounds.getSouthWest().lat(),
				longitude: bounds.getSouthWest().lng()
			}
		};
	}

}])
.controller('CvdControlDescentralize', ['$scope', '$map', function($scope, $map){
  $scope.map = $map;
  $scope.fit = function(){
    $scope.map.fit = !$scope.map.fit;
  }
}])
.controller('CvdControlReload', ['$scope', '$window', '$timeout', function($scope, $window, $timeout){
  $scope.reload = function(){
    $timeout(function () {
      $window.location.reload(true);
    }, 100);
  }
}])
