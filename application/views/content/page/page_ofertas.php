<?php
//echo json_encode($oferta);
$traduccion_body = arrayTraduccion('body',$language);
?>
<div class="container-fluid">
  <div class="row justify-content-center">
      <div class="col-11 col-sm-11 col-lg-10">
        <div class="row">
          <div class="col-md-12 text-center div-title">
            <hr>
            <h4 class="div-content-title">
              <strong>
                <?=$traduccion_body['nuestras_ofertas_del_mes']?>
              </strong>
            </h4>
            <hr>
          </div>
          <!--div class="col-md-12 text-center div-title">
            <div class="alert alert-danger">
              <div class="row">
                <div class="col-md-6">
                   <p><span><?=$language=='es'?'Ofertas termina en':'Offers ends on';?></span></p>
                </div>
                <div class="col-md-6">
                    <p id="t_restante">
                      -- -- -- --
                    </p>
                </div>
             </div>
           </div>
          </div-->

<div id="message_counter" class="col-md-12 text-center div-title">
    <div class="row" >
      <div class="col-lg-4">
      </div>
      <div class="col-lg-4">
          <div id="inner-message" class="alert alert-danger" style="background:white">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <p style="font-size: 1.2em"><strong><?=$language=='es'?'Ofertas terminan en':'Offers ends on';?></strong></p>
              <p id="t_restante">
                      -- -- -- --
              </p>
          </div>
      </div>
      <div class="col-lg-4">
      </div>
    </div>
</div>

          <?php
          if (!empty($oferta)) {
              foreach ($oferta as $offer) {
              $o_nombre   = $offer['actividad'];
              $o_duracion = $offer['duracion'][0]?"<i class='fa fa-clock-o'></i> <span>".$offer['duracion'][0]."</span>":'';
              $o_categoria= $offer['categoria']?$offer['categoria']:'';
              $o_horarios = $offer['horarios']?"<br><i class='fa fa-clock-o'></i> <span>".$offer['horarios']."</span>":"";
              $p_restantes = "<br><i class='fa fa-user'></i> <span class='text-danger'>".$offer['pasajeros_restantes']."</span>";
              $o_imagen   = $offer['imagen'];
              $o_oferta   = $offer['oferta'];
              $o_p_normal = $offer['precio_normal'];
              $o_p_pferta = $offer['precio_oferta'];
              $o_info     = $offer['txt_more_info'];
              $o_t_precio = $offer['txt_precio'];
              $o_url      = $offer['url'];
              
              echo "
              <div class='col-12 col-sm-6 col-lg-4 col-xl-3'>
                <div class='targeta'>
                  <div class='thumbnail'>
                    <a href='$o_url'><img src='$o_imagen'></a>
                    <span class='categoria'>$o_categoria</span>
                    <span class='descuento'>-$o_oferta</span>
                  </div>
                  <div class='contenido'>
                    <div class='titulo'>
                      <a href='$o_url'>$o_nombre</a>
                    </div>
                    <div class='duracion'>
                      $o_duracion
                      $o_horarios
                      $p_restantes
                    </div>
                    <div class='fecha'>
                      <!--<i class='fa fa-calendar'></i> <span>Hasta 12-septiembre-2017</span>-->
                    </div>
                  </div>
                  <div class='extra'>
                    <div class='precio'>
                      <span class='txt-precio-desde'>$o_t_precio</span>
                      <span class='oferta'>$o_p_pferta</span>
                      <span class='normal'>$o_p_normal</span>
                    </div>
                    <div class='explorar'>
                      <a href='$o_url'>$o_info>></a>
                    </div>
                  </div>
                </div>
              </div>
              ";
  
            }
          }else{
            echo $language=='es'?'<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> Este mes no tenemos ofertas disponibles.</div>':'<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> This month we have no offers available.</div>';
          }
          
          ?>
        </div>
      </div>
  </div>
</div>