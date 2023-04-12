//console.warn("config.min.js loaded successfully");
/*
*	object  = {
*		item 	 : item_name,
*		quantity : quantity,
*		price 	 : Unit_price,		
		type     : tour = 0 | recurso, guia = 1 
*	};
*/
"use strict";
class Item{
	constructor(){
		this._data      	   			= [];	// Objetos Comprados
		this._discuontRate 	   			= 0;	// Tasa de descuento en Porcentaje %
		this._feesTaxRate      			= 0; 	// Tasa de impuestos en Porcentanje %
		this._feesTaxRateMount			= 0;    // Cantidad de tasas e impuestos en basde a feesTaxRate
		//this._discuontAmount   			= 0; 	// Importe de descuento USD
		//this._feesTaxAmount    			= 0; 	// Importe de impuests en USD
		this._totalPriceTour 			= 0;	// Precio total de solamente Tours, Actividades. Esto es para aplicar tasas e impuestos 
		this._subTotalPriceData			= 0;	// Precio Sub Total Data (Precio total del los objetos)
		this._subTotalPrice				= 0;	// Precio Sub Total incluido impuestos
		this._totalPrice       			= 0; 	// Precio Total
		this._finalTotalPrice			= 0;	// Precio Final Total a cobrar
		this._totalPriceString 			= '';	// Precio modificado en cadena y válido para CULQI
		
		this._cupon    					= 0;  	// Cupon descuento en porcentaje; Ejemplo: 10%, 5%;
		this._cuponMontoDescuento		= 0;  	// Monto descontado en base al cupón
	}

	set data(object){
		if ( typeof object === "object" ) {
			object.forEach((value,index)=>{
				this._data.push(value);
				this._subTotalPriceData += (parseFloat(value.price)*parseFloat(value.quantity));
				if (value.type === 0 ) {
					this._totalPriceTour += (parseFloat(value.price)*parseFloat(value.quantity));
				}
			});
		}else{
			console.error("config.min.js: The argument isn't a valid array or object, please check");
		}
	}

	set discountRate(rate){ this._discuontRate = rate; }
	set feesTaxRate(rate){ 
		this._feesTaxRate = rate;
		this._feesTaxRateAmount =  this.totalFeesTaxRate;
	}
	//set discountAmount(amount){ this._discuontAmount = amount; }
	//set feesTaxAmount(amount){ this._feestaxAmount = amount; }
	set subTotalPriceData(price){ this._subTotalPriceData  = price; }
	set subTotalPrice(price){ this._subTotalPrice = price; };
	set totalPrice(price){ this._totalPrice; };
	set finalTotalPrice(price){ this._finalTotalPrice; };
	set totalPriceString(stringPrice){ this._totalPriceString = stringPrice; };
	set cupon(cupon){
		this._cupon = parseFloat(cupon);
		if ( this._cupon != 0 ) {
			this.cuponMontoDescuento = ( ( (this._subTotalPriceData + this.totalFeesTaxRate) * this._cupon ) / 100 );
		}
	}
	set cuponMontoDescuento(monto){this._cuponMontoDescuento = parseFloat(monto);}

	get discountRate(){ return this._discuontRate; }
	get feesTaxRate(){ return this._feesTaxRate; }
	//get discountAmount(){ return this._discuontAmount; }
	//get feesTaxAmount(){ return this._feestaxAmount; }
	get totalPriceData(){ return this._subTotalPriceData; }
	get totalDiscountRate(){ return (( parseFloat(this._totalPrice)*parseFloat(this._discuontRate) )/100); }	
	get totalFeesTaxRate(){ return (( parseFloat(this._totalPriceTour)*parseFloat(this._feesTaxRate) )/100); }
	get subTotalPrice(){ return ( parseFloat(this._subTotalPriceData) + parseFloat(this._feesTaxRateAmount) ) ; }
	get totalPrice(){ return ( ( parseFloat(this._subTotalPriceData) + parseFloat(this._feesTaxRateAmount) ) - this._cuponMontoDescuento ) ; }	
	//get totalDiscountAmount(){ return ( (parseFloat(this._totalPrice)) - (this._discuontAmount) ); }
	//get totalFeesTaxAmount(){ return ( (parseFloat(this._totalPrice)) - (this._feesTaxAmount) ); }
	get data(){return this._data;}
	get clearItem(){ 
		this._data.length 			= 0; 
		this._discuontRate 			= 0;
		this._feesTaxRate 			= 0;
		this._subTotalPriceData 	= 0;
		this._subTotalPrice 		= 0;
		this._totalPrice 			= 0;
		this._finalTotalPrice 		= 0;
		this._totalPriceString 		= '';
		this._cupon 				= 0;
		this._cuponMontoDescuento 	= 0;
		return true;
	}
	get cupon(){ return this._cupon;}
	get cuponMontoDescuento(){ 
		return this._cuponMontoDescuento;
	}
};





