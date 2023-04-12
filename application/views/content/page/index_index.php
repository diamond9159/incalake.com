<?php

  $active_slider='active';
  $temp_list='';
  $temp_img_list='';

  foreach ($slider_index  as $key => $value):
    
    if(!empty($value) && $key<=0)
    {
      $temp_list .= '<li data-target="#slider-index" data-slide-to="'.$key.'" class="'.$active_slider.'"></li>';
      $temp_img_list .= '
        <div class="carousel-item '.$active_slider.'">
          <img class="d-block w-100 img-slider" src="'.$value['imagen'].'" alt="First slide">
          <div class="carousel-caption">
            <h3 class="title carousel tour"><a href="'.$value['url'].'">'.$value['titulo'].'</a></h3>
            <p class="d-sm-none d-none d-md-block">'.$value['descripcion'].'</p>
          </div>
          <div class="fondo-slider"></div>
        </div>';
    }
    
    $active_slider='';

  endforeach 

?>


<!-- slider y buscador -->
<div id="slider-index" class="carousel slide carousel-fade" data-ride="carousel">
  
  <?php if (!empty($slider_index)): ?>
    
    <ol class="carousel-indicators">
      <?= $temp_list; ?>        
    </ol>

    <div class="carousel-inner" style="">
        <?=$temp_img_list;?>
    </div>

  <?php endif ?>


  <div class="div-search">
    <div class="content-search">
            
      <div class="row justify-content-md-center " style="margin: 0;">
        <div class="col-md-6" style="background: #fff;padding: 0;">
          
          <div class="inputWithIcon inputIconBg" style="display: inline-flex;width: 100%;">
            <div class="input-group">
              <input 
                id="input-search" 
                class="form-control" 
                placeholder="<?=($language=='es'?'Busca por ejemplo: Uros, Taquile, Machupicchu, Colca, Uyuni, etc.':'Search for example: Uros, Taquile, Machu Picchu, Colca, Uyuni, etc.');?>" 
                aria-label="Search" aria-describedby="Search"
              >
              <button type="button" class="btn btn-primary btn-search" data-toggle="modal" data-target="#searchGoogleModal2">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>

          <div class="row div-result-search ">
            <div class="col-12 div-result-content-default">
              <div class="row m-0">
                <div class="col-md-6 text-left">
                  
                  <?php if (!empty($destinos_search)): ?>                
                    
                    <div>
                      <b><?=mb_strtolower($language) === 'es'?'Los Mejores Destinos':'The Best Destinations';?></b>
                    </div>

                    <ul>
                      <?php
                        foreach($destinos_search as $destino_search)
                        {
                          $ds_nombre = $destino_search['nombre'];
                          $ds_url    = $destino_search['url'];
                          echo "<li><a href='$ds_url'>$ds_nombre</a></li>";
                        }
                      ?>
                    </ul>

                  <?php endif ?>

                  <div>
                    <a href="<?=base_url().trim(mb_strtolower($language)).'/'.( mb_strtolower($language) === 'es'?'destinos':'destinations' ) ?>">
                      <?=mb_strtolower($language) === 'es'?'Ver más Destinos':'View More Destinations';?> >>
                    </a>
                  </div>

                </div>
              
                <div class="col-md-6 text-left">

                  <?php if (!empty($actividades_search)): ?>

                    <div>
                      <b><?=mb_strtolower($language) === 'es'?'Las Mejores Actividades':'The Best Activities';?></b>
                    </div>

                    <ul>
                      <?php
                        foreach($actividades_search as $actividad_search)
                        {
                          $as_nombre = $actividad_search['nombre'];
                          $as_url    = $actividad_search['url'];
                          echo "<li><a href='$as_url'>$as_nombre</a> </li>";
                        }
                      ?>                    
                    </ul>

                  <?php endif ?>
                
                </div>
              </div>
              
            </div>


            <div id="fromList" class="row col-12 div-result-content-search">
  
              <div id="coincidencias_locations" class="text-capitalize col-12">
              </div>
  
              <div id="coincidencias_activities" class="text-capitalize col-12">
              </div>
  
              <div id="solo-cuando-no-encuentra" class=" text-center col-12">
 
                <div class="text-left font-weight-bold"><?=mb_strtolower($language) === 'es'?'Contactenos':'Contact Us';?>
                </div>

                <div class="text-left text-capitalize ">
                  <a id="llamar-telefono"> <!-- agregar href si esta en modo phone (JS) -->
                    <span class="fa fa-phone bg-primary text-light p-1 m-1"></span> <?=mb_strtolower($language) === 'es'?'teléfono':'phone';?> (+51) 984434731
                  </a>
                </div>

                <div class="text-left">
                  <a id="correo-abrir"> <!-- agregar href si esta en modo phone (JS) -->
                  <span class="fa fa-envelope text-primary bg-primary text-light p-1 m-1"></span> <?=mb_strtolower($language) === 'es'?'Correo Electrónico':'e-mail';?> reservas@incalake.com
                  </a>
                </div>
              
              </div>
  
            </div>
            
          </div>
        </div>
      </div>
    </div>
      
  </div>
        
  <a class="carousel-control-prev" href="#slider-index" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#slider-index" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>

