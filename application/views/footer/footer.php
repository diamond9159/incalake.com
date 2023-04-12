<?php
//  $translate = arrayTraduccion('footer',strtolower($language));//traducciones
  //include_once 'assets/footer/ES.txt';
 // $idioma = 'ES';
?>
<div class="container-fluid container-footer">
   <div class="row">
       <div class="col-md-6 col-xs-12">
          <div class="row">
            <div class="col-sm-4 col-xs-12">
            <?php
            
                 function retornarBloques($idioma='EN'){
                    $file = 'assets/footer/';
                    $file = file_exists($file.$idioma.'.txt')?$file.$idioma.'.txt':$file.'EN.txt';
                    $texto = null;
                    if($file){
                        $myfile = fopen($file, "r");
                        $texto = @fread($myfile,filesize($file));
                        fclose($myfile);
                    }

                    return json_decode($texto,true);
                  } 
                  $partes = retornarBloques(strtoupper($language));
                  echo $partes[0];
           
            ?>
            </div>
            <div class="col-sm-4 col-xs-12">
            <?=  $partes[1];?>
            </div>
            <div class="col-sm-4 col-xs-12">
            <?=$partes[2];?>
            </div>
          </div>
       </div>
       <div class="col-md-6 col-xs-12">
          <div class="row">
            <div class="col-sm-4 col-xs-12">
            <?=$partes[3];?>
            </div>
            <div class="col-sm-4 col-xs-12">
            <?=$partes[4];?>
            </div>
            <div class="col-sm-4 col-xs-12">
            <?=$partes[5];?>
            </div>
          </div>
       </div>
   </div>
</div>
<div class="container-fluid container-footer-bottom">
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="footer-bottom text-center"><?=($language=='es'?'Derechos Reservados':'Copyrights') ?>  &copy; IncaLake <?=date('Y')."-".((Integer)date('Y')+1)?></div>
      </div>
   </div>
