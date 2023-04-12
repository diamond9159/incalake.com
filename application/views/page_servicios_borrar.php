<?php 
  $traduccion_body = arrayTraduccion('body',$language);
?>

<div class="container-fluid">
  <div class="col-md-12 div-img-lugar">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <?php
        shuffle($slider);
        //echo json_encode($slider);
        if (count($slider) === 0 ) {
          echo '<div class="item active ">'.
                '<img src="'.BASE_URL_DEFAULT_SLIDER.'" alt="" style="width:100%;">'.
              '</div>';
        }else{
          foreach ($slider  as $key =>  $value ) {
            if ($key>2) {
              break;
            }elseif ($key==0) {
              echo '<div class="item active ">'.
                  '<img src="'.$value.'" alt="Los Angeles" style="width:100%;">'.
                '</div>';
            }
            echo '<div class="item  ">'.
                '<img src="'.$value.'" alt="Los Angeles" style="width:100%;">'.
              '</div>';
          }
        }
        ?>
      </div>
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" data-slide="prev" style="z-index: 10;">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next" style="z-index: 10;">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <div class="div-lugar col-md-12 text-center">
      <span><?=mb_strtoupper(urldecode($location));?></span>
      <p><span class="quantity-service"><?=count($data);?> <?=$traduccion_body['servicios_disponibles'];?></span></p>
    </div>
    <div class="div-color">   
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-xs-12 text-center btn div-txt-servicio">
      <div>
        <?=$traduccion_body['NUESTROS_SERVICIOS'];?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-2 col-xs-12 div-options-products" >
          <div class="panel  col-md-12 col-xs-12  visible-xs div-txt-filtrar">
            <div>FILTAR BUSQUEDA <span class=" fa fa-sort-amount-asc" style="float: right;"></span></div>
          </div>


            <div class="panel panel-default  panel-option hidden-xs">
              <div class="panel-heading collapsed" data-toggle="collapse" href="#collapse-category" aria-expanded="false">
                <h4 class="panel-title">
                <i class="fa fa-cubes" aria-hidden="true"></i> 
              <b>CATEGORIAS</b>
              </h4>
              </div>
              <div id="collapse-category" class="panel-collapse collapse in" >
                <div class="panel-body">
                  <ul class="list-group">
                    <li class="list-group-item hide" id="category_selected"  onclick="quitar_c()" style="cursor:pointer"><span class="badge">x</span><span id="category_selected_label"></span></li>
                    <?php foreach ($categorias as $key => $value): ?>
                    <li class="list-group-item boton-filtro-1" style="cursor:pointer" onclick="showProducts(null,'<?=$value;?>');"><span class="badge" id="badge-<?=$key?>"></span> <span><?=$value;?></span> </li>
                    <?php endforeach ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="panel panel-default panel-option  hidden-xs">
              <div class="panel-heading collapsed" data-toggle="collapse" href="#collapse-time" aria-expanded="false">
                <h4 class="panel-title">
                <i class="fa fa-clock-o" aria-hidden="true"></i> 
              <b>DURACIÓN</b>
              </h4>
              </div>
              <div id="collapse-time" class="panel-collapse collapse in" >
                <div class="panel-body">
                  <ul class="list-group" id="lista-duracion">
                    <li class="list-group-item hide" id="duration_selected" onclick="quitar_d()" style="cursor:pointer"><span class="badge">x</span><span id="duration_selected_label"></span></li>
                    <li class="list-group-item boton-filtro-2" id="lista-duracion-2" style="cursor:pointer" onclick="showProducts('2',null);"><span class="badge" id="badge-d-2"></span><span><?=$traduccion_body['dias'];?></span> </li>
                    <li class="list-group-item boton-filtro-2" id="lista-duracion-1" style="cursor:pointer" onclick="showProducts('1',null);"><span class="badge" id="badge-d-1"></span><span><?=$traduccion_body['horas'];?></span></li>
                    <li class="list-group-item boton-filtro-2" id="lista-duracion-0" style="cursor:pointer" onclick="showProducts('0',null);"><span class="badge" id="badge-d-0"></span><span><?=$traduccion_body['minutos'];?></span> </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="panel panel-default  panel-option hidden-xs">
            <div class="panel-heading">
            <h4 class="panel-title">
            <i class="fa fa-map" aria-hidden="true"></i> 

              <b>LUGARES</b>
              </h4>
              </div>
              <div class="panel-body">
                  <ul class="list-group">
                     <?php foreach ($menu_location as $key => $value): ?>
                      <li class="list-group-item">
                        <a href="<?=base_url().mb_strtolower($language)."/".mb_strtolower($value).'/';?>"><strong class="text-info"><span class="fa fa-map-marker"></span> <?=$value;?></strong></a>
                      </li>              
                    <?php endforeach ?>
                  </ul>
            </div>
            </div>



    </div>
    <div class="col-md-10 col-xs-12 div-list-product">
      <div class="panel panel-default" style="background:#F9F9F9">
        <div class="panel-body">
         <div class="col-md-12">
          <span>Modo de vista: </span>
            <span class="btn btn-xs fa fa-th-list btn-list" title="Lista"></span>
            <span class="btn btn-xs fa fa-th-large text-primary btn-square" title="Mosaico"></span>
          </div>

        </div>
      </div>

      <div class="col-md-12" id="products-div" >
        <?php
        $duracion_tipo = array('min','h','d');
        foreach($data as $key=>$producto){
          echo "<div class='col-md-3 div-square card'>
            <div class='col-md-12 card-div-inside'>
              <div class='col-md-4 card-image hidden-sm hidden-xs'>
                <a href='".$producto['url_servicio']."'>
                  <img class='img-responsive' src='".$producto['url_thumbs']."' width='100%' height='100%'>
                </a>
              </div>
              <div class='col-md-8 card-content'>
                <div class='col-md-9 col-sm-9 col-xs-12 div-details'>
                  <div class='card-title-product'>
                    <h3>
                      <strong> <a href='".$producto['url_servicio']."'>". $producto['subtitulo_producto'] ."</a>
                      </strong>
                    </h3>
                  </div>
                  <p>
                    <input type='text' title='Rating' name='txt_valoracion' value='".$producto['valoracion']."' class='kv-ltr-theme-fa-star  rating-loading txt_valoracion'  dir='ltr' data-show-caption='true'>
                  </p>
                  <br>
                  <div class='div-description'>
                    <p><em>".$producto['descripcion_pagina']."</em>
                    </p>
                  </div>
                  ";
                  if($producto['duracion']) {
                    echo "
                  <div class='div-go'>
                    <em>".$traduccion_body['hora_de_salida'].":".$producto['hora_inicio']."
                    </em>
                  </div>
                  <div class='div-duration'>
                    <em>".$traduccion_body['duracion'].":
                    </em>
                  </div>
                    ";
                    $duraciones = explode(',',$producto['duracion']);
                    foreach($duraciones as $duracion){
                      $tmp_duracion = explode('!',$duracion);
                      echo "
                        <div class='btn btn-default btn-xs'>
                          ".$tmp_duracion[0].$duracion_tipo[$tmp_duracion[1]]."
                        </div>   
                      ";
                    }
                  }
                  foreach($producto['categorias_producto'] as $categ){
                    echo "
                    <div class='btn btn-success btn-xs div-category'>".$categ."
                    </div>
                    ";
                  }
          echo "</div>
                <div class='col-md-3 col-sm-3 col-xs-12 div-precios'>
                  <div class='div-align-flex'>
                    <div class='div-content-align-flex'>
                      <span class='desde'>Desde  
                      </span>
                      <span class='precio'>USD ".$producto['precios_desde']." $
                      </span>
                      <p class='cantidad'>".$traduccion_body['por_persona']."
                      </p>
                      <a href='".$producto['url_servicio']."' class='btn btn-sm btn-default btn-more-details' target='new_blank'>
                        ".$traduccion_body['mas_detalles']."
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>";
          if(($key+1)%4==0) echo "<div class='col-xs-12'></div>";
        }
        ?>
        <!-- lol -->
      </div>
    </div>
    </div>
