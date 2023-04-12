<?php
  //echo json_encode($resultado);
  //$this->load->view('php/mobile-detect/Mobile_Detect');
$traduccion_body = arrayTraduccion('body',$language);
  $detect = new Mobile_Detect;
  if ($detect->isMobile()) {
     
  ?>



  <style>
.navbar-light .navbar-brand {
    color: rgba(255, 255, 255, 0.9);
}

.navbar-light .navbar-nav .active>.nav-link,
.navbar-light .navbar-nav .nav-link.active,
.navbar-light .navbar-nav .nav-link.show,
.navbar-light .navbar-nav .show>.nav-link {
    color: rgba(255, 255, 255, 0.9);
}

.navbar-light .navbar-nav .nav-link {
    color: rgba(255, 255, 255, 0.9);
}

.navbar-light .navbar-nav .nav-link:focus,
.navbar-light .navbar-nav .nav-link:hover {
    color: rgba(255, 255, 255, 0.99);
}

/*a.nav-item.nav-link.active{
border-top: 3px solid orange;
}*/
.tab-pane.fade.active.show,
.tab-pane.fade.show.active,
.tab-pane.fade{
    margin-top: 1em;
}

.la_galeria{
    height: 300px; 
    background: #000
}

@media(max-width:768px){
*{
/*border: 1px solid black;*/
}
  .container{
      padding-right: 0px;
      padding-left: 0px;
  }
  div.content-content{
      margin-top: 0px;
  }
}

.sky-tabs{
    margin: 2% 0px;
}

.div-activity .div-sky-tabs{
    border: solid 1px #e5e5e5;
}

.div-iten-tab{
    border-top: solid;
    border-left: solid;
    border-right: solid;
    border-width: 1px;
    border-color: #e5e5e5;
}

.sky-tabs > input:checked + .div-iten-tab{
    border-bottom: solid 1px #fff;
    margin-bottom: -1px;
}

.div-sky-tabs p{
    text-align: justify;
}

.div-sky-tabs li ul{
    margin-left: 20px;
}

.div-iten-tab-content{
    display: inline-flex !important;
}  


  </style>


  <!--
  <div style="background-color:#1e6496" >
    <div class="container">
      <nav class="navbar navbar-expand-md navbar-light bg-light" style="background-color:#1e6496 !important">
        <a class="navbar-brand" href="#"><img src="http://incalake.com/img/logo-white.png" style="height:1.75em" alt=""></a>
        <span style="float:right;position:relative;" class="d-block d-sm-block d-md-none" >
          <i style="font-size:1.5em;color:white;" class="fa fa-shopping-cart"></i>
          <span class="badge badge-pill badge-danger" style="position:absolute;right:-1.5em;top:-0.2em">0</span>
        </span>
        <span style="float:right;position:relative;" class="d-block d-sm-block d-md-none" >
          <i style="font-size:1.5em;color:white;" class="fa fa-search"></i>
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarp" aria-controls="navbarp" aria-expanded="false"
          aria-label="Toggle navigation">
            <i class="fa fa-bars" style="color:white"></i>
          </button>

        <div class="collapse navbar-collapse" id="navbarp">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Incalake</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                    Destinos
                  </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Puno</a>
                <a class="dropdown-item" href="#">Cusco</a>
                <a class="dropdown-item" href="#">Bolivia</a>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item d-none d-sm-none d-md-block" style="position:relative;margin-right:1em;">
              <a class="nav-link" href="#">
                <i class="fa fa-shopping-cart" style="font-size:1.5em;" aria-hidden="true"></i>
                <span class="badge badge-pill badge-danger" style="position:absolute;right:0;top:0">2</span>
              </a>
            </li>
            <li  class="nav-item d-none d-sm-none d-md-block" style="position:relative;margin-right:1em;">
              <a class="nav-link" href="#">
                <i class="fa fa-search" style="font-size:1.5em;" aria-hidden="true"></i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdownMenuLanguages" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="pe flag"></i> ES
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLanguages">
                <a class="dropdown-item" href="#"><i class="es flag"></i> ES</a>
                <a class="dropdown-item" href="#"><i class="us flag"></i> US</a>
                <a class="dropdown-item" href="#"><i class="fr flag"></i> FR</a>
                <a class="dropdown-item" href="#"><i class="br flag"></i> BR</a>
                <a class="dropdown-item" href="#"><i class="it flag"></i> IT</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  -->

  <!--
  <div style='position:relative'>
    <div>
      <img src='https://placekitten.com/g/500/400' style='width: 100%;'>
    </div>
    <div style='padding: 5px 10px;'>
      <div style='font-size: 26px;line-height: 26px;'>
        Inca jungle trek a machu picchu 4 dias y 3 noches
      </div>
      <div style='font-size: 20px;color: #565656;'>
        Viaja aqui!
      </div>
    </div>
    <div id='accordion' role='tablist'>
      <div class='card'>
        <div class='card-header' role='tab'>
          <h5 class='mb-0'>
            <a class='collapsed' data-toggle='collapse' href='#collapseTwo' aria-expanded='false' aria-controls='collapseTwo'>
              Leer mas 
            </a>
          </h5>
        </div>
        <div id='collapseTwo' class='collapse' role='tabpanel'  data-parent='#accordion'>
          <div class='card-body'>
            lorem
          </div>
        </div>
      </div>
    </div>
  </div>
  -->

  <div class="container"  id='app'>
    <div class="row" style="margin:0">
      <div class="col-12" style="padding-right:0px;padding-left:0px">

        <?php
        foreach($resultado['actividades'] as $index => $actividad){
          $a_id_actividad=$actividad['id_producto'];
          $a_titulo = $actividad['titulo_producto'];
          $a_subtitulo = $actividad['subtitulo_producto'];
          $a_descripcion = $actividad['descripcion_tab'];
          $a_itinerario = $actividad['itinerario_ta'];
          $a_incluye = $actividad['incluye_tab'];
          $a_informacion = $actividad['informacion_tab'];
          $a_mapa = $actividad['mapa_tab'];
          $a_recomendacion = $actividad['recomendacion_tab'];
          $a_sal_ret = $actividad['salida_retorno_tab'];

          $galeria_html = "";
            foreach($actividad['galeria'] as $galeria){
              $url_final = $galeria['url_final'];
              $galeria_html = $galeria_html."
                <img src='$url_final' data-title='First' data-description='My description'>  
              ";
            }
          
            if($a_mapa){
              $a_mapa = "
                <div id='mapa-$index' style='height:500px'></div>
                <map-incalake id_map='mapa-$index' tmp='".$a_mapa."'></map-incalake>
              ";
            }

          

          $tabs_adicionales_html = "";
          foreach($actividad['tabs_adicionales'] as $tabb){
            $nombre_tab = $tabb['nombre_tab'];
            $contenido_tab = $tabb['contenido_tab'];
            
            $tabs_adicionales_html = $tabs_adicionales_html."<div>".$nombre_tab."</div>".$contenido_tab;
          }

        echo "
          <div style='position:relative;margin-bottom:15px;background-color:white !important;'>
            <div class='galleria la_galeria'>
              $galeria_html
            </div>
            <div style='padding: 5px 10px;'>
              <div style='font-size: 26px;line-height: 26px;'>
                Inca jungle trek a machu picchu 4 dias y 3 noches
              </div>
              <div style='font-size: 20px;color: #565656;'>
                Viaja aqui!
              </div>
            </div>
            <div id='accordion-$index' role='tablist'>
              <div class='card'>
                
                <a data-toggle='collapse' data-parent='#accordion' href='#collapseTwo-$index' aria-expanded='true' aria-controls='collapseTwo-$index' style='text-decoration: none !important;' class=''>
                        <div class='card-header bg-primary' role='tab' id='headingOne'>
                            <h5 class='mb-0 text-light'>
                              <strong>
                              <span class='fa fa-credit-card'></span> Leer Más >></strong>
                            </h5>
                        </div>
                    </a>

                <div id='collapseTwo-$index' class='collapse' role='tabpanel'  data-parent='#accordion-$index'>
                  <div class='card-body'>
                    <div class='col-12'>
                      ";
                        echo $a_descripcion;
                        echo $a_descripcion?'<hr>':'';

                        echo $a_itinerario;
                        echo $a_itinerario?'<hr>':'';

                        echo $a_incluye;
                        echo $a_incluye?'<hr>':'';

                        echo $a_informacion;
                        echo $a_informacion?'<hr>':'';

                        echo $a_mapa;
                        echo $a_mapa?'<hr>':'';

                        echo $a_recomendacion;
                        echo $a_recomendacion?'<hr>':'';

                        echo $a_sal_ret;
                        echo $a_sal_ret?'<hr>':'';

                        echo $tabs_adicionales_html;
                    echo "</div>
                    <div class='row'>

                      <precio-producto :id_producto='$a_id_actividad'></precio-producto>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";
        }
        ?>        

      </div>

      <div class="col-12" style="margin-top: 40px;">
        <div style="position: sticky;top:10px">

          <div class="content-content" style="border-top:2px solid #007bff">
            <h5><?=$traduccion_body['necesitas_ayuda'];?></h5>
            <ul class="list-inline" style="font-size:1.1em; margin-left: 0px;">
              <li><i class="fa fa-whatsapp text-success"></i> <i class="fa fa-phone"></i> 51949755305</li>
              <li><i class="fa fa-whatsapp text-success"></i> <i class="fa fa-phone"></i> 51982769453</li>
              <li><i class="fa fa-whatsapp text-success"></i> <i class="fa fa-phone"></i> 51984434731</li>
              <li><i class="fa fa-envelope"></i> reservas@incalake.com</li>
            </ul>
          </div>

          <div class="content-content" style="border-top:2px solid #007bff">
            <h5><?=$traduccion_body['reserva_con_ayuda'];?></h5>
            <hr>
            <p>
              <?=$traduccion_body['reserva_con_ayuda_descrip'];?>
            </p>
            <button type="button" class="btn btn-primary" data-toggle="modal" style="cursor:pointer" data-target="#preguntasModal">
        <?=$traduccion_body['consultar'];?>
      </button>
           
          </div>

        </div>
      </div>
    </div>
  </div>
</div>


<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  end mobile - - - - - - - - - - - - - - - -->
  <?php

  }else{
  ?>







<style>
.navbar-light .navbar-brand {
    color: rgba(255, 255, 255, 0.9);
}

.navbar-light .navbar-nav .active>.nav-link,
.navbar-light .navbar-nav .nav-link.active,
.navbar-light .navbar-nav .nav-link.show,
.navbar-light .navbar-nav .show>.nav-link {
    color: rgba(255, 255, 255, 0.9);
}

.navbar-light .navbar-nav .nav-link {
    color: rgba(255, 255, 255, 0.9);
}

.navbar-light .navbar-nav .nav-link:focus,
.navbar-light .navbar-nav .nav-link:hover {
    color: rgba(255, 255, 255, 0.99);
}

/*a.nav-item.nav-link.active{
border-top: 3px solid orange;
}*/
.tab-pane.fade.active.show,
.tab-pane.fade.show.active,
.tab-pane.fade{
    margin-top: 1em;
}

.la_galeria{
    height: 400px; 
    background: #000
}

@media(max-width:768px){
*{
/*border: 1px solid black;*/
}
  .container{
      padding-right: 0px;
      padding-left: 0px;
  }
  div.content-content{
      margin-top: 0px;
  }
}

.sky-tabs{
    margin: 2% 0px;
}

.div-activity .div-sky-tabs{
    border: solid 1px #e5e5e5;
}

.div-iten-tab{
    border-top: solid;
    border-left: solid;
    border-right: solid;
    border-width: 1px;
    border-color: #e5e5e5;
}

.sky-tabs > input:checked + .div-iten-tab{
    border-bottom: solid 1px #fff;
    margin-bottom: -1px;
}

.div-sky-tabs p{
    text-align: justify;
}

.div-sky-tabs li ul{
    margin-left: 20px;
}

.div-iten-tab-content{
    display: inline-flex !important;
}  


  </style>

  <!--
  <div style="background-color:#1e6496" >
    <div class="container">
      <nav class="navbar navbar-expand-md navbar-light bg-light" style="background-color:#1e6496 !important">
        <a class="navbar-brand" href="#"><img src="http://incalake.com/img/logo-white.png" style="height:1.75em" alt=""></a>
        <span style="float:right;position:relative;" class="d-block d-sm-block d-md-none" >
          <i style="font-size:1.5em;color:white;" class="fa fa-shopping-cart"></i>
          <span class="badge badge-pill badge-danger" style="position:absolute;right:-1.5em;top:-0.2em">0</span>
        </span>
        <span style="float:right;position:relative;" class="d-block d-sm-block d-md-none" >
          <i style="font-size:1.5em;color:white;" class="fa fa-search"></i>
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarp" aria-controls="navbarp" aria-expanded="false"
          aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

        <div class="collapse navbar-collapse" id="navbarp">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Incalake</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                    Destinos
                  </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Puno</a>
                <a class="dropdown-item" href="#">Cusco</a>
                <a class="dropdown-item" href="#">Bolivia</a>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item d-none d-sm-none d-md-block" style="position:relative;margin-right:1em;">
              <a class="nav-link" href="#">
                <i class="fa fa-search" style="font-size:1.5em;" aria-hidden="true"></i>
              </a>
            </li>
            <li class="nav-item d-none d-sm-none d-md-block" style="position:relative;margin-right:1em;">
              <a class="nav-link" href="#">
                <i class="fa fa-shopping-cart" style="font-size:1.5em;" aria-hidden="true"></i>
                <span class="badge badge-pill badge-danger" style="position:absolute;right:0;top:0">2</span>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdownMenuLanguages" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="pe flag"></i> ES
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLanguages">
                <a class="dropdown-item" href="#"><i class="es flag"></i> ES</a>
                <a class="dropdown-item" href="#"><i class="us flag"></i> US</a>
                <a class="dropdown-item" href="#"><i class="fr flag"></i> FR</a>
                <a class="dropdown-item" href="#"><i class="br flag"></i> BR</a>
                <a class="dropdown-item" href="#"><i class="it flag"></i> IT</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  -->

  <div class="container-fluid d-none d-sm-none d-md-block" style="padding:0px" >

    <div class="row" style="margin: 0;position: relative;">
      <div class="col-12" style="padding: 0;height: 350px;overflow: hidden;">
        <img src="<?=$resultado['actual']['slider_img']?>" class="img-fluid" alt="Responsive image" style="width: 100%;
        height: auto;
        opacity: 1;
    position: absolute;
    left: -100%;
    right: -100%;
    top: -100%;
    bottom: -100%;
    margin: auto;
    min-height: 100%;
    min-width: 100%;">
      </div>
      <div style="position: absolute;
      left: 0;
      top: 0;
      background-color:rgba(0,0,0,0.2);
      width: 100%;
      height:100%">
      </div>
      <div style="position: absolute;
      left: 0;
      top: 45%;
      width: 100%;
      text-align: center;
      color:white;
      text-shadow: 0px 1px black;
      font-size: 2.5em;">
      <?=$resultado['actual']['titulo_pagina']?>
      </div>
      <div style="position: absolute;
      right: 5px;
      bottom: 5px;
      text-align: right;">
      <?php
        foreach($resultado['categorias'] as $categoria){
        $url = $categoria['url'];
        $nombre = $categoria['nombre'];
        echo "
          <a href='$url'>
            <span class='badge badge-pill badge-success' style='cursor:pointer;'>
            $nombre
            </span>
          </a>
        ";
        }
      ?>
      </div>
      <div style="
      position: absolute;
      left: 0px;
      bottom: 0px;
      text-align: left;
      background: rgba(255,255,255,0.8);
      padding: 1px 10px">
        <?=$resultado['actual']['ubicacion_servicio']?>
      </div>
    </div>
  </div>

  <div class="container"  id='app'>
    <div class="row">
      <div class="col-lg-9 col-12" style="padding-right:0px;padding-left:0px">

        <?php
        $contador_tab=0;
        foreach($resultado['actividades'] as $index => $actividad){
          $a_id_actividad=$actividad['id_producto'];
        $a_titulo = $actividad['titulo_producto'];
        $a_subtitulo = $actividad['subtitulo_producto'];
        $a_descripcion = $actividad['descripcion_tab'];
        $a_itinerario = $actividad['itinerario_ta'];
        $a_incluye = $actividad['incluye_tab'];
        $a_informacion = $actividad['informacion_tab'];
        $a_mapa = $actividad['mapa_tab'];
        $a_recomendacion = $actividad['recomendacion_tab'];
        $a_sal_ret = $actividad['salida_retorno_tab'];

        $galeria_html = "";
          foreach($actividad['galeria'] as $galeria){
            $url_final = $galeria['url_final'];
            $galeria_html = $galeria_html."
              <img src='$url_final' data-title='First' data-description='My description'>  
            ";
          }
        
        $descripcion_tab_header_html = "";
        $descripcion_tab_content_html = "";
          if($actividad['descripcion_tab']){
            $tmp = $actividad['descripcion_tab'];
            $descripcion_tab_header_html = "
            <input type='radio' name='sky-tabs$index' checked id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
              <label class='div-iten-tab' for='sky-tab$contador_tab'>
              <span><span class='div-iten-tab-content'>
              <span class='fa fa-book'></span>
              <span class='d-none d-sm-block'>
                ".($language=='es'?'Descripción':'Description')."
              </span></span></span></label>
            ";
            $descripcion_tab_content_html = "
            <li class='sky-tab-content-".$contador_tab."'>
              $tmp
            </li>
            ";

          }
        
        $itinerario_tab_header_html = "";
        $itinerario_tab_content_html = "";
          if($actividad['itinerario_ta']){
            $tmp = $actividad['itinerario_ta'];
            $itinerario_tab_header_html = "
            <input type='radio' name='sky-tabs$index' id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
              <label class='div-iten-tab' for='sky-tab$contador_tab'>
              <span><span class='div-iten-tab-content'>
              <span class='fa fa-gift'></span>
              <span class='d-none d-sm-block'>
                ".($language=='es'?'Itinerario':'Itinerary')."
              </span></span></span></label>
            ";
            $itinerario_tab_content_html = "
            <li class='sky-tab-content-".$contador_tab."'>
              $tmp
            </li>
            ";
          }

        $incluye_tab_header_html = "";
        $incluye_tab_content_html = "";
          if($actividad['incluye_tab']){
            $tmp = $actividad['incluye_tab'];
            $incluye_tab_header_html = "
            <input type='radio' name='sky-tabs$index' id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
              <label class='div-iten-tab' for='sky-tab$contador_tab'>
              <span><span class='div-iten-tab-content'>
              <span class='fa fa-gift'></span>
              <span class='d-none d-sm-block'>
                ".($language=='es'?'Incluye':'Include')."
              </span></span></span></label>
            ";
            $incluye_tab_content_html = "
            <li class='sky-tab-content-".$contador_tab."'>
              $tmp
            </li>
            ";
          }

        $informacion_tab_header_html = "";
        $informacion_tab_content_html = "";
          if($actividad['informacion_tab']){
            $tmp = $actividad['informacion_tab'];
            $informacion_tab_header_html = "
            <input type='radio' name='sky-tabs$index' id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
              <label class='div-iten-tab' for='sky-tab$contador_tab'>
              <span><span class='div-iten-tab-content'>
              <span class='fa fa-exclamation-circle'></span>
              <span class='d-none d-sm-block'>
                ".($language=='es'?'Información':'information')."
              </span></span></span></label>
            ";
            $informacion_tab_content_html = "
            <li class='sky-tab-content-".$contador_tab."'>
              $tmp
            </li>
            ";
          }

        $mapa_tab_header_html = "";
        $mapa_tab_content_html = "";
          if($actividad['mapa_tab']){
            $tmp = $actividad['mapa_tab'];
            $mapa_tab_header_html = "
            <input type='radio' name='sky-tabs$index' id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
              <label class='div-iten-tab' for='sky-tab$contador_tab'>
              <span><span class='div-iten-tab-content'>
              <span class='fa fa-map-o'></span>
              <span class='d-none d-sm-block'>
                ".($language=='es'?'Mapa':'Map')."
              </span></span></span></label>
            ";
            $mapa_tab_content_html = "
            <li class='sky-tab-content-".$contador_tab."'>
           
              <div id='mapa-$contador_tab-$index' style='height:400px'></div>
              <map-incalake id_map='mapa-$contador_tab-$index' tmp='".$tmp."'></map-incalake>
            
            </li>
            ";
          }

        $recomendacion_tab_header_html = "";
        $recomendacion_tab_content_html = "";
          if($actividad['recomendacion_tab']){
            $tmp = $actividad['recomendacion_tab'];
            $recomendacion_tab_header_html = "
            <input type='radio' name='sky-tabs$index' id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
              <label class='div-iten-tab' for='sky-tab$contador_tab'>
              <span><span class='div-iten-tab-content'>
              <span class='fa fa-thumbs-up'></span>
              <span class='d-none d-sm-block'>
                ".($language=='es'?'Recomendación':'Recommendation')."
              </span></span></span></label>
            ";
            $recomendacion_tab_content_html = "
            <li class='sky-tab-content-".$contador_tab."'>
              $tmp
            </li>
            ";
          }
        $sal_ret_tab_header_html = "";
        $sal_ret_tab_content_html = "";
          if($actividad['salida_retorno_tab']){
            $tmp = $actividad['salida_retorno_tab'];
            $sal_ret_tab_header_html = "
            <input type='radio' name='sky-tabs$index' id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
              <label class='div-iten-tab' for='sky-tab$contador_tab'>
              <span><span class='div-iten-tab-content'>
              <span class='fa fa-car'></span>
              <span class='d-none d-sm-block'>
                 ".($language=='es'?'Salida y Retorno':'Departure and Return')."
              </span></span></span></label>
            ";
            $sal_ret_tab_content_html = "
            <li class='sky-tab-content-".$contador_tab."'>
              $tmp
            </li>
            ";
          }

        $tabs_adicionales_html = "";
        $tabs_adicionales_content_html = "";
          foreach($actividad['tabs_adicionales'] as $index2=>$tab){
            $nombre_tab = $tab['nombre_tab'];
            $contenido_tab = $tab['contenido_tab'];
            $icono_tab = $tab['icono_tab_adicional'];
            
            $tabs_adicionales_html = $tabs_adicionales_html."
            <input type='radio' name='sky-tabs$index' id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
              <label class='div-iten-tab' for='sky-tab$contador_tab'>
              <span><span class='div-iten-tab-content'>
              <span class='fa fa-$icono_tab'></span>
              <span class='d-none d-sm-block'>
                $nombre_tab
              </span></span></span></label>
            ";
            $tabs_adicionales_content_html = $tabs_adicionales_content_html."
              <li class='sky-tab-content-".$contador_tab."'>
                $contenido_tab
              </li>
            ";
          }

        echo "
        <div>
        <div data-spy='scroll' data-target='#$index' data-offset='0' class='panel panel-default content-content div-activity' id='$index'>
          <h1 id='nodejs'>$a_titulo</h1>
          <h2 id='nodejs-and-npm'>$a_subtitulo</h2>
          <div class='galleria la_galeria'>
            $galeria_html
          </div>
          <div class=' sky-tabs sky-tabs-pos-top-left sky-tabs-anim-flip sky-tabs-response-to-icons'>
            $descripcion_tab_header_html
            $itinerario_tab_header_html
            $incluye_tab_header_html
            $informacion_tab_header_html
            $mapa_tab_header_html
            $recomendacion_tab_header_html
            $sal_ret_tab_header_html

            $tabs_adicionales_html
          
              <ul  class='div-sky-tabs' style='min-height: 300px;'>
                $descripcion_tab_content_html
                $itinerario_tab_content_html
                $incluye_tab_content_html
                $informacion_tab_content_html
                $mapa_tab_content_html
                $recomendacion_tab_content_html
                $sal_ret_tab_content_html

                $tabs_adicionales_content_html
              </ul>
          </div>
            <div class='cart-price'>
                <precio-producto :id_producto='$a_id_actividad'></precio-producto>
            </div>
        </div>
        </div>
        ";
        }
        ?>        

      </div>
        
        <!-- 
          <div class='row'>
              <div class='col-6 col-md-3' style='margin-top:5px;align-self:center;'>
                <span style='font-weight:bold;'>Adulto</span> (todos)
              </div>
              <div class='col-6 col-md-3' style='margin-top:5px;'>
                <div class='input-group input-group-sm'>
                  <span class='input-group-addon' style='cursor:pointer;'><i class='fa fa-minus'></i></span>
                  <input type='number' readonly value='1' class='form-control' style='text-align:center;'>
                  <span class='input-group-addon' style='cursor:pointer;'><i class='fa fa-plus'></i></span>
                </div>
              </div>
              <div class='col-6 col-md-3' style='margin-top:5px;'>
                <div class='input-group input-group-sm'>
                  <span class='input-group-addon' id='basic-addon1'><i class='fa fa-calendar'></i></span>
                  <input type='date' class='form-control'>
                </div>
              </div>
              <div class='col-6 col-md-3' style='margin-top:5px;'>
                <button class='btn btn-danger btn-block btn-sm'><i class='fa fa-cart-plus'></i> Agregar al carrito</button>
              </div>  
          </div> 
        -->

      <div class="col-lg-3 col-12" style="margin-top: 40px;">
        <div style="position: sticky;top:10px">
          <nav class="navbar navbar-light bg-light navbar-light-custom" style="border-top:2px solid #007bff">
            <h5><?=$traduccion_body['actividades_disponibles'];?></h5>
            <nav class="nav nav-pills flex-column" id="sticky-menu" style="text-transform: capitalize">
            <?php
              foreach($resultado['actividades'] as $index => $actividad){
              $nombre = $actividad['titulo_producto'];
              echo "
                <a class='nav-link' href='#$index'>".strtolower($nombre)."</a>
              ";
              }
            ?>
            </nav>
          </nav>

          <div class="content-content" style="border-top:2px solid #007bff">
            <h5><?=$traduccion_body['necesitas_ayuda'];?></h5>
            <ul class="list-inline" style="font-size:1.1em; margin-left: 0px;">
              <li><i class="fa fa-whatsapp" style="color:#39c15c"></i> 957585843</li>
              <li><i class="fa fa-phone"></i> 957585843</li>
              <li><i class="fa fa-envelope"></i> reservas@incalake.com</li>
            </ul>
          </div>

          <div class="content-content" style="border-top:2px solid #007bff">
            <h5><?=$traduccion_body['reserva_con_ayuda'];?></h5>
            <hr>
            <p>
              <?=$traduccion_body['reserva_con_ayuda_descrip'];?>
            </p>
            <button type="button" class="btn btn-primary" data-toggle="modal" style="cursor:pointer" data-target="#preguntasModal">
              <?=$traduccion_body['consultar'];?>
            </button>
           
          </div>

        </div>
      </div>
    </div>
  </div>
</div>








  <?php
  }
