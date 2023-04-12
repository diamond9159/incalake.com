//limite de oferta
$().ready(function(){
  // funciones para controlar el tiempo limitado de la oferta
  function addZero(i) {
      if (i < 10) {
          i = "0" + i;
      }
      return i;
  }
  
  function tiempoRestante() {
    var start = new Date();
    //start = start-end;
    var dia = 7-(+start.getDay());
    var hora = 24-(+start.getHours());
    var minuto = 60-(+start.getMinutes());
    var segundo = 60-(+start.getSeconds());

    var text = //'<b>'+addZero(hora)+' horas</b> y '+addZero(minuto)+' minutos y '+addZero(segundo)+' segundos';
    `<ul>
      <li><b>${addZero(dia)}</b><br><small>Days</small></li>
      <li><b>${addZero(hora)}</b><br><small>Hours</small></li>
      <li><b>${addZero(minuto)}</b><br><small>Minutes</small></li>
      <li><b>${addZero(segundo)}</b><br><small>Seconds</small></li>
    </ul>
    `;
    t_restante.html(text);
  }
  var t_restante = $('#t_restante');
  setInterval(tiempoRestante,1000)
});
// fin limite de oferta

          var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
          $(document).on('keyup', '#nombre_email', function(event) {
            event.preventDefault();
            
             if (Boolean($(this).val().match(expresion))) {
              console.log('coreo si');
              $(this).removeClass('border-danger');
            }else{
              console.log('coreo no');
              $(this).addClass('border-danger');
            }
            /* Act on the event */
          });
          // $('#suscrípcionMoldal').modal();
          
        
          $(document).on('click', '.btn_suscribirme', function(event) {
           event.preventDefault();
           /* Act on the event */
           var ck_string=[];
            $.each($("input[name='flavours']:checked"), function(){  
                ck_string.push({'destino':$(this).val(),'duracion_viaje':$('#duracion_viaje').val(),'fecha_viaje':$('#fecha_viaje').val()+'-'+'01'});  
            });
            if (ck_string.length ){
                console.log('ck_string',ck_string);
                $('#destino_suscripcion_txt').tooltip('hide');
            }else{
                // alert('Please choose atleast one value.');
                $('#destino_suscripcion_txt').tooltip('show');
            }
            if ($('#fecha_viaje').val().length>0){
                $('#fecha_viaje_txt').tooltip('hide');
            }else{
              $('#fecha_viaje_txt').tooltip('show');
            }
            if ($('#duracion_viaje').val().length>0){
                $('#duracion_viaje_txt').tooltip('hide');
            }else{
              $('#duracion_viaje_txt').tooltip('show');
            }
            // console.log($('#fecha_viaje').val().length);
            // console.log($('#duracion_viaje').val().length);
            if (ck_string.length>0 &&$('#fecha_viaje').val().length>0&&$('#duracion_viaje').val().length>0) {
              // ***********
                var datos_de_suscripcion ={
                  'nombre':$('#nombre_suscripcion').val(),
                  'email':$('#nombre_email').val(),
                  'destinos':ck_string,
                }
                // console.log('datos_de_suscripcion',datos_de_suscripcion);
              $('#nombre_suscripcion_tooltip_txt').html($('#nombre_suscripcion').val());
              $('#nombre_email_tooltip_txt').html($('#nombre_email').val());
              $('.suscripcion_datos').hide();
               $('.suscripcion_gracias').show('slow/400/fast', function() {
                 
               });
               $.ajax({
                 url: base_url+"suscripcion/add",
                 type: 'POST',
                 dataType: 'json',
                 data: {datos_de_suscripcion:datos_de_suscripcion},
               })
               .done(function() {
                 console.log("success");
               })
               .fail(function(e) {
                console.log(e.responseText)
                 console.log("error");
               });
               
             }else{

             }
           
         }); 
          $(document).ready(function($) {
            $('#fecha_viaje').datepicker({
                format: "yyyy-mm",
                minViewMode: 1,
                language: "es",
                todayHighlight: true
            });

           $('#suscrípcionMoldal').on('show.bs.modal', function (e) {
            $('.suscripcion_datos').show();
              $('.suscripcion_gracias').hide();
            });
          });
          $(document).on('click', '.btn_modal_suscripcion', function(event) {
            event.preventDefault();

            if ($('#nombre_suscripcion').length>0&&$('#nombre_email').length>0) {
              if ($('#nombre_suscripcion').val().length>0 && $('#nombre_email').val().length>0) {
                if (Boolean($('#nombre_email').val().match(expresion))) {
                  $.ajax({
                     url: base_url+"suscripcion/state_suscripcion",
                     type: 'POST',
                     dataType: 'json',
                     data: {email:$('#nombre_email').val()},
                   })
                   .done(function(data) {
                     console.log("success",data);
                     if (data==0) {
                      $('#suscrípcionMoldal').modal();
                      $('#nombre_email').removeClass('border-danger');
                      $('#nombre_email_resgistradoHelp').css('display', 'none');
                    }else{
                      $('#nombre_email').addClass('border-danger');
                      $('#nombre_email_resgistradoHelp').css('display', 'block');
                    }
                     
                   })
                   .fail(function(e) {
                    console.log(e.responseText)
                     console.log("error");
                   });
                  
                  
                }else{
                  // alert('correo no valido');
                  $('#nombre_email').addClass('border-danger');
                  $('#nombre_email').focus();

                }
                

              }else{
                console.log('aqui');
                  console.log('aqui22'+$('#nombre_suscripcion').val());
                  if ($('#nombre_suscripcion').val()==''){
                    $('#nombre_suscripcion').tooltip('show');
                  }else{
                    $('#nombre_suscripcion').tooltip('hide');
                  }
                  if ($('#nombre_email').val()==''){
                    $('#nombre_email').tooltip('show');
                  }else{
                    $('#nombre_email').tooltip('hide');
                  }
              }
            }else{
              alert('Ocurrio un error, recarge la pagina');
            }
            
          });
