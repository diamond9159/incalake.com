//console.warn("config.min.js loaded successfully");
/*
*	object  = {
*		item 	 : item_name,
*		quantity : quantity,
*		price 	 : Unit_price,		
*	};
*/
"use strict";
class Item{
	constructor(){
		this._data      	   = [];
		this._discuontRate 	   = 0;
		this._discuontAmount   = 0;
		this._feesTaxRate      = 0;
		this._feesTaxAmount    = 0;
		this._totalPrice       = 0;
		this._totalPriceString = '';
	}

	set data(object){
		if ( typeof object === "object" ) {
			object.forEach((value,index)=>{
				this._data.push(value);
				this._totalPrice += (parseFloat(value.price)*parseFloat(value.quantity));
			});
		}else{
			console.error("config.min.js: The argument isn't a valid array or object, please check");
		}
	}

	set discountRate(rate){ this._discuontRate = rate; }
	set discountAmount(amount){ this._discuontAmount = amount; }
	set feesTaxRate(rate){ this._feesTaxRate = rate; }
	set feesTaxAmount(amount){ this._feestaxAmount = amount; }
	set totalPrice(price){ this._totalPrice  = price; }

	get discountRate(){ return this._discuontRate; }
	get discountAmount(){ return this._discuontAmount; }
	get feesTaxRate(){ return this._feesTaxRate; }
	get feesTaxAmount(){ return this._feestaxAmount; }
	get totalPrice(){ return this._totalPrice; }
	get totalDiscountRate(){ return (( parseFloat(this._totalPrice)*parseFloat(this._discuontRate) )/100); }	
	get totalDiscountAmount(){ return ( (parseFloat(this._totalPrice)) - (this._discuontAmount) ); }
	get totalFeesTaxRate(){ return (( parseFloat(this._totalPrice)*parseFloat(this._feesTaxRate) )/100); }	
	get totalFeesTaxAmount(){ return ( (parseFloat(this._totalPrice)) - (this._feesTaxAmount) ); }
	get data(){return this._data;}
	get clearItem(){ this._data.length=0; return true;}
};

class ConfigPaypal extends Item{
	constructor (){
		super();
		this._urlTransaction    = ''; //https://www.sandbox.paypal.com/cgi-bin/webscr
		this._emailBusiness  	= ''; // Email de Cuenta Paypal al cual se depositará
		this._currencyCode 		= 'USD'; // USD, PEN
		this._shoppingUrl 		= ''; // https://incalake.com/paypal-cart.php
		this._returnUrl			= ''; // https://incalake.com/paypal-payment.php
		this._cancelReturnUrl   = ''; // https://incalake.com/paypal-error.php
		this._notifyUrl			= ''; // https://incalake.com/paypal-notification.php
		this._imagenUrl		    = 'https://shop.incalake.com/img/logo-150x50.png'; // https://shop.incalake.com/img/logo-150x50.png
		this._idPaypalForm      = '';

		this._taxCart 					= 0;
		this._totalDiscountAmountCart	= 0;
		this._totalDiscountRateCart  	= 0;

		this._language					= 'EN';
		this._feestaxAmountCart 		= 0;
		this._feesTaxRateCart 			= 0;
		this._returnDataType 			= '2'; //Retorno de dato: 1 = GET, 2 = POST
	}

	set urlTransaction(url){this._urlTransaction = url;}
	set emailBusiness(email){this._emailBusiness = email;}
	set currencyCode(currency){this._currencyCode = currency;}
	set shoppingUrl(url){this._shoppingUrl = url;}
	set returnUrl(url){this._returnUrl = url;}
	set cancelReturnUrl(cancelUrl){this._cancelReturnUrl = cancelUrl;}
	set notifyUrl(url){this._notifyUrl = url;}
	set imagenUrl(imgUrl){this._imagenUrl = imgUrl;}
	set idPaypalForm(id){this._idPaypalForm = id;}
	set taxCart(tax){this._taxCart = tax;}
	set language(lang){this._language = lang;}

	get urlTransaction(){return this._urlTransaction;}
	get emailBusiness(){return this._emailBusiness;}
	get currencyCode(){return this._currencyCode;}
	get shoppingUrl(){return this._shoppingUrl;}
	get returnUrl(){return this._returnUrl;}
	get cancelReturnUrl(){return this._cancelReturnUrl;}
	get notifyUrl(){return this._notifyUrl;}
	get imagenUrl(){this._imagenUrl;}
	get taxCart(){return this._taxCart;}
	get language(){return this._language;}
	get idPaypalForm(){
		if ( this._idPaypalForm.trim() ) {
			return this._idPaypalForm;
		}else{
			console.warn("config.min.js: ID for Paypal form isn't assigned");
			return '';
		}
	}

	get htmlData(){
		var htmlData = '';
		if ( typeof this._data === "object" ) {
			this._data.forEach((value,index)=>{
				htmlData += '<input name="item_number_'+(index +1)+'" type="hidden" value="'+(index+1)+'">'+
						    '<input name="item_name_'+(index+1)+'" type="hidden" value="'+value.item+'">'+
						    '<input name="quantity_'+(index+1)+'" type="hidden" value="'+value.quantity+'">'+
						    '<input name="amount_'+(index+1)+'" type="hidden" value="'+value.price+'">';
			});
		}else{
			console.warn("config.min.js: The data argument is invalid, the form for Paypal can not be generated");
		}
		return htmlData;
	}

