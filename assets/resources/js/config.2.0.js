//console.warn("config.min.js loaded successfully");
/*
*	object  = {
*		item 	 : item_name,
*		quantity : quantity,
*		price 	 : Unit_price,		
		type     : tour = 0 | recurso, guia = 1,
		porcentaje_adelanto : Porcentaje adelanto; Ej. 10%, 25%
		tasas_impuestos: porcentaje de tasas e impuestos para cobrar por el objeto.
		pago_minimo: TRUE = se cobra solo el porcentaje_adelanto, FALSE = se cobra el 100%.
*	};
*/
"use strict";
class Item{
	constructor(){
		this._data      	   			= [];	// Objetos Comprados
		/********************** ACTUALIZADO EL DIA 06/01/18 [BEGIN] ***************************/
		this._montoTotalTours			= 0; 	// Monto total de solamente tours
		this._montoTotalRecursos		= 0; 	// Monto total de recursos (Sin incluir tours)
		this._montoTotalData			= 0;	// Monto Total de todos los objetos (Tours, regalos, etc); precio total del argumento this._data	
		this._porcentajeCuponDescuento	= 0;	// Porcentaje del cupon a descontar del precio Total (this._montoTotalData).
		this._montoCuponDescuento		= 0;	// Monto de descuento por cupón.
		this._montoPagarAdelantado		= 0;	// Monto a pagar como adelanto, esto es la suma del porcentaje a pagar por cada tour + tasas e impuestos + recursos
		this._porcentajeAdelanto		= 0; 	// Porcentaje equivalente al monto total de adelanto.
		this._montoTasasImpuestos		= 0;	// Monto de tasas e impuestos a cobrar, solamente aplicado a tours.
		this._subMontoTotalPagar		= 0;	// Sub Monto total a pagar incluidos recursos, tasas e impuestos, etc.
		this._montoTotalPagar			= 0;	// Monto total a pagar incluidos recursos, tasas e impuestos y decuentos, etc.
		this._montoTotalPagarAdelantado = 0;    // Monto Total a pagar como adelanto (Incluye: tours + recursos + tasas e impuestos)
		/********************** ACTUALIZADO EL DIA 06/01/18 [ END ] ***************************/
	}

	set data(object){
		if ( typeof object === "object" ) {
			object.forEach((value,index)=>{
				this._data.push(value);
				this._subTotalPriceData += (parseFloat(value.price)*parseFloat(value.quantity));
				if (value.type === 0 ) { // Acomulando el precio de solamente tours y/o servicio
					this._totalPriceTour += (parseFloat(value.price)*parseFloat(value.quantity));
				}

				/**********************************************************************************/
				this._montoTotalData += (parseFloat(value.price)*parseFloat(value.quantity));
				if (value.type === 0 ) { // Acomulando el precio de solamente tours y/o servicio
					this._montoTotalTours += ( parseFloat(value.price)*parseFloat(value.quantity) );
					// Sumando las tasas e impuestos por cada tour
					this._montoTasasImpuestos += ( parseFloat(value.price)*parseFloat(value.quantity) ) * parseFloat(value.tasas_impuestos) / 100 ;
					// Sumando el monto a pagar por adelantado por cada tour
					if ( value.pago_minimo === true ) { // Si porcentaje es menor igual a 0 aplicamos el 100%
						if ( parseFloat(value.porcentaje_adelanto) <= 0 ) {
							this._montoPagarAdelantado += ( parseFloat(value.price)*parseFloat(value.quantity) );
						}else{ // En caso contrario aplicamos el porcentaje que llega por defecto
							this._montoPagarAdelantado += ( parseFloat(value.price)*parseFloat(value.quantity) ) * parseFloat(value.porcentaje_adelanto) / 100 ; 
						}
					}else{ // En caso que value.pago_minimo = FALSE, se cobra el 100%
						this._montoPagarAdelantado += ( parseFloat(value.price)*parseFloat(value.quantity) );
					}
				}else{
					// Sumando el monto total de los recursos.
					this._montoTotalRecursos += ( parseFloat(value.price)*parseFloat(value.quantity) );
				}				
				/**********************************************************************************/
			});
			// Actualizando this._subMontoTotalPagar sin incluir descuento
			this._subMontoTotalPagar = parseFloat(this._montoTotalTours) + parseFloat(this._montoTotalRecursos) + parseFloat(this._montoTasasImpuestos);
		}else{
			console.error("config.min.js: The argument isn't a valid array or object, please check");
		}
	}

