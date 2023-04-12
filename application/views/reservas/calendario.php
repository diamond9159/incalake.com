<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div id="calendario" style="height: 20px;"></div>	
			<!--
			<code>
				<?php 
				//echo json_encode($data);
				?>	
			</code>--><br/><br/>
		</div>
	</div>
</div>

<script type="text/javascript">	
	var color_disponible 		= "#6EC235";
	var color_bloqueo  			= "#F35141";
	var color_seleccionado 		= "#0696A5";
	var color_hoy		 		= "#5AD702";
	var color_disponible_pasado	= "#D5E4C9";
	var color_bloqueo_pasado	= "#E4CBC9";

	var language= '<?=$language;?>';
	var inicio_disponibilidad = "<?=$data['inicio_disponibilidad'];?>";
	var fin_disponibilidad    = "<?=$data['fin_disponibilidad'];?>";
	var data_bloqueo		  = <?=json_encode($data['bloqueo']);?>;	
	var data_oferta			  = <?=json_encode($data['oferta']);?>;
	var dias_activos          = <?=json_encode($data['dias_activos']);?>;
	var dias_no_activos       = <?=json_encode($data['dias_no_activos']);?>;
	var anticipacion_reserva  = <?=json_encode($data['anticipacion_reserva']);?>;
	var fechas_bloqueadas     = Array();
	fechas_bloqueadas.length  = 0;
	var click 				  = null;
	console.log(JSON.stringify(fechas_bloqueadas) );
	for (var i = 0; i < data_bloqueo.length; i++) {
		array_fechas(data_bloqueo[i]['start'],data_bloqueo[i]['end']);
	}
	console.log("FECHAS BLOQUEADAS: ",fechas_bloqueadas);
	var cantidad_dias_inicio_disponibilidad = moment(inicio_disponibilidad).diff( moment(),"days");
  	var cantidad_dias_fin_disponibilidad    = moment(fin_disponibilidad).diff(inicio_disponibilidad,"days");

	jQuery(document).ready(function($) {
		$('#calendario').fullCalendar({
			height: 460,
        	weekends: true,
        	locale: language,
		    //events: data_bloqueo,
		    dayRender: function (date, cell) {
		    	var current_date = new Date(); // Fecha Actual
		    	var today 		 = new Date(); 
				var end 		 = new Date();
				today.setDate(today.getDate() + (parseInt(cantidad_dias_inicio_disponibilidad)-1) );
				end.setDate(today.getDate() + (parseInt(cantidad_dias_fin_disponibilidad)+1) );
				//if(date >= today && date <= end) {
				if( date >= today && date <= end ) {
			  		cell.css("background-color", color_disponible);
			  		var dia_nombre = moment( date.format()).weekday();
			  		//Coloreando dias de la semana no activas	
			  		for(var i in dias_no_activos){
			    		if ( (parseInt( dias_no_activos[i] ) - 1 ) === dia_nombre ) {
			      			if (  date < current_date && date >= today ) {
								cell.css("background-color",color_bloqueo_pasado);
							}else{
				      			cell.css("background-color", color_bloqueo);
							}		    		
			    		}
			  		}
				}
				if ( date < current_date && date >= today ) {
					cell.css("background-color",color_disponible_pasado);
				}
				//Coloreando fechas bloqueadas
				for (var i = 0; i < fechas_bloqueadas.length; i++) {
					if( fechas_bloqueadas[i] === date.format('YYYY-MM-DD') ){
						if (  date < current_date && date > today ) {
								cell.css("background-color",color_bloqueo_pasado);
						}else{
							cell.css("background-color", color_bloqueo);
						}
					}
				}
				//Fecha Actual del Día
				if ( date.format("DD-MM-YYYY") == moment().format("DD-MM-YYYY") ) {
					cell.css("background-color", color_hoy);
				}
				//Resolver bug de sombrear el dia mañana 
				if ( (moment().add(1,'days').format("YYYY-MM-DD")) === date.format("YYYY-MM-DD") ) {
					var fecha_esta_en_bloqueados = fechas_bloqueadas.includes(""+date.format("YYYY-MM-DD") );
					if (fecha_esta_en_bloqueados === false) {
						cell.css("background-color", color_disponible);
					}
				}
			},
			dayClick: function(date, jsEvent, view, resourceObj) {
		 		var validar = validar_fecha(date);       
		    	if ( validar ) {
		    		$(click).css("background-color",color_disponible);	//Poner Background verde
					$(this).css("background-color",color_seleccionado);	//Poner Background Azul
			        click = $(this);									//Actualizar Estado anterior.
		    	}
		    },
		});
	});

	function validar_fecha(date,click){
		var dia =  moment( date.format()).weekday() + 1;
        if( dias_no_activos.includes(""+dia) === false ){
	        if ( fecha_disponible(date) ) {
		        if ( !disponibilidad_horaria(date) ){
		        	$.notify("Para la fecha seleccionada ya no es posible realizar su reserva,\n seleccione otra fecha por favor...!", "error");
		        	return false;
		        }else{
			        document.getElementById("txt_fecha_servicio").value = date.format("DD-MM-YYYY");
		        	$("#txt_fecha_servicio").notify( date.format("DD-MM-YYYY"),"success");
					//$(click).css("background-color",color_disponible);	//Poner Background verde
					//$(this).css("background-color",color_seleccionado);	//Poner Background Azul
			        //click = $(this);							//Actualizar Estado anterior.
		        	return true;
		        }
		    }else{
		    	$("#txt_fecha_servicio").notify("Fecha Seleccionada No válida..!","error",{ position:"top left" });
		    	return false
		    }
	    }else{
        	$("#txt_fecha_servicio").notify("Fecha No válida..!","error",{ position:"top left" });
        	return false;
        }
	}

	function disponibilidad_horaria(fecha){
		//console.clear();
		var fecha_seleccionada 	= moment(fecha);
		var fecha_actual 		= moment();
		var diferencia_minutos  = 0;
		var diferencia_horas    = 0;
		var diferencia_dias     = 0;  
		var hora_inicio         = null;
        var array_hora_inicio   = Array();
		hora_inicio = document.getElementById("slct_hora_inicio").value.trim();
		console.log("HORA INICIO SELECCIONADA: ",hora_inicio );

		if (hora_inicio.length != 0 ) {
			array_hora_inicio = hora_inicio.split(":");
		}
		//fecha_seleccionada = moment(new Date(fecha_seleccionada.format("YYYY"),fecha_seleccionada.format("MM")-1,fecha_seleccionada.format("DD"), parseInt(fecha_actual.format("H"))+1,fecha_actual.format("m"),0 ) );
		fecha_seleccionada = moment(new Date(fecha_seleccionada.format("YYYY"),fecha_seleccionada.format("MM")-1,fecha_seleccionada.format("DD"), array_hora_inicio[0],array_hora_inicio[1],0 ) );
		var diferencia 			= 0;
		if ( anticipacion_reserva.length != 0 ) {
			diferencia 			= fecha_seleccionada.diff(fecha_actual, anticipacion_reserva['tiempo'] );
			diferencia_minutos  = fecha_seleccionada.diff(fecha_actual, 'minutes' );
			diferencia_horas    = fecha_seleccionada.diff(fecha_actual, 'hours' );
			diferencia_dias     = fecha_seleccionada.diff(fecha_actual, 'days' );
		}
		var reserva_validad = tiempo_anticipacion_reserva(anticipacion_reserva['cantidad'],anticipacion_reserva['tiempo'],fecha_seleccionada);
		//console.log("FECHA SELECCIONADA: ",fecha_seleccionada.format());
		//console.log("FECHA ACTUAL: ",fecha_actual.format());
		if ( (diferencia+1) > parseInt(anticipacion_reserva['cantidad'])  ) {
			return true;
		}else{
			return false;
		}
	}

	function array_fechas(fecha_inicio, fecha_fin){
		var diferencia_dias = moment(fecha_fin).diff( fecha_inicio,"days") + 1;
		var incremento = 0;
		for (var i = 1; i <= diferencia_dias; i++) {
			var fecha_add = moment(fecha_inicio).add(incremento++, 'days');
			fechas_bloqueadas.push( fecha_add.format('YYYY-MM-DD') );
		}
	}
	
	function fecha_disponible(fecha){
		var current_date = moment().format('YYYY-MM-DD');
		var fecha_seleccionada = fecha.format('YYYY-MM-DD');
		console.log("FECHA ACTUAL:" ,current_date);
		console.log("FECHA SELECCIONADA:" ,fecha_seleccionada);
		var fecha_valido = moment(current_date).isSameOrBefore(fecha_seleccionada, 'day');
		console.log("FECHA VALIDO:" ,fecha_valido);
		console.log("FECHAS BLOQUEADAS: ",JSON.stringify(fechas_bloqueadas) );
		if ( fecha_valido ) {
			var fecha_esta_bloqueado = fechas_bloqueadas.includes(""+fecha_seleccionada);
			if ( fecha_esta_bloqueado === false ) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		return true;
	}

	function tiempo_anticipacion_reserva(tiempo_anticipacion,tipo_tiempo,fecha_seleccionada){
		var fecha_actual = moment();
		var diferencia   = 0;
		switch(tipo_tiempo){
			case 'minutes':
				diferencia = fecha_seleccionada.diff( fecha_actual, 'minutes' );
			break;
			case 'hours':
				diferencia = fecha_seleccionada.diff( fecha_actual, 'hours' );
			break;
			case 'days':
				diferencia = fecha_seleccionada.diff( fecha_actual, 'days' );
			break;
			default:
			    diferencia = fecha_seleccionada.diff( fecha_actual, tiempo );
			break;
		}
	    console.log( "ANTICIPACION DE RESERVA: ",tiempo_anticipacion+" "+tipo_tiempo );
		console.log( "TIEMPO RESTANTE: ",diferencia + " "+ tipo_tiempo);
		if ( diferencia >= tiempo_anticipacion ) {
			console.log("Quedan "+diferencia+" "+tipo_tiempo+" para reservar; Para esta reserva se requiere como mínimo "+tiempo_anticipacion+" "+tipo_tiempo+" de anticipación.");
			return true;
		}else{
			console.log("Solo Quedan "+diferencia+" "+tipo_tiempo+" para reservar; Para esta reserva se requiere como mínimo "+tiempo_anticipacion+" "+tipo_tiempo+" de anticipación.");
			return false;
		}
		return false;
	}

	$(document).on('change', '#slct_hora_inicio', function(event) {
		event.preventDefault();
   		var fecha_seleccionada = document.getElementById("txt_fecha_servicio").value.trim();
   		var valido = false;
   		if ( fecha_seleccionada.length != 0 ) {
   			valido = validar_fecha( moment(fecha_seleccionada,"DD-MM-YYYY") );
   		}
   		console.log("Cambio válido: ",valido);
	});

	$(document).on('change', '#txt_fecha_servicio', function (event) {
        event.preventDefault();
        $("#resumen_fecha_servicio").text($("#txt_fecha_servicio").val());
    })

	jQuery(document).ready(function($) {
		$("#txt_fecha_servicio").datepicker({
			minDate: 0,
			dateFormat: "dd-mm-yy",
		    beforeShowDay: function(date){
		    	var day = date.getDay(); 
		    	var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
		    	var string_result = fechas_bloqueadas.indexOf(string);
		    	var result = dias_inactivos(date);
				if ( result === false || string_result != -1  ) {
					return [false, ''];
				}else{
					return [true, ''];
				}
		    	//var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
		        //return [ fechas_bloqueadas.indexOf(string) == -1 ]
		    }
		});
		
		function dias_inactivos(date){
			var day = date.getDay();
			for (var i = 0; i < dias_no_activos.length; i++) {
	    		if( day == (parseInt(dias_no_activos[i])-1)  ){
					//return [false, ''];		
	    			return false;
	    		}
	    	}
			return true;
			//return [true, ''];
		}
		console.log(JSON.stringify(dias_no_activos));
	});
</script>