jQuery(document).ready(function($) {
console.log("Loading complementos.js");
    var idioma      = document.documentElement.lang;
    var id_idioma = document.documentElement.lang == "fr" ? 2 : document.documentElement.lang == "en" ? 1 : 0;
    $.ajax({
        url: 'header.html',
        type: 'GET',
        dataType: 'html',
    }).done(function(data) {
        $("body>header").empty();
        $("body>header").append(data); 
        var whilberth = true;
        $("body>header").html(data);
        $("div#mapSection").hide();
        $("#mymap").css("height", "450px");
        $('#butMapWhil').click(function () {
            $("div#mapSection").slideToggle();
            if (whilberth == true) {
                $("#mymap").html("<iframe src='https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3838.2886259878474!2d-70.02857166662598!3d-15.841420603534218!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x85d256b37e60e72a!2sInca+Lake!5e0!3m2!1ses!2spe!4v1399734781525' width='100%' height='100%' frameborder='0' style='border:0'></iframe>");
                whilberth = false;
            };
        });
       /* $("#Espanhol").on("click", function () {    translate(0);   });
        $("#English").on("click", function () {     translate(1);   });
        $("#French").on("click", function () {      translate(2);   });
        $("#Aleman").on("click", function () {      translate(3);   });   */  
        
/*nuevo codigo de manejo de urls*/
  links = $('.btn-group a');//selecciona solo el primero btn-group para evitar congestion
 
  var divPrecios = $('.precio_tour_gral');
   //alert(divPrecios.length);
  if(divPrecios.length)obtenerUrls(divPrecios[0].getAttribute('data-tour'));
  else links.each(function(i){$(this).click(function(){translate(i);});}); 
/*fin de nuevo codigo*/ 
  
    
    }).fail(function() {
        console.log("error");
    });

    $.ajax({
        url: 'footer.html',
        type: 'GET',
        dataType: 'html',
    }).done(function(data) {
        $("footer").empty();
        $("footer").append(data);
        $('#tripFooter').html('<div id="TA_certificateOfExcellence369" class="TA_certificateOfExcellence"><ul id="dzJvpZBuxao" class="TA_links JfYTeXkkc4lF"><li id="j7ibdN" class="02kYJCI3xHd"><a target="_blank" href="https://www.tripadvisor.com/Attraction_Review-g298442-d3265896-Reviews-Inca_Lake_Day_Tours-Puno_Puno_Region.html"><img src="https://www.tripadvisor.com/img/cdsi/img2/awards/CoE2016_WidgetAsset-14348-2.png" alt="TripAdvisor" class="widCOEImg" id="CDSWIDCOELOGO"/></a></li></ul></div><script src="https://www.jscache.com/wejs?wtype=certificateOfExcellence&amp;uniq=369&amp;locationId=3265896&amp;lang=en_US&amp;year=2016&amp;display_version=2"></script>');
    }).fail(function() {
        console.log("error");
    });
    
    
  /*funcion aniadido por froilan para el manejo de urls*/
    function obtenerUrls(ide){
    $.ajax({ method: "POST",
            url: "http://incalake.com/control/public/ajax/getUrls.php",
            data: {idePaquete:ide}
          }).done(function(exito){
               //alert(exito);
               var json = JSON.parse(exito);
               if(json.length){
                 links[0].href=json[0].url_es.length ? json[0].url_es : 'http://incalake.com/';
                 links[1].href=json[0].url_en.length ? json[0].url_en : 'http://en.incalake.com/';
                 links[2].href=json[0].url_fr.length ? json[0].url_fr : 'http://fr.incalake.com/';
                 links[3].href=json[0].url_de.length ? json[0].url_de : 'http://de.incalake.com/';
               }            
    });
}
 /*fin de funcion para manejo de urls*/
    
    
    
    function translate(idioma) {
        var urlClave = document.URL.split(".com/");
        var exitoTranslate = 0;
        var ResultadoTranslate = 'http://incalake.com/';
        $.ajax({
            async: true,
            cache: false,
            crossDomain: true,
            data: {enPHP: id_idioma, nomPHP: urlClave[1], salPHP: idioma},
            dataType: 'jsonp',
            jsonp: 'jsonp_callback',
            type: "GET",
            url: "http://www.incalake.com/wcontent/url.php",
            success: function (result) {
                if (!result.url) {
                    console.log("Lo redigiremos a la página principal.");
                    location.href = idioma == "1" ? "http://en.incalake.com/" : idioma == "2" ? "http://fr.incalake.com/" : "http://incalake.com/";
                } else {
                    location.href = result.url;
                };
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('Error ' + jqXHR + ', ' + textStatus + ',' + idioma);
            }
        });
    }
    function miFecha() {
        var f = new Date();
        return (f.getFullYear() + "-" + str_pad((f.getMonth() + 1), 2, '0', 'STR_PAD_LEFT') + "-" + str_pad(f.getDate(), 2, '0', 'STR_PAD_LEFT') + " " + str_pad(f.getHours(), 2, '0', 'STR_PAD_LEFT') + ":" + str_pad(f.getMinutes(), 2, '0', 'STR_PAD_LEFT') + ":" + str_pad(f.getSeconds(), 2, '0', 'STR_PAD_LEFT') + ":" + f.getMilliseconds());
    }

    function miFechaDetalle(tipoFecha) {
        var whilFechaDetalle = miFecha().split(' ');
        return tipoFecha == 1 ? whilFechaDetalle[0] : whilFechaDetalle[1];
    }
    /******************* FIN CAMBIAR IDIOMA **************************/

    var texto = {
        numero_de_personas :['Número de Personas','Number of Person'],
        precio_por : ['Precio por ','Price for '],
        personas : [' Persona(s)',' Person(s)'],
        precio_por_persona : ['Precio por Persona','Price per Person '],
        precio_total_por: ['Precio Total por ','Total Price for '],
        precio_por_persona : ['Precio por Persona','Price for Person '],
        precio_total_por_personas: ['Precio Total por Personas','Total Price for Person '],
        precio_total:['Precio Total','Total Price'],
        mas_detalles: ['Más Detalles','More Details'],
        precio_total_dolares: ['Precio Total Dólares:','Total Price Dollars:'],
        precio_total_soles : ['Precio Total Soles:','Total Price Soles:'],
        tasa_de_cambio: ['Tasa de Cambio:','Exchange Rate:'],
        antes:['ANTES','BEFORE'],
        ahora: ['AHORA','NOW'],
        nacionales: ['Nacionales','National People'],
        extranjeros: ['Extranjeros','Foreign People'],
        infantes:['Infante','Infant'],
        niños: ['Niño','Boy'],
        adolescentes: ['Adolescente','Teen'],
        adultos : ['Adulto','Adult'],
        adulto_mayor:['adulto Mayor','Elderly'],
        anios:['Años','Years'],
        reservar: ['RESERVAR','BOOK NOW'],
        para_mas_de:['Para ','For more than'],
        personas_escribenos_al_correo: ['persona(s) escríbenos al email: reservas@incalake.com','people email us: reservas@incalake.com'],
        url_reservas:['http://incalake.com/','http://en.incalake.com/','http://fr.incalake.com/','de.http://incalake.com/'],
    };
    function redondear(number) {
        return parseFloat(number).toFixed(2);
    }
    function extraer_datos(data,valor){
        // 0 = Precio, 1 = cantidad de personas.
        var elemento = data.split(',');
        var a = elemento[0].split(':');
        if ( valor == 0 || valor === '0' ) {
            return a[1];
        }else{
            return a[0];
        }
    }
    function precio_dos_personas(data,valor){
        var response = 0;
        var elemento = data.split(',');
        if (elemento.length == 1 ) {
            var a = elemento[0].split(':');
            if (a[0] == 1 || a[0] === '1' ) {
                if ( valor == 0 ) {
                    response = a[1];
                }else{
                    response = 2;
                }
            }
        }else{
            var aa  = elemento[0].split(':');
            var aaa = elemento[1].split(':');
            if (aa[0] == 2 || aa[0] === '2' ) {
                if ( valor == 0 ) {
                    response = aa[1];
                }else{
                    response = 2;
                }
            }else{
                if ( valor == 0 ) {
                    response = aaa[1];
                }else{
                    response = 2;
                }
            }
        }
        return parseFloat(response);
    }
    function extraer_datos_personalizados(data,valor){
        // 0 = Precio, 1 = cantidad de personas.
        var elemento = data.split(',');
        var a = elemento[1].split(':');
        if ( valor == 0 || valor === '0' ) {
            return a[1];
        }else{
            return a[0];
        }
    }
    var data_tours  = '0';
    $('.precio_tour_gral').each(function (i, element) {
        data_tours += ',' + $(element).data('tour');
    });

    if(data_tours != '0'){
       $.ajax({
            url: "http://incalake.com/control/index.php/precios/result",
            type: 'POST',
            dataType: 'json',
            data: {data: data_tours,language: idioma },
        }).done(function(data) {
            $.each(data, function(index, val) {            
                if ( val['precios_personalizados'].length === 0 ) {
                    divs_precios(val);
                }else{
                    divs_precios_personalizados(val);
                }
            });
        }).fail(function(e) {
            console.log(e.responseText);
        });
    }else{console.log("No hay tours..!");}
    /*
    function precio_unitario(data_precio,personas){
        var p_g = data_precio.split(',');
        var cantidad = 0;
        $.each(p_g, function(index, val) {
            var precio_general = val.split(':');
            if ( precio_general[0] === personas || precio_general[0] === ''+personas ) {
                cantidad = precio_general[1];
            }else if (precio_general[1] == undefined ) {
                cantidad = precio_general[0];
            }
        });
        return cantidad;
    }
    */
    function precio_unitario(data_precio,personas){
        var p_g = data_precio.split(',');
        var cantidad = 0;
        if( p_g.length == 1 ){
            var p = p_g[0].split(':');
            cantidad = parseFloat(p[1])/parseFloat(p[0]);
        }else{
            $.each(p_g, function(index, val) {
                var precio_general = val.split(':');
                if ( precio_general[0] === personas || precio_general[0] === ''+personas ) {
                    cantidad = precio_general[1];
                }
                /*
                else if (precio_general[1] == undefined ) {
                    cantidad = precio_general[0];
                }
                */
            });
        }
        return cantidad;
    }
    function divs_precios(data){
        console.log(data['precio']);
        //console.log(data['dolar']['valor_actual']);
        var html  = '';
        if( data['estado_descuento'] == 0 || data['estado_descuento']  === '0' ){
            html =  '<div class=" precio-div-padre">'+
                    '<div class="col-md-12  text-center" style="padding: 0;">'+
                        '<div class="title-precios" id="titulo_tour">'+data['nombre']+'</div>'+
                    '</div>'+
                    '<div class="col-md-12 " style="padding: 0;">'+
                        '<div class="precio text-center container-fluid">'+
                            '<div class="col-md-12 col-xd-12" style="padding:0px;">'+
                                '<div class="col-md-6 col-xs-6" style="padding:0px;">'+
                                    '<div class="precio-descripcion-titulo">'+texto['numero_de_personas'][id_idioma]+'</div>'+                            
                                '</div>'+
                                '<div class="col-md-6 col-xs-6" style="padding:0px;">'+
                                    '<div class="col-xs-6" style="padding:0px;">'+
                                        '<div class="precio-descripcion-titulo">'+texto['precio_por_persona'][id_idioma]+'</div>'+
                                    '</div>'+
                                    '<div class="col-xs-6" style="padding:0px;">'+
                                        '<div class="precio-descripcion-titulo">'+texto['precio_total_por'][id_idioma]+'<span class="span_texto_cantidad_personas_'+data['idexcursion']+'">'+precio_dos_personas(data['precio'],1)+ '</span>' +texto['personas'][id_idioma]+'</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-md-12 col-xd-12" style="padding:0px;height: 34px;line-height: 34px;">'+
                                '<div class="col-md-6 col-xs-6" style="padding:0px;">'+
                                    '<div class="btn-group" style="width: auto !important; margin: auto !important;">'+
                                        '<div class="btn btn-default btn_precios" data-value="-1" data-id="'+data['idexcursion']+'" data-descuento="'+data['descuentos']+'" data-precio="'+data['precio']+'" data-dolar="'+data['dolar']['valor_actual']+'"><i class="fa fa-caret-left" aria-hidden="true"></i></div>'+
                                        '<input name="num_personas" type="text" style="height: 34px;" name="" value="'+precio_dos_personas(data['precio'],1)+'" class="num-personas-input txt_num_personas num_personas_'+data['idexcursion']+'" id="num_personas_'+data['idexcursion']+'" data-id="'+data['idexcursion']+'" data-descuento="'+data['descuentos']+'" data-precio="'+data['precio']+'" data-ed="'+data['estado_descuento']+'" data-dolar="'+data['dolar']['valor_actual']+'">'+
                                        '<div class="btn btn-default btn_precios" data-value="1" data-id="'+data['idexcursion']+'" data-descuento="'+data['descuentos']+'" data-precio="'+data['precio']+'" data-dolar="'+data['dolar']['valor_actual']+'"><i class="fa fa-caret-right" aria-hidden="true"></i></div>'+
                                    '</div>'+                            
                                '</div>'+
                                '<div class="col-md-6 col-xs-6" style="padding:0px; ">'+
                                    '<div class="col-xs-6" style="padding:0px;">'+                                        
                                        '<span class="precio-descripcion">$  </span>'+
                                        '<span class="precios" id="precio_tour_unitario_'+data['idexcursion']+'">'+redondear( precio_dos_personas(data['precio'],0) )+'</span>'+
                                        '<span class="precio-descripcion">USD</span>'+
                                    '</div>'+
                                    '<div class="col-xs-6" style="padding:0px;">'+                                        
                                        '<span class="precio-descripcion">$ </span>'+
                                        '<span class="precios precio_total_'+data['idexcursion']+'">'+redondear( parseFloat( precio_dos_personas( data['precio'],0) ) * 2 )+'</span>'+
                                        '<span class="precio-descripcion">USD</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                   '<div class="col-md-12" style="padding: 0;">'+
                        '<div style="cursor: pointer; padding: 5px;" class="bg-info text-center border" data-toggle="collapse" data-target="#detalles_'+data['idexcursion']+'"><strong><small>'+texto['mas_detalles'][id_idioma]+'</small></strong></div>'+
                        '<div id="detalles_'+data['idexcursion']+'" class="collapse container-fluid" style="background: #fff; padding: 0 !important">'+
                            '<div class="form-group ">'+
                                '<ul>'+
                                    '<li class="col-xs-12 border ">'+
                                        '<div class=" col-xs-6 text-right"><small>'+texto['precio_total_por'][id_idioma] + precio_dos_personas(data['precio'],1) + texto['personas'][id_idioma]+':</small></div>'+
                                        '<div class=" col-xs-6 text-left"><small><strong>$ <span id="precio_unitario_persona_mas_detalles_'+data['idexcursion']+'">'+redondear( parseFloat( precio_dos_personas( data['precio'],0) ) )+'</span></strong></small></div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right"><small>'+texto['numero_de_personas'][id_idioma]+':</small></div>'+
                                        '<div class="col-xs-6 text-left numero_personas_'+data['idexcursion']+'"><small><strong>'+precio_dos_personas(data['precio'],1)+'</strong></small></div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right"><small>'+texto['precio_total_dolares'][id_idioma]+'</small></div>'+
                                        '<div class="col-xs-6 text-left precio_total_usd_'+data['idexcursion']+'"><small><strong>$ '+redondear( parseFloat( precio_dos_personas( data['precio'],0 ) ) * 2 )+'</strong></small></div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right"><small>'+texto['precio_total_soles'][id_idioma]+'</small></div>'+
                                        '<div class="col-xs-6 text-left precio_total_soles_'+data['idexcursion']+'"><small><strong>S/.'+ redondear( parseFloat( precio_dos_personas( data['precio'],0 ) * 2  )* parseFloat( data['dolar']['valor_actual'] ) )+'</strong></small></div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right"><small>'+texto['tasa_de_cambio'][id_idioma]+'</small></div>'+
                                        '<div class="col-xs-6 text-left"><small><strong> (T.C. S/. '+data['dolar']['valor_actual']+')</strong></small></div>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-12  text-center" style="padding: 0;">'+
                        '<div class="border">'+
                            '<a href="'+texto['url_reservas'][id_idioma]+'reservas.html?t='+data['idexcursion']+'&p=0" target="_blank" class="btn btn-danger">'+texto['reservar'][id_idioma]+'</a>'+
                        '</div>'+
                    '</div>'+
            '</div>';
        }else{
            html =  '<div class=" precio-div-padre">'+
                        '<div class="col-md-12  text-center" style="padding: 0;">'+
                            '<div class="title-precios" id="titulo_tour">'+data['nombre']+'</div>'+
                        '</div>'+
                        '<div class="col-md-12 " style="padding: 0;">'+
                            '<div class="precio text-center container-fluid">'+
                                '<div class="col-md-12 col-xd-12" style="padding:0px;">'+
                                    '<div class="col-md-6 col-xs-6" style="padding:0px;">'+
                                        '<div class="precio-descripcion-titulo">'+texto['precio_por'][id_idioma]+ extraer_datos(data['precio'],1) +texto['personas'][id_idioma]+'</div>'+                            
                                    '</div>'+
                                    '<div class="col-md-6 col-xs-6" style="padding:0px;">'+
                                        '<div class="col-xs-6" style="padding:0px;">'+
                                            '<div class="precio-descripcion-titulo">'+texto['precio_por'][id_idioma]+extraer_datos(data['precio'],1)+texto['personas'][id_idioma]+'</div>'+
                                        '</div>'+
                                        '<div class="col-xs-6" style="padding:0px;">'+
                                            '<div class="precio-descripcion-titulo">'+texto['precio_total_por'][id_idioma]+'<span class="span_texto_cantidad_personas_'+data['idexcursion']+'">'+extraer_datos(data['precio'],1)+ '</span>' +texto['personas'][id_idioma]+'</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-12 col-xd-12" style="padding: 5px 0 0 0;">'+
                                    '<div class="col-md-6 col-xs-6" style="padding:0px; height: 80px;line-height: 80px;">'+
                                        '<div class="btn-group" style="width: auto !important; margin: auto !important;">'+
                                            '<div class="btn btn-default btn_precios" data-value="-1" data-id="'+data['idexcursion']+'" data-descuento="'+data['descuentos']+'" data-precio="'+data['precio']+'" data-dolar="'+data['dolar']['valor_actual']+'"><i class="fa fa-caret-left" aria-hidden="true"></i></div>'+
                                            '<input name="num_personas" style="height: 34px;" type="text" name="" value="'+extraer_datos(data['precio'],1)+'" class="num-personas-input txt_num_personas num_personas_'+data['idexcursion']+'" id="num_personas_'+data['idexcursion']+'" data-id="'+data['idexcursion']+'" data-descuento="'+data['descuentos']+'" data-precio="'+data['precio']+'" data-ed="'+data['estado_descuento']+'" data-dolar="'+data['dolar']['valor_actual']+'">'+
                                            '<div class="btn btn-default btn_precios" data-value="1" data-id="'+data['idexcursion']+'" data-descuento="'+data['descuentos']+'" data-precio="'+data['precio']+'" data-dolar="'+data['dolar']['valor_actual']+'"><i class="fa fa-caret-right" aria-hidden="true"></i></div>'+
                                        '</div>'+                           
                                    '</div>'+
                                    '<div class="col-md-6 col-xs-6" style="padding:0px;">'+
                                        '<div class="col-md-12 col-xs-12" style="padding:0px;">'+                                        
                                            '<div class="col-md-6 col-xs-6" style="padding:0px;">'+
                                                '<div class="precio-tachar">'+
                                                    '<div class="precio-descripcion"><strong>'+texto['antes'][id_idioma]+'</strong></div>'+
                                                    '<span class="precio-descripcion">$ </span>'+
                                                    '<span class="precios-antes" id="precio_tour">'+redondear(parseFloat(extraer_datos(data['precio'],1))*parseFloat(extraer_datos(data['precio'],0)))+'</span>'+
                                                    '<span class="precio-descripcion">USD</span>'+
                                                '</div>'+                                            
                                            '</div>'+
                                            '<div class=" col-md-6 col-xs-6" style="padding:0px;">'+
                                                '<div class="precio-tachar">'+
                                                    '<div class="precio-descripcion"><strong>'+texto['antes'][id_idioma]+'</strong></div>'+
                                                    '<span class="precio-descripcion">$ </span>'+
                                                    '<span class="precios-antes precio_total_antes_'+data['idexcursion']+'">'+redondear(parseFloat(extraer_datos(data['precio'],1))*parseFloat(extraer_datos(data['precio'],0)))+'</span>'+
                                                    '<span class="precio-descripcion">USD</span>'+
                                                '</div>'+                                            
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-12 col-xs-12" style="padding:0px; padding: 5px 0 0 0;">'+                                        
                                            '<div class="col-md-6 col-xs-6" style="padding:0px;">'+
                                                '<div class="precio-descripcion-titulo">'+texto['ahora'][id_idioma]+'</div>'+
                                                '<span class="precio-descripcion">$  </span>'+
                                                '<span class="precios" id="precio_tour_unitario_'+data['idexcursion']+'">'+ redondear( descuentos(extraer_datos(data['precio'],0),data['descuentos'])*parseFloat(extraer_datos(data['precio'],1) ) ) +'</span>'+
                                                '<span class="precio-descripcion">USD</span>'+                                           
                                            '</div>'+
                                            '<div class=" col-md-6  col-xs-6" style="padding:0px;">'+
                                                '<div class="precio-descripcion-titulo">'+texto['ahora'][id_idioma]+'</div>'+
                                                '<span class="precio-descripcion">$ </span>'+
                                                '<span class="precios precio_total_ahora_'+data['idexcursion']+'">'+ redondear( descuentos(extraer_datos(data['precio'],0),data['descuentos'])*parseFloat(extraer_datos(data['precio'],1) ) ) +'</span>'+
                                                '<span class="precio-descripcion">USD</span>'+                                          
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                       '<div class="col-md-12" style="padding: 0;">'+
                            '<div style="cursor: pointer; padding: 5px;" class="bg-info text-center border" data-toggle="collapse" data-target="#detalles_'+data['idexcursion']+'">'+texto['mas_detalles'][id_idioma]+'</div>'+
                            '<div id="detalles_'+data['idexcursion']+'" class="collapse container-fluid" style="background: #fff; padding: 0 !important">'+
                                '<div class="form-group ">'+
                                    '<ul>'+
                                    '<li class="col-xs-12 border ">'+
                                        '<div class=" col-xs-6 text-right">'+texto['precio_por_persona'][id_idioma]+':</div>'+
                                        '<div class=" col-xs-6 text-left"> <small><strong>$  <span id="precio_unitario_persona_mas_detalles_'+data['idexcursion']+'"> '+ redondear( descuentos(extraer_datos(data['precio'],0),data['descuentos'])*parseFloat(extraer_datos(data['precio'],1) ) ) +'</span></strong></small></div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right">'+texto['numero_de_personas'][id_idioma]+':</div>'+
                                        '<div class="col-xs-6 text-left numero_personas_'+data['idexcursion']+'">1</div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right">'+texto['precio_total_dolares'][id_idioma]+'</div>'+
                                        '<div class="col-xs-6 text-left precio_total_usd_'+data['idexcursion']+'">$ '+ redondear( descuentos(extraer_datos(data['precio'],0),data['descuentos'])*parseFloat(extraer_datos(data['precio'],1) ) ) +'</div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right">'+texto['precio_total_soles'][id_idioma]+'</div>'+
                                        '<div class="col-xs-6 text-left precio_total_soles_'+data['idexcursion']+'">S/.'+redondear( descuentos(extraer_datos(data['precio'],0),data['descuentos'])*parseFloat(extraer_datos(data['precio'],1) )*data['dolar']['valor_actual'] )+'</div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right">'+texto['tasa_de_cambio'][id_idioma]+'</div>'+
                                        '<div class="col-xs-6 text-left"> (T.C. S/. '+data['dolar']['valor_actual']+')</div>'+
                                    '</li>'+
                                '</ul>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-12  text-center" style="padding: 0;">'+
                            '<div class="border">'+
                                '<a href="'+texto['url_reservas'][id_idioma]+'reservas.html?t='+data['idexcursion']+'&p=0" target="_blank" class="btn btn-danger">'+texto['reservar'][id_idioma]+'</a>'+ 
                            '</div>'+
                        '</div>'+
                '</div>';
        }
        $( '#precio_'+data['idexcursion'] ).empty();
        $( '#precio_'+data['idexcursion'] ).append(html);
    }
    $('body').on('change keyup paste', '.txt_num_personas', function () {
        var estadoinput  = 0;
        var idinput         = $(this).data('id');
        var descuentoinput  = $(this).data('descuento');
        var precioinput     = $(this).data('precio');
        var dolarinput      = $(this).data('dolar');
        var valorinput      = $(this).val();
        var edinput         = $(this).data('ed');
        var precio_totalinput   = parseInt(valorinput) * parseInt(precioinput);
        var precio_total_solesinput  = (dolarinput)*precio_totalinput;
        if( valorinput <= 30 ){    
            if (  isNaN(precioinput) ) {
                precio_totalinput =  precio_unitario( precioinput, valorinput ) * valorinput;
                if ( ! precio_totalinput == 0 || ! precio_totalinput === '0' ) {
                    precio_total_solesinput = (dolarinput)*precio_totalinput;
                }else{
                    estadoinput = 1;
                }
            }
            if(valorinput > 0 && estadoinput == 0 ){
                actualizar_divs(idinput,valorinput,precio_totalinput,precio_total_solesinput,edinput,descuentoinput);
            }else{
                if ( valorinput == 1) {
                    //$('.num_personas_'+idinput).val(extraer_datos(precioinput,1));
                    precio_totalinput = extraer_datos(precioinput,0) - 2 ;
                    precio_total_solesinput = (dolarinput)*precio_totalinput;
                    actualizar_divs(idinput,valorinput,precio_totalinput,precio_total_solesinput,edinput,descuentoinput);
                    //alert( texto['para_mas_de'][id_idioma]+" "+valorinput+" " + texto['personas_escribenos_al_correo'][id_idioma]);
                }else if( valorinput > 0 ){
                    alert( texto['para_mas_de'][id_idioma]+" "+valorinput+" " + texto['personas_escribenos_al_correo'][id_idioma]);
                }
            }
        }else{
            alert( texto['para_mas_de'][id_idioma]+" "+valorinput+" " + texto['personas_escribenos_al_correo'][id_idioma]);
        }
    });
    $('body').on('click', '.btn_precios', function () {
        var estado = 0;
        var id  = $(this).data('id');
        var v   = $(this).data('value');
        var d   = $(this).data('descuento');
        var p   = $(this).data('precio');
        var dolar= $(this).data('dolar');
        var ed  = $('.num_personas_' + id).data('ed');
        var val = $('.num_personas_' + id).val() * 1 + v * 1;
        var precio_total = parseInt(val) * parseInt(p);
        var precio_total_soles = (dolar)*precio_total;
        if( val <= 30 ){    
            if (  isNaN(p) ) {
                precio_total =  precio_unitario( p, val ) * val;
                if ( ! precio_total == 0 || ! precio_total === '0' ) {
                    precio_total_soles = (dolar)*precio_total;
                }else{
                    estado = 1;
                }
            }
            if (val > 0 && estado == 0 ) {
                actualizar_divs(id, val,precio_total,precio_total_soles,ed,d,dolar);
            }else{
                if ( val == 1 ) {
                    precio_total = extraer_datos(p,0) - 2 ;
                    precio_total_soles = (dolar)*precio_total;
                    actualizar_divs(id, val,precio_total,precio_total_soles,ed,d,dolar);
                    //alert( texto['para_mas_de'][id_idioma]+" "+val+" " + texto['personas_escribenos_al_correo'][id_idioma]);
                }else if( val > 0 ){
                    alert( texto['para_mas_de'][id_idioma]+" "+val+" " + texto['personas_escribenos_al_correo'][id_idioma]);
                }
            }
        }else{
            alert( texto['para_mas_de'][id_idioma]+" "+val+" " + texto['personas_escribenos_al_correo'][id_idioma]);
        }
    });
    function actualizar_divs(iddiv,valor,p_total,p_total_soles,descuento, descuentoval,dolar) {
        if (descuento == 0 || descuento == '0' ) {
            $('.num_personas_' + iddiv).val(valor);
            $('.precio_total_' + iddiv).empty();
            $('.precio_total_' + iddiv).text( redondear(p_total) );
            $('.precio_total_usd_' + iddiv).empty();
            $('.precio_total_usd_' + iddiv).text( '$ '+ redondear(p_total) );
            $('.precio_total_soles_' + iddiv).empty();
            $('.precio_total_soles_' + iddiv).text( 'S/. '+ redondear(p_total_soles) );
            $('.numero_personas_' + iddiv).text( valor ); 
            $('#precio_tour_unitario_'+iddiv).empty();
            $('#precio_tour_unitario_'+iddiv).text(redondear(p_total/valor));
            $('#precio_unitario_persona_mas_detalles_'+iddiv).text(redondear(p_total/valor));

            $('.span_texto_cantidad_personas_' + iddiv).text(valor);           
        }else{
            $('.num_personas_' + iddiv).val(valor);
            $('.precio_total_' + iddiv).empty();
            $('.precio_total_' + iddiv).text( redondear(p_total) );
            $('.precio_total_usd_' + iddiv).empty();
            $('.precio_total_usd_' + iddiv).text( '$ '+ descuentos(p_total,descuentoval) );
            $('.precio_total_soles_' + iddiv).empty();
            $('.precio_total_soles_' + iddiv).text( 'S/. '+ redondear( descuentos(p_total,descuentoval)*dolar ) );
            $('.numero_personas_' + iddiv).text( valor ); 

            $('.precio_total_antes_' + iddiv).text( redondear(p_total) ); 
            $('.precio_total_ahora_' + iddiv).text( descuentos(p_total,descuentoval) );

            $('#precio_tour_unitario_'+iddiv).empty();
            $('#precio_tour_unitario_'+iddiv).text(redondear(p_total/valor));

            $('.span_texto_cantidad_personas_' + iddiv).text(valor);

            $('#precio_unitario_persona_mas_detalles_'+iddiv).text(redondear(p_total/valor));
        }
    }

    function descuentos(p,d) {
        var total = (p - (p*d/100) );
        return total.toFixed(2);
    }

    /********************** IMPLEMENTACION PARA PRECIOS DIFERENCIADOS *******************/
    $('body').on('click', '.btn_precios_personalizados', function () {
        var estado = 0;
        var id  = $(this).data('id');
        var v   = $(this).data('value');
        var p   = $(this).data('precio');
        var dolarper = $(this).data('dolar');
        console.log("DOLAR PER: " + dolarper);
        var nacionalidad = $(this).data('nacionalidad');
        var edad = $(this).data('edad');
        var val = $('.num_personas_personalizado_'+ nacionalidad + '_' + edad + '_' + id).val() * 1 + v * 1;
        //console.log(id + " - " + v + " - " + p + " - " + nacionalidad + "_" + edad+ "_" + id);
        var precio_total_personalizado = parseInt(val) * parseInt(p);
        if (  isNaN(p) ) {
            precio_total_personalizado =  precio_unitario_personalizado( p, val )*val;
            if ( precio_total_personalizado == 0 || precio_total_personalizado === '0' ) {
                estado = 1;
            }
        }
        if (val > 0 && estado == 0 ) {
            $('.num_personas_personalizado_'+nacionalidad+ '_' + edad + '_' + id ).val(val);
            $('.precios_'+nacionalidad+ '_' + edad + '_' + id ).empty();
            $('.precios_'+nacionalidad+ '_' + edad + '_' + id ).text(redondear(precio_total_personalizado));
        }else{
            if ( val >= 1 ) {
                alert(texto['para_mas_de'][id_idioma]+" "+ val +" " + texto['personas_escribenos_al_correo'][id_idioma]);
            }
        }
    });
    $('body').on('change keyup paste', '.txt_num_personas_personalizado', function () {
        var estadoinput  = 0;
        var idinput         = $(this).data('id');
        var precioinput     = $(this).data('precio');
        var dolarperinput   = $(this).data('dolar');
        console.log("DOLAR INPUT PER: " + dolarperinput);
        var valorinput      = $(this).val();
        var nacionalidadinput = $(this).data('nacionalidad');
        var edadinput         = $(this).data('edad');
        var precio_total_personalizado_input   = parseInt(valorinput) * parseInt(precioinput);
        if (  isNaN(precioinput) ) {
            precio_total_personalizado_input =  precio_unitario_personalizado( precioinput, valorinput )*valorinput;
            if ( precio_total_personalizado_input == 0 || precio_total_personalizado_input === '0' ) {
                estadoinput = 1;
            }
        }
        if(valorinput > 0 && estadoinput == 0 ){
            //$('.num_personas_personalizado_'+nacionalidadinput+ '_' + edadinput + '_' + idinput ).val(val);
            $('.precios_'+nacionalidadinput+ '_' + edadinput + '_' + idinput ).empty();
            $('.precios_'+nacionalidadinput+ '_' + edadinput + '_' + idinput ).text(redondear(precio_total_personalizado_input));
        }else{
            if ( valorinput >= 1 ) {
                //$('.num_personas_'+idinput).val( valorinput - 1 );
                $('.num_personas_personalizado_'+nacionalidadinput+ '_' + edadinput + '_' + idinput ).val(extraer_datos_personalizados(precioinput,1));
                alert(texto['para_mas_de'][id_idioma]+" "+ (valorinput) + " " + texto['personas_escribenos_al_correo'][id_idioma]);
            }
        }
    });
    /*
    function precio_unitario_personalizado(data_precio,personas){
        var p_g = data_precio.split(',');
        var cantidad = 0;
        $.each(p_g, function(index, val) {
            var precio_general = val.split(':');
            if ( precio_general[0] === personas || precio_general[0] === ''+personas ) {
                cantidad = precio_general[1];
            }else if (precio_general[1] == undefined ) {
                cantidad = precio_general[0];
            }
        });
        return cantidad;
    }
    */
    function precio_unitario_personalizado(data_precio,personas){
        var p_g = data_precio.split(',');
        var cantidad = 0;
        if( p_g.length == 1 ){
            var p = p_g[1].split(':');
            cantidad = parseFloat(p[1])/parseFloat(p[0]);;
        }else{
           $.each(p_g, function(index, val) {
                var precio_general = val.split(':');
                if ( precio_general[0] === personas || precio_general[0] === ''+personas ) {
                    cantidad = precio_general[1];
                }
                /*
                else if (precio_general[1] == undefined ) {
                    cantidad = precio_general[0];
                }
                */
            }); 
        }

        return cantidad;
    }
    /******************  AGREGA DIVS DE PRECIOS "INFANTES, NIÑOS, ADOLESCENTES, ADULTOS,ADULTO MAYOR" ***********************/
    function agregar_divs_precios_personalizados(idexcursion,nacionalidad,edad,data_precio,dolar_actual) {
        console.log(data_precio);
        var html = '<div class=" col-xs-12 container-fluid ajustar-divs-precios-edad" style="padding: 0px;">'+
                        '<div class="col-md-6 col-sm-6 col-xs-6  " style="padding:0px;">'+
                            '<div class="col-xs-8 text-center" style="padding:0px;">'+
                                '<div class="btn-group" style="width: auto !important; margin: auto !important;">'+
                                    '<div class="btn btn-default boton-num-personas hidden-xs btn_precios_personalizados" data-value="-1" data-id="'+idexcursion+'" data-precio="'+data_precio+'" data-nacionalidad="'+ nacionalidad +'" data-edad="'+ edad +'" data-dolar="'+dolar_actual+'"><i class="fa fa-caret-left" aria-hidden="true"></i>'+
                                    '</div>'+
                                    '<input name="num-personas" type="text" name="" value="1" class="num-personas-input num-personas-input-personalizado  txt_num_personas_personalizado num_personas_personalizado_'+nacionalidad+'_'+ edad +'_'+idexcursion+'" id="num_personas_personalizado_'+nacionalidad+'_'+edad+'_'+idexcursion+'" data-id="'+idexcursion+'" data-precio="'+data_precio+'" data-nacionalidad="'+ nacionalidad +'" data-edad="'+ edad +'" data-dolar="'+dolar_actual+'">'+
                                    '<div class="btn btn-default boton-num-personas hidden-xs btn_precios_personalizados" data-value="1" data-id="'+idexcursion+'" data-precio="'+data_precio+'" data-nacionalidad="'+ nacionalidad +'" data-edad="'+ edad +'" data-dolar="'+dolar_actual+'"><i class="fa fa-caret-right" aria-hidden="true"></i>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-xs-4 text-left precio-descripcion-titulo " style="padding:0px;">'+
                                '<div  class="div-edad">'+ texto[edad][id_idioma] +'</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6 col-sm-6 col-xs-6 " style="padding:0px;">'+
                            '<div class="col-xs-12" style="padding:0px;">'+
                                '<div class="col-sm-6 col-xs-12" style="padding:0px;">'+
                                    '<div>'+
                                        '<span class="precio-descripcion">$  </span>'+
                                        '<span class="precios" id="precio_tour_'+ nacionalidad + "_" + edad + "_" + idexcursion +'">'+redondear(extraer_datos_personalizados(data_precio,0)*extraer_datos_personalizados(data_precio,1))+' </span>'+
                                        '<span class="precio-descripcion">USD</span>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-sm-6 hidden-xs"" style="padding:0px;">'+
                                    '<div>'+
                                        '<span class="precio-descripcion">$ </span>'+
                                        '<span class="precios precios_'+ nacionalidad + '_' + edad + "_" + idexcursion +'">'+redondear(extraer_datos_personalizados(data_precio,0)*extraer_datos_personalizados(data_precio,1))+' </span>'+
                                        '<span class="precio-descripcion">USD</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+                                    
                    '</div>';
        return html;        
    }
    /** FIN AGREGA DIVS DE PRECIOS "INFANTES, NIÑOS, ADOLESCENTES, ADULTOS,ADULTO MAYOR" **/
    
    /******************* AGREGA DIVS DE PRECIOS DIFERENCIADOS *****************************/
    function divs_precios_personalizados(data) {
        var dolar_actual = data['dolar']['valor_actual'];
        var nacionalidad   = ['extranjeros','nacionales'];
        var edad           = ['adultos','infantes','niños','adolescentes','tercera_edad'];
        var html_na_infante   = '';
        var html_na_adolescente  ='';
        var html_na_nino = '';
        var html_na_adulto = '';
        var html_na_adulto_mayor = '';

        var html_ex_infante   = '';
        var html_ex_adolescente  ='';
        var html_ex_nino = '';
        var html_ex_adulto = '';
        var html_ex_adulto_mayor = '';

        $.each(data['precios_personalizados'], function(index, val) {
            var n = val['nacionalidad'];
            switch(val['nacionalidad']){
                case 'nacionales':
                    $.each(val['grupo'], function(i, v) {
                        if ( v['edad'] === 'adultos' ) {
                            var p_na_adultos = '0:0';
                            $.each(v['precios'], function(i, v) {
                                p_na_adultos = p_na_adultos + ',' + i + ':' + v;                               
                            });
                            html_na_adulto += agregar_divs_precios_personalizados(data['idexcursion'],n,v['edad'],p_na_adultos,dolar_actual);
                        }else if ( v['edad'] === 'infantes' ){
                            var p_na_infantes  ='0:0';
                            $.each(v['precios'], function(i, v) {
                                p_na_infantes = p_na_infantes + ',' + i + ':' + v;                                
                            }); 
                            html_na_infante += agregar_divs_precios_personalizados(data['idexcursion'],n,v['edad'],p_na_infantes,dolar_actual);   
                        }else if( v['edad'] === 'niños' ){
                            var p_na_nino  = '0:0';
                            $.each(v['precios'], function(i, v) {
                                p_na_nino = p_na_nino + ',' + i + ':' + v;                               
                            });
                            html_na_nino += agregar_divs_precios_personalizados(data['idexcursion'],n,v['edad'],p_na_nino,dolar_actual);
                        }else if( v['edad'] === 'adolescentes' ){
                            var p_na_adolescente  = '0:0';
                            $.each(v['precios'], function(i, v) { 
                                p_na_adolescente = p_na_adolescente + ',' + i + ':' + v;                              
                            }); 
                            html_na_adolescente += agregar_divs_precios_personalizados(data['idexcursion'],n,v['edad'],p_na_adolescente,dolar_actual);
                        }else if( v['edad'] === 'adulto_mayor' ){
                            var p_na_adulto_mayor = '0:0';
                            $.each(v['precios'], function(i, v) {   
                                p_na_adulto_mayor = p_na_adulto_mayor + ',' + i + ':' + v;                             
                            }); 
                            html_na_adulto_mayor += agregar_divs_precios_personalizados(data['idexcursion'],n,v['edad'],p_na_adulto_mayor,dolar_actual);   
                        }
                    });
                break;
                case 'extranjeros':
                    $.each(val['grupo'], function(i, v) {
                        if ( v['edad'] === 'adultos' ) {
                            var p_ex_adultos  = '0:0';
                            $.each(v['precios'], function(i, v) {
                                p_ex_adultos = p_ex_adultos + ',' + i + ':' + v;                                
                            });
                            html_ex_adulto += agregar_divs_precios_personalizados(data['idexcursion'],n,v['edad'],p_ex_adultos,dolar_actual);
                        }else if ( v['edad'] === 'infantes' ){
                            var p_ex_infantes  = '0:0';
                            $.each(v['precios'], function(i, v) {
                                p_ex_infantes = p_ex_infantes + ',' + i + ':' + v;                                
                            }); 
                            html_ex_infante += agregar_divs_precios_personalizados(data['idexcursion'],n,v['edad'],p_ex_infantes,dolar_actual);   
                        }else if( v['edad'] === 'niños' ){
                            var p_ex_nino = '0:0';
                            $.each(v['precios'], function(i, v) {
                                p_ex_nino = p_ex_nino + ',' + i + ':' + v;
                            }); 
                            html_ex_nino += agregar_divs_precios_personalizados(data['idexcursion'],n,v['edad'],p_ex_nino,dolar_actual);
                        }else if( v['edad'] === 'adolescentes' ){
                            var p_ex_adolescente  = '0:0';
                            $.each(v['precios'], function(i, v) {
                                p_ex_adolescente = p_ex_adolescente + ',' + i + ':' + v;                                
                            }); 
                            html_ex_adolescente += agregar_divs_precios_personalizados(data['idexcursion'],n,v['edad'],p_ex_adolescente,dolar_actual);
                        }else if( v['edad'] === 'adulto_mayor' ){
                            var p_ex_adulto_mayor = '0:0';
                            $.each(v['precios'], function(i, v) {
                                p_ex_adulto_mayor = p_ex_adulto_mayor + ',' + i + ':' + v;
                            }); 
                            html_ex_adulto_mayor += agregar_divs_precios_personalizados(data['idexcursion'],n,v['edad'],p_ex_adulto_mayor,dolar_actual);   
                        }
                    });
                break;
            }
        });
        var html_inicio      = '<div class="row ">'+
                                '<div class="col-md-12 "></div>'+
                                    '<div class="col-md-10 col-md-offset-1 precio-div precio-div-padre">'+
                                        '<div class="col-md-12  text-center">'+
                                            '<div class="title-precios" id="titulo_tour">'+data['nombre']+'</div>'+
                                        '</div>'+
                                        '<div class=" col-md-12 container-fluid" >'+
                                            '<div class="precio container-fluid">'+
                                                '<div class="col-xs-6 " style="padding: 0; border-right: 1px solid #BAD7E7;">'+
                                                '<div class="col-md-12 text-center titulo-nacionalidad ">'+texto['nacionales'][id_idioma]+'</div>'+
                                                    '<div class="precio text-center container-fluid">'+
                                                        '<div class="col-xs-12 container-fluid" style="padding:0px;">'+
                                                            '<div class="precio-descripcion-titulo col-md-6 col-sm-6 col-xs-6" style="padding:0px;">'+texto['numero_de_personas'][id_idioma]+'</div>'+
                                                            '<div class="col-md-6 col-sm-6 col-xs-6 " style="padding:0px;">'+
                                                                '<div class="precio-descripcion-titulo col-sm-6 col-xs-12 " style="padding:0px;">'+texto['precio_por_persona'][id_idioma]+'</div>'+
                                                                '<div class="precio-descripcion-titulo  col-sm-6 hidden-xs" style="padding:0px;">'+texto['precio_total'][id_idioma]+'</div>'+
                                                            '</div>'+
                                                        '</div>';
        var html_separador   =      '</div>'+
                                '</div>'+
                                '<div class="col-xs-6 " style=" padding: 0;">'+
                                '<div class="col-md-12 text-center titulo-nacionalidad ">'+texto['extranjeros'][id_idioma]+'</div>'+
                                    '<div class="precio text-center container-fluid">'+
                                        '<div class="col-xs-12 container-fluid" style="padding:0px;">'+
                                            '<div class="precio-descripcion-titulo col-md-6 col-sm-6 col-xs-6" style="padding:0px;">'+texto['numero_de_personas'][id_idioma]+'</div>'+
                                            '<div class="col-md-6 col-sm-6 col-xs-6 " style="padding:0px;">'+
                                                '<div class="precio-descripcion-titulo col-sm-6 col-xs-12 " style="padding:0px;">'+texto['precio_por_persona'][id_idioma]+'</div>'+
                                                '<div class="precio-descripcion-titulo  col-sm-6 hidden-xs" style="padding:0px;">'+texto['precio_total'][id_idioma]+'</div>'+
                                            '</div>'+
                                        '</div>';
        var html_fin    =   '</div>'+   
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-12 container-fluid">'+
                        '<div class="col-md-12 col-xs-12" style="padding: 0;">'+
                            '<div style="cursor: pointer; padding: 5px;" class="bg-info text-center border" data-toggle="collapse" data-target="#detalles_personalizados_'+data['idexcursion']+'"><strong>'+texto['mas_detalles'][id_idioma]+'</strong></div>'+
                        '<div id="detalles_personalizados_'+data['idexcursion']+'" class="collapse container-fluid" style="background: #fff; padding: 0 !important">'+
                            '<div class="form-group div-mas-detalle ">'+
                                '<ul>'+
                                    '<li class="col-xs-12 border ">'+
                                        '<div class=" col-xs-6 text-right">'+texto['infantes'][id_idioma]+':</div>'+
                                        '<div class=" col-xs-6 text-left">'+data['rango_edad']['infante']+' '+texto['anios'][id_idioma]+'</div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right">'+texto['niños'][id_idioma]+':</div>'+
                                        '<div class="col-xs-6 text-left">'+data['rango_edad']['ninio']+' '+texto['anios'][id_idioma]+'</div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right">'+texto['adolescentes'][id_idioma]+':</div>'+
                                        '<div class="col-xs-6 text-left">'+data['rango_edad']['adolescente']+' '+texto['anios'][id_idioma]+'</div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right">'+texto['adultos'][id_idioma]+':</div>'+
                                        '<div class="col-xs-6 text-left">'+data['rango_edad']['adulto']+' '+texto['anios'][id_idioma]+'</div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right">'+texto['adulto_mayor'][id_idioma]+':</div>'+
                                        '<div class="col-xs-6 text-left">'+data['rango_edad']['adulto_mayor']+' '+texto['anios'][id_idioma]+'</div>'+
                                    '</li>'+
                                    '<li class="col-xs-12 border">'+
                                        '<div class="col-xs-6 text-right"><strong>'+texto['tasa_de_cambio'][id_idioma]+':</strong></div>'+
                                        '<div class="col-xs-6 text-left">(T.C. S/. '+data['dolar']['valor_actual']+')</div>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>'+
                        '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-12  text-center">'+
                        '<div class="border">'+
                            '<a href="'+texto['url_reservas'][id_idioma]+'reservas.html?t='+data['idexcursion']+'&p=0" target="_blank" class="btn btn-danger">'+texto['reservar'][id_idioma]+'</a>'+                        
                        '</div>'+
                    '</div>'+
                '</div></div>'+
            '</div>'+
        '</div>';

        var html_divs_nacionales  = html_na_infante+html_na_nino+html_na_adolescente+html_na_adulto+html_na_adulto_mayor;
        var html_divs_extranjeros = html_ex_infante+html_ex_nino+html_ex_adolescente+html_ex_adulto+html_ex_adulto_mayor;
        $( '#precio_'+data['idexcursion'] ).empty();
        $( '#precio_'+data['idexcursion'] ).append(html_inicio + html_divs_nacionales + html_separador + html_divs_extranjeros + html_fin);
    }
    /******************* FIN AGREGA DIVS DE PRECIOS DIFERENCIADOS *****************************/

    /********************* DESPLIEGA EL PANEL MAS DETALLES DE LOS PRECIOS *****************
    $(document).on('click', '.panel-heading', function(e) {

        var $this = $(this);
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');

        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');

        }
    });

    $(document).on('click', '.panel div.clickable', function(e) {
        var $this = $(this);
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }
    });
    $(document).ready(function() {
        $('.panel-heading span.clickable').click();
        $('.panel div.clickable').click();
    });
    ********************* FINAL DESPLIEGA EL PANEL MAS DETALLES DE LOS PRECIOS ****************/
    /******************************* BEGIN SearchGoogle **********************************/
    (function () {
        var cx = '014210685266793079517:tb6pzsyd9ti';
        var gcse = document.createElement('script');
        gcse.type = 'text/javascript';
        gcse.async = true;
        gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                '//www.google.com/cse/cse.js?cx=' + cx;
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(gcse, s);
    })();
    /******************************* END SearchGoogle **********************************/
    var idexcursion = '';
    idexcursion = $('#relacionados').data('id');    
    if ( $.isNumeric(idexcursion) && idexcursion != '0' ) {
        $.ajax({
            url: 'http://incalake.com/control/index.php/relacionados/excursiones',
            data: {'id': idexcursion, 'idioma': idioma },
            type: 'POST',
            dataType: 'Json',
            success: function (data) {
                div_relacionados(data);
            }
        });            
    }

    function div_relacionados(data) {
        var html  = '';
        $.each(data, function(index, val) {
            var p = val['precio'].split(',');
            var precio = 0;
            if (  isNaN(p[0]) ) {
                var pp = p[0].split(':');
                precio = pp[1];
            }else{
                precio  = p[0];
            }
            var html_oferta = '';
            var tachado = '';
            var fondo_color = '';
            if ( val['estado_descuento'] === '1' || val['estado_descuento'] == 1 ) {
                html_oferta = html_oferta + '<div class="padre">'+
                                                '<div class="hijo3"></div>'+
                                                '<div class="hijo2"></div>'+
                                                '<div class="hijo1"><i class="fa fa-dollar" aria-hidden="true"></i></div>'+
                                                '</div><span class="precio-relacionado" style="margin: 26px 0 0 5px;background: #48a526;">$ ' +descuentos(precio, val['descuento']) + ' USD</span>';
                tachado = tachado + 'line-through;';
                fondo_color=fondo_color+'background: rgba(0, 0, 0, 0.55);';
            }
            //console.log(precio);
            html = html + '<a href="' + val['url'] + '">'+
                '<div class="col-md-12 col-xs-12">'+
                    '<div class="row">'+
                          '<div class="col-md-6 col-xs-6">'+
                                '<span class="precio-relacionado" style="text-decoration: '+tachado+'; '+fondo_color+' ">$ ' + precio + ' USD</span>'+
                                html_oferta+
                                '<img class="img-responsive img-thumbnail" src="' + val['imagen'] + '">'+
                        '</div>'+
                        '<div class="col-md-6 col-xs-6"><span class="titulorel">' + val['nombre'] + '</span></div>'+
                    '</div>'+
                '</div>'+
            '</a>';      
        });
        $('#relacionados').empty();
        $('#relacionados').html(html);
    }
//*********************** INICIO PRECIOS BUSES ******************************//
    var get_precios_buses = function (data) {
        $.ajax({
            url: 'http://incalake.com/incalakesisothers/precios_gral_buses.php',
            data: {'ids': data},
            type: 'POST',
            dataType: 'Json',
            success: function (res) {
                for (var i = 0; i < res.length; i++) {
                    $('#' + res[i].id).html(res[i].tabla);
                }
                $('.table_bus').dataTable({
                    "paging": false,
                    "searching": false
                });
            }
        });
    };
    var data_buses = '0/0';
    $('.precio_bus_gral').each(function (indice, elemento) {
        data_buses += ',' + $(elemento).data('bus');
    });
    if (data_buses != '0/0')
        get_precios_buses(data_buses);
//************************* FIN PRECIOS BUSES ********************************//

    console.log("zopim loading");

    window.$zopim || (function (d, s) {
        var z = $zopim = function (c) {
            z._.push(c)
        }, $ = z.s = d.createElement(s), e = d.getElementsByTagName(s)[0];
        z.set = function (o) {
            z.set._.push(o)
        };
        z._ = [];
        z.set._ = [];
        $.async = !0;
        $.setAttribute("charset", "utf-8");
        $.src = "//v2.zopim.com/?1IklAHllvGDF4LzNvH49FK65Snt4sk3I";
        z.t = +new Date;
        $.type = "text/javascript";
        e.parentNode.insertBefore($, e)
    })(document, "script");

});



