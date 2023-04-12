<script>
	var language = <?=json_encode($language)?>;
	var place = <?=json_encode($place)?>;
	var service = <?=json_encode($service)?>;
	var products = <?=json_encode($productos)?>;
	var neighbours = <?=json_encode($vecinos)?>;
	var other_language = <?=json_encode($otros_idiomas)?>;
	var base_url = <?=json_encode(base_url('assets/incalakemap'))?>;
	var menu_language = <?=json_encode($menu_language)?>;
	//var menu_categoria
	
	console.log('language:',language);
	console.log('place:',place);
	console.log('servicio:',service);
	console.log('productos:',products);
	console.log('vecinos:',neighbours);
	console.log('otros idiomas:',other_language);
	console.log('menu de lenguages:',menu_language);
	//console.log('menu de categorias:',menu_categoria);
	// 
</script>
<div class="col-md-12">
	<div class="col-md-12 div-img-lugar">
		<div class="div-lugar col-md-12 text-center">
			<span><?=mb_strtoupper($place);?></span>
			<p><?=mb_strtoupper($service->descripcion_pagina);?></p>
			</div>
			<div id="custom-search-input" class="text-center">
				<div class="form-group col-md-6 col-md-offset-3">
				<?php
				$tmp = count($productos);
				if(count($productos) > 1){
					echo "<div class='dropdown'>";
					echo "	<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>$tmp {$translate['productos']}";
					echo "	<span class='caret'></span></button>";
					echo "	<ul class='dropdown-menu div-dropdown-menu-product'>";
						foreach($productos as $producto){
							$id_div = 'div-'.$producto->titulo;
							$nombre = $producto->titulo;

							echo "<li><a href='#$id_div'>$nombre</a></li>";
						}
					echo "	</ul>";
					echo "</div>";
				}
				?>
			</div>	       
		</div>
		<div class="div-color">      
		</div>
		<div class="place-incons" id="map-icons-div">
			
		</div>
		<div class="categoria">
			<div class="color-categoria" id="tipos_categoria">
			</div>
		</div>

		<?php
			$carpeta = "";
			switch ($service->portada->tipo_archivo) {
				case '0':
					$carpeta = 'docs';
					break;
				case '1':
					$carpeta = 'full-slider';
					break;
				case '2':
					$carpeta = 'short-slider';
					break;
				case '3':
					$carpeta = 'relateds';
					break;
				case '4':
					$carpeta = 'recursos';
					break;
				case '5':
					$carpeta = 'politicas';
					break;
				default:
					$carpeta = 'otros';
					break;
			}
			$folderg = $service->portada->carpeta_archivo;
			$namef = $service->portada->url_archivo;
				
			echo "<img src='".base_url()."galeria/admin/$carpeta/$folderg/$namef'>";
?>

	</div>

	<div class="row">
		<div class="col-md-12 text-center page-titulo">
			<div class="container-fluid ">
				<h1><span class="main-title"><?=$service->titulo_pagina;?></span> <br><small><?=$service->descripcion_pagina;?></small></h1>
			</div>
			<hr>
		</div>

		<div class="col-md-9">
		<!-- probando carusel -->
		<style>
.slider-navigation {
  background: aquamarine;
  text-align: center;
}

#slider-thumbs { /*margin-top: -100px;*/
   padding:0 15px 0 15px;
 }
#slider-thumbs .list-inline{ 
  background: #333;
  padding:5px 0 0px 0;
  margin:0;
 }

#slider-thumbs .list-inline li {
  width: 15%;
  padding: 0px;
  cursor: pointer;
  margin-right:-4px;
  border:1px solid transparent;
}

#slider-thumbs .list-inline li:first-child { }

.slider-nav-arrow {
  text-align: center;
  margin-bottom: 0px;
  visibility: hidden;
}

.selected .slider-nav-arrow { visibility: visible; }