	/********************** ACTUALIZADO EL DIA 06/01/18 [BEGIN] ***************************/
	set porcentajeCuponDescuento(porcentaje){
		this._porcentajeCuponDescuento = parseFloat(porcentaje);
		// Calculando el monto a descontar por cupón.
		this._montoCuponDescuento = ( this._subMontoTotalPagar * parseFloat(this._porcentajeCuponDescuento) ) / 100;
	}
	get totalMontoPagarAdelantado(){
		// Calculamos el monto total a pagar por adelantado sumando this._montoPagarAdelantado + this._montoTotalRecursos + this._montoTasasImpuestos
		//this._montoPagarAdelantado = parseFloat(this._montoPagarAdelantado) + parseFloat(this._montoTotalRecursos) + parseFloat(this._montoTasasImpuestos);  		
		this._montoTotalPagarAdelantado = ( parseFloat(this._montoPagarAdelantado) + parseFloat(this._montoTotalRecursos) + parseFloat(this._montoTasasImpuestos) );
		if ( parseFloat( this.porcentajeAdelanto ) > 100 ) {
			return parseFloat(this._montoTotalPagar);
		}else{
			return parseFloat(this._montoTotalPagarAdelantado);
		}
	}
	get subTotalMontoPagar(){
		return this._subMontoTotalPagar;
	}
	get totalMontoPagar(){
		// Calculamos el monto total que debe pagar el cliente: this._montoTotalData + this._montoTotalRecursos + this._montoTasasImpuestos - this._montoDecuentoCupon
		this._montoTotalPagar = parseFloat(this._montoTotalTours) + parseFloat(this._montoTotalRecursos) + parseFloat(this._montoTasasImpuestos) - parseFloat(this._montoCuponDescuento);
		return this._montoTotalPagar;
	}
	get porcentajeAdelanto(){
		// Calculando el porcentaje al que equivale el monto a pagar por adelantado
		if ( this._montoTotalPagar ) {
			this._porcentajeAdelanto = ( this._montoTotalPagarAdelantado * 100 ) / this._montoTotalPagar;
			//this._porcentajeAdelanto = parseFloat( this._porcentajeAdelanto ) > 100 ? 100:parseFloat(this._porcentajeAdelanto);
		}
		return parseFloat(this._porcentajeAdelanto).toFixed(2);
	}
	get montoCuponDescuento(){
		// Antes de calcular el montoCuponDescuento actualizamos el this._subMontoTotalPagar.
		this.totalMontoPagar;
		// Recalculando el monto descuento
		this._montoCuponDescuento = ( this._subMontoTotalPagar * parseFloat(this._porcentajeCuponDescuento) ) / 100;
		return this._montoCuponDescuento;	
	}
	get totalMontoTasasImpuestos(){
		return parseFloat(this._montoTasasImpuestos);	// Retorna el monto de tasas e impuestos a cobrar
	}
	get montoTotalRecursos(){
		return parseFloat(this._montoTotalRecursos);	// Retorna el monto total de recursos
	}
	get montoTotalTours(){
		return parseFloat(this._montoTotalTours);	// Retorna el monto total de tours
	}
	get montoTotalData(){
		return parseFloat(this._montoTotalData);	// Retorna el monto total del contenido del objeto this._data
	}
	get data(){
		return this._data;
	}
	/********************** ACTUALIZADO EL DIA 06/01/18 [ END ] ***************************/
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
				//if ( value.type === 0 && parseFloat(value.porcentaje_adelanto) > 0 ) {
				// Si el data es un tour y el valor del porcentaje es mayor a cero y si el pago minimo es true si le aplcia el pago minimo.
				if ( value.type === 0 && parseFloat(value.porcentaje_adelanto) > 0 && value.pago_minimo === true ) {
					htmlData += '<input name="item_number_'+(index +1)+'" type="hidden" value="'+(index+1)+'">'+
						    '<input name="item_name_'+(index+1)+'" type="hidden" value="'+value.item+'">'+
						    '<input name="quantity_'+(index+1)+'" type="hidden" value="'+value.quantity+'">'+
						    '<input name="amount_'+(index+1)+'" type="hidden" value="'+( parseFloat(value.price)* parseFloat(value.porcentaje_adelanto)/100 )+'">';
				}else{
					htmlData += '<input name="item_number_'+(index +1)+'" type="hidden" value="'+(index+1)+'">'+
						    '<input name="item_name_'+(index+1)+'" type="hidden" value="'+value.item+'">'+
						    '<input name="quantity_'+(index+1)+'" type="hidden" value="'+value.quantity+'">'+
						    '<input name="amount_'+(index+1)+'" type="hidden" value="'+value.price+'">';
				}
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
                            '<input type="hidden" name="custom" value="" id="paypalCustomValue">'+ // Enviando datos para porcesar en la página de respuesta
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