</div>
<!--/ slider y buscador -->


<!-- info -> porque elegirnos, etc -->
<ul class="nav nav-tabs container-fluid row text-center div-porque-elegirnos text-light text-capitalize" id="myTab" role="tablist">
  <li class="col-sm-6 col-md d-flex align-items-center item-porque-elegirnos div-txt-porque-elegirnos">
    <a class="nav-link" >
      <span class="txt-porque-elegirnos "><?=($language=='es'?'¿Por Qué Elegirnos?':'Why Choose Us?')?></span>
    </a>
  </li>
  <li class="col-sm-6 col-md d-flex align-items-center item-porque-elegirnos">
    <a class="nav-link active" id="guia-tab" data-toggle="tab" href="#guia" role="tab" aria-controls="guia" aria-expanded="true">
      <span class="fa fa-group fa-2x"></span>
      <span class="txt-porque-elegirnos"><?=($language=='es'?'Guías Impecables':'Impeccable Guides')?></span>
    </a>
  </li>
  <li class="col-sm-6 col-md d-flex align-items-center item-porque-elegirnos">
    <a class="nav-link" id="destinos-tab" data-toggle="tab" href="#destinos" role="tab" aria-controls="destinos">
      <span class="fa fa-map-signs fa-2x"></span>
      <span class="txt-porque-elegirnos"><?=($language=='es'?'Diversos Destinos':'Other Destinations')?></span>
    </a>
  </li>
  <li class="col-sm-6 col-md d-flex align-items-center item-porque-elegirnos">
    <a class="nav-link" id="clientes-tab" data-toggle="tab" href="#clientes" role="tab" aria-controls="clientes">
      <span class="fa fa-thumbs-o-up fa-2x"></span>
      <span class="txt-porque-elegirnos"><?=($language=='es'?'Clientes Satisfechos':'Satisfied customers')?></span>
    </a>
  </li>
  <li class="col-sm-6 col-md d-flex align-items-center item-porque-elegirnos">
    <a class="nav-link" id="precios-tab" data-toggle="tab" href="#precios" role="tab" aria-controls="precios">
      <span class="fa fa-money fa-2x"></span>
      <span class="txt-porque-elegirnos"><?=($language=='es'?'Precios Justos':'Fair Prices')?></span>
    </a>
  </li>
</ul>