.selected .slider-navigation { opacity: 0.5; }
</style>
		<div class="row">
		    <div class="col-md-12" id="slider">
		      
		        <div id="myCarousel" class="carousel slide "> 
		          <!-- main slider carousel items -->
		          <div class="carousel-inner">
		            <div class="active item" data-slide-number="1"> <img src="https://unsplash.it/1200/600?image=365" class="img-responsive"> </div>
		            <div class="item" data-slide-number="2"> <img src="https://unsplash.it/1200/600?image=361" class="img-responsive"> </div>
		            <div class="item" data-slide-number="3"> <img src="https://unsplash.it/1200/600?image=366" class="img-responsive"> </div>
		            <div class="item" data-slide-number="4"> <img src="https://unsplash.it/1200/600?image=367" class="img-responsive"> </div>
		          </div>
		          <!-- main slider carousel nav controls --> <a class="carousel-control left" href="#myCarousel" data-slide="prev">‹</a> <a class="carousel-control right" href="#myCarousel" data-slide="next">›</a> </div>
		      
		    </div>




		      <div class="col-md-12 hidden-xs" id="slider-thumbs"> 
		    <!-- thumb navigation carousel items -->
		    <ul class="list-inline">
		      <li> <a id="carousel-selector-1" class="selected">
		        <div class="slider-navigation"><img src="https://unsplash.it/1200/600?image=365" class="img-responsive"></div>
		        </a></li>
		      <li> <a id="carousel-selector-2">
		        <div class="slider-navigation" style="background: darksalmon;"> <img src="https://unsplash.it/1200/600?image=361" class="img-responsive"> </div>
		        </a></li>
		      <li> <a id="carousel-selector-3">
		        <div class="slider-navigation" style="background: bisque;"> <img src="https://unsplash.it/1200/600?image=366" class="img-responsive"> </div>
		        </a></li>
		      <li> <a id="carousel-selector-4">
		        <div class="slider-navigation" style="background: burlywood;"> <img src="https://unsplash.it/1200/600?image=367" class="img-responsive"> </div>
		        </a></li>
		    </ul>
		  </div>
		  </div>

		  <!-- fin probando carusel -->
			<?php

			//funcion para formatear fechas
		    function formatoFecha($horainicio,$dur,$translate){
				    //global $translate;
					 $tip_tiempo = 0;
					 if($dur[1]==0)$tip_tiempo = (60*$dur[0]);
					 elseif($dur[1]==1)$tip_tiempo = (60*60*$dur[0]);
					 elseif($dur[1]==2)$tip_tiempo = (60*60*24*$dur[0]);
					 return date('h:i A',strtotime($horainicio)+$tip_tiempo)." {$translate['horas']} ".($dur[1]==2?" {$translate['del_dia']} ".$dur[0]:" {$translate['mismo_dia']}.");
		    }
		    $tiempo_duracion = array($translate['minutos'],$translate['horas'],$translate['dias']);
			foreach($productos as $producto){
				echo "
				<div class='col-md-12 text-center' id='div-$producto->titulo' tabindex='-1'>
					<div class='row sub-page-titulo'>
						<div class=' container-fluid'>
							<h2>$producto->titulo</h2>
							<small>$producto->subtitulo</small>
						</div>
					</div>
				</div>
				<div class='col-md-12'>
					<div class='row typography'>
						<ul class='nav nav-tabs'>
							<li class='active'><a data-toggle='tab' href='#descripcion-$producto->id'>	<span class='fa fa-list'></span><span class='name-tab hidden-xs'> {$translate['descripcion']}</span></a></li>";
						if( !empty($producto->itinerario))
						echo "<li><a data-toggle='tab' href='#itinerario-$producto->id'>	<span class='fa fa-clock-o'></span><span class='name-tab hidden-xs'> {$translate['itinerario']}</span></a></li>";
						if( !empty($producto->incluye))
						echo "<li><a data-toggle='tab' href='#incluye-$producto->id'>		<span class='fa fa-plus-circle'></span><span class='name-tab hidden-xs'> {$translate['incluye']}</span></a></li>";
						if( !empty($producto->informacion))
						echo "<li><a data-toggle='tab' href='#informacion-$producto->id'>	<span class='fa fa-home'></span><span class='name-tab hidden-xs'> {$translate['informacion']}</span></a></li>";
						if( !empty($producto->mapa))
						echo "<li><a data-toggle='tab' href='#mapa-$producto->id' id='tab-mapa-$producto->id' ><span class='fa fa-map-o'></span><span class='name-tab hidden-xs'> {$translate['mapa']}</span></a></li>";
						if(!empty($producto->recomendacion))
						echo "<li><a data-toggle='tab' href='#recomendacion-$producto->id'><span class='fa fa-plus'></span><span class='name-tab hidden-xs'> {$translate['recomendacion']}</span></a></li>";
						if(!empty($producto->salida))
						echo "<li><a data-toggle='tab' href='#salida-$producto->id'><span class='fa fa-plus'></span><span class='name-tab hidden-xs'> {$translate['salida']}</span></a></li>";
						/*adding inicios*/
						if(!empty($producto->hora_inicio)){
							/*ver los horarios de salidas*/
							echo "<li><a data-toggle='tab' href='#inicios-$producto->id'><span class='fa fa-hourglass-start'></span><span class='name-tab hidden-xs'> {$translate['inicios']}</span></a></li>";

							$html_inicios = null;
							if(!empty($producto->hora_inicio)){
								$inicios = explode(',',$producto->hora_inicio);
								$dur_nom = $tiempo_duracion;
								$duracion = explode(',',$producto->duracion);
								$html_inicios = '<div class="well well-sm"><i class="fa fa-clock-o"></i> <strong>'.$translate['horas_salida'].'</strong></div><table class="table table-hover"><thead><tr><th>#</th><th>'.$translate['hora_inicio'].'</th><th>'.$translate['hora_final'].'</th><th>'.$translate['duracion'].'</th></tr></thead>';
								foreach ($inicios as $key => $value) {
									$dur = explode('!',$duracion[$key]);
									$html_inicios .= '<tr><td> '.++$key.'</td><td>'.$value.'</td><td>'.formatoFecha($value,$dur,$translate).'</td><td>'.$dur[0].' '.$dur_nom[$dur[1]].'</td></tr>';

								}
								$html_inicios.='</table>';
							}
						/*fin de ver los horarios de salidas*/
						}

						/*fin adding inicios*/

						foreach($producto->add_tabs as $tab){
							echo "<li><a data-toggle='tab' href='#extra-$tab->id_tab_adicional'><span class='fa fa-$tab->icono_tab_adicional'></span><span class='name-tab hidden-xs'>$tab->nombre_tab</span></a></li>";
						}
					echo "</ul>";
						
					echo "<div class='tab-content col-md-12'>
							<div id='descripcion-$producto->id' class='tab-pane fade in active'>
								<div id='carousel-$producto->id' class='carousel slide slider-ajustar' data-ride='carousel'>
									<div class='carousel-inner'>";
									$carpeta = "";
									$cont = "active";
									foreach ($producto->images as $imagen) {

										switch ($imagen->tipo_archivo) {
											case '0':
												$carpeta = 'docs';
												break;
											case '1':
												$carpeta = 'full-slider';
												break;
											case '2':
												$carpeta = 'short-slider';
												break;
											case '3':
												$carpeta = 'relateds';
												break;
											case '4':
												$carpeta = 'recursos';
												break;
											case '5':
												$carpeta = 'politicas';
												break;
											default:
												$carpeta = 'otros';
												break;
										}
										echo "
										<div class='$cont item'>
											<img class='img-responsive' src='".base_url()."galeria/admin/$carpeta/$imagen->carpeta_archivo/$imagen->url_archivo'>
											<div class='container'>
												<p>$imagen->detalles_archivo</p>
											</div>
										</div>
										";
										$cont = '';
									}
									if(empty($producto->images)){
										echo "
										<div class='$cont item'>
											<img class='img-responsive' src='".base_url()."galeria/admin/otros/default.jpg'>
											<div class='container'>
												<p>Imagen no disponible</p>
											</div>
										</div>
										";
									}
										
								echo "  </div>
									<div class='gradiente-top'></div>
									<a class='left carousel-control' href='#carousel-$producto->id' data-slide='prev'><span class='glyphicon glyphicon-chevron-left'></span></a>
									<a class='right carousel-control' href='#carousel-$producto->id' data-slide='next'><span class='glyphicon glyphicon-chevron-right'></span></a>
								</div>
								<div>
									<div class='line-header'><div>DESCRIPCIÓN</div></div>
									$producto->descripcion
								</div>
							</div>";

						if(!empty($producto->itinerario))
						echo "<div id='itinerario-$producto->id' class='tab-pane fade'>
								<div class='line-header'><div>ITINERARIO</div></div>
								$producto->itinerario
							</div>";
						if(!empty($producto->incluye))
						echo "<div id='incluye-$producto->id' class='tab-pane fade'>
								<div class='line-header'><div>INCLUYE</div></div>
								$producto->incluye
							</div>";
						if(!empty($producto->informacion))
						echo "<div id='informacion-$producto->id' class='tab-pane fade'>
								<div class='line-header'><div>informacion</div></div>
								$producto->informacion
							</div>";
						if(!empty($producto->mapa))
						echo "<div id='mapa-$producto->id' class='tab-pane fade'>
								<div class='line-header'><div>MAPA</div></div>
								<div id='div-mapa-$producto->id' style='height:500px;width:100%'></div>
							</div>";
						if(!empty($producto->recomendacion))
						echo "<div id='recomendacion-$producto->id' class='tab-pane fade'>
					<div class='line-header'><div>Recomendaciones</div></div>
								$producto->recomendacion
							</div>";
						if(!empty($producto->salida))
						echo "<div id='salida-$producto->id' class='tab-pane fade'>
								$producto->salida
							</div>";
						if(!empty($producto->hora_inicio))
						echo "<div id='inicios-$producto->id' class='tab-pane fade'>
					<div class='line-header'><div>Horarios de salida</div></div>
								$html_inicios
							</div>";

						foreach($producto->add_tabs as $tab){
							echo "<div id='extra-$tab->id_tab_adicional' class='tab-pane fade'>
								$tab->contenido_tab
							</div>";
						}
					
						//$tip_tiempo_temp = $tiempo_duracion;
							if(!empty($producto->anticipacion_reserva_producto)){
							    $tiempo_duracion_data = explode(':',$producto->anticipacion_reserva_producto);
							    $tiempo_duracion_num = $tiempo_duracion_data[0];
							    $tiempo_duracion_tipo = @$tiempo_duracion[$tiempo_duracion_data[1]];	
							}

						 /*informacion sobre el aforo de personas y anticipacion de reserva*/
					       if(!empty($producto->capacidad) or !empty($producto->anticipacion_reserva_producto)){
					       	 $temp_info_reserva="<div class='alert alert-danger'>".($producto->capacidad?"<strong>Capacidad:</strong> $producto->capacidad personas":null).($producto->anticipacion_reserva_producto?"<strong> * Tiempo de anticipación de la reserva:</strong> $tiempo_duracion_num $tiempo_duracion_tipo":null)."</div>";
					       }
					      /*fin de informacion sobre el aforo de personas y anticipacion de reserva*/   	

				   // $precios = html_precio($producto->id,$producto->precio_edad?$producto->precio_edad:$producto->precio_persona,$translate,$language);
					echo "</div>
					  <div style='clear:both'></div><br>
					        <div class='col-md-2'></div>
					        <div class='col-md-8'>
					        <div class='preciosLista'  data-urlreserva='".base_url().mb_strtolower($language)."/".$translate["reservas"]."/".$producto->id."' data-idproducto='$producto->id' data-titulo='$producto->titulo' data-value='".($producto->precio_edad?$producto->precio_edad:$producto->precio_persona)."'></div>".
							$temp_info_reserva
					        ."</div>
					        <div class='col-md-2'></div>
					       <div style='clear:both'></div>";
					       
					   echo $producto->precio_detalles?"<div class='alert alert-info'><strong>Información Importante sobre los precios: </strong> $producto->precio_detalles</div>":null;
					   echo "<div style='clear:both'></div>
					     
					    
					</div>
					
				</div>	";
			}
			?>
			<script>
	$('.carousel').carousel({
	  interval: 3000
	});

	// handles the carousel thumbnails
	$('[id^=carousel-selector-]').hover(function() {
	  var id_selector = $(this).attr("id");
	  //console.log(id_selector);
	  var id = id_selector.substr(id_selector.length - 1);
	  console.log(id);
	  id = parseInt(id);
	  $(this).parents('.row').find('.carousel').carousel(id - 1);
	  //console.log($(this).parents('.row').hide());
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $(this).addClass('selected');
	  //console.log(this);
	});

	// when the carousel slides, auto update
	$('.carousel').on('slid.bs.carousel', function(e) {
	  var id = $('.item.active').data('slide-number');
	  id = parseInt(id);
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $('[id=carousel-selector-' + id + ']').addClass('selected');
	});