</div>         

<script>
  /* Datos a mostrar */
  var data = <?=json_encode($data)?>;
  var categorias = <?=json_encode($categorias)?>;
  console.log('data',data);
  console.log('categorias',categorias);
  /* Memoria */
  var categoria_seleccionada = null;
  var duracion_seleccionado = null;
  var vista_seleccionada = "btn-square";
  /* Variables globales de javascript */
  var duracion_tipo = ['min','h','d'];
  var duracion_tipo_completo = ['<?=$traduccion_body['minutos'];?>','<?=$traduccion_body['horas'];?>','<?=$traduccion_body['dias'];?>'];
</script>
<script>
  function contar_categorias(){
    categorias.map(function(categoria){
      return data.filter(function(producto){
        if(producto.categorias_producto.indexOf(categoria) >=0 ) return true;
      }).length;
    }).forEach(function(cantidad, index){
      document.getElementById('badge-'+index).innerHTML = cantidad;
    });
  }
  function contar_duracion(){
    ['0','1','2'].map(function(duracion){
      return data.filter(function(producto){
        if(producto.duracion.split(',').map(function(d){ return d.split('!')[1];}).indexOf(duracion) >=0 ) return true;
      }).length;
    }).forEach(function(cantidad, index){
      document.getElementById('badge-d-'+index).innerHTML = cantidad;
      var parent = document.getElementById('lista-duracion');
      if(cantidad==0){
        var child = document.getElementById('lista-duracion-'+index);
        parent.removeChild(child);
      }
    });
  }
  function quitar_c(){
    categoria_seleccionada = null;
    $('.boton-filtro-1').removeClass('hide');
    $('#category_selected').addClass('hide');
    $('#category_selected_label').html();
    showProducts(null,null);
  }
  function quitar_d(){
    duracion_seleccionado = null;
    $('.boton-filtro-2').removeClass('hide');
    $('#duration_selected').addClass('hide');
    $('#duration_selected_label').html();
    showProducts(null,null);
  }