<div class="row justify-content-center" style="margin: 0;background: #fff;box-shadow: 0px 0px 7px 0px;">
  <div class="col-11 col-sm-11 col-lg-10 tab-content" id="myTabContent" style="padding-top: 1%;padding-bottom: 1%;" >
    
    <div class="tab-pane fade show active" id="guia" role="tabpanel" aria-labelledby="guia-tab">
      <h5><b><?=($language=='es'?'Guías Impecables':'Impeccable Guides')?></b></h5>
      <div class="row justify-content-md-center">
        <div class="col-sm-auto col-md-auto d-flex align-items-center justify-content-end div-description-porque-elegirnos" >
          <span class="fa fa-group fa-2x d-none d-sm-none d-md-block"></span>
        </div>
        <div class="col col-sm col-md">
          <p>
          	<?=($language=='es'?'<b>Nuestros guías son excepcionales,</b> padres, emprendedores, lectores entre otras muchas cosas. Hablan diferentes idiomas, son divertidos y responsables. Así que tendrás una buena experiencia con nosotros en las excursiones que tomes.':'<b>Guides from Inca Lake are exceptional</b>, some father’s entrepreneurs, readers, football players among many Other things. They speak very well the language you request, and most of all, they are fun. You will be very happy, because you will be in great hands, come on and <a href="http://en.incalake.com/incalake-team">meet our team</a>') ?>
          </p>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="destinos" role="tabpanel" aria-labelledby="destinos-tab">
      <h5><b><?=($language=='es'?'Diversos Destinos':'Other Destinations')?></b></h5>
      <div class="row justify-content-md-center">
        <div class="col-sm-auto col-md-auto d-flex align-items-center div-description-porque-elegirnos" >
          <span class="fa fa-map-signs fa-2x d-none d-sm-none d-md-block"></span>
        </div>
        <div class="col col-sm col-md ">
          <p>
          	<?=($language=='es'?'<strong>Somos especialistas en la región sur del Perú; desde Cusco, pasando por Arequipa, navegando por el Lago Titicaca y llegando hasta el Salar de Uyuni.</strong> Déjanos planificar tu viaje y verás por qué estamos felices de hacer lo que hacemos.':'<b>We’re specialist in the south region of Peru; from Cusco (Machupicchu), passing through Arequipa (Colca), navigating Lake Titicaca and reaching Salt flats of Uyuni.</b> Let us plan your trip and see why you and us are very happy about what we do.') ?>
          </p>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="clientes" role="tabpanel" aria-labelledby="clientes-tab">
      <h5><b><?=($language=='es'?'Clientes Satisfechos':'Satisfied customers')?></b></h5>
      <div class="row justify-content-md-center">
        <div class="col-sm-auto col-md-auto d-flex align-items-center div-description-porque-elegirnos ">
          <span class="fa fa-thumbs-o-up fa-2x d-none d-sm-none d-md-block"></span>
        </div>
        <div class="col col-sm col-md ">
          <p>
          <?=($language=='es'?'<strong>Desde la primera llamada telefónica hasta la última</strong>, nos enorgullecemos de anticipar y responder a cada una de las preguntas que pueda tener antes, durante y después de su viaje.<strong> Cientos de comentarios online nos respaldan en TripAdvisor, también offline</strong>, y los puedes <a href="http://incalake.com/recomendaciones">ver aquí</a>':'<b>From the first phone call to the final nostalgic photo swap</b>, we pride ourselves on anticipating and answering each and every question you might have before, during and after your trip Hundreds of clients, are very happy with our service and you can check it from our travel social networks <a href="https://www.tripadvisor.com.pe/Attraction_Review-g298442-d3265896-Reviews-or20-Inca_Lake_Day_Tours-Puno_Puno_Region.html#REVIEWS" target="_blank">Tripadvisor</a> and as well offline comments, and you can see it <a href="http://en.incalake.com/why-choose-us" target="_blank">here.</a>') ?>
          </p>
        </div>
     	</div>
		</div>

    <div class="tab-pane fade" id="precios" role="tabpanel" aria-labelledby="precios-tab">
      <h5><b><?=($language=='es'?'Precios Justos':'Fair Prices')?></b></h5>
      <div class="row justify-content-md-center">
        <div class="col-sm-auto col-md-auto d-flex align-items-center div-description-porque-elegirnos ">
          <span class="fa fa-money fa-2x d-none d-sm-none d-md-block"></span>
        </div>
        <div class="col col-sm col-md ">
          <p>
          	<?=($language=='es'?'Ofrecemos los <strong>mejores y más justos precios en la región sur del país</strong>; respaldados por una gran reputación, que no dejaremos caer.':'<b>We offer fair and good prices in the region of Peru</b>; always supported with a great reputation, that we won’t let it go down.') ?>
          </p>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="dropdown2" role="tabpanel" aria-labelledby="dropdown2-tab">...</div>

  </div>