</script>
		</div>
		

		<div class="col-md-3">
			<div class="typography">

					<ul class="nav nav-tabs">
					    <li class="active"><a data-toggle="tab" href="#similares"><?=$translate['sitios_similares'];?></a></li>
					</ul>
					
					<div class="tab-content">
						<div id="similares" class="tab-pane fade in active">
							<div class='row' id='relacionados' data-id='4'>
					      	<?php
					      		$carpeta = "";
					      		foreach($vecinos as $vecino){

									switch ($vecino->tipo_archivo) {
										case '0':
											$carpeta = 'docs';
											break;
										case '1':
											$carpeta = 'full-slider';
											break;
										case '2':
											$carpeta = 'short-slider';
											break;
										case '3':
											$carpeta = 'relateds';
											break;
										case '4':
											$carpeta = 'recursos';
											break;
										case '5':
											$carpeta = 'politicas';
											break;
											
										default:
											$carpeta = 'otros';
											break;
									}
									echo "
										<a href='".base_url().''.strtolower($language).'/'.$place.'/'.$vecino->uri_servicio."'>
										<div class='col-md-12 col-xs-12'>
										    <div class='row'>
										        <div class='col-md-6 col-xs-6'><span class='precio-relacionado' style='text-decoration: ;  '></span><img class='img-responsive img-thumbnail' src='".base_url()."galeria/admin/$carpeta/$vecino->carpeta_archivo/$vecino->url_archivo'>
										        </div>
										        <div class='col-md-6 col-xs-6'><span class='titulorel'>
										        	$vecino->titulo_pagina
										        </div>
										    </div>
										</div>
									</a>
									";
								}
						  	?>
						  	</div>
					    </div>
					</div>
			</div>	
			<!-- otras opciones -->
			<div class="panel panel-info" id="fixed_form">
			  <div class="panel-heading">¿Tienes una pregunta?</div>
			  <div class="panel-body">
			  <form>
				  <div class="form-group">
				    <label for="email">Nombre:</label>
				    <input type="email" class="form-control" id="email">
				  </div>
				  <div class="form-group">
				    <label for="email">Correo:</label>
				    <input type="email" class="form-control" id="email">
				  </div>
				  <div class="form-group">
				    <label for="email">Pregunta:</label>
				    <textarea class="form-control"></textarea>
				  </div>

				  <div class="form-group">
				    <label for="email">Seleccione tour:</label>
				    <select class="form-control"><option>Tour uros</option><option>Tour uros medio dia</option><option>Tour uros full day</option></select>
				  </div>

				  <button type="submit" class="btn btn-info btn-lg btn-block">Enviar</button>
				</form>
			  
			 </div>
			</div>
			<script>

			function fixFORM(){
				var top_window = Math.ceil($(this).scrollTop());
				
				/*console.log('window: '+top_window);
				console.log('element: '+top_element);
				console.log('ancho : '+form_fix.width());*/
				  if (top_window > top_element) {
				     form_fix.addClass('fixed_form');
				  } else {
				     form_fix.removeClass('fixed_form');
				}
			}
			var form_fix = $('#fixed_form');
			form_fix.width(form_fix.width()+'px');
			var top_element = Math.ceil(form_fix.offset().top);
			$(window).scroll(fixFORM);
			 
			</script>
			<style type="text/css">
				.fixed_form{
					position: fixed;
					top:70px;
				}
			</style>
			<!-- fin otras opciones -->
		</div>
	</div>
