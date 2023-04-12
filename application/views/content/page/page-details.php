<?php
    // VARIABLES GTAG.JS
    $GTAG_CATEGORIAS  = null; // Aquí se concatenarán todas las categorias de los productos que se muestran en esta página 
    $GTAG_ARRAY_ITEMS = [];   // Aquí se guardarán todos los productos que se muestran en esta página en forma de objetos con la respectiva información necesaria para enviar a google analitics  
?>


<!-- historial de TAB -->
<div class="container p-0">
    <div class="col-12 p-0 mt-2 mb-2" style="font-size: 0.8rem;">
        <?php
            $var_destiny='';
            foreach ($breadcrumb as $key => $value) 
            {
                if (!empty($value["url"])) 
                    echo '<a href="'.$value["url"].'" style="color: #333;" class="text-capitalize">'.strtolower($value["txt"]).'</a> > ';
            }
            echo '<span class="text-capitalize pl-1 pr-1 font-weight-bold">'.strtolower($resultado['actual']['titulo_pagina']).'</span>';
        ?>
  </div>
</div>


<?php
    $traduccion_body = arrayTraduccion('body', $language);
?>


<style>
    .navbar-light .navbar-brand,.navbar-light .navbar-nav .active>.nav-link,.navbar-light .navbar-nav .nav-link,.navbar-light .navbar-nav .nav-link.active,.navbar-light .navbar-nav .nav-link.show,.navbar-light .navbar-nav .show>.nav-link{color:rgba(255,255,255,.9)}.navbar-light .navbar-nav .nav-link:focus,.navbar-light .navbar-nav .nav-link:hover{color:rgba(255,255,255,.99)}.tab-pane.fade,.tab-pane.fade.active.show,.tab-pane.fade.show.active{margin-top:1em}.la_galeria{height:400px;background:#000}@media(max-width:768px){.container{padding-right:0;padding-left:0}div.content-content{margin-top:0}}.sky-tabs{margin:2% 0}.div-activity .div-sky-tabs{border:1px solid #e5e5e5}.div-iten-tab{border-top:solid!important;border-left:solid!important;border-right:solid!important;border-width:1px!important;border-color:#e5e5e5!important}.sky-tabs>input:checked+.div-iten-tab{border-bottom:solid 1px #fff!important;margin-bottom:-1px!important}.div-sky-tabs p{text-align:justify}.div-sky-tabs li ul{margin-left:20px}.div-iten-tab-content{display:inline-flex!important}

    .carousel-indicators li{
        cursor: pointer;
    }

    .carousel-indicators li:hover{
        background-color: #9CCC65;
    }

    .carousel-indicators .active {
        background-color: #9CCC65;
    }
</style>


<!-- banner modo web -->
<?php 
if (!empty($resultado['actual']['slider_img'])) 
{
?>
    <div class="container d-none d-sm-none d-md-block mt-3 mb-3 p-0" >
        <div class="row" style="margin: 0;position: relative;">
            
            <div class="col-12" style="padding: 0;height: 350px;overflow: hidden;">
                <img src="<?=$resultado['actual']['slider_thumbs']?>" data-thumbs="<?=$resultado['actual']['slider_img']?>" class="img-fluid img-thumbs" alt="Responsive image" style="width: 100%;height: auto;opacity: 1;position: absolute;left: -100%;right: -100%;top: -100%;bottom: -100%;margin: auto;min-height: 100%;min-width: 100%;">
            </div>
            
            <div style="position: absolute;left: 0;top: 0;background-color:rgba(0,0,0,0.2);width: 100%;height:100%;    box-shadow: inset 0px -19px 98px 7px #000000fa;"></div>
      
            <div style="position: absolute;left: 0;bottom: 0;color: white;text-shadow: 0px 1px black;padding: 1%;">
                <span style="text-align: left;background: rgba(74, 180, 52, 0.78);padding: 1px 10px;color: #f5f5f5;font-size: 1rem;">
                    <?=$resultado['actual']['ubicacion_servicio']?>
                </span>
                <div style="font-size: 1.5em;"><?=$resultado['actual']['titulo_pagina']?></div>
            </div>
            
            <div style="position: absolute;right: 5px;bottom: 5px;text-align: right;">
                <?php
                    foreach($resultado['categorias'] as $categoria)
                    {
                        $GTAG_CATEGORIAS .= ($GTAG_CATEGORIAS ? ", " : "") . ucfirst(mb_strtolower(@$categoria['nombre'])); // Concatenando las categorias para enviar como una variable de un producto
                        $url = $categoria['url'];
                        $nombre = $categoria['nombre'];
                        echo "
                            <a href='$url'>
                                <span class='badge badge-pill badge-success' style='cursor:pointer;'>$nombre</span>
                            </a>
                        ";
                    }
                ?>
            </div>
      
        </div>
    </div>
<?php
} 
?>
<!--/ banner modo web -->



<!-- app -->
 <div class="container"  id='app'>
    <div class="row">
        <div class="col-lg-9 col-12" style="padding-right:0px;padding-left:0px">

        <?php
            
            // Alerta si no hay actividades
            if(!count($resultado['actividades'])) 
            {
                echo $language=='es' ? 
                '<br>
                <div class="alert alert-warning" role="alert">
                    <strong>Alerta:</strong> En estos momentos no tenemos actividades disponibles para este lugar por lo que estamos trabajando en ello, pronto tendremos novedades. 
                    En caso tenga alguna pregunta y/o sugerencia no dude en escribirnos a reservas@incalake.com
                </div>' 
                :
                '<br>
                <div class="alert alert-warning" role="alert">
                    <strong>Alert:</strong> 
                    At this time we do not have activities available for this place so we are working on it, soon we will have news. If you have any question and / or suggestion, do not hesitate to write to reservas@incalake.com
                </div>';
            }

            $contador_tab=0;
            $id = 0;
            
            foreach($resultado['actividades'] as $index => $actividad)
            {
                $GTAG_ARRAY_ITEMS[] = array(
                    'id'            => "P".@$actividad['id_producto'],
                    'name'          => @$actividad['titulo_producto'],
                    'category'      => $GTAG_CATEGORIAS,
                    'list_position' => ++$index,
                );
            
                $a_id_actividad=$actividad['id_producto'];
                $a_titulo = $actividad['titulo_producto'];
                $a_codigo_producto=$actividad['codigo_producto'];
                $a_subtitulo = $actividad['subtitulo_producto'];

                $galeria_html = "";
                $galeria_thumbs="";
                $galeria_first="active";
                if (!empty($actividad['galeria'])) 
                {
                    foreach($actividad['galeria'] as $key => $galeria)
                    {
                        $url_final = $galeria['url_final'];
                        $url_thumbs = $galeria['url_thumbs'];

                        $galeria_html .= 
                            '<div class="carousel-item '.$galeria_first.'">
                                <img class="d-block img-thumbs faded img-thumbnail" src="'.$url_thumbs.'" data-thumbs="'.$url_final.'" style="margin: 0 auto;">
                            </div>';
                            
                        $galeria_thumbs .= 
                            '<li data-target="#galeria_producto_'.$a_id_actividad.'" data-slide-to="'.$key.'" class="'.$galeria_first.' img-thumbnail">
                                <img class="d-block " src="'.$url_thumbs.'" style="margin: 0 auto;">
                            </li>';
                        $galeria_first="";
                    }
                }
        
                $descripcion_tab_header_html = "";
                $descripcion_tab_content_html = "";
                $tab_check="checked";
                if($actividad['descripcion_tab'])
                {
                    $tmp = $actividad['descripcion_tab'];
                    $descripcion_tab_header_html = "
                        <input type='radio' name='sky-tabs$index' ".$tab_check." id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
                        <label class='div-iten-tab' for='sky-tab$contador_tab'>
                            <span>
                                <span class='div-iten-tab-content'>
                                    <span class='fa fa-book'></span>
                                    <span class='d-none d-sm-block'>
                                        ".$traduccion_body['descripcion']."
                                    </span>
                                </span>
                            </span>
                        </label>
                    ";
                    $descripcion_tab_content_html = "
                        <li class='sky-tab-content-".$contador_tab."'>
                            <div class='line-header'>
                                <div>".$traduccion_body['descripcion']."</div>
                            </div>
                            $tmp
                        </li>
                    ";
                    $tab_check="";
                }
            
                $acordion_html = "";
                //Descripcion acordion
                $acordion_descripcion_data = "";
                $descripcion_acordion_html = "";
                if($actividad['descripcion_tab'])
                {
                    $acordion_descripcion_titulo = $traduccion_body['descripcion'];
                    $acordion_descripcion_data = $actividad['descripcion_tab'];
                    $acordion_html .= "
                        <div class='card'>
                            <div class='card-header' id='heading_descripcion' data-toggle='collapse' data-target='#collapse_descripcion_$id' aria-expanded='false' aria-controls='collapse_descripcion_$id'>
                                <h2 class='mb-0'>
                                    <button class='btn btn-link' type='button' >
                                        <i class='fa fa-chevron-down'></i>
                                        $acordion_descripcion_titulo
                                    </button>
                                </h2>
                            </div>
                            <div id='collapse_descripcion_$id' class='collapse' aria-labelledby='heading_descripcion' data-parent='#accordionExample'>
                                <div class='card-body'>
                                    $acordion_descripcion_data
                                </div>
                            </div>
                        </div>
                    ";
                    ++$id;
                }
            
            
                $itinerario_tab_header_html = "";
                $itinerario_tab_content_html = "";
                if($actividad['itinerario_ta'])
                {
                    $tmp = $actividad['itinerario_ta'];
    
                    $itinerario_tab_header_html = "
                        <input type='radio' name='sky-tabs$index' ".$tab_check." id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
                        <label class='div-iten-tab' for='sky-tab$contador_tab'>
                            <span>
                                <span class='div-iten-tab-content'>
                                    <span class='fa fa-gift'></span>
                                    <span class='d-none d-sm-block'>".$traduccion_body['itinerario']."</span>
                                </span>
                            </span>
                        </label>
                    ";
                    
                    $itinerario_tab_content_html = "
                        <li class='sky-tab-content-".$contador_tab."'>
                            <div class='line-header'>
                                <div>".$traduccion_body['itinerario']."</div>
                            </div>
                            $tmp
                        </li>
                    ";
                    $tab_check="";
                }
            
            
                //Itinerario acordion
                $acordion_descripcion_data = "";
                $descripcion_acordion_html = "";
                if($actividad['descripcion_tab'])
                {
                    $acordion_itineario_titulo = $traduccion_body['itinerario'];
                    $acordion_itinerario_data = $actividad['itinerario_ta'];
                    $acordion_html .= "
                        <div class='card'>
                            <div class='card-header' id='heading_itineario' data-toggle='collapse' data-target='#collapse_itinerario_$id' aria-expanded='false' aria-controls='collapse_itinerario_$id'>
                                <h2 class='mb-0'>
                                    <button class='btn btn-link collapsed' type='button' >
                                        <i class='fa fa-chevron-down'></i>
                                        $acordion_itineario_titulo
                                    </button>
                                </h2>
                            </div>
                            <div id='collapse_itinerario_$id' class='collapse' aria-labelledby='heading_itineario' data-parent='#accordionExample'>
                                <div class='card-body'>
                                    $acordion_itinerario_data
                                </div>
                            </div>
                        </div>
                    ";
                    ++$id;
                }

                $incluye_tab_header_html = "";
                $incluye_tab_content_html = "";
                if($actividad['incluye_tab'])
                {
                    $tmp = $actividad['incluye_tab'];
                    $incluye_tab_header_html = "
                        <input type='radio' name='sky-tabs$index' ".$tab_check." id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
                        <label class='div-iten-tab' for='sky-tab$contador_tab'>
                        <span><span class='div-iten-tab-content'>
                        <span class='fa fa-gift'></span>
                        <span class='d-none d-sm-block'>
                        ".$traduccion_body['incluye']."
                        </span></span></span></label>
                    ";
                    $incluye_tab_content_html = "
                        <li class='sky-tab-content-".$contador_tab."'>
                        <div class='line-header'><div>".$traduccion_body['incluye']."</div></div>
                        $tmp
                        </li>
                    ";
                    $tab_check="";
                }
            
                //Incluye acordion
                $acordion_incluye_data = "";
                $incluye_acordion_html = "";
                if($actividad['incluye_tab'])
                {
                    $acordion_incluye_titulo = $traduccion_body['incluye'];
                    $acordion_incluye_data = $actividad['incluye_tab'];
                    $acordion_html .= "
                        <div class='card'>
                            <div class='card-header' id='heading_incluye' data-toggle='collapse' data-target='#collapse_incluye_$id' aria-expanded='false' aria-controls='collapse_incluye_$id'>
                                <h2 class='mb-0'>
                                    <button class='btn btn-link collapsed' type='button' >
                                        <i class='fa fa-chevron-down'></i>
                                        $acordion_incluye_titulo
                                    </button>
                                </h2>
                            </div>
                            <div id='collapse_incluye_$id' class='collapse' aria-labelledby='heading_incluye' data-parent='#accordionExample'>
                                <div class='card-body'>
                                    $acordion_incluye_data
                                </div>
                            </div>
                        </div>
                    ";
                    
                    ++$id;
                }

                $informacion_tab_header_html = "";
                $informacion_tab_content_html = "";
                if($actividad['informacion_tab'])
                {
                    $tmp = $actividad['informacion_tab'];
                    $informacion_tab_header_html = "
                        <input type='radio' name='sky-tabs$index' ".$tab_check." id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
                            <label class='div-iten-tab' for='sky-tab$contador_tab'>
                            <span><span class='div-iten-tab-content'>
                            <span class='fa fa-exclamation-circle'></span>
                            <span class='d-none d-sm-block'>
                            ".$traduccion_body['informacion']."
                            </span></span></span></label>
                        ";
                    $informacion_tab_content_html = "
                        <li class='sky-tab-content-".$contador_tab."'>
                            <div class='line-header'><div>".$traduccion_body['informacion']."</div></div>
                            $tmp
                        </li>
                    ";
                    $tab_check="";
                 }
          
          
                //Informacion acordion
                $acordion_informacion_data = "";
                $informacion_acordion_html = "";
                if($actividad['informacion_tab'])
                {
                    $acordion_informacion_titulo = $traduccion_body['informacion'];
                    $acordion_informacion_data = $actividad['informacion_tab'];
                    $acordion_html .= "
                        <div class='card'>
                            <div class='card-header' id='heading_informacion' data-toggle='collapse' data-target='#collapse_informacion_$id' aria-expanded='false' aria-controls='collapse_informacion_$id'>
                                <h2 class='mb-0'>
                                    <button class='btn btn-link collapsed' type='button' >
                                        <i class='fa fa-chevron-down'></i>
                                        $acordion_informacion_titulo
                                    </button>
                                </h2>
                            </div>
                            <div id='collapse_informacion_$id' class='collapse' aria-labelledby='heading_informacion' data-parent='#accordionExample'>
                                <div class='card-body'>
                                    $acordion_informacion_data
                                </div>
                            </div>
                        </div>
                    ";
                    
                    ++$id;
                }

                $mapa_tab_header_html = "";
                $mapa_tab_content_html = "";
                if($actividad['mapa_tab'])
                {
                    $tmp = $actividad['mapa_tab'];
                    $mapa_tab_header_html = "
                        <input type='radio' name='sky-tabs$index' ".$tab_check." id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
                        <label class='div-iten-tab' for='sky-tab$contador_tab'>
                        <span><span class='div-iten-tab-content'>
                        <span class='fa fa-map-o'></span>
                        <span class='d-none d-sm-block'>
                        ".$traduccion_body['mapa']."
                        </span></span></span></label>
                    ";
                    $mapa_tab_content_html = "
                    <li class='sky-tab-content-".$contador_tab."'>
                    <div class='line-header'><div>".$traduccion_body['mapa']."</div></div>
                   
                      <div id='mapa-$contador_tab-$index' style='height:400px'></div>
                      <map-incalake id_map='mapa-$contador_tab-$index' tmp='".$tmp."'></map-incalake>
                    
                    </li>
                    ";
                    $tab_check="";
                }
          
                //Mapa acordion
                $acordion_mapa_data = "";
                $mapa_acordion_html = "";
                if($actividad['mapa_tab'])
                {
                    $acordion_mapa_titulo = $traduccion_body['mapa'];
                    $acordion_mapa_data = $actividad['mapa_tab'];
                    $acordion_html .= "
                        <div class='card'>
                            <div class='card-header' id='heading_mapa' data-toggle='collapse' data-target='#collapse_mapa_$id' aria-expanded='false' aria-controls='collapse_mapa'>
                                <h2 class='mb-0'>
                                    <button class='btn btn-link collapsed' type='button' >
                                        <i class='fa fa-chevron-down'></i>
                                        $acordion_mapa_titulo
                                    </button>
                                </h2>
                            </div>
                            <div id='collapse_mapa_$id' class='collapse' aria-labelledby='heading_mapa' data-parent='#accordionExample'>
                                <div class='card-body'>
                                    $acordion_mapa_data
                                </div>
                            </div>
                        </div>
                    ";
                    ++$id;
                }

                $recomendacion_tab_header_html = "";
                $recomendacion_tab_content_html = "";
                if($actividad['recomendacion_tab'])
                {
                    $tmp = $actividad['recomendacion_tab'];
                    $recomendacion_tab_header_html = "
                        <input type='radio' name='sky-tabs$index' ".$tab_check." id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
                        <label class='div-iten-tab' for='sky-tab$contador_tab'>
                        <span><span class='div-iten-tab-content'>
                        <span class='fa fa-thumbs-up'></span>
                        <span class='d-none d-sm-block'>
                        ".$traduccion_body['recomendaciones']."
                        </span></span></span></label>
                    ";
                    $recomendacion_tab_content_html = "
                        <li class='sky-tab-content-".$contador_tab."'>
                        <div class='line-header'><div>".$traduccion_body['recomendaciones']."</div></div>
                        $tmp
                        </li>
                    ";
                    $tab_check="";
                }
          
                //Recomendacion acordion
                $acordion_recomendacion_data = "";
                $recomendacion_acordion_html = "";
                if($actividad['mapa_tab'])
                {
                    $acordion_recomendacion_titulo = $traduccion_body['recomendaciones'];
                    $acordion_recomendacion_data = $actividad['recomendacion_tab'];
                    $acordion_html .= "
                        <div class='card'>
                            <div class='card-header' id='heading_recomendacion' data-toggle='collapse' data-target='#collapse_recomendacion_$id' aria-expanded='false' aria-controls='collapse_recomendacion'>
                                <h2 class='mb-0'>
                                    <button class='btn btn-link collapsed' type='button' >
                                        <i class='fa fa-chevron-down'></i>
                                        $acordion_recomendacion_titulo
                                    </button>
                                </h2>
                            </div>
                            <div id='collapse_recomendacion_$id' class='collapse' aria-labelledby='heading_recomendacion' data-parent='#accordionExample'>
                                <div class='card-body'>
                                    $acordion_recomendacion_data
                                </div>
                            </div>
                        </div>
                    ";
                    ++$id;
                }  
          
          
                $sal_ret_tab_header_html = "";
                $sal_ret_tab_content_html = "";
                if($actividad['salida_retorno_tab'])
                {
                    $tmp = $actividad['salida_retorno_tab'];
                    $sal_ret_tab_header_html = "
                        <input type='radio' name='sky-tabs$index' ".$tab_check." id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
                        <label class='div-iten-tab' for='sky-tab$contador_tab'>
                        <span><span class='div-iten-tab-content'>
                        <span class='fa fa-car'></span>
                        <span class='d-none d-sm-block'>
                        ".$traduccion_body['salida_retorno']."
                        </span></span></span></label>
                    ";
                    $sal_ret_tab_content_html = "
                        <li class='sky-tab-content-".$contador_tab."'>
                            <div class='line-header'><div>".$traduccion_body['salida_retorno']."</div></div>
                            $tmp
                        </li>
                    ";
                    $tab_check="";
                }
          
                //Salida retorno acordion
                $acordion_salret_data = "";
                $salret_acordion_html = "";
                if($actividad['salida_retorno_tab'])
                {
                    $acordion_salret_titulo = $traduccion_body['salida_retorno'];
                    $acordion_salret_data = $actividad['salida_retorno_tab'];
                    $acordion_html .= "
                        <div class='card'>
                            <div class='card-header' id='heading_salret' data-toggle='collapse' data-target='#collapse_salret_$id' aria-expanded='false' aria-controls='collapse_salret'>
                                <h2 class='mb-0'>
                                    <button class='btn btn-link collapsed' type='button' >
                                        <i class='fa fa-chevron-down'></i>
                                        $acordion_salret_titulo
                                    </button>
                                </h2>
                            </div>
                            <div id='collapse_salret_$id' class='collapse' aria-labelledby='heading_salret' data-parent='#accordionExample'>
                                <div class='card-body'>
                                    $acordion_salret_data
                                </div>
                            </div>
                        </div>
                    ";
                    
                    ++$id;
                }  

                $tabs_adicionales_html = "";
                $tabs_adicionales_content_html = "";
                foreach($actividad['tabs_adicionales'] as $index2=>$tab)
                {
                    $nombre_tab = $tab['nombre_tab'];
                    $contenido_tab = $tab['contenido_tab'];
                    $icono_tab = $tab['icono_tab_adicional'];
                    
                    $tabs_adicionales_html = $tabs_adicionales_html."
                        <input type='radio' name='sky-tabs$index' ".$tab_check." id='sky-tab".(++$contador_tab)."' class='sky-tab-content-".$contador_tab."'>
                        <label class='div-iten-tab' for='sky-tab$contador_tab'>
                        <span><span class='div-iten-tab-content'>
                        <span class='fa fa-$icono_tab'></span>
                        <span class='d-none d-sm-block'>
                        $nombre_tab
                        </span></span></span></label>
                    ";
                    $tabs_adicionales_content_html = $tabs_adicionales_content_html."
                        <li class='sky-tab-content-".$contador_tab."'>
                        <div class='line-header'><div>$nombre_tab</div></div>
                            $contenido_tab
                        </li>
                    ";
                    $tab_check="";
                }
          
        
                //Adicionales acordion
                $tabs_adicionales_html = "";
                $tabs_adicionales_content_html = "";
                $acordion_adicionales_data = "";
                $adicionales_acordion_html = "";
                $tmp = 0;
                foreach($actividad['tabs_adicionales'] as $index2=>$tab)
                {
                    $nombre_tab = $tab['nombre_tab'];
                    $contenido_tab = $tab['contenido_tab'];
                    
                    //mt_srand(time());
                    $num = mt_rand(1,100);
                    
                    
                    if($contenido_tab != "")
                    {
                        $acordion_html .= "
                            <div class='card'>
                                <div class='card-header' id='heading_".$nombre_tab."' data-toggle='collapse' data-target='#collapse_".$id."' aria-expanded='false' aria-controls='collapse_".$id."'>
                                    <h2 class='mb-0'>
                                        <button class='btn btn-link collapsed' type='button'>
                                            <i class='fa fa-chevron-down'></i>
                                            $nombre_tab
                                        </button>
                                    </h2>
                                </div>
                                <div id='collapse_".$id."' class='collapse' aria-labelledby='heading_".$nombre_tab."' data-parent='#accordionExample'>
                                    <div class='card-body'>
                                        $contenido_tab
                                    </div>
                                </div>
                            </div>
                        ";
                        $tmp++;    
                        
                        ++$id;
                    }
                }
          
          
                
                // IMPRIME INFORMACION PRINCIPAL
                echo "
                    <div>
                        <div data-spy='scroll' data-target='#$index' data-offset='0' class='panel panel-default content-content div-activity' id='".$actividad['id_producto']."'>
                            <h1 id='nodejs'>$a_titulo</h1>
                            <h2 id='nodejs-and-npm'>$a_subtitulo</h2>
                            <small class='text-muted'>ID: $a_codigo_producto</small>
                            ".
                            ($galeria_html!='' ?
                            ('<div id="galeria_producto_'.$a_id_actividad.'" class="galeria_producto carousel slide" style="/*background:#000;*/" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    '.$galeria_thumbs.'
                                </ol>
                            <div class="carousel-inner">
                                '.$galeria_html.'
                            </div>
                            <a class="carousel-control-prev" href="#galeria_producto_'.$a_id_actividad.'" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#galeria_producto_'.$a_id_actividad.'" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        ') 
                        :
                        '').

                        "
                        <!-- Acordion -->
                        <div id='reserve_ahora' style='display:none;'>
                            <a href='#cart-price'>
                                <div class='col-md-12' style='color:#fff; background:#fc6c4e !important; padding:20px; text-align:center; font-size:17px; cursor:pointer;'>RESERVE AHORA</div>
                            </a>
                        </div>
                        <div class='accordion' id='accordionExample' style='display:none;'>
                            $acordion_html
                        </div>
                        <!-- Acordion -->
                        " .

                        "<div class=' sky-tabs sky-tabs-pos-top-left sky-tabs-anim-flip sky-tabs-response-to-icons'>
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
          
          
                        <div class='cart-price' id='cart-price'>";
                            
                            if(!empty($a_id_actividad))
                                echo "<producto-cart :producto_id='$a_id_actividad'></producto-cart>";
                            else 
                                echo "<h4 class='text-center mx-auto'>El servicio no esta disponible</h4>";
                       
                        echo "</div>
                    </div>
                </div>
                ";
            }
        ?> 
        
        
        
        
        <!-- mas informacion -->
        <div class="container-fluid" style="padding: 0;">       
        
        <?php
            $reating_all=0;
            if (!empty($resultado['actual']['reviews'])) 
            {
                $reviews=$resultado['actual']['reviews'];
                $manage = (array) json_decode($reviews);
                $reating_all=count($manage['items']);
            }


            if ($reating_all!=0 ) 
            { 
        ?>
        
        <?php
  
  
            $div_reviews='';
            $div_reviews_more='';
            $rating_count=0;
            $rating_value=0;
            $rating_value_1=0;
            $rating_value_2=0;
            $rating_value_3=0;
            $rating_value_4=0;
            $rating_value_5=0;
            $temp_i=0;
            
            foreach (array_reverse($manage['items']) as $key => $value) 
            {
                $rating_count+=(@$value->rating===null?4:(int)$value->rating);
                $temp_i+=1;
                if ($temp_i<=3) 
                {
                    $div_reviews.='
                    <div class="card form-group">
                    <div class="card-body">
                    <div class="row">
                    <div class="col-md">
                    <div class="row">
                    <div class="col-md">
                    <div class="row">
                    
                        <div class="col-md-auto" style="align-self: center;">
                            <div class="star-ratings-css">
                                <div class="star-ratings-css-top" style="width:'.((@$value->rating===null?4:$value->rating)*100/5).'%">
                                    <span class="fa fa-star text-primary"></span>
                                    <span class="fa fa-star text-primary"></span>
                                    <span class="fa fa-star text-primary"></span>
                                    <span class="fa fa-star text-primary"></span>
                                    <span class="fa fa-star text-primary"></span>
                                </div>
                                <div class="star-ratings-css-bottom">
                                    <span class="fa fa-star text-secondary"></span>
                                    <span class="fa fa-star text-secondary"></span>
                                    <span class="fa fa-star text-secondary"></span>
                                    <span class="fa fa-star text-secondary"></span>
                                    <span class="fa fa-star text-secondary"></span>
                                </div>
                            </div>
                            <div class="font-weight-bold text-center">'.(@$value->rating===null?'4':$value->rating).'/5</div>
                        </div>
                        
                        <div class="col-md text-justify">
                            <div class="row">
                                <div class="col-md font-weight-bold">
                                    '.(@$value->nombres===null?'':$value->nombres).'
                                </div>
                                <div class="col-md text-right text-secondary">
                                    '.(@$value->nacionalidad===null?'':$value->nacionalidad).'
                                </div>
                            </div>
                            <p>'.(@$value->comentario===null?'':$value->comentario).'</p>
                        </div>
                    
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>';
                }
                else
                {
                    $div_reviews_more.='
                    <div class="card form-group">
                    <div class="card-body">
                    <div class="row">
                    <div class="col-md">
                    <div class="row">
                    <div class="col-md">
                    <div class="row">
                    <div class="col-md-auto" style="align-self: center;">
                    <div class="star-ratings-css">
                                    
                        <div class="star-ratings-css-top" style="width:'.((@$value->rating===null?4:$value->rating)*100/5).'%">
                            <span class="fa fa-star text-primary"></span>
                            <span class="fa fa-star text-primary"></span>
                            <span class="fa fa-star text-primary"></span>
                            <span class="fa fa-star text-primary"></span>
                            <span class="fa fa-star text-primary"></span>
                        </div>
                        
                        <div class="star-ratings-css-bottom">
                            <span class="fa fa-star text-secondary"></span>
                            <span class="fa fa-star text-secondary"></span>
                            <span class="fa fa-star text-secondary"></span>
                            <span class="fa fa-star text-secondary"></span>
                            <span class="fa fa-star text-secondary"></span>
                        </div>
                        
                        </div>
                            <div class="font-weight-bold text-center">'.(@$value->rating===null?'4':$value->rating).'/5</div>
                        </div>
                        
                        <div class="col-md text-justify">
                            <div class="row">
                                <div class="col-md font-weight-bold">
                                    '.(@$value->nombres===null?'':$value->nombres).'
                                </div>
                                <div class="col-md text-right text-secondary">
                                    '.(@$value->nacionalidad===null?'':$value->nacionalidad).'
                                </div>
                            </div>
                            <p>'.(@$value->comentario===null?'':$value->comentario).'</p>
                        </div>
                        
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>';
                }
      
      
                switch (@$value->rating===null ? 4 : (int)$value->rating) 
                {
                    case 1:
                        $rating_value_1+=1;
                        break;
                    case 2:
                        $rating_value_2+=1;
                        break;
                    case 3:
                        $rating_value_3+=1;
                        break;
                    case 4:
                        $rating_value_4+=1;
                        break;
                    case 5:
                        $rating_value_5+=1;
                        break;    
                }
            }

            $rating_value=$rating_count/count($manage['items']);
        ?>
        
        
        <!-- estadistica -->
        <h4 class="text-capitalize"><?=$traduccion_body['estadistica'];?></h4>
        
        <div class="card form-group">
        <div class="card-body">
          <div class="row ">
            <div class="col-md ">
              <div class="row">
                <div class="col-md-4 col-sm-4">5 <?=$traduccion_body['estrellas'];?></div>
                <div class="col-md-6 col-sm-6" style="align-self: center;">
                  <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: <?=number_format((($rating_value_5*100)/$reating_all),1);?>%" aria-valuenow="<?=number_format((($rating_value_5*100)/$reating_all),1);?>" aria-valuemin="0" aria-valuemax="100"><?=number_format((($rating_value_5*100)/$reating_all),1);?>%</div>
                </div>
                </div>
                <div class="col-md-2 col-sm-2"><?=$rating_value_5;?></div>
              </div>
              <div class="row">
                <div class="col-md-4 col-sm-4">4 <?=$traduccion_body['estrellas'];?></div>
                <div class="col-md-6 col-sm-6" style="align-self: center;">
                  <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: <?=number_format((($rating_value_4*100)/$reating_all),1);?>%" aria-valuenow="<?=number_format((($rating_value_4*100)/$reating_all),1);?>" aria-valuemin="0" aria-valuemax="100"><?=number_format((($rating_value_4*100)/$reating_all),1);?>%</div>
                </div>
                </div>
                <div class="col-md-2 col-sm-2"> <?=$rating_value_4;?></div>
              </div>
              <div class="row">
                <div class="col-md-4 col-sm-4">3 <?=$traduccion_body['estrellas'];?></div>
                <div class="col-md-6 col-sm-6" style="align-self: center;">
                  <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: <?=number_format((($rating_value_3*100)/$reating_all),1);?>%" aria-valuenow="<?=number_format((($rating_value_3*100)/$reating_all),1);?>" aria-valuemin="0" aria-valuemax="100"><?=number_format((($rating_value_3*100)/$reating_all),1);?>%</div>
                </div>
                </div>
                <div class="col-md-2 col-sm-2"> <?=$rating_value_3;?></div>
              </div>
              <div class="row">
                <div class="col-md-4 col-sm-4">2 <?=$traduccion_body['estrellas'];?></div>
                <div class="col-md-6 col-sm-6" style="align-self: center;">
                  <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: <?=number_format((($rating_value_2*100)/$reating_all),1);?>%;" aria-valuenow="<?=number_format((($rating_value_2*100)/$reating_all),1);?>" aria-valuemin="0" aria-valuemax="100"><?=number_format((($rating_value_2*100)/$reating_all),1);?>%</div>
                </div>
                </div>
                <div class="col-md-2 col-sm-2"> <?=$rating_value_2;?></div>
              </div>
              <div class="row">
                <div class="col-md-4 col-sm-4">1 <?=$traduccion_body['estrellas'];?></div>
                <div class="col-md-6 col-sm-6" style="align-self: center;">
                  <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: <?=number_format((($rating_value_1*100)/$reating_all),1);?>%;" aria-valuenow="<?=number_format((($rating_value_1*100)/$reating_all),1);?>" aria-valuemin="0" aria-valuemax="100"><?=number_format((($rating_value_1*100)/$reating_all),1);?>%</div>
                </div>
                </div>
                <div class="col-md-2 col-sm-2"><?=$rating_value_1;?></div>
              </div>
            </div>
            <div class="col-md text-center text-capitalize" style="align-self: center;">
              <span><?=$traduccion_body['evaluacion_promedio'];?></span>
              <div class="star-ratings-css">
                <div class="star-ratings-css-top" style="width: <?=($rating_value*100)/5;?>%">
                  <span class="fa fa-star text-primary"></span>
                  <span class="fa fa-star text-primary"></span>
                  <span class="fa fa-star text-primary"></span>
                  <span class="fa fa-star text-primary"></span>
                  <span class="fa fa-star text-primary"></span>
                </div>
                <div class="star-ratings-css-bottom">
                  <span class="fa fa-star text-secondary"></span>
                  <span class="fa fa-star text-secondary"></span>
                  <span class="fa fa-star text-secondary"></span>
                  <span class="fa fa-star text-secondary"></span>
                  <span class="fa fa-star text-secondary"></span>
                </div>
              </div>
              <span class="font-weight-bold"> <?=number_format($rating_value,1);?> / 5</span>
            </div>
            
          </div>
        </div>
        </div>
        <!--/ estadistica -->
        
        
        
        <!-- revisiones o comentarios -->
        <h4 class="text-capitalize"><?=$traduccion_body['comentarios_calificacion'];?></h4>
        <p class="text-secondary"><span class="fa fa-star "></span> <?=$traduccion_body['comentarios_calificacion_msn'];?> </p>
        
        <?php echo $div_reviews; ?>

        <?php 
        if ($div_reviews_more!='') 
        { 
        ?>
          <div class="form-group">
            <a class=" text-capitalize font-weight-bold" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <?=$traduccion_body['mas_opiniones'];?> >>
            </a>  
          </div>
  
          <div class="collapse" id="collapseExample">
            <?=$div_reviews_more;?>
          </div>
        <?php 
        } 
        ?>


    <?php 
    }
    else
    {
        // echo 'sin comentario';
    } 
    ?>
    
    </div>
    </div>
        
        
    
    <!-- sidebar -->
    <div class="col-lg-3 col-12" style="margin-top: 15px;">
        <div style="position: sticky;top:100px">
            <nav class="navbar navbar-light bg-light navbar-light-custom form-group" style="border-top:2px solid #007bff">
                <h5><?=$traduccion_body['actividades_disponibles'];?></h5>
                <nav class="nav nav-pills flex-column" id="sticky-menu" style="text-transform: capitalize">
                <?php
                  foreach($resultado['actividades'] as $index => $actividad){
                  $nombre = $actividad['titulo_producto'];
                  echo "
                    <a class='nav-link' href='#".$actividad['id_producto']."'>".strtolower($nombre)."</a>
                  ";
                  }
                ?>
                </nav>
            </nav>

          <div class="content-content" style="border-top:2px solid #007bff">
            <h5><?=$traduccion_body['necesitas_ayuda'];?></h5>
            <ul class="list-inline" style="font-size:1.1em; margin-left: 0px;">
              <li><i class="fa fa-whatsapp text-success"></i> <i class="fa fa-phone text-primary"></i> 51949755305</li>
              <li><i class="fa fa-whatsapp text-success"></i> <i class="fa fa-phone text-primary"></i> 51982769453</li>
              <li><i class="fa fa-whatsapp text-success"></i> <i class="fa fa-phone text-primary"></i> 51984434731</li>
              <li><a href="<?=base_url().$language?>/checkout/ivan" target="_blank"><i class="fa fa-envelope"></i></a> reservas@incalake.com</li>
            </ul>
          </div>

          <div class="content-content" style="border-top:2px solid #007bff">
            <h5><?=$traduccion_body['reserva_con_ayuda'];?></h5>
            <hr>
            <p>
              <?=$traduccion_body['reserva_con_ayuda_descrip'];?>
            </p>
            <button type="button" class="btn btn-carrot" data-toggle="modal" style="cursor:pointer" data-target="#preguntasModal">
              <?=$traduccion_body['consultar'];?>
            </button>
           
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!--/ sidebar -->


<!-- BEGIN GTAG -->
<?php //Script para ver que productos se están mostrando en la página (view_item_list) ?>
<script type="text/javascript">
	gtag('event', 'view_item_list', {
	  "items": <?=json_encode($GTAG_ARRAY_ITEMS)?>  
	});
</script>
<!-- END GTAG -->


<style type="text/css">
    .galeria_producto{height:450px}.carousel-indicators li{width:60px;margin-right:5px;height:40px}.carousel-indicators .active{background-color:none}.galeria_producto .carousel-item{height:400px}.galeria_producto img{height:100%}.carousel-indicators{margin-bottom:3px;bottom:0}.star-ratings-css{unicode-bidi:bidi-override;color:#c5c5c5;font-size:21px;height:25px;width:100px;margin:0 auto;position:relative;padding:0;text-shadow:0 1px 0 #a2a2a2}.star-ratings-css-bottom,.star-ratings-css-top{padding:0;display:inline-flex;top:0;position:absolute;left:0}.star-ratings-css-top{color:#e7711b;z-index:1;overflow:hidden}.star-ratings-css-bottom{z-index:0}
    /*footer          */
    .title-panel.list-group-item {
        font-weight: 700;
        background: none;
        color: #aaa8a8;
        border: none;
        cursor: pointer;
    }
    .title-panel.list-group-item:hover{
        background: none;
        color: #fff;
    }
    .sublinks ul li a{
        color: #f5f5f5;
       }
       .sublinks ul li a:hover{
        color: #fff ;
       }
    footer .panel {
        background: none !important;
    }      
    
    @media screen and (max-width: 992px) {
        #accordionExample {
            display:block !important;
        }
        
        #reserve_ahora{
            display:block !important;
        }
        
        .sky-tabs{
            display:none !important;
        }
    }
</style>

<?php
//COMENTARIO PARA ELIMINAR RESTRICCION DE TABS EN MOVILES -   }
?>

<script>
    $('body').scrollspy({ target: '#sticky-menu' });
        $('.sky-tabs pre,.sky-tabs code').replaceWith(function(){
            return $("<p />", {html: $(this).html()
            
        });
    });
    
    $(document).ready(function(){
        $('.collapse').on('shown.bs.collapse', function(){
            $(this).parent().find(".fa-chevron-down").removeClass("fa-chevron-down").addClass("fa-chevron-up");
        }).on('hidden.bs.collapse', function(){
            $(this).parent().find(".fa-chevron-up").removeClass("fa-chevron-up").addClass("fa-chevron-down");
            
        });
    });
</script>

<style>
.div-activity .nav-tabs .nav-link{border-radius:0;border-style:ridge;border-width:1px;background:var(--color-complement);color:var(--color-text)}.div-activity .nav-tabs{margin:1% 0}.div-activity .nav-link.active{background:var(--color-primary)}.navbar-light-custom{background:#fff!important}.sky-tabs{font-family:Quicksand!important}.galleria-theme-classic .galleria-thumbnails-container{z-index:1}.line-header{display:block;border-bottom:1px solid #ddd!important}.line-header>div{font-size:20px;margin:0 0 -1px;padding-bottom:5px;display:inline-block;border-bottom:1px solid #007bff;font-weight:700;text-transform:uppercase;color:var(--color-text)}.faded{opacity:.5}
</style>


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
                if(parseInt(result)){
                  $('#preguntasModal').modal('hide');
                  grecaptcha.reset();
                }
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
    $('table').css('width', '100%');
    $('table thead').addClass('bg-primary text-light');

  // 
   $(document).on('click', '.nav-pills .nav-link', function(event) {
     var val = $(this).attr( "href" );
      if (val) {
          $('html,body').animate({
              scrollTop: $(val).offset().top
          }, 500);
      }

   });
   window.addEventListener('load', function() {
    var time = 1500;
    var image = new Image();
    $('.img-thumbs').each(function(i, obj) {
      
       setTimeout( function(){
        $(obj).removeClass('faded');
              $(obj).attr('src', $(obj).data('thumbs')).slideUp( 1 ).fadeIn( 1000 );
              image.src = $(obj).attr("src");


        }, time);
        time += 1000;
                    
      
      
    });
    
    setTimeout(footer, 5000);
    function footer(){
        $("footer").append(`<?=$this->load->view('footer/footer_index.php');?>`);
    }
    });

</script>