</div>
<!--/ info -> porque elegirnos, etc -->



<!-- row bienvenidos -->
<div class="row justify-content-center" style="margin: 2% 0;">
  <div class="col-11 col-sm-11 col-lg-10 row" style="margin: 0;">
	  
	  <div class="col-12 col-sm-3 col-md-3">
	  	<h6 class="text-center text-uppercase font-weight-bold"><?=$language=='es'?'Premio':'Reward'?></h6>
	    <div class="text-center" style="position: relative;">
	      <img class="img" src="//incalake.com/img/tripadvisor/tripadvisor-2017.png" style="height: 130px;" title="Certificado de Excelencia Trip Advisor 2017" alt="Certificado de Excelencia Trip Advisor 2017">
	      <div class="div-year">
	        <div class="txt-year">2017</div>
	      </div>
	      <div class=" div-cinta">
	        <div class="cinta"> <span>INCALAKE</span> </div>
	      </div>
	    </div>
	  </div>
  
	  <div class="col-12 col-sm-6 col-md-6 text-justify">
	    <h4 class="text-center text-uppercase font-weight-bold"><?=($language=='es'?'¡Bienvenidos a la agencia de viajes Incalake!':'Welcome to Incalake travel agency!')?> </h4>
	    <p>
	    	<?=($language=='es'?'<strong>Agencia de viajes incalake</strong>, somos operadores de turismo, especializados en viajes creativos y únicos en los paises de Perú y Bolivia, ofrecemos una experiencia unica en turismo convencional, aventura, mistica, rural, de lujo, y ecoturismo. Nuestra filosofia de servicio es cuidar desde el momento que llegas hasta cuando decides salir de nuestro país.':'<strong> Incalake Travel Agency </strong>, we are tour operators, specializing in creative and unique travel in the countries of Peru and Bolivia, we offer a unique experience in conventional tourism, adventure, mystic, rural, luxury, and ecotourism. Our philosophy of service is to take care of from the moment you leave until you decide to leave our country.')?>
	    </p>
	  </div>

  	<div class="col-12 col-sm-3 col-md-3 ">
  		<h6 class="text-center text-uppercase font-weight-bold"><?=$language=='es'?'Comentarios':'comments'?></h6>

    	<div class="embed-responsive embed-responsive-16by9 content-coments">
      
      	<a href="https://www.youtube.com/watch?v=UuWqDJY5lXc" target="_blank">
          <div class="embed-responsive-item">
            <img src="https://incalake.com/img/video/UuWqDJY5lXc.webp" class="w-100">
          </div>
          <p class="text-center">https://www.youtube.com/watch?v=UuWqDJY5lXc</p>
      	</a>
      
      	<div class="btn-view-coments" data-toggle="modal" data-urlvideo="https://www.youtube.com/embed/UuWqDJY5lXc?rel=0" data-target="#comentariosModal"></div>
    	</div>
    </div>

  </div>
</div>
<!--/ row bienvenidos -->



<div class="row justify-content-center div-destinos-index" style="margin:0;"></div>
<div class="row justify-content-center div-ofertas-index" style="margin:0;"></div>
<div class="row justify-content-center div-comprados-index" style="margin:0;"></div>


