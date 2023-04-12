    var itemData = [];

    var id_reserva = undefined;

    let objPaypal  = null;
    let objCulqi   = null;
    var feesAndTaxRate = 0;   // descuento 5%
    var discountAmount = 0;
    var jsonCookie = [];
    if (Cookies.get('cart')) {
        jsonCookie  = JSON.parse(Cookies.get('cart'));
        itemData.length  = 0;

        /* Tasas e impuestos */
        tasa = 0;
        jsonCookie.forEach((t, index) => { tasa += t.tasas_impuestos; });
        feesAndTaxRate = tasa / jsonCookie.length;
        
        (jsonCookie).forEach((value,index) => {
            (value['personas']).forEach((val,i) => {
                tempItem = {
                    item     : caracteresEspeciales(value['titulo_producto']+" ("+val['descripcion_etapa_edad']+" "+val['descripcion_nacionalidad']+")"),
                    quantity : val['cantidad'],
                    price    : ( parseFloat(value['total']) / parseFloat(val['cantidad']) )
                };
                itemData.push(tempItem);    
            });
            if ( (value['recursos']) ) {
                (value['recursos']).forEach((v,j) => {
                    tempRecurso = {
                        item     : caracteresEspeciales(v['nombre']+' x'+v['cantidad']),
                        quantity : parseInt(v['cantidad']),
                        price    : parseFloat(v['precio'])    
                    }
                    itemData.push(tempRecurso);
                });
            }
        });
    }

    //console.log(JSON.stringify(jsonCookie));
    //console.log("DATA",JSON.stringify(itemData));
    console.log("Done loading transact.js");
    objPaypal                   = new ConfigPaypal();
    objPaypal.data              = itemData;
    objPaypal.feesTaxRate       = feesAndTaxRate;
    objPaypal.taxCart           = objPaypal.totalFeesTaxRate;
    //objPaypal.urlTransaction    = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    objPaypal.urlTransaction    = 'https://www.paypal.com/cgi-bin/webscr';    
    //objPaypal.emailBusiness     = 'incalake004@gmail.com';
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
    //console.log("******************** PAYPAL *******************");
    //console.log("FEES AND TAX",objPaypal.feesTaxRate,"%");
    //console.log("SUB TOTAL AMOUNT",objPaypal.currencyCode,objPaypal.totalPrice);
    //console.log("FEES AND TAX", objPaypal.totalFeesTaxRate );
    //console.log("TOTAL AMOUNT",(parseFloat(objPaypal.totalPrice)+parseFloat(objPaypal.totalFeesTaxRate)));
    //console.log("PAYPAL CONFIG",configPaypalStatus);
    
    
    objCulqi                = new ConfigCulqi();
    //objCulqi.publicKey      = "pk_test_NVbRNu7rdWFpxXI7";
    objCulqi.publicKey     = 'pk_live_17reIdaSwa03ckDL';
    objCulqi.data           = itemData;
    objCulqi.feesTaxRate    = feesAndTaxRate;
    objCulqi.title          = "Inca Lake";
    objCulqi.currency       = 'USD';
    objCulqi.description    = 'Tours or Activities Inca Lake';
    objCulqi.amount         = objCulqi.totalPrice+objCulqi.totalFeesTaxRate;
    
    var configCulqiStatus = objCulqi.validData;

    validarBotonComprar(configCulqiStatus,"btn-culqi","data-culqi-initialize");

    //console.log("********************* CULQI *******************");
    //console.log("FEES AND TAX",objCulqi.feesTaxRate,"%");
    //console.log("AMOUNT STRING CULQI",objCulqi.currency,objCulqi.amountCulqi);
    //console.log("SUB TOTAL AMOUNT",objCulqi.currency,objCulqi.totalPrice);
    //console.log("FEES AND TAX",objCulqi.totalFeesTaxRate);
    //console.log("TOTAL AMOUNT",objCulqi.amount);
    //console.log("CULQI CONFIG",configCulqiStatus);

    if (objCulqi.publicKey) {
        Culqi.publicKey = objCulqi.publicKey;
        Culqi.init();
    }
    /*
    document.getElementById("btn-culqi").addEventListener("click", function(e){
        e.preventDefault();
        Culqi.createToken();
        //console.log("Click..!");    
    }); 
    document.getElementById("btn-paypal").addEventListener("click", function(e){
        e.preventDefault();
        document.paypalFormPayment.submit();
    });
    */
    $(document).on('click','#btn-culqi',function(e){
        e.preventDefault();
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
        //console.log("Click..!"); 
    });

    $(document).on('click','#btn-paypal',function(e){
        e.preventDefault();
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

    window.registerCustomer = (method) =>  
    {
        customer = JSON.parse(Cookies.get('customer'));
        cart = JSON.parse(Cookies.get('cart'));
        dataJson = {
            id: '',
            language : document.documentElement.lang,
            url: window.location.host,
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

        Cookies.remove('reserva_incalake');
        Cookies.set('reserva_incalake', JSON.stringify(dataJson), { domain: '.incalake.com' });
        //console.log("jsonData",dataJson);
    }

    function culqi() {
        if(Culqi.token) {
            
            registerCustomer('culqi'); /* Registro de Datos */

            var token = Culqi.token.id;
            var serverData = {
                token           : Culqi.token.id,
                amount          : (objCulqi.amount).toFixed(2),
                subTotalAmount  : (objCulqi.totalPrice).toFixed(2),
                currency        : objCulqi.currency,
                description     : objCulqi.description,
                email           : Culqi.token.email,
                amountString    : objCulqi.amountCulqi
                //metadata    : JSON.stringify(Culqi) 
            };
            
            $.ajax({
                url: 'https://shop.incalake.com/transaccion/transaccion-incalake.php',
                //url: 'https://shop.incalake.com/transaccion/transaccion-incalake-test.php',
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
                            $.unblockUI();
                            window.location.href = base_url+langApp+'/checkout/confirm?codr='+id_reserva;         
                        });                       
                                  
                        //alert('transacción Realizada con éxito..!');

                        //implementar respuesta al cliente sobre la tranzacción realizada mediante culqi.
                        
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




