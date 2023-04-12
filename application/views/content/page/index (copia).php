<?php 
  $traduccion_body = arrayTraduccion('body',$language);
?>
<div class="col-md-12">
  <!--
  <div class="pull-right">
    <?php  //echo json_encode($menu); ?>
      <?php foreach ($menu_language as $key => $value): ?>
        <a href="<?//=base_url().mb_strtolower($value['codigo']);?>"><strong><?=$value['codigo'];?></strong></a> 
      <?php endforeach ?>
  </div> 
  <br/><br/><br/><br/>
  -->
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <?php $active = ' active'; ?>
    <?php if ( count($data) === 0 ): ?>
      <? echo "Sin imágenes..!";?>
    <?php endif ?>
    <?php foreach ($data as $key => $value): ?>
      
      <div class="item <?=$active;?>">
        <img src="<?=$value['url_slider'];?>" alt="<?=$value['titulo_pagina'];?>" style="width:100%;">
        <div class="carousel-caption fadeInRight">
          <h3 class="hidden-xs"><span class="title-slider-tour "><?=$value['titulo_pagina'];?></span></h3>
          <div class="location-slider-tour"><span><?=$value['ubicacion_servicio'];?></span></div>
        </div>
      </div>

    <?php $active=""; endforeach ?>
  </div>

  <div id="custom-search-input" class="col-md-12">
        <h4 class="text-center title-header visible-xs">
          <span>
            <strong>BUSCAR VIAJE</strong>
          </span>
        </h4>
    <form id="search-form">
      <div class="input-group col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3" id="search_form_container">
          <input type="text" autocomplete="off" id="search-input" class="search-query-index form-control lg" placeholder="<?=$traduccion_body['buscar_index'];?>" data-lang="<?=$language;?>" />
          <span class="search_btn input-group-btn">
              <button class="btn btn-info" type="submit">
                  <span class="glyphicon glyphicon-search"></span>
              </button>
          </span>
           
      </div>
<!-- sugerir destinos -->
      <div id="lista_destinos">
         <table>
           <tr>
             <td>Puno</td><td>Isla de uros</td>
           </tr>
           <tr>
             <td>Bolivia</td><td>Uyuni</td>
           </tr>
           <tr>
             <td>Cusco</td><td>Valle sagrado</td>
           </tr>
           <tr>
             <td>Arequipa</td><td>Colca</td>
           </tr>
         </table>
      </div>
      <!--div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3" style="padding: 0;">
        <div id="searchList" style="position:absolute;overflow-y: scroll; max-height: 20em;width: 100%;padding: 0;" class="container-fluid">Buscar por ciudad, tour, etc.</div>
      </div-->
    </form>      
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  
</div>
<div>
<h1 class="div-title"><span class="why"><?=mb_strtoupper($traduccion_body['por_que_eligirnos']);?></span></h1>
</div>
<div class="container-fluid container-resize div-content-why">
  
  <div class="col-md-12">
  <hr>
    <div class="col-md-4 ">
      <div class="col-md-3 text-center hidden-xs hidden-sm">
        <span class="fa fa-user fa-3x div-icon-why"></span>
      </div>
      <div class="col-md-9">
        <div class="list-title-why"><?=strtoupper($traduccion_body['guias_inpecables']);?></div>
        <p><?=$traduccion_body['guias_inpecables_descripcion'];?></p>
      </div>
    </div>
    <div class="col-md-4 ">
      <div class="col-md-3 text-center hidden-xs hidden-sm">
        <span class="fa fa-map-signs fa-3x div-icon-why"></span>
      </div>
      <div class="col-md-9">
        <div class="list-title-why"><?=$traduccion_body['diversos_destinos'];?></div>
        <p><?=$traduccion_body['diversos_destinos_descripcion'];?></p>
      </div>
    </div>
    <div class="col-md-4 ">
      <div class="col-md-3 text-center hidden-xs hidden-sm">
        <span class="fa fa-commenting-o  fa-3x div-icon-why"></span>
      </div>
      <div class="col-md-9">
        <div class="list-title-why"><?=$traduccion_body['nuestro_servicio_es_respaldado_por_los_comentarios_de_usuarios'];?></div>
        <p><?=$traduccion_body['nuestro_servicio_es_respaldado_por_los_comentarios_de_usuarios_descripcion'];?></p>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="col-md-4 ">
      <div class="col-md-3 text-center hidden-xs hidden-sm">
        <span class="fa fa-usd fa-3x div-icon-why"></span>
      </div>
      <div class="col-md-9">
        <div class="list-title-why"><?=$traduccion_body['mejores_precios'];?></div>
        <p><?=$traduccion_body['mejores_precios_descripcion'];?></p>
      </div>
    </div>
    <div class="col-md-4 ">
      <div class="col-md-3 text-center hidden-xs hidden-sm">
        <span class="fa fa-thumbs-up fa-3x div-icon-why"></span>
      </div>
      <div class="col-md-9">
        <div class="list-title-why"><?=$traduccion_body['responsables'];?></div>
        <p><?=$traduccion_body['responsables_descripcion'];?></p>
      </div>
    </div>
    <div class="col-md-4 ">
      <div class="col-md-3 text-center hidden-xs hidden-sm">
        <span><span class="fa fa-envelope  fa-3x div-icon-why"></span></span>
      </div>
      <div class="col-md-9">
        <div class="list-title-why"><?=$traduccion_body['contacto_rapido_y_ayuda_rapida'];?></div>
        <p><?=$traduccion_body['contacto_rapido_y_ayuda_rapida_descripcion'];?></p>
      </div>
    </div>
  </div>