?>




<script>
  $('body').scrollspy({ target: '#sticky-menu' });
  $(document).ready(function(){
    Galleria.loadTheme('https://cdnjs.cloudflare.com/ajax/libs/galleria/1.5.7/themes/classic/galleria.classic.min.js');
    Galleria.ready(function(options){
      this.enterFullscreen();
    });
    Galleria.run('.galleria',{
      //flickr: 'set:72157688289106985'
    });
  })
</script>
<style>
:root {

}
  .div-activity .nav-tabs .nav-link{
    border-radius: 0;
        border-style: ridge;
    border-width: 1px;
    /*border-color: rgba(183, 183, 183, 0.36);*/
    /*margin-right: 1%;*/
    /*padding: 1%;*/
    background: var(--color-complement);
    color: var(--color-text);
  }
  .div-activity .nav-tabs .nav-link span{
    /*padding: 1%;*/
  }
  .div-activity .nav-tabs{
    margin: 1% 0;
  }
  .div-activity .nav-link.active{
    /*background: #fff;*/
    background: var(--color-primary);
    /*color: #fff;*/
  }
.navbar-light-custom{
  background: #fff !important;
}
.sky-tabs{
      font-family: 'Quicksand' !important;
    }
.galleria-theme-classic .galleria-thumbnails-container{
z-index:1;
}
</style>