</div>
<style> #myCarousel-recomendacion{ padding-left: 20%; padding-right: 20%; padding-top: 5%; padding-bottom: 8%; background: transparent; } #myCarousel-recomendacion .carousel-inner{ border: outset 5px #3f79b6; /*padding-left: 10%;*/ /*padding-right: 10%;*/ background: #fff; } #myCarousel-recomendacion .item img { padding-left: 10%; padding-right: 10%; } /*-----------1*/ .div-year { position: absolute; top: 0; width: 100%; right: 0; left: 0; } .div-year .txt-year{ text-align: center; width: 100px; margin: auto; text-align: center; border: 1px solid #236b26; background-color: #2b992f; background-size: 4px 4px; color: #fff; line-height: 15px; font-weight: bold; } #myCarousel-tripadvisor{ background: #2d2d2d; } #myCarousel-tripadvisor .carousel-control.left,#myCarousel-tripadvisor .carousel-control.right,#myCarousel-recomendacion .carousel-control.left,#myCarousel-recomendacion .carousel-control.right { background-image: none; } #myCarousel-tripadvisor .item{ border-radius: 50%; background: #fff; padding: 10%; } #myCarousel-tripadvisor { padding-left: 20%; padding-right: 20%; padding-top: 5%; padding-bottom: 8%; } #myCarousel-tripadvisor .carousel-control span,#myCarousel-recomendacion .carousel-control span { background: none; border: none; opacity: 0.4; } #myCarousel-tripadvisor .carousel-control span:hover,#myCarousel-recomendacion .carousel-control span:hover { opacity: 1; } .div-cinta{ position: absolute; z-index: 1; bottom: 4%; width: 100%; left: 0; right: 0; } .cinta { position: relative; width: 130px; height: 15px; margin: auto; text-align: center; border: 1px solid #236b26; background-color: #2b992f; /* background-image: linear-gradient(0deg, rgba(255, 255, 255, .2) 50%, transparent 50%, transparent); */ background-size: 4px 4px; color: #fff; line-height: 15px; } .cinta:before { content: " "; position: absolute; display: block; width: 0px; height: 0px; top: 5px; left: -15px; border-color: #226e25 #226e25 #226e25 transparent; border-style: solid; border-width: 7px; } .cinta:after { content: ""; position: absolute; display: block; border-color: #1b541d #1b541d #226e25 #226e25; border-style: solid; border-width: 2.5px 5px; top: 14px; left: -1px; } /* ----------- */ .cinta span { text-transform:uppercase; font-family:arial; font-weight:bold; color: white; text-shadow: 1px 2px 3px grey; } .cinta span:before { content:" "; position:absolute; display:block; width:0px; height:0px; top:5px; right:-15px; border-color:#226e25 transparent #226e25 #226e25 ; border-style:solid; border-width:7px; } .cinta span:after { content:""; position:absolute; display:block; border-color:#1b541d #226e25 #226e25 #1b541d; border-style:solid; border-width:2.5px 5px; top:14px; right:-1px; }</style>
<style type="text/css"> .container-footer { /* background-color: #1a4c80 !important; */ background-color: #2D2D2D !important; color: #fff; font-family: Lato, sans-serif; padding-top: 0.7em; } .container-footer>div>div>div>ul>li>a, .link-title { color: #d0d0d0; font-weight: bold; } .container-footer>div>div>div>ul>li>a:hover, .link-title:hover { color: #fff; font-weight: bold; text-decoration: none; } .container-footer-bottom { padding-top: 0.8em; padding-bottom: 0.8em; /*font-weight: bold;*/ color: rgba(208, 208, 208, 0.62); /* background-color: #4680bd !important; */ background-color: #292929 !important; /*text-transform: uppercase;*/ } .hr-separator { margin-top: 0.5em; margin-bottom: 0.3em; border-width: 0px 0 0; } .footer-column-title { color: #fff; border-bottom: 2px solid #7e7e7e; width: 100%; margin-bottom: 0.3em; padding-top: 0.2em; } .footer-column-title strong{ margin: 0 0 -2px 0; padding-bottom: 5px; display: inline-block; border-bottom: 2px solid #ff0; font-weight: bold; text-transform: uppercase; } .footer-escribe-tu-opinion { background: #fff; border-radius: 0.1em; padding: 0.2em; } .footer-escribe-tu-opinion>ul>li>p { color: #111; } .footer-content-title{ background: #ff0; color: rgb(07,07,07); width: 100%; text-align:center; text-transform: uppercase; border-bottom: 2px solid #ff0; } .color-text-1{ color: #cccc00 !important; } .carousel-footer {} .col-xs-4 { padding: 1%; } .col-xs-3 { padding: 1%; }</style>
<style> /**css para el carousel*/ /* carousel */ #quote-carousel, #quote-carousel2 { padding: 0 10px 10px 10px; margin-top: 5px; } /* Control buttons */ #quote-carousel .carousel-control, #quote-carousel2 .carousel-control { background: none; color: white; font-size: 2.3em; text-shadow: none; margin-top: 35px; } /* Previous button */ #quote-carousel .carousel-control.left, #quote-carousel2 .carousel-control.left { left: -12px; } /* Next button */ #quote-carousel .carousel-control.right, #quote-carousel2 .carousel-control.right { right: -12px !important; } /* Changes the position of the indicators */ #quote-carousel .carousel-indicators, #quote-carousel2 .carousel-indicators { right: 50%; top: auto; bottom: 0px; margin-right: -19px; } /* Changes the color of the indicators */ #quote-carousel .carousel-indicators li, #quote-carousel2 .carousel-indicators li { background: #c0c0c0; } #quote-carousel .carousel-indicators .active, #quote-carousel2 .carousel-indicators .active { background: #333333; } #quote-carousel img, #quote-carousel2 img { width: 250px; height: 100px } /* End carousel */ .item blockquote { border-left: none; margin: 0; } .item blockquote img { margin-bottom: 10px; } .item blockquote p:before { content: "\f10d"; font-family: 'Fontawesome'; float: left; margin-right: 10px; } /** MEDIA QUERIES */ /* Small devices (tablets, 768px and up) */ @media (min-width: 768px) { #quote-carousel, #quote-carousel2 { margin-bottom: 0; padding: 0 15px 15px 15px; } } /* Small devices (tablets, up to 768px) */ @media (max-width: 768px) { /* Make the indicators larger for easier clicking with fingers/thumb on mobile */ #quote-carousel .carousel-indicators, #quote-carousel2 .carousel-indicators { bottom: -20px !important; } #quote-carousel .carousel-indicators li, #quote-carousel2 .carousel-indicators li { display: inline-block; margin: 0px 5px; width: 15px; height: 15px; } #quote-carousel .carousel-indicators li.active, #quote-carousel2 .carousel-indicators li.active { margin: 0px 5px; width: 20px; height: 20px; } }
.title-panel {
    /*display: block;*/
    color: #f5f5f5;
}

.container-footer .title-panel{
    padding: 0;
}
.panel {
    background: none;
}
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
.sublinks ul{
    list-style: none;
    padding: 0 10px;
}
.sublinks ul li{
    padding: 5px 0;
}
   .sublinks ul li a{
    color: #f5f5f5;
   }
   .sublinks ul li a:hover{
    color: #fff ;
   }
footer .carousel-inner>.item>a>img,footer .carousel-inner>.item>img{
height: auto !important;
}
footer .panel {
    background: none !important;
}
</style>

<script>
  var cartCliente;

      if(Cookies.get('cart')) {
          cartCliente = JSON.parse(Cookies.get('cart'));
      } else {
          Cookies.set('cart', []);
          cartCliente = [];

      }

      if(cartCliente.length){
         $("#count-cart").show();
         $("#count-cart").text(cartCliente.length);
      }
      else {
         $("#count-cart").hide();
      }
</script>