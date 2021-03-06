angular.module('starter.services')
.factory('$localStorage', ['$window', function($window){
	return {
		set: function(key, value){
			$window.localStorage[key] = value;
			return $window.localStorage[key];
		},
		get: function(key, defaultValue){
			return $window.localStorage[key] || defaultValue;
		},
		setObject: function(key, obj){
			$window.localStorage[key] = JSON.stringify(obj);
			return this.getObject(key);
		},
		getObject: function(key){
			return JSON.parse(($window.localStorage[key] || null)); 
		}
	}
}]);