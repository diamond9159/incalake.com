<?php
$traduccion_body = arrayTraduccion('body',$language);
      if (!empty($destinos)) {
        ?>
<div class="col-11 col-sm-11 col-lg-10">
          <div class="row image-tour">
            <div class="col-md-12 text-center div-title"><h4 class="div-content-title">
                <strong><?=$traduccion_body['nuestros_destinos_y_actividades']?></strong></h4>
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
<?php
      }
      ?>