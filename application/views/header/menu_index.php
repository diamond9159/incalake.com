<?php
// $this->load->view('php/mobile-detect/Mobile_Detect.php');
$dir = "assets/menu/";
$file = $dir.strtoupper($language).'.txt';
$file = file_exists($file)?$file:$dir.'EN'.'.txt';
  $json = null;
 
        $myfile = fopen($file, "r");
      $json = @fread($myfile,filesize($file));
      fclose($myfile);
    

 $json = json_decode($json,true);
 function get_menu_tree($json,$parent_id=0,$window=0){ 
      $menu = "";
        if(is_array(@$json[$parent_id])){
             foreach($json[$parent_id] as $key => $value){
                 if(!empty($value['nombre'])){
                     $cantidad = @count($json[$value['id']]);
                     $menu .="<li ".((trim($value['background'])&&$window)?"style='border-left:solid 2px ".$value['background']."'":null)."> 
                         <a ".($window?null:"style='background:".$value['background'])."' target='_".($value['target']?'blank':'self')."' href='".($value['url']?$value['url']:'#')."'>
                           <span class='".$value['icono']."'></span> "
                           .$value['nombre'].
                        "</a>".
                        ($cantidad?"<ul>".get_menu_tree($json,$value['id'])."</ul>":null)
                      ."</li>"; 
                 }
              
              }

            }
          
          return $menu;
  }
 function get_menuMobile_tree($json,$parent_id=0,$window=0){ 
      $menu = "";
        if(is_array(@$json[$parent_id])){
             foreach($json[$parent_id] as $key => $value){
                 if(!empty($value['nombre'])){
                     $cantidad = @count($json[$value['id']]);
                     $menu .="<li ".((trim($value['background'])&&$window)?"style='border-left:solid 2px ".$value['background']."'":null).">".($cantidad?"<span><span class='".$value['icono']."'></span> ".$value['nombre']."</span>":"
                         <a ".($window?null:"style='background:".$value['background']."'")." target='_".($value['target']?'blank':'self')."' href='".($value['url']?$value['url']:'#')."'>
                           <span class='".$value['icono']."'></span> "
                           .$value['nombre'].
                        "</a>").
                        ($cantidad?"<ul>".get_menuMobile_tree($json,$value['id'])."</ul>":null)
                      ."</li>"; 
                 }
              
              }

            }
          
          return $menu;
  }
  // $detect = new Mobile_Detect;
  $menus_traducciones = arrayTraduccion('body',$language);