</div>
<div class="col-md-12 why">
    <div class="col-md-12 col-sm-12 col-sx-12 title-why">
      <h4 class="text-center title-header">
          <span>
            <strong><?=mb_strtoupper($traduccion_body['por_que_eligirnos']);?></strong>
          </span>
        </h4>
    </div>

    <!--div class="col-md-12 div-child-why">
      <div class="col-md-2 col-sm-2">
            <div class="div-why-icon hidden-xs">
                <span class="why-icon fa fa-user fa-4x">
                </span>
              </div>

      <div class="why_texts">
        <span class=" title-why-icon"><?=$traduccion_body['guias_inpecables'];?></span>
        <div><?=$traduccion_body['guias_inpecables_descripcion'];?></div>
      </div>
        <!--div class="panel text-center ">
              <div class="panel-heading collapsed" data-toggle="collapse" href="#collapse-guide" aria-expanded="false">
                <h4 class="panel-title"><span class=" title-why-icon"><?=$traduccion_body['guias_inpecables'];?></span></h4>
              </div>
              <div id="collapse-guide" class="panel-collapse collapse" aria-expanded="false">
                <div class="panel-body">
                  <ul>
              <li><?=$traduccion_body['guias_inpecables_descripcion'];?></li>
            </ul>
                </div>
              </div>
        </div-->

      </div>
      <div class="col-md-2 col-sm-2">
          <div class="div-why-icon hidden-xs">
            <span class="why-icon fa fa-map-signs fa-4x">
            </span>
            <div class="why_texts">
              <span class=" title-why-icon"><?=$traduccion_body['guias_inpecables'];?></span>
              <div><?=$traduccion_body['guias_inpecables_descripcion'];?></div>
            </div>
          </div>
          <!--div class="panel text-center ">
              <div class="panel-heading collapsed" data-toggle="collapse" href="#collapse-destiny" aria-expanded="false">
                <h4 class="panel-title"><span class="title-why-icon"><?=$traduccion_body['diversos_destinos'];?></span></h4>
              </div>
              <div id="collapse-destiny" class="panel-collapse collapse" aria-expanded="false">
                <div class="panel-body">
                  <ul>
                    <li><?=$traduccion_body['diversos_destinos_descripcion'];?></li>
                  </ul>
                </div>
              </div>
          </div-->

      </div>
      <div class="col-md-2 col-sm-2">
        <div class="div-why-icon hidden-xs">
            <span class="why-icon fa fa-commenting-o fa-4x">
            </span>
          </div>
          <div class="panel text-center ">
              <div class="panel-heading collapsed" data-toggle="collapse" href="#collapse-review" aria-expanded="false">
                <h4 class="panel-title"><span class="title-why-icon"><?=$traduccion_body['nuestro_servicio_es_respaldado_por_los_comentarios_de_usuarios'];?></span></h4>
              </div>
              <div id="collapse-review" class="panel-collapse collapse" aria-expanded="false" >
                <div class="panel-body">
                  <ul>
                    <li><?=$traduccion_body['nuestro_servicio_es_respaldado_por_los_comentarios_de_usuarios_descripcion'];?></li>
                  </ul>
                </div>
              </div>
          </div>

      </div>
   
      <div class="col-md-2 col-sm-2">
            <div class="div-why-icon hidden-xs">
                <span class="why-icon fa fa-usd fa-4x">
                </span>
              </div>
            <div class="panel text-center ">
              <div class="panel-heading collapsed" data-toggle="collapse" href="#collapse-best-price" aria-expanded="false">
                <h4 class="panel-title"><span class="title-why-icon"><?=$traduccion_body['mejores_precios'];?></span></h4>
              </div>
              <div id="collapse-best-price" class="panel-collapse collapse" aria-expanded="false" >
                <div class="panel-body">
                  <ul>
                    <li><?=$traduccion_body['mejores_precios_descripcion'];?></li>
                  </ul>
                </div>
              </div>
            </div>

      </div>
      <div class="col-md-2 col-sm-2">
          <div class="div-why-icon hidden-xs">
            <span class="why-icon fa fa-thumbs-up fa-4x">
            </span>
          </div>
          <div class="panel text-center ">
              <div class="panel-heading collapsed" data-toggle="collapse" href="#collapse-responsible" aria-expanded="false">
                <h4 class="panel-title"><span class="title-why-icon"><?=$traduccion_body['responsables'];?></span></h4>
              </div>
              <div id="collapse-responsible" class="panel-collapse collapse" aria-expanded="false" >
                <div class="panel-body">
                  <ul>
                    <li><?=$traduccion_body['responsables_descripcion'];?></li>
                  </ul>
                </div>
              </div>
            </div>

      </div>
      <div class="col-md-2 col-sm-2">
        <div class="div-why-icon hidden-xs">
            <span class="why-icon fa fa-envelope fa-4x">
            </span>
          </div>
          <div class="panel text-center ">
              <div class="panel-heading collapsed" data-toggle="collapse" href="#collapse-fast-contanct" aria-expanded="false">
                <h4 class="panel-title"><span class="title-why-icon"><?=$traduccion_body['contacto_rapido_y_ayuda_rapida'];?></span></h4>
              </div>
              <div id="collapse-fast-contanct" class="panel-collapse collapse" aria-expanded="false" >
                <div class="panel-body">
                  <ul>
                    <li><?=$traduccion_body['contacto_rapido_y_ayuda_rapida_descripcion'];?></li>
                  </ul>
                </div>
              </div>
            </div>

      </div>
    </div-->
    <!-- tours destacados -->
    <div style="clear:both"></div>
    <div class="panel panel-primary">
      <div class="panel-heading">Tours mas valorados</div>
      <div class="panel-body tours_valorados">
        <?php 
       //var_dump($tours_valorados);
       $html = '';
       foreach($tours_valorados as $value){
          $html .= '<div class="col-sm-2"><a href="'.$value['url_servicio'].'"><img src="'.base_url().'galeria/admin/relateds/'.$value['carpeta_archivo'].'/'.$value['url_archivo'].'"><span>'.$value['titulo_pagina']."</span></a></div> \n";
       }
       echo $html;
    ?>
    <div style="clear:both"></div>
      </div>
    </div>

    <style>
      .tours_valorados{
        margin: 0 0 10px 0;
      }
      .tours_valorados>div{
       padding: 2px;
      }
      .tours_valorados>div>a{
        border:1px solid #D7CDC8;
        box-shadow:1px 1px 1px #CCC;
        display: block;
        text-decoration: none;
      }
      .tours_valorados>div>a:hover span{
        text-shadow:0 0 3px #3D669D;
      }
      .tours_valorados>div img{
        width: 100%;

      }
      .tours_valorados>div span{
        position: relative;
        top:-50px;
        display:block;
        font:bold 1em sans;
        padding:5px;
        color:white;
        text-shadow: 0 0 3px #000;
      }
      #search_form_container{
        border:2px solid #1B914A;
        border-radius:5px;
        background:#1B914A;

      }
      #search-input{
        padding:10px !important;
        background:white;
        height:50px;
        border-right:none;
        font:normal 1.2em sans;
        border:none;

      }
      .search_btn{
        padding:0 !important;
      }
      .search_btn button.btn{
        height:100% !important;
        width:100%;
        margin:0;padding:0;width: 50px;
        border:none;
        background:#1B914A;
      }
      .search_btn button.btn:hover, .search_btn button.btn:active{
        background:#0A833A;

      }
      #lista_destinos{
        background: #1B914A;
        display: none;
        border-radius:0 0 5px 5px;
      }
      @media (min-width:768px){
        #lista_destinos{
        width:50%;
        margin-left:25%;
        }
      }
      #lista_destinos table{
        width: 99%;
        margin:auto;
        color:white;
      }
       #lista_destinos table td{
        border:1px solid #429664;
        padding:3px;
        cursor:pointer;
       }
       #lista_destinos table td:hover{
        background: #429664;
       }
    </style>
    <script type="text/javascript">
      $('.tours_valorados span').each(function(){
        $(this).css('margin-bottom','-'+$(this).height()+'px');
      });

      var lista_destinos = $('#lista_destinos');
      var search_form_container = $('#search_form_container');
      var search_input = $('#search-input');
      lista_destinos.find('td').click(function(){search_input.val(this.innerText)});
      function showDestinos(){
        lista_destinos.slideDown();
        search_form_container.css('border-radius','5px 5px 0 0');

      }
       function hideDestinos(){
        lista_destinos.slideUp();
        search_form_container.css('border-radius','5px');

      }
      search_input.focus(showDestinos).keyup(function(){
          if($(this).val().length>0)hideDestinos();
          else showDestinos();
          
        }).blur(function(){hideDestinos();});
    </script>
    <!-- end tours destacados -->
