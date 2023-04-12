<?php
$dir = "../assets/menu/";
$file = !empty($_GET['idioma'])?$dir.$_GET['idioma'].'.txt':$dir.'ES'.'.txt';
  $json = null;
  if(file_exists($file)){
        $myfile = fopen($file, "r");
      $json = @fread($myfile,filesize($file));
      fclose($myfile);
    }

//$hola = include('web/assets/menu/ES.txt');
  $json = json_decode($json,true);
  




      function get_menu_tree($parent_id=0) 

{ 
  global $json;
        $menu = "";
       if(is_array(@$json[$parent_id])){
         foreach($json[$parent_id] as $key => $value){
          //var_dump($json[$parent_id]);
          $cantidad = @count($json[$value['id']]);
                  $menu .="<li> 
                     <a target='_".($value['target']?'blank':'self')."' href='".($value['url']?$value['url']:'#')."'>
                       <span class='".$value['icono']."'></span> "
                       .$value['nombre'].($cantidad?' <span class="badge">'.$cantidad.'</span>':null).
                    "</a>".
                    ($cantidad?"<ul>".get_menu_tree($value['id'])."</ul>":null)
                  ."</li>";
          }
        }
          return $menu;
      }
      //echo get_menu_tree();
      $detect=false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
   <link rel="stylesheet" href="//incalake.com/estilos/css/font-awesome.min.css" media="all" onload="if(media!='all')media='all'">

