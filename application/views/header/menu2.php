<?php
$dir = "assets/menu/";
$file = !empty($_GET['idioma'])?$dir.$_GET['idioma'].'.txt':$dir.'ES'.'.txt';
  $json = null;
  if(file_exists($file)){
        $myfile = fopen($file, "r");
      $json = @fread($myfile,filesize($file));
      fclose($myfile);
    }

 $json = json_decode($json,true);

 function get_menu_tree($json,$parent_id=0){ 
      $menu = "";
        if(is_array(@$json[$parent_id])){
             foreach($json[$parent_id] as $key => $value){
              $cantidad = @count($json[$value['id']]);
                      $menu .="<li> 
                         <a target='_".($value['target']?'blank':'self')."' href='".($value['url']?$value['url']:'#')."'>
                           <span class='".$value['icono']."'></span> "
                           .$value['nombre'].($cantidad?' <span class="badge">'.$cantidad.'</span>':null).
                        "</a>".
                        ($cantidad?"<ul>".get_menu_tree($json,$value['id'])."</ul>":null)
                      ."</li>";
              
              }

            }
          
          return $menu;
  }
?>
  <div style="background:#1a4c80;height:50px" id="barra_superior">
  </div>
  <nav id="main-nav">
       <img style="display:none" class="logo" src="//incalake.com/img/logo-white.png" />
       <input id="main-menu-state" type="checkbox" />
        <label class="main-menu-btn" for="main-menu-state">
          <span class="main-menu-btn-icon"></span> Ver menu
        </label>
      <ul id="main-menu" class="sm sm-blue collapsed">
         <?=get_menu_tree($json);?>
      </ul>  
      <div style="clear:both"></div>
  </nav>

<script>
(function(){
  var barra_superior = $('#barra_superior');
  var main_nav = $('#main-nav');
  var alto_superior = barra_superior.outerHeight();
  $(window).scroll(function(){
      if ($(this).scrollTop() > alto_superior)main_nav.addClass('fixed-menu');
      else main_nav.removeClass('fixed-menu');   
  });
})();

 //console.log(barra_superior.outerHeight());
///////////////////////////////////////////////////////////////
  $(function() {
  var menu_principal = $('#main-menu');
  var $mainMenuState = $('#main-menu-state');
  menu_principal.smartmenus();
  if ($mainMenuState.length) {
    // animate mobile menu
    $mainMenuState.change(function(e) {
      if (this.checked) {
        menu_principal.hide().slideDown(250, function() { menu_principal.css('display', ''); });
      } else {
        menu_principal.show().slideUp(250, function() { menu_principal.css('display', ''); });
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
  margin:5px;

}
  /* hamburger icon */
  .main-menu-btn-icon, .main-menu-btn-icon:before, .main-menu-btn-icon:after {
    position: absolute;
    top: 50%;
    left: 2px;
    height: 2px;
    width: 24px;
    background: #EEE;
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
    #main-nav{
        background-image: linear-gradient(to bottom, #1e6496, #2C6B99);
    }
    @media (min-width: 768px) {
        #main-nav {
            line-height: 0;
            text-align: right;
        }
        #main-menu {
            display: inline-block;
            float:right;
        }

        #main-nav  img.logo{
            width:150px;
            float:left;
            margin:-35px 0 0 20px;
            display: inline-block !important;
            transition: all 2s;
        }
    }
   .fixed-menu{
    position: fixed !important;
    top:0;
    left: 0;
    width:100%;
    z-index:100;
   }
   .fixed-menu img.logo{
     width: 80px !important;
     margin:4px !important;
   }
 </style>
