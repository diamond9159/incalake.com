<?php
$traduccion_body = arrayTraduccion('body',$language);
?>
      <div id="slider-index" class="carousel slide carousel-fade" data-ride="carousel">
      <?php if (!empty($slider_index)): ?>
        <ol class="carousel-indicators">
        <?php 
        $temp_carrusel_value='active';
        foreach ($slider_index  as $key => $value2): ?>
        <?php if (!empty($value2)): ?>
          <li data-target="#slider-index" data-slide-to="<?=$key;?>" class="<?=$temp_carrusel_value;?>"></li>
        <?php endif ?>
        <?php 
        $temp_carrusel_value='';
        endforeach ?>
        </ol>
        <div class="carousel-inner" style="
        ">
        <?php 
        $active_slider='active';
        foreach ($slider_index as $key => $value): ?>
        <?php if (!empty($value)&&$key<=3): ?>
          <div class="carousel-item <?=$active_slider?>">
            <img class="d-block w-100 img-slider" src="<?=$value['imagen'];?>" alt="First slide" >
            <div class="carousel-caption">
              <h3 class="title carousel tour"><a href="<?=$value['url'];?>"><?=$value['titulo'];?></a></h3>
              <p class="d-sm-none d-none d-md-block"><?=$value['descripcion'];?></p>
            </div>
            <div class="fondo-slider"></div>
          </div>
        <?php endif ?>
        <?php 
        $active_slider='';
        endforeach ?>
          
        </div>
        <?php endif ?>
        <div class="div-search">
          <div class="content-search">
            
          <div class="row justify-content-md-center " style="margin: 0;">
            <div class="col-md-6" style="background: #fff;padding: 0;">
            <div class="inputWithIcon inputIconBg" style="display: inline-flex;width: 100%;">
              <div class="input-group">
                <input type="text" id="input-search" class="form-control" placeholder="<?=($language=='es'?'Busca experiencias y lugares':'Look for experiences and places
      ');?>" aria-label="Search" aria-describedby="Search">
                <button type="button" class="btn btn-primary btn-search" data-toggle="modal" data-target="#searchGoogleModal2">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
              <div class="row div-result-search ">
                <div class="row col-12 div-result-content-default">
                  <div class="col-md-6 text-left">
                  <?php if (!empty($destinos_search)):
                    ?>                
                    <div>
                      <b><?=mb_strtolower($language) === 'es'?'Los Mejores Destinos':'The Best Destinations';?></b>
                    </div>
                    <ul>
                      <?php
                        foreach($destinos_search as $destino_search){
                          $ds_nombre = $destino_search['nombre'];
                          $ds_url    = $destino_search['url'];
                          echo "
                            <li><a href='$ds_url'>$ds_nombre</a> </li>
                          ";
                        }
                      ?>
                    </ul>
                    <?php endif ?>
                    <div>
                      <a href="<?=base_url().trim(mb_strtolower($language)).'/'.( mb_strtolower($language) === 'es'?'destinos':'destinations' ) ?>"><?=mb_strtolower($language) === 'es'?'Ver más Destinos':'View More Destinations';?> >></a>
                    </div>
                  </div>
                  <div class="col-md-6 text-left">
                  <?php if (!empty($actividades_search)): ?>
                    <div>
                      <b><?=mb_strtolower($language) === 'es'?'Las Mejores Actividades':'The Best Activities';?></b>
                    </div>
                    <ul>
                      <?php
                        foreach($actividades_search as $actividad_search){
                          $as_nombre = $actividad_search['nombre'];
                          $as_url    = $actividad_search['url'];
                          echo "
                            <li><a href='$as_url'>$as_nombre</a> </li>
                          ";
                        }
                      ?>                    
                    </ul>
                    <?php endif ?>
                    <!-- <div><a href="<?=base_url().trim(mb_strtolower($language)).'/'.( mb_strtolower($language) === 'es'?'destinos':'destiny' ) ?>">Ver más Actividades >></a></div> -->
                  </div>
                </div>
                <div id="fromList" class="row col-12 div-result-content-search">
      
                  <div id="coincidencias_locations" class="text-capitalize col-12">
                  </div>
      
                  <div id="coincidencias_activities" class="text-capitalize col-12">
                  </div>
      
                  <div id="solo-cuando-no-encuentra" class=" text-center col-12">
                  <div>
                    <?=($language=='es') ? "Sin Resultados "  : "Without Results"; ?>
                  </div>
                  <div class="btn btn-primary" onclick="abrirModalDeGoogle()">
                    
                  <?=($language=='es') ? "Búsqueda Avanzada"  : "Advanced search"; ?>
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

      <!--  -->
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
          <h4 class="text-center text-uppercase font-weight-bold"><?=($language=='es'?'¡Bienvenidos a agencia de viajes Incalake!':'Welcome to Incalake travel agency!')?> </h4>
          <p><?=($language=='es'?'<strong>Agencia de viajes incalake</strong>, somos operadores de turismo, especializados en viajes creativos y unicos en los paises de Perú y Bolivia, ofrecemos una experiencia unica en turismo convencional, aventura, mistica, rural, de lujo, y ecoturismo. Nuestra filosofia de servicio es cuidar desde el momento que legas hasta cuando decides salir de nuestro pais.':'<strong> Incalake Travel Agency </strong>, we are tour operators, specializing in creative and unique travel in the countries of Peru and Bolivia, we offer a unique experience in conventional tourism, adventure, mystic, rural, luxury, and ecotourism. Our philosophy of service is to take care of from the moment you leave until you decide to leave our country.')?>
          </p>
        </div>
        <div class="col-12 col-sm-3 col-md-3 ">
        <h6 class="text-center text-uppercase font-weight-bold"><?=$language=='es'?'Comentarios':'comments'?></h6>
          <!-- <div class=" fa fa-youtube-play btn btn-outline-danger btn-view-coments" data-toggle="modal" data-urlvideo="https://www.youtube.com/embed/UuWqDJY5lXc?rel=0" data-target="#comentariosModal">  </div> -->
          <div class="embed-responsive embed-responsive-16by9 content-coments">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/UuWqDJY5lXc?rel=0" frameborder="0" allowfullscreen></iframe>
            <div class="btn-view-coments" data-toggle="modal" data-urlvideo="https://www.youtube.com/embed/UuWqDJY5lXc?rel=0" data-target="#comentariosModal"></div>
          </div>
          </div>
          <!-- <div class="row image-tour">
          </div> -->
        </div>
      </div>
      
        <?php
      if (!empty($destinos)) {
        ?>
      <div class="row justify-content-center" style="margin:0;">
        <div class="col-11 col-sm-11 col-lg-10">
          <div class="row image-tour">
            <div class="col-md-12 text-center div-title"><h4 class="div-content-title">
                <strong><?=$traduccion_body['nuestros_destinos_y_actividades']?></strong></h4>
                <small>
                <code>
                  <?php 
                    //echo json_encode($destinos); 
                  ?>
                </code>
                </small>
            </div>

            <div class='col-md-12 div-destino'>
                <div class='div-full row'>
                  <?php foreach ($destinos as $key => $value): ?>
                      <div id="id-<?=$value['id_temp_destino'];?>" class="col-md-6 col-12 form-group">
                        <div class="row div-full card-destino">
                          <div class="col-md-6 div-full">
                              <div class="div-img">
                                  <a href="<?=$value['url_destino'];?>"><img class="img-activity" src="<?=$value['imagen_thumb'];?>" data-img="<?=$value['imagen_normal'];?>" width="100%" height="200px">
                                  </a>
                                  <figcaption>
                                      <span><?=$value['descripcion_destino'];?></span>
                                  </figcaption>
                              </div>
                          </div>
                          <div class="col-md-6 text-content-destino">
                            <div class="txt-div-destino">
                                <span><?=(strtolower($language)=='es'?'Actividades Recomendadas':'Recommended Activities');?></span>
                                <ul>
                                <?php if (count($value['actividades']) != 0 ): ?>
                                  <?php foreach ($value['actividades'] as $k => $val): ?>
                                    <?php if ( $key < 7 ): ?>
                                    <li>  
                                      <a href="<?=$val['url'];?>"><?=$val['titulo_actividad'];?></a>
                                    </li>
                                    <?php endif ?>
                                  <?php endforeach ?>
                                <?php else: ?>
                                <p><?=((strtolower($language))=='es'?'No tenemos destinos recomendados':'We have no recommended destinations');?></p>
                                <?php endif ?>  
                                </ul>
                            </div>

                          </div>
                        </div>
                      </div>
                  <?php endforeach ?>
                </div>
            </div>            
          </div>
        </div>
      </div>
      <?php
      }
      ?>
      
        <?php
          // echo json_encode($oferta);
          if(!empty($oferta)){
            ?>
        <hr>
        <div class="row justify-content-center" style="margin:0;">
      <div class="col-11 col-sm-11 col-lg-10">
        <div class="row">
        
          
            <div class="col-md-12 text-center div-title"><h4 class="div-content-title">
              <strong><?=$traduccion_body['nuestras_ofertas_del_mes']?></strong></h4>
            </div>
            <?php
          foreach ($oferta as $key => $value) {
            if ($key<=2) {        
          ?>
          
          <div class="col-12 col-sm-6 col-md-3 col-xl-3">
            <div class="targeta">
              <div class="thumbnail"> 
                <a href="<?=$value['url']; ?>"><img src="<?=$value['imagen']; ?>"></a>
                <span class="categoria"><?=mb_strtolower($value['categoria']); ?></span>
                <span class="descuento">-<?=$value['oferta']; ?></span>
              </div>
              <div class="contenido">
                <div class="titulo">
                  <a href="<?=$value['url']; ?>"><?=mb_strtoupper($value['actividad']); ?></a>
                </div>
                <div class="duracion">
                <?php if (!empty($value['duracion'][0])) {
                 ?>
                  <i class="fa fa-clock-o"></i> <span><?=mb_strtolower($value['duracion'][0]); ?></span>
                  <br><i class="fa fa-clock-o"></i> <span><?=$value['horarios']; ?></span>
                  <?php } ?>
                </div>
                <div class="fecha">
                  <!--<i class="fa fa-calendar"></i> <span>Hasta 12-septiembre-2017</span>-->
                </div>
              </div>
              <div class="extra">
                <div class="precio">
                  <span class="txt-precio-desde"><?=$value['txt_precio']; ?></span>
                  <span class="oferta">$<?=$value['precio_oferta']; ?></span>
                  <span class="normal">$<?=$value['precio_normal']; ?></span>
                </div>
                <div class="explorar">
                  <a href="<?=$value['url']; ?>"><?=$value['txt_more_info']; ?>>></a>
                </div>
              </div>
            </div>
          </div>
          
          <?php
          }elseif($key==3&&count($value)>3){
            ?>
            <div class="col-12 col-sm-6 col-md-3 col-xl-3">
              <div class="targeta targeta-ver-ofertas">
                <div class="thumbnail"> 
                  <a href="<?=$value['url']; ?>"><img src="<?=$value['imagen']; ?>"></a>
                  <span class="categoria"><?=mb_strtolower($value['categoria']); ?></span>
                  <span class="descuento">-<?=$value['oferta']; ?></span>
                </div>
                <div class="contenido">
                  <div class="titulo">
                    <a href="<?=$value['url']; ?>"><?=mb_strtoupper($value['actividad']); ?></a>
                  </div>
                  <div class="duracion">
                  <?php if (!empty($value['duracion'][0])) {
                   ?>
                    <i class="fa fa-clock-o"></i> <span><?=mb_strtolower($value['duracion'][0]); ?></span>
                    <br><i class="fa fa-clock-o"></i> <span><?=$value['horarios']; ?></span>
                    <?php } ?>
                  </div>
                  <div class="fecha">
                    <!-- <i class="fa fa-calendar"></i> <span>Hasta 12-septiembre-2017</span> -->
                  </div>
                </div>
                <div class="extra">
                  <div class="precio">
                    <span class="txt-precio-desde"><?=$value['txt_precio']; ?></span>
                    <span class="oferta">$<?=$value['precio_oferta']; ?></span>
                    <span class="normal">$<?=$value['precio_normal']; ?></span>
                  </div>
                  <div class="explorar">
                    <a href="<?=$value['url']; ?>"><?=$value['txt_more_info']; ?>>></a>
                  </div>
                </div>
                <div class="div-content-ofertas" >
                  <div class="div-count-ofertas"><span class="num"><?=count($oferta); ?></span> <br> <?=$txt_ofertas;?> <br><?=$txt_disponibles;?></div>
                  <div class="div_ver_ofertas"><a href="<?=$url_mas_ofertas;?>"><span><?=$txt_ver_mas_ofertas;?></span></a></div>
                </div>
              </div>
            </div>
      
            <?php
            }
          }
          ?>
          <?php
          ?>
          
      
          <?php
      
          ?>
          
          
        </div>
      </div>
        </div>
        <hr>
        <?php
          }
          ?>
      <div class="row justify-content-center" style="margin: 2% 0;">
        <div class="col-11 col-sm-11 col-lg-10 row" style="margin: 0;">
        <div class="col-12 col-sm col-md">
          <h5 class="text-center text-uppercase font-weight-bold"><?=($language=='es'?'nuestros reconocimientos':'our acknowledgments')?> </h5>
          <div class="row justify-content-center">
            <picture class="col-6 col-sm col-md div-tooltip" data-toggle="tooltip" data-html="true" title="<?=($language=='es'?'Reconocimiento a la aplicación de buenas prácticas de gestión de servicios para <b> agencias de viaje y turismo 2017</b>.':'Recognition of the application of good service management practices for <b> travel and tourism agencies 2017 </ b>.')?> ">
            <source media="(max-width: 768px)" srcset="//incalake.com/img/small-banner-mincetur.png"> <img src="//incalake.com/img/banner-mincetur.png" class="img-responsive img-thumbnail" title="<?=($language=='es'?'Reconocimiento a la aplicación de buenas prácticas de gestión de servicios para <b> agencias de viaje y turismo 2017</b>.':'Recognition of the application of good service management practices for <b> travel and tourism agencies 2017 </ b>.')?>">
            </picture>
            <picture class="col-6 col-sm col-md div-tooltip" data-toggle="tooltip" data-html="true" title="<?=($language=='es'?'Nominado a mejor operador local por la revista<b> LTG 2017</b>.':'Nominated for best local operator by the <b> LTG 2017 </ b> magazine.')?>">
            <source media="(max-width: 768px)" srcset="//incalake.com/img/small-banner-shortlisted.png"> <img src="//incalake.com/img/medium-banner-shortlisted.png" class="img-responsive img-thumbnail" title="<?=($language=='es'?'Nominado a mejor operador local por la revista<b> LTG 2017</b>.':'Nominated for best local operator by the <b> LTG 2017 </ b> magazine.')?>" alt="<?=($language=='es'?'Nominado a mejor operador local por la revista<b> LTG 2017</b>.':'Nominated for best local operator by the <b> LTG 2017 </ b> magazine.')?>">                                    

            </picture>
          </div>
        </div>
        <div class="col-12 col-sm col-md">
          <h5 class="text-center text-uppercase font-weight-bold"><?=($language=='es'?'recomendados por':'recommended by')?> </h5>
          <div class="row" style="margin:0;">
                <div class="col-4 col-sm-4 col-md"> <img src="//incalake.com/img/recomendados/y-tu-que-planes.png" class="img-responsive img-thumbnail div-tooltip" data-toggle="tooltip" data-html="true" title="y tu que planes" alt="y tu que planes">                    </div>
                <div class="col-4 col-sm-4 col-md"> <img src="//incalake.com/img/recomendados/viva-travel-guides.png" class="img-responsive img-thumbnail div-tooltip" data-toggle="tooltip" data-html="true" title="viva travel guides" alt="viva travel guides">                    </div>
                <div class="col-4 col-sm-4 col-md"> <img src="//incalake.com/img/recomendados/moon-travel-guides.png" class="img-responsive img-thumbnail div-tooltip" data-toggle="tooltip" data-html="true" title="moon travel guides" alt="moon travel guides">                    </div>
                <div class="col-4 col-sm-4 col-md"> <img src="//incalake.com/img/recomendados/lets-go.png" class="img-responsive img-thumbnail div-tooltip" data-toggle="tooltip" data-html="true" title="let's go" alt="let's go"> </div>
                <div class="col-4 col-sm-4 col-md">
                <img src="//incalake.com/img/recomendados/rough-guides.png" class="img-responsive img-thumbnail div-tooltip" data-toggle="tooltip" data-html="true" title="rough guides" alt="rough guides"> </div>
                <div class="col-4 col-sm-4 col-md"> <img src="//incalake.com/img/recomendados/lonely-planet.png" class="img-responsive img-thumbnail div-tooltip" data-toggle="tooltip" data-html="true" title="lonely planet" alt="lonely planet"> </div>
            </div>
        </div>
        </div>
      </div>
      
      
