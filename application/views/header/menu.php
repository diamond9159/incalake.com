<?php
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
  $detect = new Mobile_Detect;
  $menus_traducciones = arrayTraduccion('body',$language);
if ($detect->isMobile()) {

?>
<script type="text/javascript" src="//incalake.com/mobile/menu.all.js"></script>
   
    <!-- <link rel="stylesheet" href="//incalake.com/mobile/demo.css" /> -->
    <link rel="stylesheet" href="<?=base_url(); ?>assets/resources/mmenu/demo.css">
    <link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.m.css">
    <link rel="stylesheet" href="//incalake.com/mobile/menu.all.css" />
    
    <script type="text/javascript">
                    $(function() {
                        $("#menu").mmenu({
                        extensions      : [ "shadow-page", "theme-white", "pagedim-black" ],
                        counters        : true,
                        searchfield     : {
                            resultsPanel    : true
                        },
                        navbar          : {
                            title           : "TOURS INCALAKE"
                        },
                        navbars     : [{
                            content: [
                                '<span style="line-height: 52px;"><a href="tel:+51949755305" class="fa fa-phone"></a></span>',
                                '<span><a href="<?=base_url();?>" style="width: 100%;height: 100%;line-height: normal;border: none;"><img src="//incalake.com/img/logo_2.png" /></a></span>',
                                '<span style="line-height: 52px;"><a href="sms://+51949755305?body=I%27m%20interested%20in%20your%20product.%20Please%20contact%20me." class="fa fa-envelope"></a></span>',
                                "searchfield"
                            ]
                        }, true]
                                    }, {
                                    }).on( 'click',
                                        'a[href^="#/"]',
                                        function() {
                                            alert( "Thank you for clicking, but that's a demo link." );
                                            return false;
                                        }
                                    );
                    });

    </script>
      
            
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
                <script>
                    $(document).ready(function(){
                        var count = 0;
                        
                        
                        $('.mm-listview>li').click(function(){
                            count += 1;
                            // console.log(count); 
                            if(count==1){
                                $('.mm-hasbtns>.mm-title').css('background','#2376B1');
                            }
                            else if(count==2){
                                $('.mm-hasbtns>.mm-title').css('background','#1c84cf');
                            }
                            else{
                                $('.mm-hasbtns>.mm-title').css('background','#1E6496');
                            }   
                            // console.log(count);                     
                        });
                        $('.mm-hasbtns').click(function(){
                            count -= 1;
                            // console.log(count); 
                            if(count==1){
                                $('.mm-hasbtns>.mm-title').css('background','#2376B1');
                            }
                            else if(count==2){
                                $('.mm-hasbtns>.mm-title').css('background','#1c84cf');
                            }
                            else{
                                $('.mm-hasbtns>.mm-title').css('background','#1E6496');
                            }
                            // console.log(count); 
                        });
                        var temp_scroll=0;
                        $(window).scroll(function(event){
                           var st = $(this).scrollTop();
                           // console.log(st);

                                if (st > 106){
                                   $('.header').css({'position':'fixed','top': '0px'});
                               }else {
                                  $('.header').css({'position':'relative','top': 'auto'});
                               }
                           temp_scroll=st;
                        });
                        
                        $('.precio_tour_gral').parent().css('margin','0px');
                        // console.log($('.precio_tour_gral').parent().parent().html());
                        $(document).ready(function(){
                        $('#div-mm-close,.mm-blocker').click(function(){
                              $('#menu').removeClass("mm-opened");
                              $('html').removeClass('mm-opened mm-blocking mm-background mm-opening');
                            });
                        $('.header>a').click(function(){
                             $('#menu').addClass("mm-opened");
                             $('html').addClass('mm-opened mm-blocking mm-background mm-opening');
                        });
                        // $('.mm-search').addClass('fa fa-search');
                        $('.mm-search').prepend('<div class="input-group-addon fa fa-search" style="width: auto;float: left;border: none;"></div>');
                        $('.mm-search input').css({'max-height': '33px','height': '33px','width':'87%'});
                        // $('#page .header').append('<spam class=" pull-right" style="line-height: 30px;background: red;margin: 5px 0px;padding: 0px 5px;"><a hreft="/*" style="position: relative;width: auto;height: auto;background: none;left: auto;color: #f5f5f5;">Reservar</a></spam>');
                        
                        var temp_lag_html=document.documentElement.lang;
                        console.log(temp_lag_html.toUpperCase());
                        if (temp_lag_html.toLowerCase()=='es') {
                            $(".mm-search input").attr("placeholder", "Busque su destino: ejemplo: Uros, Machupicchu, Uyuni, etc");
                        }else{
                            $(".mm-search input").attr("placeholder", "Find your destination: e.g. Uros, Machupicchu, Uyuni, etc");
                        }

                      });  
                    });

                </script>
<style>
                  .mm-search{
                        display: inline-flex !important;
                  }
                  .mm-listview>li>a, .mm-listview>li>span {
                      white-space: normal;
                  }
                </style>
<?php
}else{
?>
<link href='<?=base_url(); ?>assets/resources/css/sm-core-css.css' rel='stylesheet' type='text/css' />
    <link href='<?=base_url(); ?>assets/resources/css/sm-blue/sm-blue-2.css' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.css">
    <script src="<?=base_url(); ?>assets/resources/js/jquery.smartmenus.min.js"></script>


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
<li><a  class="btn-search-button-menu " href=""><span class="fa fa-search" style="display: block !important;"></span></a></li>
     </ul>
    <div style="clear:both"></div>
  </nav>

  <script>
      $(function() {
      var $mainMenuState = $('#main-menu-state');
      if ($mainMenuState.length) {
        // animate mobile menu
        $mainMenuState.change(function(e) {
          var $menu = $('#main-menu');
          if (this.checked) {
            $menu.hide().slideDown(250, function() { $menu.css('display', ''); });
          } else {
            $menu.show().slideUp(250, function() { $menu.css('display', ''); });
          }
        });
        // hide mobile menu beforeunload
        $(window).on('beforeunload unload', function() {
          if ($mainMenuState[0].checked) {
            $mainMenuState[0].click();
          }
        });
        }
      });
  </script>



    </div>

    
<script type="text/javascript">
$(function() {
  $('#main-menu').smartmenus();
});

  $(document).ready(function(){
    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
      event.preventDefault(); 
      event.stopPropagation(); 
      $(this).parent().siblings().removeClass('open');
      $(this).parent().toggleClass('open');
    });
  });
  /**/
  var primera_barra = $('.div-header-main');
  /**/
  $(window).scroll(function(event){
    var st = $(this).scrollTop();  
    var el_menu = $('.incalake-menu');
    //console.log(el_menu.height());
    // console.log(st);
    if (st > primera_barra.height())el_menu.addClass('menu_fixed')
    else el_menu.removeClass('menu_fixed');
    
    temp_scroll=st;
  });

</script>
<?php
}
?>
<script type="text/javascript">
  $(document).on('click', '.btn-search-button-menu', function(event) {
    event.preventDefault();
  $("#searchGoogleModal2").modal();
  $('#search_modal').focus();
});
</script>