	get paypalForm(){
		var paypalFormHtml =  
			('<form name="paypalFormPayment" method="post" action="'+this._urlTransaction+'">'+
			    '<input type="hidden" name="cmd" value="_cart">'+
			    '<input type="hidden" name="upload" value="1">'+
			    '<input type="hidden" name="business" value="'+this._emailBusiness+'">'+
			    '<input type="hidden" name="shopping_url" value="'+this._shoppingUrl+'">'+
			    '<input type="hidden" name="return" value="'+this._returnUrl+'">'+
			    '<input type="hidden" name="cancel_return" value="'+this._cancelReturnUrl+'">'+
			    '<input type="hidden" name="notify_url" value="'+this._notifyUrl+'">'+
			    '<input type="hidden" name="currency_code" value="'+this._currencyCode+'">'+
			    '<input type="hidden" name="rm" value="'+this._returnDataType+'">'+ // Retorno de dato: 1 = GET, 2 = POST
			    '<input type="hidden" name="lc" value="'+this._language+'">'+
			    '<input type="hidden" name="tax_cart" value="'+this._taxCart+'">'+
			    '<input type="hidden" name="no_shipping" value="1">'+
			    '<input type="hidden" name="image_url" value="'+this._imagenUrl+'">'+
				this.htmlData+
			'</form>');
		if (this._idPaypalForm.trim().length != 0 ) {
			document.getElementById(this._idPaypalForm).innerHTML = paypalFormHtml;
		}else{
			console.warn("config.min.js: The Id for paypal form isn't defined");
		}
		return paypalFormHtml;
	}

	get validData(){
		if ( this._urlTransaction.trim().length !=0 && this._emailBusiness.trim().length != 0 && 
			 this._shoppingUrl.trim().length != 0 && this._returnUrl.trim().length != 0 &&
			 this._cancelReturnUrl.trim().length != 0 && this._notifyUrl.trim().length != 0 &&
			 this._idPaypalForm.trim().length != 0 ) {
			return true;
		}else{
			return false;
		}
	}
};




class ConfigCulqi extends Item{
	constructor (){
		super();
		this._publicKey     = '';
		this._title         = 'Inca Lake';
        this._currency     	= 'USD';// PEN  => SOLES , USD => DOLARES
        this._description   = '';	// MinLong = 5 and MaxLong = 80
        this._amount        = 0;	// MONTO A COBRAR MAXVALUE = 100, MINVALUE = 999900
	}

	set publicKey(key){this._publicKey = key;}
	set title(titulo){this._title = titulo;}
	set currency(moneda){this._currency = moneda;}
	set description(descripcion){this._description = descripcion;}
	set amount(monto){this._amount = parseFloat(monto);}

	get publicKey(){
		if (this._publicKey.length != 0) {
			return this._publicKey;
		}else{
			console.warn("config.min.js: Public key is invalid, please check");
			return false;
		}
	}
	get title(){return this._title;}
	get currency(){return this._currency;}
	get amount(){return this._amount;}
	get description(){
		if (this._description.length <= 80 ) {
			return this._description;
		}else{
			console.warn("config.min.js: The description has exceeded the established limits, please check");
			return 'Payments for Inca Lake';
		}
	}

	get amountCulqi(){
		if (this._amount >= 1 ) {
			return  (this.amount.toFixed(2)).replace('.','');
		}else{
			console.warn("config.js: The amount to be transferred is not valid, please check");
			return '0000';
		}
	}

	get validData(){
		if (this._publicKey.trim().length != 0 && this._title.trim().length != 0 && 
			this._currency.trim().length != 0 && this._description.trim().length != 0 && 
			parseFloat(this._amount) >=1 ) {
			return true;
		}else{
			return false;
		}
	}
};





//Paypal Form
/*
'<form name="paypalForm" method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">'+
    '<input type="hidden" name="cmd" value="_cart">'+
    '<input type="hidden" name="upload" value="1">'+
    '<!--'+
	'<input type="hidden" name="business" value="correosandboxvendedor@gmail.com">'+
	'-->'+
    '<input type="hidden" name="business" value="incalake004@gmail.com">'+
    '<input type="hidden" name="shopping_url" value="http://localhost/carrito-paypal/productos.php">'+
    '<input type="hidden" name="currency_code" value="USD">'+
    '<input type="hidden" name="return" value="http://localhost/carrito-paypal/exito.php">'+
    '<input type="hidden" name="cancel_return" value="http://localhost/carrito-paypal/errorPaypal.php">'+
    '<input type="hidden" name="notify_url" value="http://localhost/carrito-paypal/paypalipn.php">'+
    '<input type="hidden" name="rm" value="2">'+ // Retorno de dato: 1 = GET, 2 = POST
    '<input type="hidden" name="lc" value="EN">'+
    '<input type="hidden" name="tax_cart" value="3.99">'+
    '<input type="hidden" name="no_shipping" value="1">'+
    '<!--'+
	'<input type="hidden" name="discount_amount_cart" value="0.50">'+
	'<input type="hidden" name="discount_rate_cart" value="3">'+
	'-->'+
    '<input type="hidden" name="image_url" value="https://shop.incalake.com/img/logo-150x50.png">'+
    '<!--'+
	'<input type="hidden" name="country" value="ES">'+
	'-->'+
    '<input name="item_number_1" type="hidden" value="4">'+
    '<input name="item_name_1" type="hidden" value="City Tour Puno 1 Día">'+
    '<input name="amount_1" type="hidden" value="1.20">'+
    '<input name="quantity_1" type="hidden" value="1">'+
'</form>'
*/