<style>
.carousel-caption .title a{color:#fff;text-transform:capitalize;font-weight:700}.fondo-slider{position:absolute;height:100%;top:0;background:#00000012;width:100%;box-shadow:inset 0 -1px 20px 1px #000}#slider-index{min-height:150px}#slider-index .carousel-item{padding:0;height:400px;overflow:hidden;-webkit-transition-property:opacity;transition-property:opacity}#slider-index .carousel-inner .carousel-item,#slider-index .carousel-inner .carousel-item.active.left,#slider-index .carousel-inner .carousel-item.active.right{opacity:1}#slider-index .carousel-item.active{opacity:1}#slider-index .img-slider{width:100%;height:auto;opacity:1;position:absolute;left:-100%;right:-100%;top:-100%;bottom:-100%;margin:auto;min-height:100%;min-width:100%}.carousel-indicators{z-index:1}.carousel-caption{top:20px;bottom:0}#slider-index .carousel-item .carousel-caption{opacity:0;transition:opacity 1.5s ease-in-out}#slider-index .carousel-item.active .carousel-caption{opacity:1}@media (max-width: 600px){#slider-index .carousel-item{height:200px}#slider-index .carousel-caption{top:20px;bottom:0;top:auto;width:100%;padding:1%;right:0;left:0;background:rgba(43,153,47,0.62)}#slider-index .title.carousel.tour{font-size:14px;margin:0}}.div-description-porque-elegirnos{color:#fff}.div-description-porque-elegirnos>:first-child{padding:10px;background:#2b992f}.div-porque-elegirnos{background:#0667ac;margin:0;padding:0}.div-porque-elegirnos .item-porque-elegirnos{padding:0}.div-porque-elegirnos .item-porque-elegirnos>a{width:100%!important;color:#fff!important}.div-porque-elegirnos .item-porque-elegirnos>a:hover{background:#1a4c80;border:none}.div-porque-elegirnos .item-porque-elegirnos>a.active{background:#1a4c80;border:none}.div-txt-porque-elegirnos{display:flex!important;align-items:center!important}.div-porque-elegirnos .txt-porque-elegirnos:nth-child(n+2){margin-left:2%}.inputWithIcon{position:relative}.inputWithIcon span{height:100%;position:absolute}.inputWithIcon input[type=text]:focus + span{color:#1e90ff}.inputWithIcon.inputIconBg span{background-color:#2cae4a;color:#fff;padding:9px 7px;right:0}.inputWithIcon.inputIconBg input[type=text]:focus + span{color:#fff;background-color:#1e90ff}.div-search{position:absolute;top:55%;width:100%;text-align:center;z-index:1}@media (max-width: 768px){.div-search{position:relative}}.div-title .div-content-title{margin:2% 0}.image-tour .div-img{position:relative;background:rgba(0,0,0,0.16);height:200px}.image-tour figcaption{position:absolute;text-align:right;color:#e5e5e5;line-height:16px;font-weight:700;transition:.2s;text-align:left;text-transform:capitalize;bottom:0;left:0;padding:1%;background:#bd00ff;margin-bottom:2%;margin-left:2%}.image-tour figcaption hr{border:none;border-bottom:1px solid #c9c9c9;margin-top:10px;margin-right:0;width:100%}.image-tour figcaption strong{font-size:16px}.image-tour figcaption small{font-size:19px;letter-spacing:1px}.image-tour figcaption div a{border:1px solid #f5f5f5;width:170px;padding:5px 20px;color:#fff;font-weight:700;font-size:13px}.div-full{width:100%!important;padding:0!important;margin:0!important}.div-destino{margin-bottom:1%;padding:0!important}.card-destino{background:#fff;box-shadow:0 0 5px 0 rgba(0,0,0,0.5);position:relative}.card-destino ul{padding-left:15px;list-style-type:square;color:#039BE5}.card-destino ul li a{color:#000;text-transform:capitalize}.card-destino ul li a:hover{color:#007bff}.text-content-destino{font-size:15px;padding:5px}.txt-div-destino>span{font-weight:700}.div-result-search{padding:0!important;margin:0!important;border-right:solid 1px #ddd;border-left:solid 1px #ddd;border-bottom:solid 1px #ddd}.div-result-search .div-result-content-default{margin:0;padding:1.5% 0;display:none}.div-result-search .div-result-content-search{margin:0;padding:1.5% 0;display:none}.div-result-search .div-result-content-search #coincidencias_locations,.div-result-search .div-result-content-search #coincidencias_activities{padding:0}.div-result-search .div-txt-search-destiny,.div-result-search .div-txt-search-activity{border-bottom:solid 1px #ddd;padding-top:.5%;padding-bottom:.5%}.div-result-search .div-destiny-search{background:#4bb436;color:#f5f5f5}.div-result-search .div-activity-search{background:#4bb436;color:#f5f5f5}.div-result-search ul{list-style-type:none;padding:0}.div-result-search ul li a{color:#000;text-transform:capitalize}.div-result-search ul li:hover a{color:#007bff}.div-result-search #solo-cuando-no-encuentra{display:none}</style> <style>
/*OFERTAS*/
.div-content-ofertas{position:absolute;height:100%;width:100%;top:0;background:rgba(21,155,27,0.81)}.div-count-ofertas{position:absolute;width:100%;text-align:center;right:0;font-size:2rem;color:#fff}.div-count-ofertas .num{font-size:3rem;font-weight:700}.div_ver_ofertas{position:absolute;bottom:21%;width:100%;text-align:center;right:0;font-size:1rem;font-weight:700;color:#fff}.div_ver_ofertas a{color:#fff}.div_ver_ofertas span{border:solid 1px #fff;padding:3%;cursor:pointer}.div_ver_ofertas span:hover{background:#28a22d}.color-text-10{color:#fff!important}            
  </style>
      <script>
        //console.log("sssss");
        const loc_act = JSON.parse(`<?=json_encode($search)?>`);
        // console.log(loc_act);
        const language = JSON.parse('<?=json_encode($language)?>');
        const destinos = JSON.parse(`<?=json_encode($destinos)?>`);
        // console.log(destinos);
        var locations = [];
        var activities = [];
        // Abrir div donde se muestrar resultados
        function abrir_div_resultados(){
    //   console.log('pff');
      if(!!locations.length || !!activities.length){
        mostrar_filtrados();
      }else if(document.getElementById('input-search').value.trim().length>0){
        let tmp_html = `
          <!--<div>
            No se encontraron resultados
          </div>-->
          <button type="button" class="btn btn-primary" onclick="abrirModalDeGoogle()">
            Buscar "${document.getElementById('input-search').value.trim()}" en google
          </button>
        `;
        
        // $('#div-result-search').show();
        // document.getElementById('solo-cuando-no-encuentra').innerHTML = tmp_html;
        $('.div-result-content-default').css('display','none');
        $('.div-result-content-search').css('display','inline-flex');
      }else{
        $('.div-result-content-default').css('display','inline-flex');
        $('.div-result-content-search').css('display','none');
      }
        }
        // Cuando hace keyup mostramos coincidencias, si hay caracteres
        function mostrar_filtrados(){
      let text = $("#input-search").val()?$("#input-search").val():'';
      text = text.trim().toLowerCase();
      if(text==''){
        $('.div-result-content-default').css('display','inline-flex');
        $('.div-result-content-search').css('display','none');
        return;
      }
      
      locations  = loc_act.location.filter(function(location){
        return location.descripcion.toLowerCase().indexOf(text) != -1;
      }).sort(function(a,b){
        if (a.count < b.count ) {
          return 1;
        }
        if (a.count > b.count) {
          return -1;
        }
        return 0;
      });
      var temp_a=[];
      var temp_b=[];
      activities = loc_act.activity.filter(function(activity){
        return activity.descripcion.toLowerCase().indexOf(text) != -1;
      }).sort(function (a, b) {
        temp_a=a.duracion.split("!");
        temp_b=b.duracion.split("!");
        console.log(temp_a[1]);
        if (temp_a[1]+temp_a[0] > temp_b[1]+temp_b[0] ) {
          return 1;
        }
        if (temp_a[1]+temp_a[0] < temp_b[1]+temp_b[0]) {
          return -1;
        }
        return 0;
      });
      
      console.log('Locations:',locations);
      console.log('Activities:',activities);
      
      text_locations = '';
      text_activities = '';
      var lenguaje="<?=$language;?>"
      lenguaje=='es'?temp_actividades='actividad':temp_actividades='activity';
      locations.forEach(function(location){
        text_locations = text_locations + `
          <div class="col-md-12 text-left div-txt-search-destiny">
           <a style="width:100%; display:inline-block;" href="${location.url}" ><b>${location.descripcion}
            </b><b class="float-right text-dark">${location.count} 
 ${location.count>1?(lenguaje=='es'?temp_actividades+'es':temp_actividades.substring(0,7)+'ies'):(temp_actividades)}</b></a>
          </div>
        `;
      });
      var array_duraciones=[];
      if ("<?=$language;?>"=="es") {
        array_duraciones = ['minuto','hora','dia'];
      }else{
        array_duraciones = ['minute','hour','day']
      }

      activities.forEach(function(activity){
        var duracion = ' -- ';
        if(activity.duracion){
            duracion = activity.duracion.split('!');
            duracion[1] = array_duraciones[duracion[1]];
            duracion = duracion[0] +' '+duracion[1]+ (parseInt(duracion[0])>1?'s':'');
        }
        
        
        text_activities = text_activities + `
          <div class="col-md-12 text-left div-txt-search-activity">
            <b><a href="${activity.url}">${activity.descripcion}
            </a></b><b class="pull-right">${duracion}</b>
          </div>
        `;
      });
      
      if(!!locations.length) {
        text_locations = `
          <div class="col-md-12 div-destiny-search text-left">
          <b>${language=='es'?'Destinos Populares':'Popular Destinations'}
          <span class="float-right">${language=='es'?'#Actividades':'#Activities'}</span></b>
          </div>
        ` + text_locations;
      }
      
      if(!!activities.length) {
        text_activities = `
          <div class="col-md-12 div-activity-search text-left">
            <b>${language=='es'?'Recorridos y actividades':'Tours and Activities'}
            <span class="pull-right">${language=='es'?'Duraci&oacute;n':'Duration'}</span></b>
          </div>
        ` + text_activities;
      }
      
      let tmp_html = '';
      if(!locations.length && !activities.length){
        
        tmp_html = `
          <!--<div>
            No se encontraron resultados
          </div>-->
          <button type="button" class="btn btn-primary" onclick="abrirModalDeGoogle()">
            Buscar "${document.getElementById('input-search').value.trim()}" 
          </button>
        `;
        
      }
      
      
      $('#coincidencias_locations').html(text_locations);
      $('#coincidencias_activities').html(text_activities);
      // $('#solo-cuando-no-encuentra').html(tmp_html);
      if (text_activities.length==0&&text_locations.length==0&&document.getElementById('input-search').value.trim().length>0) {
        console.log('asds');
        $('#solo-cuando-no-encuentra').css('display', 'block');
      }else{
        $('#solo-cuando-no-encuentra').css('display', 'none');
      }
      
      $('.div-result-content-default').css('display','none');
      $('.div-result-content-search').css('display','inline-flex');
        }
      
        function abrirModalDeGoogle(){
      
      $("#input_lol").val($("#input-search").val());
          $('.btn-search').click();//Trigger search button click event
        }
      $(document).on('keyup',"#input-search",mostrar_filtrados);
      // $('').click(abrir_div_resultados);
      $(document).on('keyup', '#input-search', function(event) {
        var code = event.which;
        $("#input_lol").val($("#input-search").val());
        if(code==13){
            //holaaaaaaaaa
          $('.btn-search').click();//Trigger search button click event
          //$("#searchGoogleModal2").modal();
        }
      });
      
      
      
        var focus = false;
      $("#input-search,.div-result-search").mouseenter(function() {
        focus = true;
      }).mouseleave(function() {
        focus = false;
      });
        $(document).on('click', 'html', function(event) {
      if (!focus) {
          $('.div-result-content-default').css('display','none');
          $('.div-result-content-search').css('display','none');
        }
        });
        $(document).on('click', '#input-search', function(event) {
      abrir_div_resultados();
        });
        // modal comentarios
        $(document).ready(function($) {
          $('#comentariosModal').on('hidden.bs.modal', function (e) {
            $('#comentariosModal .embed-responsive-item').attr('src', '');
          })
          $('#comentariosModal').on('show.bs.modal', function (e) {
           $('#comentariosModal .embed-responsive-item').attr('src', $('.btn-view-coments').data("urlvideo"));
          })
        });
$('#slider-index').carousel({
  interval: 6000,
  pause:'hover'
});
  
      </script>
<script type="text/javascript">
  window.addEventListener('load', function() {
  //console.log('All assets are loaded');
  for (var i = 0; i < destinos.length; i++) {
    $("#id-"+destinos[i].id_temp_destino).find(".img-activity").attr('src', $("#id-"+destinos[i].id_temp_destino).find(".img-activity").data('img'));
  }
}); 
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