<!-- recomendaciones en video -->
<div class="row justify-content-center div-youtube-index" style="margin:0;">
  <div class="col-11 col-sm-11 col-lg-10">
    
    <hr class="col-md-12">
          
    <div class="row" style="display:flex;align-items:center;justify-content:center">
             
     	<div class="col-md-12 text-center div-title">
        <h4 class="div-content-title"><strong><?=$language=='es'?'RECOMENDACIONES EN VIDEO':'VIDEO REVIEWS';?></strong></h4>
     	</div>
             
             
      <div class="col-12 col-sm-6 col-md-3 col-xl-3">
        <a href="https://www.youtube.com/watch?v=sUVaxTj9UI4" target="_blank">
          <div class="card">
            <div class="card-body">
              <div class="embed-responsive embed-responsive-16by9">
                <div class="embed-responsive-item">
                  <img src="https://incalake.com/img/video/sUVaxTj9UI4.webp" class="w-100 h-100">
                </div>
              </div>
            </div>
          </div>
          <p class="text-center">https://www.youtube.com/watch?v=sUVaxTj9UI4</p>
        </a>
      </div>
             
      <div class="col-12 col-sm-6 col-md-3 col-xl-3">
        <a href="https://www.youtube.com/watch?v=MuAQ4OaNhpQ" target="_blank">
          <div class="card">
            <div class="card-body">
              <div class="embed-responsive embed-responsive-16by9">
                <div class="embed-responsive-item">
                  <img src="https://incalake.com/img/video/MuAQ4OaNhpQ.webp" class="w-100 h-100">
                </div>
              </div>
            </div>
          </div>
          <p class="text-center">https://www.youtube.com/watch?v=MuAQ4OaNhpQ</p>
        </a>
      </div>
            
      <div class="col-12 col-sm-6 col-md-3 col-xl-3">
        <a href="https://www.youtube.com/watch?v=UuWqDJY5lXc" target="_blank">
          <div class="card">
            <div class="card-body">
              <div class="embed-responsive embed-responsive-16by9">
                <div class="embed-responsive-item">
                  <img src="https://incalake.com/img/video/UuWqDJY5lXc.webp" class="w-100 h-100">
                </div>
              </div>
            </div>
          </div>
          <p class="text-center">https://www.youtube.com/watch?v=UuWqDJY5lXc</p>
        </a>
      </div>
      
      <div class="col-12 col-sm-6 col-md-3 col-xl-3">
        <a href="https://www.youtube.com/watch?v=pOZDbv39fU0" target="_blank">
          <div class="card">
            <div class="card-body">
              <div class="embed-responsive embed-responsive-16by9">
                <div class="embed-responsive-item">
                  <img src="https://incalake.com/img/video/pOZDbv39fU0.webp" class="w-100 h-100">
                </div>
              </div>
            </div>
          </div>
          <p class="text-center">https://www.youtube.com/watch?v=pOZDbv39fU0</p>
        </a>
      </div>
      
      <div class="col-12 col-sm-6 col-md-3 col-xl-3">
        <a href="https://www.youtube.com/watch?v=uBNo5dcbnJg" target="_blank">
          <div class="card">
            <div class="card-body">
              <div class="embed-responsive embed-responsive-16by9">
                <div class="embed-responsive-item">
                  <img src="https://incalake.com/img/video/uBNo5dcbnJg.webp" class="w-100 h-100">
                </div>
              </div>
            </div>
          </div>
          <p class="text-center">https://www.youtube.com/watch?v=uBNo5dcbnJg</p>
        </a>
      </div>
      
      <div class="col-12 col-sm-6 col-md-3 col-xl-3">
        <a href="https://www.youtube.com/watch?v=GtmX98c0klg" target="_blank">
          <div class="card">
            <div class="card-body">
              <div class="embed-responsive embed-responsive-16by9">
                <div class="embed-responsive-item">
                  <img src="https://incalake.com/img/video/GtmX98c0klg.webp" class="w-100 h-100">
                </div>
              </div>
            </div>
          </div>
          <p class="text-center">https://www.youtube.com/watch?v=GtmX98c0klg</p>
        </a>
      </div>
            
      <div class="col-12 col-sm-6 col-md-3 col-xl-3">
        <a href="https://www.youtube.com/watch?v=wY2aFifqF-o" target="_blank">
          <div class="card">
            <div class="card-body">
              <div class="embed-responsive embed-responsive-16by9">
                <div class="embed-responsive-item">
                  <img src="https://incalake.com/img/video/wY2aFifqF-o.webp" class="w-100 h-100">
                </div>
              </div>
            </div>
          </div>
          <p class="text-center">https://www.youtube.com/watch?v=wY2aFifqF-o</p>
        </a>
      </div>
            
    </div>
	</div>
