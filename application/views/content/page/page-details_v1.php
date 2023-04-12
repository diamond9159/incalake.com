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
<div class="container-fluid">
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
					echo "	<ul class='dropdown-menu'>";
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
				case '6':
					$carpeta = 'other-images';
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
				<h1><?=$service->titulo_pagina;?> <br><small><?=$service->descripcion_pagina;?></small></h1>
			</div>
		</div>
		<div class="col-md-9">
			<?php
			function html_precio($id_producto,$precio){
		      return '<div class="row">
						            <div class="col-md-2">
						                <!--div class="form-group">
						                    <div class="input-group date" id="datetimepicker">
						                        <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="text"/>
						                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
						                        </span>
						                    </div>
						                </div-->
						            </div>
						            <div class="col-md-8"> 
						              <div class="preciosLista" data-urlreserva="http://localhost/web/reservas" data-idproducto="'.$id_producto.'" data-value=\''.$precio.'\'></div>
						            </div>
						            <!--div class="col-md-2"><button class="btn btn-danger reservasBtn">Reservar</button></div-->
						      </div>';		
			}
			//var_dump($productos);
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
							<li><a data-toggle='tab' href='#descripcion-$producto->id'>	<span class='fa fa-list'></span><span class='name-tab hidden-xs'> {$translate['descripcion']}</span></a></li>";
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
						echo "<li><a data-toggle='tab' href='#salida-$producto->id'>		<span class='fa fa-plus'></span><span class='name-tab hidden-xs'> {$translate['salida']}</span></a></li>";

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
									$producto->descripcion
								</div>
							</div>";

						if(!empty($producto->itinerario))
						echo "<div id='itinerario-$producto->id' class='tab-pane fade'>
								$producto->itinerario
							</div>";
						if(!empty($producto->incluye))
						echo "<div id='incluye-$producto->id' class='tab-pane fade'>
								$producto->incluye
							</div>";
						if(!empty($producto->informacion))
						echo "<div id='informacion-$producto->id' class='tab-pane fade'>
								$producto->informacion
							</div>";
						if(!empty($producto->mapa))
						echo "<div id='mapa-$producto->id' class='tab-pane fade'>
								<div id='div-mapa-$producto->id' style='height:500px;width:100%'></div>
							</div>";
						if(!empty($producto->recomendacion))
						echo "<div id='recomendacion-$producto->id' class='tab-pane fade'>
								$producto->recomendacion
							</div>";
						if(!empty($producto->salida))
						echo "<div id='salida-$producto->id' class='tab-pane fade'>
								$producto->salida
							</div>";
						foreach($producto->add_tabs as $tab){
							echo "<div id='extra-$tab->id_tab_adicional' class='tab-pane fade'>
								$tab->contenido_tab
							</div>";
						}
							
					echo "</div>
					</div>
					<hr>";
					/*ver los horarios de salidas*/
					function formatoFecha($horainicio,$dur){
					 $tip_tiempo = 0;
					 if($dur[1]==0)$tip_tiempo = (60*$dur[0]);
					 elseif($dur[1]==1)$tip_tiempo = (60*60*$dur[0]);
					 elseif($dur[1]==2)$tip_tiempo = (60*60*24*$dur[0]);
					 return date('h:i A', strtotime($horainicio)+$tip_tiempo).($dur[1]==2?' del dia '.$dur[0]:' del  mismo dia');
					}

					if(!empty($producto->hora_inicio)){
						$inicios = explode(',',$producto->hora_inicio);
						$dur_nom = array('Minutos','Horas','Dias');
						$duracion = explode(',',$producto->duracion);
						$html_inicios = null;
						foreach ($inicios as $key => $value) {
							$dur = explode('!',$duracion[$key]);
							$html_inicios .= '<p>'.$value.' hasta '.formatoFecha($value,$dur).' ('.$dur[0].' '.$dur_nom[$dur[1]].')</p>';
						}
					}
				    
					/*fin de ver los horarios de salidas*/
					echo '<div class="panel panel-default"><div class="panel-body">'.$html_inicios.'</div></div>'.html_precio($producto->id,$producto->precio_edad?$producto->precio_edad:$producto->precio_persona)."
				</div>	";
			}
			?>
		</div>
		

		<div class="col-md-3">
			<div class="typography">
				<div>
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
										case '6':
											$carpeta = 'other-images';
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
			</div>	
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
				
				html = html + "<a href='"+_base_url+language.toLowerCase()+'/categoria/'+category.uri+"' class='btn btn-success btn-xs'>"+category.nombre+"</a>";
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
							case "1": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-bus'></span></div>";
								break;
							case "2": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-hotel'></span></div>";
								break;
							case "3": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-dollar'></span></div>";
								break;
							case "4": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-object-ungroup'></span></div>";
								break;
							case "5": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-anchor'></span></div>";
								break;
							case "6": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-cutlery'></span></div>";
								break;
							case "7": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-lemon-o'></span></div>";
								break;
							case "8": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-camera'></span></div>";
								break;
							case "9": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-square-o'></span></div>";
								break;
							case "10": html = html + "<div class='btn btn-success btn-xs'><span class='fa fa-train'></span></div>";
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