</div>
<script>
	products.forEach((product)=>{
		if(product.mapa){
			var waypoints = JSON.parse(product.mapa);
			waypoints = waypoints.lugares;
			$("#tab-mapa-"+product.id).on('shown.bs.tab', function () {
				var mapa = new IncalakeMap("div-mapa-"+product.id);
				mapa.setBaseUrl(base_url);
				mapa.addWaypoints(waypoints);
				mapa.showNumberedMarkers();
			});
		}
	});
	const _base_url = <?=json_encode(base_url())?>;
	function loaded(){
		console.log('cargo por completo');
		
		other_language.forEach((another_language)=>{
			document.getElementById(`link-lang-${another_language.codigo.toLowerCase()}`).href = _base_url+another_language.codigo.toLowerCase()+'/'+place+'/'+another_language.uri_servicio;
		});
		document.getElementById(`link-lang-${language.toLowerCase()}`).href = '#';
		$(`#link-lang-${language.toLowerCase()}`).attr("disabled","disabled");

		// Categorias de la pagina ===============
		var tmp_categorias = [];
		html = "";
		products.forEach((product)=>{
			product.categorias.forEach((category)=>{
				let existe_en_lista = false;
				tmp_categorias.forEach((cat)=>{
					if(cat.uri == category.uri) existe_en_lista = true;
				});

				if(!existe_en_lista) tmp_categorias.push(category);
				
				html = html + " <a href='"+_base_url+language.toLowerCase()+'/categoria/'+category.uri+"' class='btn btn-success btn-xs'>"+category.nombre+"</a>";
			});
		});
		console.log('total de categorias: ', tmp_categorias);
		document.getElementById('tipos_categoria').innerHTML = html;

		// Iconos del mapa ==================
		var tmp_map_icons = [];
		html = "";
		products.forEach((product)=>{
			if(product.mapa){
				var datos_mapa = JSON.parse(product.mapa);
				datos_mapa.lugares.forEach((lugar)=>{
					if( tmp_map_icons.indexOf(lugar.tipo)==-1 ){
						tmp_map_icons.push(lugar.tipo);
						switch(lugar.tipo){
							case "0": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-plane'></span></div>";
								break;
							case "1": html = html + " <div class='btn btn-success btn-xs'><span class='fa fa-bus'></span></div>";
								break;
							case "2": html = html + " <div class='btn btn-success btn-xs'><span class='fa fa-hotel'></span></div>";
								break;
							case "3": html = html + " <div class='btn btn-success btn-xs'><span class='fa fa-dollar'></span></div>";
								break;
							case "4": html = html + " <div class='btn btn-success btn-xs'><span class='fa fa-object-ungroup'></span></div>";
								break;
							case "5": html = html + " <div class='btn btn-success btn-xs'><span class='fa fa-anchor'></span></div>";
								break;
							case "6": html = html + " <div class='btn btn-success btn-xs'><span class='fa fa-cutlery'></span></div>";
								break;
							case "7": html = html + " <div class='btn btn-success btn-xs'><span class='fa fa-lemon-o'></span></div>";
								break;
							case "8": html = html + " <div class='btn btn-success btn-xs'><span class='fa fa-camera'></span></div>";
								break;
							case "9": html = html + " <div class='btn btn-success btn-xs'><span class='fa fa-square-o'></span></div>";
								break;
							case "10": html = html + " <div class='btn btn-success btn-xs'><span class='fa fa-train'></span></div>";
								break;
						}
						
					}
				});
			}
		});
		console.log('total de iconos de mapa: ', tmp_map_icons);
		document.getElementById('map-icons-div').innerHTML = html;
	}
</script>