<!-- ------------------ -->
 <!-- modal -->
            <div class="modal fade" id="preguntasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?=$traduccion_body['formulario_contacto'];?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <?=$traduccion_body['formulario_contacto_descrip'];?>
                    
                   <form id="preguntas_form"> 
                    <input type="hidden" name="url" value="<?=$_SERVER["REQUEST_URI"];?>" />
                    <div class="form-group">
                      <label for="email"><?=$traduccion_body['nombres'];?></label>
                      <input type="text" required name="nombres" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" required name="email" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="descripcion"><?=$traduccion_body['pregunta'];?></label>
                      <textarea class="form-control" name="descripcion"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="email"><?=$traduccion_body['selecione_tour'];?></label>
                      <select name="actividad" class="form-control">
                       <option value="">-------<?=$traduccion_body['seleccione'];?>------</option>
                      <?php
                        foreach($resultado['actividades'] as $index => $actividad){
                        $nombre = $actividad['titulo_producto'];
                        echo "
                          <option>".strtolower($nombre)."</option>
                        ";
                        }
                      ?>
                      </select>
                    </div>
                    
                    <div class="form-control">
                      <div class="g-recaptcha" data-sitekey="6LcrXzEUAAAAABUnaBOXWonI0I5Tpj1C4xPJ2hcb"></div>
                    </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$traduccion_body['cerrar'];?></button>
                    <button type="button" class="btn btn-primary" id="btn_enviar_pregunta"><?=$traduccion_body['enviar'];?></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- modal -->
            <script>
            /*script de las preguntas*/
            $(function(){

              var preguntas_form = $('#preguntas_form');
              var inputs = preguntas_form.find('input,textarea');
              inputs.focusin(function(){
                $(this).css('background','white');
              });
              //alert(inputs.length);
              $('#btn_enviar_pregunta').click(function(){
                
                var todo_ok = true;
                var send_button = $(this);
                if(!grecaptcha.getResponse().length){
                  alert("Por favor resuelva el captcha");
                  todo_ok=false;
                }

                inputs.each(function(){
                  //console.log($(this).val());
                  if($(this).val().length<3){
                    $(this).css('background','#DEACAC');
                    todo_ok=false;
                  }
                });

                if(todo_ok){
                  send_button.attr('disabled','disabled');
                  var datos = preguntas_form.serializeArray();
                  console.log(datos);
                  $.post('<?=base_url();?>preguntas',datos,function(result){
                     console.log(result);
                     if(!isNaN(result)){
                        if(parseInt(result))$('#preguntasModal').modal('hide');
                        else alert('Errores al enviar intente de nuevo.');
                     } else alert('Errores en el servidor intente de nuevo.');
                     send_button.removeAttr('disabled');
                  });
                }

                
              })
            });
            /*fin del script de las preguntas*/  
            // Tablas
            $('table').addClass('table table-striped table-bordered');
            $('table thead').addClass('bg-primary text-light');
          // 
           $(document).on('click', '.nav-pills .nav-link', function(event) {
             var val = $(this).attr( "href" );
              if (val) {
                  $('html,body').animate({
                      scrollTop: $(val).offset().top
                  }, 2000);
              }

           });
            </script>
