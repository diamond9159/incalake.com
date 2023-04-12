/////////////////////////////////////////////////////////////////////////////
(function(){
  var palabra = traduccionPrecios;//contiene palabras para traducir
  var id_collapse = 0;
  function returnCollapse(trs,pagina_proceso,id_producto,titulo){//trs= la lista de precio; pagina de proceso= donde se envia la reserva; id_producto= para agregar a la url e indicar a la pagina de proceso de que tour se trata

   id_collapse++;
   return  '<div class="panel panel-success pricecontainer">'+
        '<div class="panel-heading" data-toggle="collapse" href="#collapse-precios'+id_collapse+'" aria-expanded="true">'+
          '<h4 class="panel-title">'+
          '<b class="tituloCollapse"><i class="fa fa-address-card"></i> '+(titulo?titulo:palabra.titulo_collapse)+'</b>'+
          '<span style="float:right" class="panel-icon glyphicon glyphicon-chevron-down"></span></h4>'+
         '</div>'+
        '<div id="collapse-precios'+id_collapse+'" class="panel-collapse collapse in" aria-expanded="true">'+
           '<div class="panel-body">'+
              //'<form target="_blank" action="'+pagina_proceso+'?id='+id_producto+'" method="post">'+
              '<form target="_blank" action="'+pagina_proceso+'" method="post">'+
              '<table class="tablaPrecios"><tr><td>&nbsp;</td><td>'+palabra.cantidad+'</td><td>$ '+palabra.precio_persona+'</td><td> $ '+palabra.subtotal+'</td></tr>'+trs+'</table>'+
             (pagina_proceso?'<input type="button" class="btn btn-danger reservasBtn" value="'+palabra.reservar+'" />':'')+' <span>$ '+palabra.total+': <i class="totalprice">0</i></span></form></div>'+                       
           '</div>'+
        '</div>'+
      '</div>';
  }
  var numnacprecios = 0;
  var arrayPrecios = [];


  var person = [];
  var tituloOriginal = '';
  var i = 0;

   function generarTablaPrecios(){
    var idioma = idiomaGeneral;
     var precios = $(this).data('value');// puede ser un entero o un json ,titulo_tr:el titulo de los trs que identifican edades
     //var titulo_tr = palabra.titulo_tr;//titulo que viene a emular edades para mayores
     //var titulo_td = palabra.titulo_td;// titulo que emula nacionalidades
     if(!isNaN(precios))precios = {[palabra.titulo_tr]:{"nacionalidades":{[palabra.titulo_td]:{"precios":{"1":precios},"idiomas":{"en":"People"}}},"idiomas":{"en":"General"}}};// si es un solo valor se vuelve json para procesar sin problemas en adelante

     if(precios instanceof Object){
        var trs = '';
        $.each(precios,function(key,value){
          /*detectar traducciones*/
           var tituloPrincipal = key;
           if(value.idiomas)tituloPrincipal = (value.idiomas[idioma]!=undefined?value.idiomas[idioma]:key);
            // var tituloNAC = (value2.idiomas[idioma]!=undefined?value2.idiomas[idioma]:key2);
           trs += '<tr class="tituloPrincipal"><td colspan="4"><i class="fa fa-users" aria-hidden="true"></i> '+tituloPrincipal+'</td></tr>';
           
          

           $.each(value.nacionalidades,function(key2,value2){
             arrayPrecios.push(value2.precios);
             /*detectar traducciones*/
             var tituloSecundario = key2;
             if(value2.idiomas)tituloSecundario = (value2.idiomas[idioma]!=undefined?value2.idiomas[idioma]:key2);

             var controles = '<span class="fa fa-minus precioAnterior"></span><input type="number" value="2" name="cantidades['+tituloPrincipal+']['+tituloSecundario+']" class="inputPrecio" value="0" /><span class="fa fa-plus precioSiguiente"></span>';
             //var controles = '<span class="fa fa-minus precioAnterior"></span><input type="number" value="2" class="inputPrecio" value="0" /><span class="fa fa-plus precioSiguiente"></span>';

              trs += '<tr data-key="'+numnacprecios+'" ><td class="child_name"><i class="fa fa-user-plus" aria-hidden="true"></i> '+tituloSecundario+'</td><td style="min-width:100px">'+controles+'</td><td><input class="precioPersona" type="number"  disabled /></td><td><input class="precioTotal" type="number" disabled  /></td></tr>';
              numnacprecios++;
    
                             
                person.push({
                    persona: tituloPrincipal.toLowerCase(),
                    nacionalidad: tituloSecundario.toLowerCase(),
                    cantidad: 2,
                });

            });
           
        });
       
     }  
     return returnCollapse(trs,$(this).data('urlreserva'),$(this).data('idproducto'),$(this).data('titulo'));
   }
   /////////////////////////////////////////////////////////////////////////////////////////////
   ///  //var inputPrecio = contenedorNAC.find('.inputPrecio');//input en foco actual 
  var j = 0;

  function gestionPrecios(){
    function cambiarValorInput(THIS,direction){//directinon: false hacia atras y true hacia adelante y sin valor toma el input 
      var parentInput = THIS.parents('tr');
      var actualInput = direction==undefined?THIS:parentInput.find('.inputPrecio');
      var preciotext = parentInput.find('.precioPersona');
      var precioTotal = parentInput.find('.precioTotal');// precio todal input
      var valorInput = parseFloat(actualInput.val());

     
       

    


      if(direction!=undefined)valorInput = direction?valorInput+1:valorInput-1;

       //var cantidad=null,
       if(valorInput>0 && valorInput<100){
          var datakey = arrayPrecios[parentInput.data('key')];//key el num del index array
          
          var cantidad_precios = Object.keys(datakey);
          var precio=null;
          var precioporunapersona = parseFloat(datakey[cantidad_precios[0]]);
          var precioporpersona = 0;

          if(cantidad_precios.length>1){
            //alert('funciones');
            var precioObtenido = datakey[valorInput];
            if(!precioObtenido)alert(palabra.para+valorInput+' '+palabra.contactos);
            else precioporpersona = precioObtenido/valorInput;
          } else {
            //alert('normal');
            //cantidad = valorInput;
            precioporpersona = precioporunapersona;
          }
         // alert(arrayPrecios[parentInput.data('key')][nuevoValor]);
          actualInput.val(valorInput);
          preciotext.val(precioporpersona?Math.round(precioporpersona*100)/100:'');//si es cero mostrar vacio
          precioTotal.val(precioporpersona?precioporpersona*valorInput:'');//si es cero mostrar vacio total
      } else {
        actualInput.val('0');preciotext.val('');precioTotal.val('');
    }
      //ahora se creara instrucciones para la suma total del todo los subtotales
      var tabla = parentInput.parents('table');
      var total = 0;
      var cantidad_personas = 0;
      
          tabla.find('.precioTotal').each(function(){
              var value = $(this).val();
              if(value){
                var preciosubtotal = $(this).parents('tr').find('.inputPrecio').val();
                if(preciosubtotal)cantidad_personas +=parseFloat(preciosubtotal);// cantidad de personas
                total+=parseInt(value);// precio total
              }
              if( $(this).parents('tr').find('.precioPersona').val() == '')
              {
                person[j++].cantidad = 0;
              }
              else {
                person[j++].cantidad = parseInt($(this).parents('tr').find('.inputPrecio').val());
              }
             
          });
          j = 0;


     // var cantidad_personas = tabla.find(".inputPrecio").html(total);
     tabla.parents('form').find(".totalprice").html(total);
     sumarTotal();
    // tabla.parents('.pricecontainer').find('.tituloCollapse').html('<i class="fa fa-chevron-circle-right"></i> Precio por '+cantidad_personas+' personas: $'+total);
    // tabla.parents('.tituloCollapse');
      
      //fin para total total
    }
    $('.inputPrecio').on('change paste',function(){
      
      cambiarValorInput($(this));
      //if(parseInt($(this).val())<1){alert(mensajes.valorNegativo);$(this).val(1);}
    });
    $('.inputPrecio').trigger('paste');//capturar el primer precio el value del inout
    $('.precioAnterior').click(function(){
      cambiarValorInput($(this),false);
    });

    $('.precioSiguiente').click(function(){
      cambiarValorInput($(this),true);
    });
    //acciones a presionar el boton de reservar//
     $('.reservasBtn').click(function(){
        //var idproducto = $(this).parents('.preciosLista').data('idproducto');
        var formulario = $(this).parents('form');

        formulario.submit();
      });
    //fin de las acciones para el botn de reservar//
   }

  function sumarTotal(){
    var value = 0;
    $('.inputPrecio').each(function(){
        value += parseInt($(this).val());
    });

    var countPerson = 0;

    person.forEach(function (p) {
      if(p.cantidad != 0)
      {
          countPerson+=p.cantidad;
      }
    });
    $("#person_array").val(JSON.stringify(person));
    $('#cantidad_input').val(countPerson);
    $('#cantidad_input').trigger('change');

  }

    $(document).ready(function(){
      var divsPrecioLista = $('.preciosLista');
      divsPrecioLista.html(generarTablaPrecios);
      gestionPrecios();

      //agregar evento a boton de reservas
     

    });
})();
