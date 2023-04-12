    console.log("Done loading transact.js");
    
    var itemData        = [];

    var id_reserva      = undefined;

    let objPaypal       = null;
    let objCulqi        = null;
    var feesAndTaxRate  = 0;   // descuento 5%
    var discountAmount  = 0;
    var jsonCookie      = [];
    var objItem         = null;

    var jsonCookieCupon = null;
    var cupon           = 0;

    /**********************************/
    var cuotaMonto      = 0;
    var cuotaPorcentaje = 0;
    var totalMontoPagar = 0;
    //var totalPorcentajeDescuento = 0;
    //var tpdCantidad = 0; // tcdCantidad = TOTAL PORCENTAJE DESCUENTO cantidad //sumaremos todos aquellos que sean mayor a cero
    /**********************************/

    var currencyCodePYM = '840'; // Dólar

    function actualizarDatos(){
        if (Cookies.get('cart')) {
            if (Cookies.get('cupon')) {
                jsonCookieCupon = JSON.parse(Cookies.get('cupon'));
                cupon           = jsonCookieCupon['cupon_valor'];
            }

            jsonCookie  = JSON.parse(Cookies.get('cart'));
            //console.log(JSON.stringify(jsonCookie));
            itemData.length  = 0;
            /* Tasas e impuestos */
            tasa = 0;
            jsonCookie.forEach((t, index) => { tasa += t.tasas_impuestos; });
            feesAndTaxRate = tasa / jsonCookie.length;
            
            (jsonCookie).forEach((value,index) => {
                (value['personas']).forEach((val,i) => {
                    var precio_item = ( parseFloat(value['total']) / parseFloat(val['cantidad']) );
                    //Se aplica precio normal si es que existe un cupón válido
                    if (jsonCookieCupon['cupon_valido']) {
                        precio_item = ( parseFloat(value['precio_normal']) / parseFloat(val['cantidad']) )
                    }

                    tempItem = {
                        item     : caracteresEspeciales(value['titulo_producto']+" ("+val['descripcion_etapa_edad']+" "+val['descripcion_nacionalidad']+")"),
                        quantity : val['cantidad'],
                        //price    : ( parseFloat(value['total']) / parseFloat(val['cantidad']) )
                        price    : precio_item,
                        type     : 0, // ES TOUR, ACTIVIDAD
                        porcentaje_adelanto : value['porcentaje_adelanto'], // Porcentaje de adelanto para pagar mediante tarjeta.
                        tasas_impuestos: value['tasas_impuestos'],  // Porcentaje para cobrar tasas e impuestos
                    };
                    itemData.push(tempItem);    
                });

                if ( (value['recursos']) ) {
                    (value['recursos']).forEach((v,j) => {
                        tempRecurso = {
                            item     : caracteresEspeciales(v['nombre']+' x'+v['cantidad']),
                            quantity : parseInt(v['cantidad']),
                            price    : parseFloat(v['precio']),
                            type     : 1, // ES RECURSOS  
                            porcentaje_adelanto: 0, // Los recursos no tiene el porcentaje de pago por adelantado  
                            tasas_impuestos: 0, // Un recurso no tiene tasas e impuestos
                        }
                        itemData.push(tempRecurso);
                    });
                }
                /*
                totalPorcentajeDescuento += parseFloat(value['porcentaje_adelanto']);
                if ( parseFloat(value['porcentaje_adelanto']) > 0 ) {
                    tpdCantidad += 1;
                }
                */
            });
            //console.log("Total Porcentaje Descuento Suma: ",totalPorcentajeDescuento);
            // Actualizando el promedio de totalPorcentajeDenscuento
            //totalPorcentajeDescuento = (totalPorcentajeDescuento/tpdCantidad);
            //console.log("Total Porcentaje Descuento Promedio: ",totalPorcentajeDescuento);
            
            console.log("Items",JSON.stringify(itemData));
            
            //Iniciamos la carga de objetos a la Clase Item si es que itemData no está vacío
            if ( itemData.length != 0 ) {
                objItem                          = new Item();
                objItem.data                     = itemData; // Cargando datos (Objetos)
                objItem.porcentajeCuponDescuento = cupon; // Enviando el valor del cupón en porcentaje

                //console.log("/******************** ITEM ************************/");
                /*
                console.log("MONTO TOTAL TOURS $",objItem.montoTotalTours);
                console.log("TASAS IMPUESTOS $",objItem.totalMontoTasasImpuestos);
                console.log("MONTO TOTAL RECURSOS $",objItem.montoTotalRecursos);
                console.log("MONTO TOTAL A PAGAR $",objItem.subTotalMontoPagar);
                console.log("MONTO CUPON DESCUENTO $",objItem.montoCuponDescuento);
                console.log("MONTO TOTAL A PAGAR $",objItem.totalMontoPagar);
                console.log("MONTO ADELANTO $", " - ",objItem.porcentajeAdelanto,"%");
                */
                /********************************************************************************/           
            }
        }
        
        objPaypal                   = new ConfigPaypal();
        objPaypal.data              = objItem.data;
        objPaypal.taxCart           = objItem.totalMontoTasasImpuestos;
        objPaypal.totalDiscountAmountCart = objItem.montoCuponDescuento;
        //objPaypal.urlTransaction    = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        //objPaypal.emailBusiness     = 'incalake004@gmail.com';
        objPaypal.urlTransaction    = 'https://www.paypal.com/cgi-bin/webscr';    
        objPaypal.emailBusiness     = 'reservas@incalake.com';
        objPaypal.shoppingUrl       = 'http://web.incalake.com/'+langApp+'/checkout/cart';
        objPaypal.returnUrl         = 'https://shop.incalake.com/paypal/success.php';
        objPaypal.cancelReturnUrl   = 'http://web.incalake.com/'+langApp+'/checkout/cart';
        //objPaypal.cancelReturnUrl   = 'https://shop.incalake.com/paypal/error.php';
        objPaypal.notifyUrl         = 'https://shop.incalake.com/paypal/ipn.php';
        //objPaypal.imagenUrl         = 'https://shop.incalake.com/img/logo-150x50.png';
        objPaypal.currencyCode      = 'USD';
        objPaypal.language          = 'EN';
        
        objPaypal.idPaypalForm      = "paypalFormHtml";  
        //var idFormPaypal            = objPaypal.idPaypalForm;   
        var paypalFormHtml          = objPaypal.paypalForm;   
        //console.log(paypalFormHtml);
        //console.log("$", objPaypal.totalPrice,"USD" );
        var configPaypalStatus  = objPaypal.validData;  
        validarBotonComprar(configPaypalStatus,"btn-paypal","data-paypal-initialize");     

        console.log("******************** PAYPAL *******************");
        console.log("MONTO TOTAL TOURS $",objItem.montoTotalTours);
        console.log("TASAS IMPUESTOS $",objItem.totalMontoTasasImpuestos);
        console.log("MONTO TOTAL RECURSOS $",objItem.montoTotalRecursos);
        console.log("TOTAL AMOUNT",objPaypal.currencyCode,objItem.subTotalMontoPagar);
        console.log("CUPON DESCUENTO",objItem.montoCuponDescuento);
        console.log("TOTAL AMOUNT",(objItem.totalMontoPagar));
        console.log("MONTO ADELANTO",objItem.totalMontoPagarAdelantado, " - ",objItem.porcentajeAdelanto,"%");
        console.log("PAYPAL CONFIG",configPaypalStatus);

        objCulqi                = new ConfigCulqi();
        objCulqi.publicKey      = "pk_test_NVbRNu7rdWFpxXI7";
        //objCulqi.publicKey     = 'pk_live_rRgjM0Lbve8ZkrRT';
        
        objCulqi.title          = "Inca Lake";
        objCulqi.currency       = 'USD';
        objCulqi.description    = 'Tours or Activities Inca Lake';
        //objCulqi.amount         = objItem.totalPrice; // Cobrar el monto total de las compras
        objCulqi.amount         = objItem.totalMontoPagarAdelantado; // Cobrar un porcentaje del monto como adelanto de todas las compras        
        var configCulqiStatus = objCulqi.validData;

        validarBotonComprar(configCulqiStatus,"btn-culqi","data-culqi-initialize");
        
        console.log("********************* CULQI *******************");
        console.log("MONTO TOTAL TOURS $",objItem.montoTotalTours);
        console.log("TASAS IMPUESTOS $",objItem.totalMontoTasasImpuestos);
        console.log("MONTO TOTAL RECURSOS $",objItem.montoTotalRecursos);
        console.log("TOTAL AMOUNT",objCulqi.currency,objItem.subTotalMontoPagar);
        console.log("CUPON DESCUENTO",objItem.montoCuponDescuento);
        console.log("TOTAL AMOUNT",(objItem.totalMontoPagar));
        console.log("MONTO ADELANTO",objCulqi.amount, " - ",objItem.porcentajeAdelanto,"%");
        console.log("AMOUNT STRING CULQI",objCulqi.currency,objCulqi.amountCulqi);
        console.log("CULQI CONFIG",configCulqiStatus);
        /*************************************************************/
        objPYM                          = new configPYM();
        objPYM.acquirerId               = '';   /***/
        objPYM.idCommerce               = '';   /***/
        objPYM.purchaseOperationNumber  = '';   /***/
        objPYM.language                 = ( langApp.toLowerCase() == 'es'?'SP':'EN' );
        //objPYM.purchaseAmount           = objCulqi.amount; // Cobrar el monto total de las compras
        objPYM.purchaseAmount           = objItem.totalMontoPagarAdelantado; // Cobrar un porcentaje del monto como adelanto de todas las compras
        objPYM.purchaseCurrencyCode     = currencyCodePYM;
        objPYM.descriptionProducts      = 'Tours or Activities Inca Lake';
        objPYM.programmingLanguage      = 'PHP';
        objPYM.purchaseVerification     = '';   /***/
        var configPYMStatus = objPYM.validData;
        validarBotonComprar(configPYMStatus,"btn-transferencia-bancaria","data-pym-initialize"); 
    
        console.log("********************* VPOST2 *******************");
        console.log("LANGUAGE",objPYM.language);
        console.log("MONTO TOTAL TOURS $",objItem.montoTotalTours);
        console.log("TASAS IMPUESTOS $",objItem.totalMontoTasasImpuestos);
        console.log("MONTO TOTAL RECURSOS $",objItem.montoTotalRecursos);
        console.log("TOTAL AMOUNT",objItem.subTotalMontoPagar);
        console.log("CUPON DESCUENTO",objItem.montoCuponDescuento);
        console.log("TOTAL AMOUNT",(objItem.totalMontoPagar));
        console.log("MONTO ADELANTO",objPYM.purchaseAmount, " - ",objItem.porcentajeAdelanto,"%");
        console.log("AMOUNT STRING CULQI",objCulqi.currency,objPYM.purchaseAmountString);
        console.log("PYM CONFIG",configPYMStatus);

        // Actualizando variables para enviar al server
        cuotaMonto        = objItem.totalMontoPagarAdelantado;
        cuotaPorcentaje   = objItem.porcentajeAdelanto;
        totalMontoPagar   = objItem.totalMontoPagar;
    }


    actualizarDatos();
    if (objCulqi.publicKey) {
        Culqi.publicKey = objCulqi.publicKey;
        Culqi.init();
    }

    $(document).on('click','#btn-culqi',function(e){
        e.preventDefault();
        actualizarDatos();
        document.getElementById('btn-culqi').disabled = true;
        $.blockUI({ 
            message: '<h3>Loading..!</h3><p>Wait a moment please.</p>',
            css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff'                
        } });
        var resultValidate = validarFormPago();
        //console.log(resultValidate);
        
        if (resultValidate.response) {
            Culqi.createToken();
            console.log("Token Culqi Creado..!");
        }else{
            $.unblockUI();
            setTimeout(function(){}, 1500);
            var message = '';
            (resultValidate.data).forEach((value,index)=>{
                message += value+"\n";
            });
            alert(message);
            document.getElementById('btn-culqi').disabled = false;
        }
        //operarCulqui();
    });

    $(document).on('click','#btn-paypal',function(e){
        e.preventDefault();
        actualizarDatos();
        document.getElementById('btn-paypal').disabled = true;
        $.blockUI({ 
            message: '<h3>Loading..!</h3><p>Wait a moment please.</p>',
            css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        registerCustomer('paypal');
    });

    $(document).on('change', '.tipo_moneda', function(event) {
        event.preventDefault();
        currencyCodePYM = $(this).val();
    });

    $(document).on('click', '.btn-transferencia-bancaria', function(event) {
        event.preventDefault();
        document.getElementById('btn-transferencia-bancaria').disabled = true;
        $.blockUI({ 
            message: '<h3>Loading..!</h3><p>Wait a moment please.</p>',
            css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        actualizarDatos();
        registerCustomer('payme');
        $.ajax({
            //url: 'https://shop.incalake.com/payme/payme-vpos2-test.php',
            url: 'https://shop.incalake.com/payme/payme-vpos2.php',
            type: 'POST',
            dataType: 'JSON',
            data: { amount : objPYM.purchaseAmount, amountstring : objPYM.purchaseAmountString, currency : currencyCodePYM },
        }).done(function(data) {
            if (data.response === 'success') {
                document.getElementById('acquirerId').value                 = data.acquirer;
                document.getElementById('idCommerce').value                 = data.comercio;
                document.getElementById('purchaseOperationNumber').value    = data.numero;
                document.getElementById('purchaseAmount').value             = data.amount;
                document.getElementById('purchaseCurrencyCode').value       = data.currency;
                document.getElementById('language').value                   = objPYM.language;

                document.getElementById('descriptionProducts').value        = objPYM.descriptionProducts;
                document.getElementById('programmingLanguage').value        = objPYM.programmingLanguage;
                document.getElementById('purchaseVerification').value       = data.hash;
                
                $.unblockUI();
                document.getElementById('btn-transferencia-bancaria').disabled = true;
                //AlignetVPOS2.openModal('https://integracion.alignetsac.com/'); // INTEGRACION
                AlignetVPOS2.openModal('','2'); // PRODUCCION
            }
        }).fail(function(e) {
            console.log(e.responseText);
        });
        //AlignetVPOS2.openModal('https://integracion.alignetsac.com/');
    });

    window.registerCustomer = (method) =>  
    {
        customer = JSON.parse(Cookies.get('customer'));
        cart     = JSON.parse(Cookies.get('cart'));
        cupon    = JSON.parse(Cookies.get('cupon'));

        dataCoutas = {
            montoAdelanto: cuotaMonto,
            porcentajeAdelanto: cuotaPorcentaje,
            montoTotal: totalMontoPagar,
        };
        console.log("Coutas",dataCoutas);
        dataJson = {
            id: '',
            language : document.documentElement.lang,
            url: window.location.host,
            domain   : window.location,
            from: 'web.incalake.com',
        };

        $.ajax({
            url: base_url + 'api/reserva',
            type: 'POST',
            dataType: 'JSON',
            data: {
                cliente: customer, 
                productos: cart, 
                lang: langApp, 
                metodo_pago: method,
                cupon:cupon,
                cuota: dataCoutas,
            }
        }).done((data) => {
            id_reserva = data;
            dataJson.id = data;
            Cookies.set('reserva_incalake', JSON.stringify(dataJson), { domain: '.incalake.com' });
            if(method == 'paypal') {
                document.paypalFormPayment.submit();
            }
        }).fail(() => {
            alert('El registro no ha sido exitoso.');
        });

        Cookies.remove('cupon');
        Cookies.remove('reserva_incalake');
        Cookies.set('reserva_incalake', JSON.stringify(dataJson), { domain: '.incalake.com' });
        //console.log("jsonData",dataJson);
    }
/***************************************************************************************/
    
    function sleep(milliseconds) {
      var start = new Date().getTime();
      for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
          break;
        }
      }
    }
    function operarCulqui(){
        registerCustomer('culqi'); /* Registro de Datos */
        sleep(4000);
        console.log("id_reserva",id_reserva);
        sleep(2000);
        $.post(base_url+'api/reserva/update', { 
           id_reserva: id_reserva,
        }, function (response) {
            Cookies.remove('cart');
            Cookies.remove('customer');
            Cookies.remove('cupon');
            $.unblockUI();
            window.location.href = base_url+langApp+'/checkout/confirm?codr='+id_reserva;         
        });          
    }
/***************************************************************************************/

    function culqi() {
        console.log("Entrando a Culqi..!");
        if(Culqi.token) {
            registerCustomer('culqi'); /* Registro de Datos */
            var token = Culqi.token.id;
            var serverData = {
                token           : Culqi.token.id,
                amount          : (parseFloat(objCulqi.amount)).toFixed(2),
                subTotalAmount  : (parseFloat(objItem.totalPrice)).toFixed(2),
                currency        : objCulqi.currency,
                description     : objCulqi.description,
                email           : Culqi.token.email,
                amountString    : objCulqi.amountCulqi
                //metadata    : JSON.stringify(Culqi) 
            };
            
            $.ajax({
                //url: 'https://shop.incalake.com/transaccion/transaccion-incalake.php',
                url: 'https://shop.incalake.com/transaccion/transaccion-incalake-test.php',
                type: 'POST',
                dataType: 'JSON',
                data: {data: serverData},
            }).done(function(data) {
                //console.log(data);
                if ( data['response'] === 'success' ) {
                    var jsonCulqi = data['data'];
                    if ( jsonCulqi['object'] === 'charge' ) {

                        $.post(base_url+'api/reserva/update', { 
                           id_reserva: id_reserva,
                        }, function (response) {
                            Cookies.remove('cart');
                            Cookies.remove('customer');
                            Cookies.remove('cupon');
                            $.unblockUI();
                            window.location.href = base_url+langApp+'/checkout/confirm?codr='+id_reserva;         
                        });                        
                    }else if( jsonCulqi['object'] === 'error' ){
                        $.unblockUI();
                        alert(jsonCulqi['user_message']);
                    }else{
                        $.unblockUI();
                        alert("unknown error");
                    }
                }else if(data['response'] === 'ERROR' ){
                    if (data['error_level'] === '1' ) {
                        var message = '';
                        (data['data']).forEach((value,index)=>{
                            message += value+'\n';
                        });
                        $.unblockUI();
                        alert(message);
                        
                    }else if(data['error_level'] === '2' ){
                        if (data['data']['object'] === 'error' ) {
                            $.unblockUI();
                            alert(data['data']['user_message']);
                            
                        }else{
                            $.unblockUI();
                            alert("unknown error");
                            
                        }
                    }
                    document.getElementById('btn-culqi').disabled = false;
                }else{
                    $.unblockUI();
                    alert("unknown error");
                    document.getElementById('btn-culqi').disabled = false;
                }
            }).fail(function(e) {
                $.unblockUI();
                //console.log(e.responseText);
                document.getElementById('btn-culqi').disabled = false;
            });
        }else{
            //console.log(Culqi.error);
            $.unblockUI();
            alert(Culqi.error.user_message);
            document.getElementById('btn-culqi').disabled = false;
        }
        Culqi.close();
    };

    function validarBotonComprar(status,idButton,idSpan) {
        if (status) {
            document.getElementById(idButton).disabled = false;
            //document.getElementById(idSpan).innerHTML = '  <span class="fa fa-check-circle text-success"></span>';
        }else{
            document.getElementById(idButton).disabled = true;
            document.getElementById(idSpan).innerHTML = ' <span class="fa fa-times-circle text-danger"></span> <small class="text-danger"><i>Error generating data for transaction</i></small>';
        }
    }

    (function(){
        var cardEmail   = document.getElementById('card[email]');
        var cardNumber  = document.getElementById('card[number]');
        var type        = document.getElementById('spanCardTypeText');
        var expiryMonth = document.getElementById('card[exp_month]');
        var expiryYear  = document.getElementById('card[exp_year]');
        var cardCcv     = document.getElementById('card[cvv]');
        var cardExpiry  = expiryMonth+"/"+expiryYear;

        payform.cardNumberInput(cardNumber);
        //payform.expiryInput(expiryYear);
        payform.cvcInput(cardCcv);

        cardEmail.addEventListener('focusout',function(e){
            var result = validarEmail(cardEmail.value);
            if (result) {
                fieldStatus(cardEmail,true);
            }else{
                fieldStatus(cardEmail,false);
            }
        });

        cardNumber.addEventListener('focusout',function(){
            var validCard     = [];
            var expiryObj = payform.parseCardExpiry(cardExpiry);
            validCard.push(fieldStatus(cardNumber,  payform.validateCardNumber(cardNumber.value)));
        });
        
        cardCcv.addEventListener('focusout',function(){
            var validCvv     = [];
            validCvv.push(fieldStatus(cardCcv,     payform.validateCardCVC(cardCcv.value,type.innerHTML)));
        });

        expiryMonth.addEventListener('focusout',function(){
            if (expiryYear.value.trim() != 0 ) {
                var validateExpire = payform.validateCardExpiry(expiryMonth.value,expiryYear.value);
                if (validateExpire) {
                    fieldStatus(expiryMonth,true);
                    fieldStatus(expiryYear,true);
                }else{
                    fieldStatus(expiryMonth,false);
                    fieldStatus(expiryYear,false);
                }
            }else{
                expiryYear.focus();
            }
        });

        expiryYear.addEventListener('focusout',function(){
            if (expiryMonth.value.trim() != 0 ) {
                var validateExpire = payform.validateCardExpiry(expiryMonth.value,expiryYear.value);
                if (validateExpire) {
                    fieldStatus(expiryMonth,true);
                    fieldStatus(expiryYear,true);
                }else{
                    fieldStatus(expiryMonth,false);
                    fieldStatus(expiryYear,false);
                }
            }else{
                expiryMonth.focus();
            }
        });

        cardNumber.addEventListener('input', updateType);
        function updateType(e) {
            var cardType = payform.parseCardType(e.target.value);
            //console.log("CARD",cardType);
            typeCard("spanCardType",cardType);
        }

        function typeCard(idSpan,card){
            var cards = [   
                'visa','mastercard','amex','dinersclub',
                'discover','unionpay','jcb','visaelectron',
                'maestro','forbrugsforeningen','dankort'
            ]; //Cards aceptados por la librería.
            var icon  ='',brandCard='';
            switch(card){
                case 'visa':
                    icon = 'fa-cc-visa';
                    brandCard ='VISA';
                break;
                case 'mastercard':
                    icon = 'fa-cc-mastercard';
                    brandCard = 'MASTERCARD';
                break;
                case 'amex':
                    icon = 'fa-cc-amex';
                    brandCard = 'AMERICAN EXPRESS';
                break;
                case 'dinersclub':
                    icon = 'fa-cc-diners-club';
                    brandCard = 'DINERS CLUB';
                break;
                case 'discover':
                    icon = 'fa-cc-discover';
                    brandCard  ='DISCOVER';
                break;
                case 'jcb':
                    icon = 'fa-cc-jcb';
                    brandCard  = 'JCB';
                break;
                case 'visaelectron':
                    icon = 'fa-cc-visa';
                    brandCard = 'VISA ELECTRON';
                break;
                default:
                    icon = 'fa-credit-card';
                    brandCard  ='CARD NUMBER';
                break;
            }
            if ( idSpan.trim().length != 0 ) {
                document.getElementById(idSpan).innerHTML = '<i class="fa '+icon+'" title="'+brandCard+'"></i>';
            }else{
                console.warn("The id to insert the logo of the card is undefined");
            }
        }

        function fieldStatus(input, valid) {
            if (valid) {
                removeClass(input.parentNode,'has-warning');
                removeClass(input,'form-control-warning');
                addClass(input.parentNode,'has-success');
                addClass(input,'form-control-success');
            } else {
                removeClass(input.parentNode,'has-success');
                removeClass(input,'form-control-success');
                addClass(input.parentNode,'has-warning');
                addClass(input,'form-control-warning');
            }
            return valid;
        }
        function addClass(ele, _class) {
            if (ele.className.indexOf(_class) === -1) {
                ele.className += ' ' + _class;
            }
        }

        function removeClass(ele, _class) {
            if (ele.className.indexOf(_class) !== -1) {
                ele.className = ele.className.replace(_class, '');
            }
        }
    })();

    function justNumbers(e){
        //console.log("Keypress",e.keyCode);
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46)){
            return true;
        }
        return /\d/.test(String.fromCharCode(keynum));
    }

    function caracteresEspeciales(argument) {
        especiales = new Array('á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ');
        normales   = new Array('&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;','&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&Ntilde;');
        //argument = argument.toLowerCase();
        i=0;
        while (i<especiales.length) {
            //argument = argument.replace(especiales[i], normales[i]);
            argument = argument.split(especiales[i]).join(normales[i]);
            i++;
        }
        return argument;
    }

    function validarEmail(email){
        var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        if (emailRegex.test(email)) {
            return true;
        } else {
            return false;
        }
    }

    function validarFormPago(){
        var txtEmail        = validarEmail( document.getElementById('card[email]').value );
        var txtCard         = payform.validateCardNumber( document.getElementById('card[number]').value );
        var txtExpiry       = payform.validateCardExpiry( document.getElementById('card[exp_month]').value , document.getElementById('card[exp_year]').value );
        var txtCcv          = payform.validateCardCVC( document.getElementById('card[cvv]').value );

        var status = true;
        var errorMessage = Array();
        if (!txtEmail ) {
            status = false;
            errorMessage.push("Your Email is invalid");
        }else if (!txtCard ) {
            status = false;
            errorMessage.push("Your card number is invalid");
        }else if (!txtExpiry ) {
            status = false;
            errorMessage.push("The date or year of your card is invalid");
        }else if (!txtCcv ) {
            status = false;
            errorMessage.push("Your card CCV is invalid");
        }   
        return { response: status, data: errorMessage };
    }