//class ConfigPaypal extends Item{
class ConfigPaypal{
	constructor (){
		//super();
		this._urlTransaction    = ''; //https://www.sandbox.paypal.com/cgi-bin/webscr
		this._emailBusiness  	= ''; // Email de Cuenta Paypal al cual se depositará
		this._currencyCode 		= 'USD'; // USD, PEN
		this._shoppingUrl 		= ''; // https://incalake.com/paypal-cart.php
		this._returnUrl			= ''; // https://incalake.com/paypal-payment.php
		this._cancelReturnUrl   = ''; // https://incalake.com/paypal-error.php
		this._notifyUrl			= ''; // https://incalake.com/paypal-notification.php
		this._imagenUrl		    = 'https://shop.incalake.com/img/logo-150x50.png'; // https://shop.incalake.com/img/logo-150x50.png
		this._idPaypalForm      = '';

		this._totalDiscountAmountCart	= 0; // Descuento al total del precio (Cupón) 
		this._language					= 'EN';
		this._taxCart 					= 0;
		this._returnDataType 			= '2'; //Retorno de dato: 1 = GET, 2 = POST
		this._data 				= [];  // Objetos para cargar en el formulario de Paypal

		//this._cupon    					= 0;  //Cupon descuento en porcentaje; Ejemplo: 10%, 5%;
		//this._cuponMontoDescuento		= 0; //Monto descontado en base al cupón

		//this._totalDiscountRateCart  	= 0;
		//this._feestaxAmountCart 		= 0;
		//this._feesTaxRateCart 	    = 0;
	}

	set data(data){ this._data = data; };
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

	set totalDiscountAmountCart(amount){ this._totalDiscountAmountCart = amount; }

	get totalDiscountAmountCart(){ return this._totalDiscountAmountCart; }

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
			    '<input type="hidden" name="discount_amount_cart" value="'+this._totalDiscountAmountCart+'">'+
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




//class ConfigCulqi extends Item{
class ConfigCulqi{
	constructor (){
		//super();
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
			return  ( this.amount ).toFixed(2).replace('.','');
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



class configPYM{
	constructor (){
		this._acquirerId         		= null; // INTEG = 144
        this._idCommerce     			= null; // INTEG = 8909
        this._purchaseOperationNumber   = null;	// Id de orden de compra seis (6) digitos
        this._purchaseAmount        	= 0;	// Monto a cobrar 10.50 = 1050, 100 = 10000, enviar como string
        this._purchaseCurrencyCode      = null; // 840 = Dólares, 604 = Soles
        this._language					= null; // SP = Español, EN = Inglés, idioma en que se mostrará el formulario PYM
        this._purchaseAmountString		= null; //Monto a cobrar en formato String
        
        this._descriptionProducts       = null; // Descripción del Producto a comprar
        this._programmingLanguage		= null; // Lenguaje de programación
        this._purchaseVerification		= null; // SH2
	}

	set acquirerId(acquirerId){ this._acquirerId = acquirerId.trim(); }
	set idCommerce(idCommerce){ this._idCommerce = idCommerce.trim(); }
	set purchaseOperationNumber(pon){ this._purchaseOperationNumber = pon.trim(); }
	set purchaseAmount(purchaseAmount){ this._purchaseAmount = parseFloat(purchaseAmount); }
	set purchaseCurrencyCode(pcc){ this._purchaseCurrencyCode = pcc.trim(); }
	set language(language){ this._language = language.trim(); }
	set purchaseAmountString(pas){ this._purchaseAmountString = pas.trim(); }

	set descriptionProducts(description){ this._descriptionProducts = description.trim(); }
	set programmingLanguage(lenguajeProgramacion){ this._programmingLanguage = lenguajeProgramacion.trim(); }
	set purchaseVerification(pv){ this._purchaseVerification = pv.trim(); }

	get acquirerId(){ return this._acquirerId; }
	get idCommerce(){ return this._idCommerce; }
	get purchaseOperationNumber(){ return this._purchaseOperationNumber; }
	get purchaseAmount(){ return this._purchaseAmount; }
	get purchaseCurrencyCode(){ return this._purchaseCurrencyCode; }
	get language(){ return this._language; }
	get purchaseAmountString(){ 
		if (this._purchaseAmount >= 1 ) {
			return  ( this._purchaseAmount ).toFixed(2).replace('.','');
		}else{
			console.warn("config.js: The amount to be transferred is not valid, please check");
			return '0000';
		}
	}

	get descriptionProducts(){ return this._descriptionProducts; }
	get programmingLanguage(){ return this._programmingLanguage; }
	get purchaseVerification(){ return this._purchaseVerification; }

	get validData(){
		if ( parseFloat(this._purchaseAmount) >=1 ) {
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