</script>
<script>
  function showProducts(tiempo, categ){
    if(tiempo) duracion_seleccionado = tiempo;
    if(categ) categoria_seleccionada = categ;
      
    if(categ){
      $('.boton-filtro-1').addClass('hide');
      $('#category_selected').removeClass('hide');
      $('#category_selected_label').html(categ);
    }
    if(tiempo){
      $('.boton-filtro-2').addClass('hide');
      $('#duration_selected').removeClass('hide');
      $('#duration_selected_label').html(duracion_tipo_completo[tiempo]);
    }
    
    var html = "<div class='col-xs-12'><h3><?=$traduccion_body['resultados'];?>:</h3></div>";

    /* Filtrar productos */
    var productos_filtrados = data.filter(function(product){
      if(categoria_seleccionada){
        if(product.categorias_producto.filter(function(catg){return catg==categoria_seleccionada;}).length == 0) return null;
      }
      if(duracion_seleccionado){
        if(!product.duracion) return null;
        if(product.duracion.split(',').map(function(d){ return d.split('!')[1];}).indexOf(duracion_seleccionado) === -1) return null;
      }
      return product;
    });
    /* Mostrar los productos */
    productos_filtrados.forEach(function(product, index){
      let clase = vista_seleccionada=="btn-list"?"col-md-12":"col-md-3 div-square";
      html += `
        <div class='${clase} card'>
          <div class='col-md-12 card-div-inside'>
            <div class='col-md-4 card-image hidden-sm hidden-xs'>
              <a href='${product.url_servicio}'>
                <img class='img-responsive' src='${product.url_thumbs}' width='100%' height='100%'>
              </a>
            </div>
            <div class='col-md-8 card-content'>
                <div class='col-md-9 col-sm-9 col-xs-12 div-details'>
                  <div class='card-title-product'>
                    <h3>
                      <strong>
                        <a href='${product.url_servicio}'>
                          ${product.subtitulo_producto}
                        </a>
                      </strong>
                    </h3>
                  </div>
                  <p>
                    <input type='text' title='Rating' name='txt_valoracion' value='${product.valoracion}' class='kv-ltr-theme-fa-star  rating-loading txt_valoracion'  dir='ltr' data-show-caption='true'>
                  </p>
                  <br>
                  <div class='div-description'>
                    <p>
                      <em>
                        ${product.descripcion_pagina}
                      </em>
                    </p>
                  </div>
      `;
      if(product.duracion){
      html +=`    
                  <div class='div-go'>
                    <em>
                      <?=$traduccion_body['hora_de_salida'];?>: ${product.hora_inicio}
                    </em>
                  </div>
                  <div class='div-duration'>
                    <em>
                      <?=$traduccion_body['duracion'];?>:
                    </em>
                  </div>
              `;
                product.duracion.split(',').forEach((d)=>{
                  var tmp = d.split('!');
      html +=`
                  <div class='btn btn-default btn-xs'>
                    ${tmp[0]} ${duracion_tipo[tmp[1]]}
                  </div> 
      `;
                });
      }
      product.categorias_producto.forEach((c)=>{
        html +=`
                  <div class='btn btn-success btn-xs div-category'>
                    ${c}
                  </div>
        `; 
      });
      html += `
                </div>
                <div class='col-md-3 col-sm-3 col-xs-12 div-precios'>
                  <div class='div-align-flex'>
                    <div class='div-content-align-flex'>
                      <span class='desde'>
                        Desde
                      </span>
                      <span class='precio'>
                        USD ${product.precios_desde} $
                      </span>
                      <p class='cantidad'>
                        <?=$traduccion_body['por_persona'];?>
                      </p>
                      <a href='${product.url_servicio}' class='btn btn-sm btn-default btn-more-details' target='new_blank'>
                        <?=$traduccion_body['mas_detalles'];?>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      `;
      if((index+1)%4==0){
        html += `<div class='col-xs-12'></div>`;
        console.log('index',index);
      }
    });
    /* Renderizar los productos */
    if(productos_filtrados.length==0) 
      document.getElementById('products-div').innerHTML = html + "<div class='col-md-12 col-sm-12 col-xs-12 text-center'><h4>0 Results</h4></div>";
    else 
      document.getElementById('products-div').innerHTML = html;
    // funcion ver filtro movil
    $('.div-txt-filtrar').click(function(){
      if($(this).nextAll('.panel-option').hasClass('hidden-xs')==true){
        $(this).nextAll('.panel-option').removeClass('hidden-xs').addClass('col-xs-12');
        $(this).nextAll('.panel-option').find('.panel-collapse').removeClass('in');
        
      }else{
        $(this).nextAll('.panel-option').addClass('hidden-xs').removeClass('col-xs-12');
        $(this).nextAll('.panel-option').find('.panel-collapse').addClass('in');
      }
      
      console.log('asda');
      console.log($(this).nextAll('.panel').hasClass('hidden-xs'));
    });
    /* Para ver en iconos */
    $('.btn-square').click(function(){
      $('.btn-list').removeClass('text-primary');
      $('.card').removeClass('col-md-12 div-list').addClass('col-md-3 div-square');
      $(this).addClass('text-primary');
      vista_seleccionada = "btn-square";
    });
    /* Para ver en lista */
    $('.btn-list').click(function(){
      $('.btn-square').removeClass('text-primary');
      $('.card').removeClass('col-md-3 div-square').addClass('col-md-12 div-list');
      $(this).addClass('text-primary');
      vista_seleccionada = "btn-list";
    });
    /* Activamos estilos para las estrellas */
    $('.txt_valoracion').rating({
      displayOnly: true, 
      theme: 'krajee-fa',
      size: 'xs',
      min: 0, 
      max: 5, 
      step: 0.1, 
      stars: 5,
    });
  }