</div>


<style type="text/css">
ul.list-group{
  z-index: 1;
  position: relative;
}
  #searchList ul>li:hover{
    background-color: #1570a6 !important;
    color: white;
    font-weight: bold; 
    
  }
  /*POR QUE*/
  @media(min-width:768px){
    .panel-icon{
      float: none !important;
    }
  }
.panel-icon{
      padding: 5px;
    }

  .title-why,.div-child-why {
    padding: 0;
  }
.title-why h1{
      
    color: #fff;
}
/*span why*/
.span-why {
    border: 1px solid #ccc;
    border-radius: 2px;
    background: #eee;
}
.typography .text-success {
    color: #53b855;
}
/*CARUSEL CUSTOM*/
.carousel-indicators li {
    width: 22px;
    height: 5px;
    border-radius: 0px;
    background: #f5f5f5;
}
.carousel-indicators .active {
    width: 22px;
    height: 5px;
    margin: 0;
    background-color: #1984c4;
    border: 1px solid rgba(25, 132, 196, 0.55);
}
.carousel-caption .title-slider-tour {
  background: var(--color-primary);
  padding: 1%;
}
.carousel-caption .location-slider-tour{
  margin: 2%;
}
.carousel-caption .location-slider-tour span{
  background: var(--color-secondary);
  padding: 0.5%;
}
.carousel-caption{
  bottom: 40%;
}
..carousel-indicators{
  z-index: 1;
}
@media (max-width: 768px){
  .carousel-caption {
    position: relative;
    right: 0;
    left: 0;
    padding: 0;
    background: var(--color-secondary);
  }
  .carousel-caption .location-slider-tour{
    margin: 0;
  }
  .carousel-caption .location-slider-tour span{
    background: none;
  }
  /*CONTROLS CAROUSEL*/
  .carousel-indicators{
    display: none;
  }
  .carousel-control .icon-prev, .carousel-control .icon-next, .carousel-control .glyphicon-chevron-left, .carousel-control .glyphicon-chevron-right {
    top: 25%;
}
  /*DIV SEARCH SLIDER INDEX*/
  #custom-search-input {
     position: relative !important; 
     bottom: 0;
    z-index: 4;
    background: #fff;
    padding: 10px 0;
  }

}