</head>
<body>
  <?php
  if ($detect) {
    ?>
    <script type="text/javascript" src="//incalake.com/mobile/menu.all.js"></script>
   
    <link rel="stylesheet" href="//incalake.com/mobile/demo.css" />
    <link rel="stylesheet" href="//incalake.com/mobile/menu.all.css" />
    <style type="text/css">
      .header {
          z-index: 2;
      }
      .header a {
          top: auto;
      }
      .mm-navbars-top>div:first-child {
          height: 100%;
      }
      .mm-navbars-top .mm-navbar span a {
          border: 1px solid rgb(51, 122, 183);
          border-radius: 40px;
          color: rgb(51, 122, 183) !important;
          font-size: 16px !important;
          line-height: 40px;
          width: 40px;
          height: 40px;
          padding: 0;
      }
      .mm-navbars-top .mm-navbar span:first-child {
          padding-right: 4%;
      }
      .mm-navbars-top .mm-navbar span:first-child a {
          float: right;
      }
      .mm-navbars-top .mm-navbar span:nth-child(3) {
          padding-left: 4%;
      }
      .mm-navbars-top .mm-navbar span:nth-child(3) a {
          float: left;
      }
      .mm-navbars-top .mm-navbar:first-child {
          margin: 0;
          padding: 0;
          height: 100%;
          position: relative;
          display: inline-block;
      }
      .mm-navbar>* {
          width: 33.33%;
          display: inline-block;
      }
      .mm-navbar span>img {
          width: 100%
      }
      .mm-navbar .mm-search {
          width: 100%;
      }
      .mm-menu.mm-offcanvas.mm-opened {
          z-index: 4;
      }
      div#mm-0 {
          transform: none;
      }
      .mm-menu.mm-offcanvas {
          width: 90%;
      }
      .mm-navbar.mm-hasbtns {
          padding: 0;
      }
      .mm-navbar .mm-title {
          text-overflow: inherit;
          white-space: nowrap;
          overflow: inherit;
          width: 100%;
          background: #1E6496;
          color: #f5f5f5 !important;
      }
      .mm-listview>li>a,
      .mm-listview>li>span {
          white-space: normal;
      }
      .mm-menu.mm-theme-white .mm-divider {
          background: rgb(103, 137, 215);
          color: #fff;
      }
      .mm-listview li.div-mm-category {
          padding: 5px;
          background: #96989b;
          width: 100%;
          color: #fff;
      }
      .mm-menu.mm-theme-white .mm-divider li.div-mm-category {
          background: rgb(184, 185, 187);
          font-weight: normal;
      }
      .mm-listview .mm-divider {
          white-space: normal;
          font-size: 12px;
      }
      .mm-prev:before {
          border-color: #f5f5f5 !important;
      }
      .mm-hasnavbar-top-2 .mm-panels {
          top: 180px;
      }
      .mm-navbar .mm-btn {
          height: 100%;
      }
      .mm-panels,
      .mm-panels>.mm-panel {
          /*    position: relative;
              top: auto;*/
      }
      .mm-navbars-bottom,
      .mm-navbars-top {
          position: relative;
      }
      .mm-hasnavbar-top-2 .mm-panels {
          /*top: auto;*/
      }
      .header {
          background: #1e6496;
      }
      #mm-1 .mm-listview li:nth-last-child(2) span {
          color: #fff;
          background: #21961e;
      }
      #mm-1 .mm-listview li:nth-last-child(2) .mm-counter {
          color: #fff;
      }
      #mm-1 .mm-listview li:nth-last-child(2) .mm-next:after {
          border-color: rgba(255, 255, 255, 0.73);
      }
    </style>
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
                                '<span><img src="//incalake.com/img/logo_2.png" /></span>',
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
      
            
                <div id="page">
                    <div class="header">
                        <a href="#menu" ></a>
                        INCALAKE 
                        <!-- <spam class="div-reservar pull-right" style="line-height: 30px;background: red;margin: 5px 0px;padding: 0px 5px;"><a href="<?=$menus[count($menus)-1]['url'][isset($lang)?$lang:'es'] ?>" style="position: relative;width: auto;height: auto;background: none;left: auto;color: #f5f5f5;">
                                <?= $menus[count($menus)-1]['name'][isset($lang)?$lang:'en'] ?></a>
                            </a></spam> -->
                    </div>
                <nav id="menu">
                <span id="div-mm-close" class="fa fa-close" style="position: absolute;height: 30px;width: 40px;top: 0;right: 0; z-index: 3;font-size: x-large;padding: 5px;color: #b3b3b3;"></span>
                <ul>
                      <?=get_menu_tree();?>    
                                    
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
                        $('.mm-search input').css('width','87%');
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
  <?php
  }else{
    ?>
    <link href='//localhost/web/assets/resources/css/sm-core-css.css' rel='stylesheet' type='text/css' />
    <link href='//localhost/web/assets/resources/css/sm-blue/sm-blue-2.css' rel='stylesheet' type='text/css' />
    <script src="//localhost/web/assets/resources/js/jquery.smartmenus.min.js"></script>
    <nav style="background: #454545">
     <input id="main-menu-state" type="checkbox" />
    <label class="main-menu-btn" for="main-menu-state">
      <span class="main-menu-btn-icon"></span> Ver menu
    </label>
  
    <ul id="main-menu" class="sm sm-blue collapsed">
       <?=get_menu_tree();?>
    </ul>
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
<style type="text/css">
  .main-menu-btn {
  position: relative;
  display: inline-block;
  width: 28px;
  height: 28px;
  text-indent: 28px;
  white-space: nowrap;
  overflow: hidden;
  cursor: pointer;
  -webkit-tap-highlight-color: rgba(0,0,0,0);
}
  /* hamburger icon */
  .main-menu-btn-icon, .main-menu-btn-icon:before, .main-menu-btn-icon:after {
    position: absolute;
    top: 50%;
    left: 2px;
    height: 2px;
    width: 24px;
    background: #bbb;
    -webkit-transition: all 0.25s;
    transition: all 0.25s;
  }
  .main-menu-btn-icon:before {
    content: '';
    top: -7px;
    left: 0;
  }
  .main-menu-btn-icon:after {
    content: '';
    top: 7px;
    left: 0;
  }
  /* x icon */
  #main-menu-state:checked ~ .main-menu-btn .main-menu-btn-icon {
    height: 0;
    background: transparent;
  }
  #main-menu-state:checked ~ .main-menu-btn .main-menu-btn-icon:before {
    top: 0;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }
  #main-menu-state:checked ~ .main-menu-btn .main-menu-btn-icon:after {
    top: 0;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
  }
  /* hide menu state checkbox (keep it visible to screen readers) */
  #main-menu-state {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    border: 0;
    padding: 0;
    overflow: hidden;
    clip: rect(1px,1px,1px,1px);
  }
  /* hide the menu in mobile view */
  #main-menu-state:not(:checked) ~ #main-menu {
    display: none;
  }
  #main-menu-state:checked ~ #main-menu {
    display: block;
  }
  @media (min-width: 768px) {
    /* hide the button in desktop view */
    .main-menu-btn {
      position: absolute;
      top: -99999px;
    }
    /* always show the menu in desktop view */
    #main-menu-state:not(:checked) ~ #main-menu {
      display: block;
    }
  }
  /*added by froy*/
   #main-menu > li:nth-last-child(1){
    background: linear-gradient(to bottom,  #CB4B4B,   #CD3636);
    
    }
    #main-menu > li:nth-last-child(1) a:hover{
    background: linear-gradient(to bottom,  #C62828,   #CD3636) !important;
    
    }
    #main-menu > li:nth-last-child(2){
      background: linear-gradient(to bottom,  #5AAF86,   #41A172);
    }
    #main-menu > li:nth-last-child(2) a:hover{
      background: linear-gradient(to bottom,  #41A273,   #41A172) !important;
    }
</style>


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

</script>
 <?php
  }

  ?>





                
</body>
</html>

    
      
