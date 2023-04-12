<?php
	$traduccion = arrayTraduccion('info_clientes',strtolower($language));
?>
<!DOCTYPE html>
<html lang="<?=strtolower($language);?>">
<head>
<meta name="google-site-verification" content="qy9vxQEC9LYKLrPOeKqRxhTQTCu1u7T_ReVvsvugjeY" />
<title><?=$traduccion['titulo_pagina'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/flag/flag.min.css">
	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
	?>

	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css">

<!-- Global site tag (gtag.js) - Google Analytics -->


</head>
	<body>
		<header>
			<?php
				$this->load->view('header/header');
				$this->load->view('header/menu');
			?>
		</header>
		<content>
		 <div class="container" style="margin:10px auto 10px auto">
		   <div class="card">
			 <div class="card-header bg-info text-white" style="font-size:1.3em"><?=$traduccion['datos_pasajeros'];?> <button type="button" class="btn btn-success pull-right guardar_form"><?=$traduccion['enviar_form'];?></button></div>
			 <div class="card-body" id="form_container">
			    <input type="hidden" name="id_reserva" value="<?=@$_GET['id'];?>" >
				<table class="table">
					<tr><td><b><?=$traduccion['titular_reserva'];?></b></td><td>: <?=@$campos_formulario[0]['nombres_titular'];?></td></tr>
					<tr><td><b><?=$traduccion['codigo_reserva'];?></b></td><td>: <?=@$campos_formulario[0]['codigo_reserva'];?></td></tr>
				</table>
				<hr>
				<div class="alert alert-warning">
				<?=$traduccion['nota_alerta'];?>
				
				</div>
				<hr>
	          <?php
				//echo json_encode($campos_formulario);
				function html_inputs($inputs,$language,$id_reserva,$id_actividad,$num_cliente){
					// bucle inputs
					// global $language;
					$html_inputs = '<table>';
					foreach($inputs as $key => $input){
						$nombre_campo = json_decode($input['nombre_campo'],true);
						$placeholder_campo = json_decode($input['placeholder_campo'],true);
						$html_inputs .= '<tr>
						<td width="40%">'.($nombre_campo[$language]?$nombre_campo[$language]:$nombre_campo['en']).'</td>
						<td><input type="text" name="inputs['.$id_reserva.']['.$id_actividad.']['.$num_cliente.']['.$input['id_campo_formulario'].']" class="form-control" placeholder="'.($placeholder_campo[$language]?$placeholder_campo[$language]:$placeholder_campo['en']).'" ></td>
						</tr>';
					}
					return $html_inputs.'</table>';
				}
				$html_actividades = null;
				foreach($campos_formulario as $value){
					$html_formulario = '<div class="row forms_container">';
					
					
					// blucle cantidad de personas
					for($i=1;$i<=$value['cantidad'];$i++){
						$html_formulario .= ' 
											  <div class="col-md-6">
											  <h5 class="alert alert-info">'.$traduccion['cliente'].' '.$i.'</h5>
											  '.html_inputs($value['inputs'],$language,$value['id_reserva'],$value['id_actividad'],($i-1)).'
											  </div>
											';
					}
					$html_formulario .= '<input type="hidden" name="id_calendar_event[]" value="'.($value['id_calendar_event']? $value['id_calendar_event'] : 0).'" /></div>';
					
					$html_actividades .= "<h1 class='titulo_actividad'>{$value['nombre_actividad']}</h1> ".$html_formulario.'<hr>';

				} 
				echo $html_actividades;
			  ?>
			  <div class="alert alert-danger">
			  	<p>
			  		<?php 
			          	if(strtolower($language)=='es')echo "Si eres extranjero, es importante que nos envíes una copia/foto (puede ser a color o blanco y negro) de tu pasaporte a ";
			          	else echo "If you are a foreigner, it is important that you send us a copy / photo (it can be in color or black and white) of your passport to";
		          	
		         	 ?>
			  	 <strong>reservas@incalake.com</strong></p>

				<a href="#" data-toggle="modal" data-target="#myModal">
					<?php 
		          	if(strtolower($language)=='es')echo "¿Por qué tengo que enviarles mi pasaporte?";
		          	else echo "Why do I have to send my passport?";
		          	
		          ?>
				</a>

			  </div>
			  <button type="button" class="btn btn-success pull-right guardar_form"><?=$traduccion['enviar_form'];?></button>
	         </div>
	   </div>
	 </div>
	</content>
	 <!-- The Modal -->
	  <div class="modal fade" id="myModal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	      
	        <!-- Modal Header -->
	        <div class="modal-header">
	          <h4 class="modal-title" style="font-weight: bold;color:#537A9C">
		          <?php 
		          	if(strtolower($language)=='es')echo "¿Por qué tengo que enviarles mi pasaporte?";
		          	else echo "Why do I have to send my passport?";
		          	
		          ?>
	          </h4>
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	        </div>
	        
	        <!-- Modal body -->
	        <div class="modal-body" style="overflow: auto;max-height: 350px">
	        	<?php 
	        	 if(strtolower($language)=='es'):
	        	?>
					<p><strong>1.- &iquest;Por qu&eacute; tengo que enviar mi pasaporte y Tarjeta de migraci&oacute;n Andina (TAM)?</strong></p>
					<p><span style="font-weight: 400;">Si eres extranjero, Inca Lake, en tu beneficio te evita de cobrar el IGV o IVA (18%), De acuerdo con las leyes fiscales del pa&iacute;s, los extranjeros que permanezcan m&aacute;s de 59 d&iacute;as en Per&uacute;, </span><strong>deber&aacute;n abonar un suplemento del 18 %</strong><span style="font-weight: 400;">. Para no pagar este impuesto del 18 %. Envienos una copia de la tarjeta de inmigraci&oacute;n y del pasaporte. </span></p>
					<p><span style="font-weight: 400;">Es imprescindible aportar ambos documentos para poder acogerse a la exenci&oacute;n del pago.</span><span style="font-weight: 400;">De lo contrario, iniciado los servicios deber&aacute;n abonar el suplemento correspondiente (18%). </span></p>
					<p><span style="font-weight: 400;">Esto, s&oacute;lo aplica a ciudadanos no residentes en el Per&uacute;</span><span style="font-weight: 400;"><br /><br /></span></p>
					<p><span style="font-weight: 400;">Fuentes: &nbsp;</span><a target="_blank" href="http://busquedas.elperuano.pe/normaslegales/ley-que-fomenta-la-exportacion-de-servicios-y-el-turismo-ley-n-30641-1555415-1/"><span style="font-weight: 400;">http://busquedas.elperuano.pe/normaslegales/ley-que-fomenta-la-exportacion-de-servicios-y-el-turismo-ley-n-30641-1555415-1/</span></a></p>
					<p><strong>2.- &iquest;C&oacute;mo les env&iacute;o mi TAM?</strong></p>
					<p><span style="font-weight: 400;">Para empezar, el TAM o tarjeta de migraci&oacute;n andina, es un documento de control </span><strong>migratorio</strong><span style="font-weight: 400;"> de car&aacute;cter estad&iacute;stico y de uso obligatorio cuando se encuentra acompa&ntilde;ado del documento de identidad; </span><strong>se lo dar&aacute;n al momento de ingresar al Per&uacute;. Le dar&aacute;n un voucher f&iacute;sico,</strong><span style="font-weight: 400;"> as&iacute; mismo tambi&eacute;n lo puede sacar en duplicado virtual, en el siguiente punto, le explicaremos c&oacute;mo.</span></p>
					<p><strong>3.- &iquest;C&oacute;mo puedo obtener mi TAM?</strong></p>
					<ul>
					<li style="font-weight: 400;"><span style="font-weight: 400;">Una vez que haya ingresado al Per&uacute;, podr&aacute; obtener su TAM o una copia de el, Ingrese a la siguiente p&aacute;gina: </span><a href="https://cel.migraciones.gob.pe/ConsultaTAMVirtual/VerificarTAM"><span style="font-weight: 400;">https://cel.migraciones.gob.pe/ConsultaTAMVirtual/VerificarTAM</span></a></li>
					<li style="font-weight: 400;"><span style="font-weight: 400;">Ponga sus datos correspondientes</span></li>
					<li style="font-weight: 400;"><span style="font-weight: 400;">Env&iacute;enos una copia de su TAM a </span><span style="font-weight: 400;"><a href="mailto:reservas@incalake.com">reservas@incalake.com</a></span></li>
					</ul>
					<p><span style="font-weight: 400;">Muchas gracias por su paciencia, el tr&aacute;mite </span><strong>le permitir&aacute; ahorrar el 18% del valor de los</strong><span style="font-weight: 400;"> servicios.</span></p>
					<p><strong>IMPORTANTE: </strong><span style="font-weight: 400;">Inca Lake por defecto, tiene en su p&aacute;gina web exentos los impuestos del IVA, si despu&eacute;s del pago, no se cumple con enviar la documentaci&oacute;n, se adicionar&aacute; el 18% del IVA al momento de iniciar su viaje. </span></p>
				<?php ; else:?>
					<p><strong>1.- Why do I have to send my passport and Andean migration card (TAM)?</strong></p>
					<p><span style="font-weight: 400;">If you are a foreigner, Inca Lake, in your benefit, prevents you from collecting the VAT or VAT (18%), In accordance with the country's tax laws, foreigners staying more than 59 days in Peru, must pay an additional 18% . </span><strong>To not pay this 18% extra tax. Send us a copy of the immigration card and passport.</strong></p>
					<p><strong>It is essential to provide both documents to be eligible for the payment exemption.</strong></p>
					<p><span style="font-weight: 400;">Otherwise, you must pay the corresponding supplement (18%) at the beginning of the services.</span></p>
					<p><span style="font-weight: 400;">This only applies to citizens who are not residents of Peru</span></p>
					<p><span style="font-weight: 400;">Legal Sources:</span></p>
					<p><a href="http://busquedas.elperuano.pe/normaslegales/ley-que-fomenta-la-exportacion-de-servicios-y-el-turismo-ley-n-30641-1555415-1/%20" target="_blank"><span style="font-weight: 400;"> http://busquedas.elperuano.pe/normaslegales/ley-que-fomenta-la-exportacion-de-servicios-y-el-turismo-ley-n-30641-1555415-1/&nbsp;</span></a></p>
					<p><strong>2.- How do I send my TAM (Migration Andeand Card)?</strong></p>
					<p><span style="font-weight: 400;">To begin with, the </span><strong>TAM </strong><span style="font-weight: 400;">or Andean migration card </span><strong>is a document of migratory control </strong><span style="font-weight: 400;">of a statistical nature and of obligatory use when it is accompanied by the identity document</span><strong>;</strong><span style="font-weight: 400;"> custom offices will give you this document, when entering Peru for the first time. You will be given a physical voucher (your TAM), if you lose it, ou can also take it out in virtual duplicate, in the next point, we will explain how.</span></p>
					<p><strong>3.- How can I get my TAM?</strong></p>
					<ul>
					<li><span style="font-weight: 400;">Once you have entered Peru, you can obtain your TAM or a copy of it. Go to the following link: https://cel.migraciones.gob.pe/ConsultaTAMVirtual/VerificarTAM</span></li>
					<li><span style="font-weight: 400;">Put your corresponding data</span></li>
					<li><span style="font-weight: 400;">Send us a copy of your TAM to reservas@incalake.com</span></li>
					</ul>
					<p><span style="font-weight: 400;">Thank you very much for your patience,</span><strong> the procedure will allow you to save 18% of the value of the services.</strong></p>
					<p><strong>IMPORTANT: </strong><span style="font-weight: 400;">Inca Lake by default, has on its website exempt VAT taxes, if after payment, is not satisfied to send the documentation, will be added 18% VAT at the time of starting your trip.</span></p>
				<?php ; endif;?>
	        </div>
	        
	        <!-- Modal footer -->
	        <div class="modal-footer">
	          <button type="button" class="btn btn-danger" data-dismiss="modal">
	          	<?php 
		          	if(strtolower($language)=='es')echo "Cerrar";
		          	else echo "Close";
		          	
		          ?>
	          </button>
	        </div>
	        
	      </div>
	    </div>
	  </div>
	<footer class="footer">
			<?php $this->load->view('footer/footer'); ?>
	</footer>
	<style>
		.sitemap-list,.sitemap-list ul{
			list-style:none;
		}
		.sitemap-list > li{
			margin-bottom:10px;
			background:#f5f5eb;
			padding:3px;
			font-size:1em;
		}
		.sitemap-list  ul{
			margin-bottom:10px;

		}
		/* PERSONALIZAR EL CONTENEDOR DE FORMULARIOS */
		.forms_container .col-md-6:nth-child(odd){
			border-right:2px dashed #CCC;
		}
		input.error{
			border-color:red;
		}
		/*.forms_container table tr:hover{
			background:red;
		}*/
		.forms_container table tr:nth-child(2n+2){
			background:#f3f3f3;
		}
		.titulo_actividad{
			font-size:1.5em;
			background:#005bb7;
			font-weight:bold;
			color:white;
			margin-bottom:15px;
			padding:3px;
			
		}
	</style>
	<script>
	    (function(){
			var contenedor_form = $('#form_container');
			var campos_form = contenedor_form.find('input');
			campos_form.focusin(function(){$(this).removeClass('error');});

			var btn_guardar = $('.guardar_form');
			btn_guardar.click(function(){
				// alert('guardando');
				var validador = true;

				btn_guardar.text('<?=$traduccion['enviando'];?>');
				btn_guardar.attr('disabled','disabled');
				campos_form.each(function(){
					if(!$(this).val()){
						validador = false;
						$(this).addClass('error');
						
					}
				});
				if(validador){
					var data = campos_form.serializeArray();
					$.post('<?=base_url().$language;?>/data/customer_reg',data,function(result){
						console.log(result);
						if(!isNaN(result)){
						  alert('<?=$traduccion['registro_correcto'];?>');
						  location.href = '<?=base_url();?>';
						} else alert('<?=$traduccion['error_registro'];?>');
						btn_guardar.removeAttr('disabled');
				        btn_guardar.text('<?=$traduccion['enviar_form'];?>');
					});
				} else{
					btn_guardar.removeAttr('disabled');
					btn_guardar.text('<?=$traduccion['enviar_form'];?>');
					alert('<?=$traduccion['rellene_campos'];?>');
				} 
				
			})<?=count($campos_formulario)?'':'.attr("disabled","disabled")';?>; // deshabilitar botones de guardado si no hay formularios

		})();
		
	</script>
	</body>
</html>