<?php
$traduccion_body = arrayTraduccion('body',$language);

$type = !empty($type_mas_comprados) ? $type_mas_comprados : 0;

if(!empty($mas_comprados))
{
?>       

  <div class="col-11 col-sm-11 col-lg-10">
    
    <hr class="col-md-12">
    
    <div class="row">
    
      <div class="col-md-12 text-center div-title">
        <h4 class="div-content-title">
          <strong><?=$traduccion_body['actividades_mas_vendidas']?></strong>
        </h4>
      </div>

      <?php
      foreach ($mas_comprados as $key => $value) 
      {
        if($key <= 2 && $type) 
        {        
      ?>
      
      <div class="col-12 col-sm-6 col-md-3 col-xl-3">
        <div class="targeta">
          <div class="thumbnail"> 
            <a href="<?=$value['url']; ?>"><img src="<?=$value['imagen']; ?>"></a>
            <span class="categoria"><?=mb_strtolower($value['categoria']); ?></span>
          </div>
          <div class="contenido">
            <div class="titulo">
              <a href="<?=$value['url']; ?>"><?= mb_strtoupper($value['actividad']); ?></a>
            </div>
            <div class="duracion">
            <?php 
            if(!empty($value['duracion'][0])) 
            {
            ?>
              <i class="fa fa-clock-o"></i> <span><?=mb_strtolower($value['duracion'][0]); ?></span>
              <br><i class="fa fa-clock-o"></i> <span><?=$value['horarios']; ?></span>
            <?php 
            } 
            ?>
            </div>
            <div class="fecha"></div>
          </div>
          <div class="extra">
            <div class="precio">
              <span class="txt-precio-desde"><?=$value['txt_precio']; ?></span>
              <span class="oferta">$<?=$value['precio_normal']; ?></span>
            </div>
            <div class="explorar">
              <a href="<?=$value['url']; ?>"><?=$value['txt_more_info']; ?>>></a>
            </div>
          </div>
        </div>
      </div>
      
      <?php
      }
      elseif($key == 3 && count($value) > 3 && $type)
      {
      ?>
        <div class="col-12 col-sm-6 col-md-3 col-xl-3">
          <div class="targeta targeta-ver-ofertas">
            <div class="thumbnail"> 
              <a href="<?=$value['url']; ?>"><img src="<?=$value['imagen']; ?>"></a>
              <span class="categoria"><?=mb_strtolower($value['categoria']); ?></span>
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
              <div class="fecha"></div>
            </div>
            <div class="extra">
              <div class="precio">
                <span class="txt-precio-desde"><?=$value['txt_precio']; ?></span>
                 <span class="oferta">$<?=$value['precio_normal']; ?></span>
              </div>
              <div class="explorar">
                <a href="<?=$value['url']; ?>"><?=$value['txt_more_info']; ?>>></a>
              </div>
            </div>
            <div class="div-content-ofertas" >
              <div class="div-count-ofertas">
                <span class="num"><?=count($mas_comprados); ?></span> 
                <br> 
                <?=$txt_super;?> 
                <br>
                <?= $txt_ventas; ?>
              </div>
              <div class="div_ver_ofertas">
                <a href="<?=$url_mas_superventas;?>">
                  <span><?=$txt_ver_superventas;?></span>
                </a>
              </div>
            </div>
          </div>
        </div>
  
        <?php
        }else if(!$type)
        {
        ?>

        <div class="col-12 col-sm-6 col-md-3 col-xl-3">
          <div class="targeta">
            <div class="thumbnail"> 
              <a href="<?=$value['url']; ?>"><img src="<?=$value['imagen']; ?>"></a>
              <span class="categoria"><?=mb_strtolower($value['categoria']); ?></span>
            </div>
            <div class="contenido">
              <div class="titulo">
                <a href="<?=$value['url']; ?>"><?=mb_strtoupper($value['actividad']); ?></a>
              </div>
              <div class="duracion">
              <?php 
              if(!empty($value['duracion'][0])) 
              {
              ?>
                <i class="fa fa-clock-o"></i> <span><?=mb_strtolower($value['duracion'][0]); ?></span>
                <br><i class="fa fa-clock-o"></i> <span><?=$value['horarios']; ?></span>
              <?php 
              } 
              ?>
              </div>
              <div class="fecha"></div>
            </div>
            <div class="extra">
              <div class="precio">
                <span class="txt-precio-desde"><?=$value['txt_precio']; ?></span>
                <span class="oferta">$<?=$value['precio_normal']; ?></span>
              </div>
              <div class="explorar">
                <a href="<?=$value['url']; ?>"><?=$value['txt_more_info']; ?>>></a>
              </div>
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