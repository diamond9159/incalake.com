<?php
$traduccion_body = arrayTraduccion('body',$language);
if(!empty($oferta))
{
?>   

  <div class="col-11 col-sm-11 col-lg-10">
    <hr class="col-md-12">
    <div class="row">
    
      
      <div class="col-md-12 text-center div-title">
        <h4 class="div-content-title">
          <strong><?=$traduccion_body['nuestras_ofertas_del_mes']?></strong>
        </h4>
      </div>

      <?php
      foreach ($oferta as $key => $value) 
      {
        if ($key<=2) 
        {        
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
            <?php 
            if (!empty($value['duracion'][0])) 
            {
            ?>
              <i class="fa fa-clock-o"></i> <span><?=mb_strtolower($value['duracion'][0]); ?></span>
              <br><i class="fa fa-clock-o"></i> <span><?=$value['horarios']; ?></span>
            <?php 
            } 
            ?>
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
      }
      elseif($key == 3 && count($value) > 3)
      {
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
              <?php 
              if (!empty($value['duracion'][0])) 
              {
              ?>
                <i class="fa fa-clock-o"></i> <span><?=mb_strtolower($value['duracion'][0]); ?></span>
                <br><i class="fa fa-clock-o"></i> <span><?=$value['horarios']; ?></span>
              <?php 
              } 
              ?>
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
      
    </div>
  </div>

<?php
}
?>