</div>
<!--/ recomendaciones en video -->
      


<!-- nuestras recomendaciones y calificaciones -->
<div class="row justify-content-center mb-3">
	<div class="col-11 col-sm-11 col-lg-10">
		<hr class="col-md-12">
    <div class="row">

      <div class="col-md-12 text-center div-title">
        <h4 class="div-content-title">
          <strong><?=(mb_strtolower(@$language)==="es"?"NUESTRAS RECOMENDACIONES Y CALIFICACIONES":"OUR RECOMMENDATIONS AND RATINGS")?></strong>
      	</h4>
      </div>

      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/reconocimientos-calificaciones/tripadvisor-2017.png" alt="tripadvisor" class="img-thumbnail" title="tripadvisor">
      </div>

			<div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/reconocimientos-calificaciones/ministerio-de-comercio-exterior-y-turismo.png" alt="Mincetur Perú" class="img-thumbnail" title="Mincetur Perú">
	    </div>
       
      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/reconocimientos-calificaciones/ltg-europe-2017-shortlisted.png" alt="shortlisted" class="img-thumbnail" title="shortlisted">
      </div>

      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/reconocimientos-calificaciones/viva-travel-guides.png" alt="viva travel guides" class="img-thumbnail" title="viva travel guides">
      </div>
      
      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/reconocimientos-calificaciones/lonely-planet.png" alt="lonely planet" class="img-thumbnail" title="lonely planet">
      </div>
      
      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/reconocimientos-calificaciones/rough-guides.png" alt="rough guides" class="img-thumbnail" title="rough guides">
      </div>
      
      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/reconocimientos-calificaciones/moon-travel-guides.png" alt="moon travel guides" class="img-thumbnail" title="moon travel guides">
      </div>
      
      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/reconocimientos-calificaciones/y-tu-que-planes.png" alt="y tu que planes" class="img-thumbnail" title="y tu que planes">
      </div>
      
      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/reconocimientos-calificaciones/lets-go.png" alt="lets go" class="img-thumbnail" title="lets go">
      </div>
      
      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/tripadvisor/tripadvisor-2016.png" alt="tripadvisor 2016" class="img-thumbnail" title="tripadvisor 2016">
      </div>
      
      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/tripadvisor/tripadvisor-2015.png" alt="tripadvisor 2015" class="img-thumbnail" title="tripadvisor 2015">
      </div>
      
      <div class="col-4 col-sm-3 col-md-3 col-xl-1 pt-1">
				<img src="https://incalake.com/img/tripadvisor/tripadvisor-2014.png" alt="tripadvisor 2014" class="img-thumbnail" title="tripadvisor 2014">
      </div>
    
   	</div>
	</div>
</div>
<!--/ nuestras recomendaciones y calificaciones -->



<!-- Ya no se muestra los feeds del blog por motivos de SEO -->
<?php 
if(false) 
{
?> 
  <div class="row justify-content-center div-posts-index pb-3" style="margin:0;"></div>
<?php 
} 
?>
      

<style>
    
	@media (min-width: 600px) {
	  .div-result-content-search{
      max-height: 450px;
      overflow: auto;
    }
	}

</style>



<script>

	// agregar href al number phone y href e target al email 
  if(detectPhone())
  {
    $('#llamar-telefono').attr('href', 'tel:+51984434731')
    $('#correo-abrir').attr('href', 'mailto:reservas@incalake.com?Subject=Hola/Hello, ')
    $('#correo-abrir').attr('target', '_top')
  }
    
</script>



<!-- Modal -->
<div class="modal fade " id="comentariosModal" tabindex="-1" role="dialog" aria-labelledby="comentariosModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body" style="padding: 0;">
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" src="" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
      <div class="btn btn-danger btn-sm fa fa-close btn-close-modal-comentarios" data-dismiss="modal" style="position: absolute;right: -4%;top: -4%;"></div>  
    </div>
  </div>
</div>