if ($style) {

?>     
            
                <div id="page" class="row">
                    <div class="header col">
                        <a href="#menu" ></a>
                        <!-- <span>INCALAKE</span> -->
                        <!-- <div class=""> -->
                          <!-- </div> -->
                          <div class="dropdown">
                              <span class="menu-div-cart pull-right btn btn-md dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="fa fa-ellipsis-v"></span>
                            </span>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="<?=base_url()?>">
                                  <span class="fa fa-home"> </span>
                                  <?=($language=='es'?'Inicio':'Home')?> 
                                </a>
                                <a class="dropdown-item" href="<?=base_url().$language.'/'.($language=='es'?'ofertas':'offers')?>">
                                  <span class="fa fa-percent"> </span>
                                  <?=($language=='es'?'Oferta':'Offers')?> 
                                </a>
                              <a class="dropdown-item" href="<?=base_url().$language.'/'.($language=='es'?'destinos':'destinations')?>">
                                  <span class="fa fa-map-signs"></span>
                                  <?=($language=='es'?'Destinos':'Destinations')?> 
                              </a>
                              <!-- <div class="dropdown-divider"></div> -->
                              <!-- <a class="dropdown-item"> ES</a>  -->
                              </div>
                          </div>
                            <div class="dropdown">
                              <span class="menu-div-cart pull-right btn btn-md dropdown-toggle" role="button" id="dropdownIdioma" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="<?=strtolower(preg_match('[EN|en]',$language)?'us':$language);?> flag"></i>
                                 <?=$language;?>
                              </span>
                              <div class="dropdown-menu" aria-labelledby="dropdownIdioma">
                              <a class="dropdown-item" href="<?=base_url()?>es"><i class="es flag"></i><strong>ES</strong></a>
                              <a class="dropdown-item" href="<?=base_url()?>en"><i class="us flag"></i><strong>EN</strong></a>
                              <a class="dropdown-item" href="<?=base_url()?>fr"><i class="fr flag"></i><strong>FR</strong></a>
                              <a class="dropdown-item" href="<?=base_url()?>de"><i class="de flag"></i><strong>DE</strong></a>
                              <?php
                                  foreach($menu_language as $menu){
                                    /*if($menu['codigo'] == 'ES' || $menu['codigo'] == 'EN' || $menu['codigo'] == 'FR' || $menu['codigo'] == 'DE')
                                    continue;*/
                                    if(preg_match("[ES|EN|FR|DE]",$menu['codigo']))continue;//better
                                    $tmp_base_url = base_url(mb_strtolower($menu['codigo'])).'/';
                                    $tmp_id_link = "link-lang-".mb_strtolower($menu['codigo']);
                                    $tmp_cod_lang = $menu['codigo'];
                                    $tmp_cod_lang_icon=strtolower($menu['codigo']);
                                    echo "<a href='$tmp_base_url' id='$tmp_id_link' class='dropdown-item'><strong><i class='$tmp_cod_lang_icon flag'></i> $tmp_cod_lang</strong></a>";
                                  }
                                ?>
                              <!-- <div class="dropdown-divider"></div> -->
                              <!-- <a class="dropdown-item"> ES</a>  -->
                              </div>
                            </div>
                          

                        

<a href="/<?=$language?>/checkout/cart" class="menu-div-cart pull-right btn btn-md" style="position: relative;color: #ddd;">
                          <span class="fa fa-shopping-cart"></span>
<span class="badge badge-pill badge-danger" id="count-cart" style="position: absolute; right: 0px; top: 0px; display: block;"></span>
</a>
                        
                        <span class="menu-div-search pull-right btn btn-md btn-search-button-mobile">
                          <span class="fa fa-search"> </span>
                        </span>
                        <!-- <spam class="div-reservar pull-right" style="line-height: 30px;background: red;margin: 5px 0px;padding: 0px 5px;">
                                <a href="" style="position: relative;width: auto;height: auto;background: none;left: auto;color: #f5f5f5;">
                                <?= $menus_traducciones['reservar'] ?>
                                  
                                </a>
                        </spam> -->
                        
                    </div>
                <nav id="menu">
                <span id="div-mm-close" class="fa fa-close" style="position: absolute;height: 30px;width: 40px;top: 0;right: 0; z-index: 3;font-size: x-large;padding: 5px;color: #b3b3b3;"></span>
                <ul>
                      <?=get_menuMobile_tree($json,0,true);?>    
                                    
                </ul>
                </nav>
                <!-- <h1>Esto es mobil</h1> -->

<?php
}else{
?>



    <nav  class="incalake-menu">
      <input id="main-menu-state" type="checkbox" />
      <label class="main-menu-btn" for="main-menu-state">
       <span class="main-menu-btn-icon"></span> Ver menu
      </label>
      <a href="<?=base_url()?>" style="float: right;
          line-height: 42px;
          color: white;
          padding-right: 16px;" class="d-md-none">
          Incalake 
      </a>
     <a href="<?=base_url()?>"><img src="//incalake.com/img/logo-white.png" id="logo_principal" /></a>
     <ul id="main-menu" class="sm sm-blue collapsed">
       <?=get_menu_tree($json);?>
     </ul>
    <div style="clear:both"></div>
  </nav>



    </div>

<?php
}
?>