/*BUSCADOR*/
#custom-search-input{
  position: absolute;
  bottom: 25%;
}
/*TITLES*/
.title-header{
  font-weight: bold;
  color: var(--color-text);
  font-size: 20px;
  /*border-bottom: solid;*/
  /*border-width: 2px;*/
  /*border-color: var(--color-complement);*/
  padding-top: 10px;
  padding-bottom: 20px;
  
}
.title-header span {
    position:relative;
    display:inline-block;
}

.title-header span:after{
  content:'';
    position:absolute;
    left:0;right:0;
    top:100%;
    margin: 10px auto;
    width:50%;
    height:6px;
  border-bottom: solid 2px var(--color-primary);
}

.line-header{
  display: block;
    margin: 25px 0 15px 0;
    border-bottom: 1px solid var(--color-complement);
    padding: 0;

}
.line-header div{
          font-size: 20px;
    margin: 0 0 -1px 0;
    padding-bottom: 5px;
    display: inline-block;
    border-bottom: 1px solid var(--color-primary);
    font-weight: bold;
    text-transform: uppercase;
    color: var(--color-text);
}
/*LIST*/
.div-why-icon{
position: relative;
padding: 2%;
text-align: center;
}
.why-icon{
height: 100px;
width: 100px;
border-radius: 100%; 
border: 1px solid var(--color-complent);

background: #555;
line-height: 100px;
color: #fff;
cursor: pointer;
}
@media (max-width: 768px){
  .panel .panel-heading{
  background: var(--color-primary);
  color: #f5f5f5;
}
}

