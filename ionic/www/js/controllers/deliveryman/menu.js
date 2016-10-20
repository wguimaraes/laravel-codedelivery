angular.module('starter.controllers')
.controller('DeliveryManMenuCtrl', 
['$scope', '$state', 'UserData',
 function($scope, $state, UserData){
	$scope.user = UserData.get();
 }])