/* Giro and transfer */
window.registerPaymentGlobal = (metodo) =>  
{
        $.blockUI({ 
            message: '<h3>'+trans('msg_loading_transaction')+'</h3>',
            css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff'                
        } });

        var idddd;
        
        customer = JSON.parse(Cookies.get('customer'));
        cart = JSON.parse(Cookies.get('cart'));
        
        //console.log(cart);
        
        dataJson = {
            id: '',
            language : document.documentElement.lang,
            url: '//'+window.location.host,
            from: 'web.incalake.com',
        };

        $.post(base_url+'api/reserva', { 
            cliente: customer, productos: cart, lang: langApp, metodo_pago: metodo,
        }, function (data) {
            idddd = data;
            //console.log("ID RESERVA",data);
            dataJson.id = data;

            Cookies.set('reserva_incalake', JSON.stringify(dataJson), { domain: '.incalake.com' });
            
            $.post(base_url+'api/reserva/update', { 
                            id_reserva: idddd,
                        }, function (response) {
               Cookies.remove('cart');
               Cookies.remove('customer');
                
              window.location.href = base_url+langApp+'/checkout/confirm?codr='+idddd;     
               $.unblockUI();    
            });   

        }).fail(() => {
            alert('El registro no ha sido exitoso.');
        });
        Cookies.remove('reserva_incalake');
        Cookies.set('reserva_incalake', JSON.stringify(dataJson), { domain: '.incalake.com' });
        //console.log("jsonData",dataJson);

}

// Autorellenado del formulario PYM
datosCliente = JSON.parse(Cookies.get('customer'));
document.getElementById('shippingFirstName').value  = datosCliente.nombres;
document.getElementById('shippingLastName').value   = datosCliente.apellidos;
document.getElementById('shippingEmail').value      = datosCliente.email;




