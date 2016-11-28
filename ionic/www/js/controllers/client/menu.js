angular.module('starter.controllers')
.controller('ClientMenuCtrl', 
['$scope', '$state', 'UserData', '$localStorage',
 function($scope, $state, UserData, $localStorage){
 	$scope.user = UserData.get();
 	
 	$scope.logout = function(){
 	    $localStorage.setObject('user', null);
 	   $localStorage.setObject('token', null);
 	    $state.go('login');
 	}
 }])