.div-child-why >div:hover .why-icon{
  background: var(--color-primary);
}
.div-child-why >div:hover .panel-icon{
  color: var(--color-primary);
}
.panel-heading{
  cursor: pointer;
}

/*added by froy for why us?*/
.why_texts{
  text-align: center;
}
.why_texts>div{
   display: none;
}
/*end css added by froy*/
.title-why-icon{
  font-weight: bold;
  text-transform: uppercase;
}
.why ul {
  list-style: none;
  padding: 0;
}
.why li {
  padding-left: 1.3em;
  text-align: justify;
}
.why li:before {
  content: "\f00c"; /* FontAwesome Unicode */
  font-family: FontAwesome;
  display: inline-block;
  margin-left: -1.3em; /* same as padding-left set on li */
  width: 1.3em; /* same as padding-left set on li */
  color: var(--color-secondary);
}
.list-title-why{
  top: 5%;
    right: 15%;
    background: var(--color-primary);
    /*background: #9315A6;*/
    /*padding: 0.8%;*/
    padding: 8px;
    color: #f5f5f5;
    border-left: solid 5px #1a4c80;
    /*border-left: solid 5px #6a1976;*/
    font-weight: 300;
    /*display: inline-block;  */
    display: block;
}
.div-icon-why{
      /*font-size: 4em;*/
    background: var(--color-primary);
  text-align: center;
    height: 80px;
    width: 80px;
    line-height: 80px !important;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    padding: 2%;
    border: solid 1px;
        

}
</style>
<!-- <code>
  <?php echo json_encode($data); ?>
  <?=json_encode($menu_location); ?>
  <?php echo json_encode($data); ?>
</code> -->