</script>


<code>
  <?php 
    //echo json_encode($data);
    //echo "<br/><br/>".json_encode($categorias);
    //echo "<br/><br/>".json_encode($duraciones);
    //echo "<br/><br/>".json_encode($location);
  ?>
  </code>


<style type="text/css">

.rating-xs{
  font-size: 15px;
  float: left;
}
.rating-container .filled-stars{
  color: #fec701;
  -webkit-text-stroke: 1px #d8ab09;
  text-shadow: 1px 1px #d8ab09; 
}
/*inicio*/

.div-details{
  padding-left: 0;
}
.div-details .btn-default {
    background: rgba(226, 226, 226, 0.35);
    color: #6f6d6d;
    border-color: #dcdcdc;
}
.rating-container{
  display: grid;
}
.div-precios{
  
    display: table-cell;
    height: 100%;
     background: #187eba; 
    
}
.div-precios .div-align-flex{
     display: flex;
  flex-flow: column;
  align-items: center;
  justify-content: center;
 
  width: 100%;
  height: 100%;
}
.div-precios .div-content-align-flex{
  display: flex;
  flex-flow: column;
 
  justify-content: center;
  text-align: center;
}
.div-precios  .btn-default {
    background: rgba(186, 152, 152, 0);
    color: #fff;
}
.div-precios .precio{
  font-weight: bold;
  font-size: 20px;
  color: #fff;
}
.div-precios .cantidad, .div-precios .desde{
  font-size: 18px;
  color: #ccc;
}    
/**/
.div-img-lugar{
  padding: 0;
}
.div-img-lugar img{

width: 100%;
position: relative;
}
/*.div-img-lugar .div-lugar{
  position: absolute;
  top: 30%;
  z-index: 1;
  text-transform: uppercase;
  color: #fff;
  font-weight: bold;
}
.div-img-lugar .div-lugar>span{
padding: 10px;
    background: rgba(92, 184, 92, 0.86);
    font-size: 40px;
}
.div-img-lugar .div-lugar>p{
padding: 10px;
    
}*/
.quantity-service{
  padding: 5px;
  background: rgba(24, 128, 190, 0.65);
}
.div-txt-servicio>div{
  background: var(--color-primary);
    color: #fff;
    padding: 5px;
    font-weight: bold;
    font-size: 15px;
}
.div-txt-filtrar{
 /*padding-bottom: 5px;*/
}
.div-txt-filtrar>div{
  background: var(--color-complement);
  padding: 5px;
  font-weight: bold;
}
@media (max-width: 768px){
.div-options-products .panel-option.col-xs-12 .panel-heading{
  background: var(--color-primary);
    color: #f5f5f5;
}
.div-options-products .panel-option.col-xs-12 .panel-body{
  padding: 0;
}
}
.div-options-products .panel-body{
      padding:0;
     }
