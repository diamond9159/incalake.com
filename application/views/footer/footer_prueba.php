
<?php
  $translate = arrayTraduccion('footer',strtolower($language));//traducciones
?>


<div class="footer navbar navbar-default">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarfooter">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>                        
    </button>
    <a class="navbar-brand" href="#">
      <span class="div-title-left hidden-xs">INCA</span><span class="div-title-right hidden-xs">LAKE</span>
      <span class="visible-xs">AIUDA</span>
    </a>
  </div>
  <div class="collapse navbar-collapse" id="navbarfooter">
    <ul class="nav nav-justified">
      <li><a href="/">contactanos</a></li>
      <li><a href="/">servicio</a></li>
      <li><a href="/">mas servicios</a></li>
      <li><a href="/">Medios de pago</a></li>
      <li><a href="/">Reconocimientos</a></li>
      <li><a href="/">Nuestra calificación</a></li>
    </ul>
  </div>
</div>

<div class="row copyright col-md-12">
  <div class="col-md-6 copy-div-left">
    <?=$translate['derechos_reservados'];?> &copy; <?=date('Y');?> | <a href=""><?=$translate['terminos_condiciones'];?></a>
  </div>
  <div class="col-md-6 copy-div-right hidden-xs">
    <ul class="bottom_ul">
      <li><a href="#"><?=$translate['nosotros'];?></a><span></span></li>
      <li><a href="#"><?=$translate['blog'];?></a></li>
      <li><a href="#"><?=$translate['faq'];?></a></li>
      <li><a href="#"><?=$translate['contactos'];?></a></li>
      <li><a href="#"><?=$translate['sitemap'];?></a></li>
    </ul>
  </div>
</div>