<script type="text/javascript">
var uri_search = null;
jQuery(document).ready(function($) {
  // FOR WHY ICONS COLLAPS DESCRIPTION
  // console.log($('div-child-why>.col-md-4').html());
 // $('.panel-title').append('<span id="icon-panel-producto" class="panel-icon glyphicon glyphicon-chevron-down" style="float: right;"></span>');


$('.div-why-icon').click(function(){
  if ($(this).parent().find('.panel-heading').attr('aria-expanded')=='true') {
      $(this).parent().find('.panel-collapse').removeClass('in');
      $(this).parent().find('.panel-heading').addClass('collapsed').attr('aria-expanded','false');
      $(this).next('.panel').find('.panel-icon').removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
  }else{
      $(this).parent().find('.panel-collapse').addClass('in');
      $(this).parent().find('.panel-heading').removeClass('collapsed').attr('aria-expanded','true');
      $(this).next('.panel').find('.panel-icon').removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
  }

});
$(".panel-heading").click(function(){
    if ($(this).children().find('span.panel-icon').prop("class")=='panel-icon glyphicon glyphicon-chevron-down') {
      $(".panel-icon",this).removeClass("glyphicon glyphicon-chevron-down");
      $(".panel-icon",this).addClass("glyphicon glyphicon-chevron-up");
      
    }else{
      $(".panel-icon",this).removeClass("glyphicon glyphicon-chevron-up");
      $(".panel-icon",this).addClass("glyphicon glyphicon-chevron-down");
    } 
  });

  // $("content>div:first-child").css("margin-top","60px");




//   $('.div-child-why>.col-md-4').hover(function(){


//     console.log($(this).find('.panel-heading').attr('aria-expanded'));
//     if($(this).find('.panel-heading').attr('aria-expanded')=='true'){
// console.log('1');
//     }else{
// $(this).find('.panel-collapse').addClass('in');
//       $(this).find('.panel-heading').removeClass('collapsed').attr('aria-expanded','true');
//     }
//         }
//         , function(){
          
//               console.log('nada');


      

    
//   }
//   );

  


  $("#search-form").submit(function(event) {
    var token = $(".search-query-index").val();
    location.href = '<?=base_url().$language;?>/'+string_format(uri_search) ;
    event.preventDefault();
  });

  $('.search-query-index').keyup(function(){  
    var query = $(this).val();  
    var lang  = $(this).data('lang');
    if(query.length > 2 ){  
      $.ajax({  
        url:"<?=base_url().'page/search';?>",  
        method:"POST", 
        dataType: "json",
        data:{query:query, language:lang},  
        success:function(data){  
          html_list = '<ul class="list-group">';
          if (data.length != 0 ) {
            $.each(data, function(index, val) {
              html_list += '<li class="list-group-item" data-uri="'+val['uri']+'"><span class="fa fa-search text-info"></span> '+val['descripcion']+'</li>';
            });
          }else{
            html_list += '<ol>Sin resultados para tu búsqueda..!</ol>';
          }
          html_list += '</ul>';
          //console.log(html_list);
          $('#searchList').fadeIn();  
          $('#searchList').empty().append(html_list);
        }  
      });  
    }  
  });  
    
  $(document).on('click', 'li', function(){  
    $('.search-query-index').val($(this).text());  
    uri_search = $(this).data('uri');
    console.log("URI SEARCH: ",uri_search);
    $('#searchList').fadeOut();   
  }); 
});

var string_format = (function() {
  var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç", 
      to   = "aaaaaeeeeiiiioooouuuuaaaaaeeeeiiiioooouuuunncc",
      mapping = {};
 
  for(var i = 0, j = from.length; i < j; i++ ){
    mapping[ from.charAt( i ) ] = to.charAt( i );
  }
  return function( text ) {
    var str = text.trim();
    str     = str.replace(/[,|_|;|:|.|(|)|'|´]/gi,"");
    str     = str.replace(/[ ]/gi, "-");
    str     = str.toLowerCase();
    var ret = [];
    for( var i = 0, j = str.length; i < j; i++ ) {
      var c = str.charAt( i );
      if( mapping.hasOwnProperty( str.charAt( i ) ) ){
          ret.push( mapping[ c ] );
      }else{
        ret.push( c );
      }
    }      
    return ret.join( '' );
  }
})();
</script>