.div-options-products .list-group li{
        border-bottom: none
}
    
    

.div-img-lugar #custom-search-input{
      position: absolute;
    top: 75%;
    z-index: 1;
}
.div-img-lugar .div-color{
  position: absolute;
    top: 0;
    left: 0; 
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.13);
}
/*DIV LIST PORDUCTS*/
@media (max-width: 768px){
  .div-list-product{
    padding: 0;
  }
  .div-list-product .div-precios{
  height: auto;
  width: 100%;
  background: none;
  }
  .div-list-product .card-content h3{
    font-size: 16px;

  }
  
  
  /*.div-square .card-image,.div-square .card-content,.div-square .div-details{
    width: 100%;
  }*/


  .div-list-product .card-title-product a{
    /*color: #fff;*/

  }
  .div-list-product .div-precios  .btn-default{
  background: var(--color-primary);
  color: #f5f5f5;
  }

  .div-list-product .div-content-align-flex .precio{
    color: #1880be;
  }
  .div-list-product .div-precios .div-content-align-flex, .div-list-product .div-content-align-flex .cantidad {
  display: inline;
  }

}


.card-price {
    position: absolute;
    top: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.68);
    
}
.precio-antes{
line-height: 25px;
text-decoration:line-through;
}
.precio-ahora{
  background: rgba(211, 40, 35, 0.86);
    color: #fff;
    padding: 8px;
}
#products-div{
  padding: 0;
}
#products-div .container{
  height: 100%;
        /*margin-top: 20px;*/
            display: grid;
}
.card {
  
  /*width: 100%;*/
}

.card {
  /*margin-top: 0.9em;*/
  box-sizing: border-box;
  border-radius: 0.2em;
  background-clip: padding-box;
  /*padding: 10px;*/
  
  /*padding: 0;*/
  /*background: #fff;*/
  margin-bottom: 20px;
}
.card-div-inside{
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  height: 100%;
  display: table;
  background: #fff;
  padding: 0;
  width: 100%;
}

.card-title-product a{
      color: #337ab7;
}
.dropdown-menu {
    right: 0 !important;
    left: auto;
}

.card .card-image {
  position: relative;
  /*padding: 1%;*/
  padding: 0;
  /*overflow: hidden;*/
}
.card .card-image img {
  border-radius: 0.2em 0.2em 0 0;
  background-clip: padding-box;
  position: relative;
  /*z-index: -1;*/
      /*min-height: 150px;*/
}
.card .card-image .card-title {
  position: absolute;
  bottom: 0;
  left: 0;
  padding: 0.3em;
}
.div-list-product .card-content{
height: 100%;
}
.div-square .card-content{
height: auto;
}
.card-content{
  /*height: 100%;*/
  display: table-cell;
  padding: 2%;
}
.card-content h3{
  margin-top: 0;
  margin-bottom: 0;
}
.card .card-action {
  border-top: 0.1em solid rgba(160, 160, 160, 0.2);
  padding: 0.9em;
}
.card .card-action a {
  
  /*color: #105984;*/
  margin-right: 0.1em;
  transition: color 0.3s ease;
  text-transform: uppercase;
  font-weight: bold;
}
.card .card-action a:hover {
  /*color: #438cb7;*/
  text-decoration: none;
  font-weight: bold;
} 
/*DIVS MODO LIST*/


/*divs modo square*/
.div-square .card-image,.div-square .card-content,.div-square .div-details{
  width: 100%;
}
.div-square .div-description,.div-square .div-go,.div-square .div-duration,.div-square .div-category, .div-square .div-precios .cantidad,.div-square .div-precios .btn-more-details{
  display: none;
}
.div-square .card-content{
  padding: 10px;
}
.div-square .card-title-product a{
  /*color: #fff;*/

}
.div-square .card-content h3{
  font-size: 16px;
}
.div-square .div-precios{
  height: auto;
  width: 100%;
  background: none;
}
.div-square .div-content-align-flex .precio{
  color: #1880be;
}
.div-square .div-precios .div-content-align-flex {
display: inline;
}
/*CATEGORRY LIST*/
#category_selected .badge,#duration_selected .badge{
  background: var(--color-danger);
  color: #f5f5f5;
}
.boton-filtro-1:hover .badge,.boton-filtro-2:hover .badge{
  background: var(--color-primary);
  color: #f5f5f5;
}


</style>

