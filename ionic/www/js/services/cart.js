angular.module('starter.services')
.service('$cart', ['$localStorage', function($localStorage){
	var key = 'cart', carAux = $localStorage.getObject(key);
	
	if(!carAux){
		initCart();
	}
	
	this.clear = function(){
		initCart();
	};
	this.get = function(){
		return $localStorage.getObject(key);
	};
	
	this.getItem = function(index){
		return this.get().items[index];
	};
	
	this.addItem = function(item){
		var cart = this.get(), itemAux, exists = false;
		for(var index in cart.items){
			itemAux = cart.items[index];
			if(itemAux.id == item.id){
				itemAux.qtd = parseInt(itemAux.qtd) + item.qtd;
				itemAux.subtotal = calculateSubTotal(itemAux);
				exists = true;
				break;
			}
		}
		
		if(!exists){
			item.subtotal = calculateSubTotal(item);
			cart.items.push(item);
		}
		cart.total = getTotal(cart.items);
		$localStorage.setObject(key, cart);
	};
	
	this.setCupom = function(code, value){
		var cart = this.get();
		cart.cupom = {code: code, value: value};
		$localStorage.setObject(key, cart);
	};
	
	this.removeCupom = function(){
		var cart = this.get();
		cart.cupom = {code: null, value: null};
		$localStorage.setObject(key, cart);
	};
	
	this.removeItem = function(index){
		var cart = this.get();
		cart.items.splice(index, 1);
		cart.total = getTotal(cart.items);
		$localStorage.setObject(key, cart);
	};
	
	this.updateQtd = function(index, qtd){
		var cart = this.get(), itemAux = cart.items[index];
		itemAux.qtd = qtd;
		itemAux.subtotal = calculateSubTotal(itemAux);
		cart.total = getTotal(cart.items);
		$localStorage.setObject(key, cart);
	}
	
	function calculateSubTotal(item){
		return item.price * item.qtd;
	};
	
	function getTotal(items){
		var sum = 0;
		angular.forEach(items,function(item){
			sum += item.subtotal;
		});
		return sum;
	};
	
	this.getTotalFinal = function(){
		var cart = this.get();
		return cart.total - (cart.cupom.value || 0);
	}
	
	function initCart(){
		$localStorage.setObject(key, {
			items: [],
			total: 0,
			cupom: {
				code: null,
				value: null
			}
		});
	};
	
}])