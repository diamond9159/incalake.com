<!--

notas:
-index
  - agregar margin a las targetas
  - desperdicio de espacio en las targetas
-individual tour
  - Falta pie de pagina
-destinos
  - Falta el desarrollo
-destino
  - Pie de pagina no de ajusta
-serp
  -no carga cabecera

busqueda por motor
monedas

-->
<style>
.envoltura{
    position: relative;
    padding: 0 !important;
}
.envoltura div.capa{
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
    position: absolute;
    top: 0;
}
.envoltura .imagen img{
    width: 100%;
}
.envoltura .destino{
    position: absolute;
    left: 0px;
    top: 40%;
    text-align: center;
    width: 100%;
    font-size: 40px;
    color: white;
    text-transform: uppercase;
    font-weight: bold;
}
.envoltura .destino>*:first-child{
    padding: 0.4rem;
    background: var(--color-secondary);
}
.envoltura .path{
    position: absolute;
    left: 30px;
    top: 20px;
    color: white;
    text-shadow: 1px 1px black;
    text-transform: capitalize;
}
.envoltura .path a{
    color: white;
    text-shadow: 1px 1px black;
}
</style>

<?php
     echo "
        <script>
        const actividades = ".json_encode($activity).";
        const categorias = ".json_encode($category).";
        const lugares = ".json_encode($destiny).";
        const duraciones = ".json_encode($duration).";
        console.log('actividades',actividades);
        console.log('categorias',categorias);
        console.log('lugares',lugares);
        console.log('duraciones',duraciones);            
        </script>
     ";
?> 


<?php
  //echo json_encode($resultado);
  // $this->load->view('php/mobile-detect/Mobile_Detect');
  $detect = new Mobile_Detect;
  if ($detect->isMobile()) {
     
  ?>




<?php
// echo json_encode($destino);

$traduccion_body = arrayTraduccion('body',$language);
?>



<div class="envoltura form-group col-md-12">
                <div class="imagen">
                    <img src="https://placekitten.com/2000/600">
                </div>
                <div class="capa">
                </div>
                <div class="path">
                    <?php
                    $var_destiny='';
                    foreach ($breadcrumb as $key => $value) {
                        if (!empty($value["url"])) {
                           echo '<a href="'.$value["url"].'">'.$value["txt"].'</a> > ';
                        }else{
                            echo $value["txt"];
                            $var_destiny=$value["txt"];
                        }
                       
                    }
                    ?>
                </div>
                <div class="destino">
                   <span><?=$var_destiny?></span>
                </div>
            </div>
        <div class="container-fluid">
            <button style="    position: sticky;
    top: 10px;
    z-index: 2;
    border: 0px;
    font-size: 20px;
    background-color: #a8f939;
    padding: 5px 10px;
    border-radius: 50%;" data-toggle="modal" data-target="#modal_filtro">
                <i class="fa fa-filter"></i>
            </button>

            <div class="col-12  div-txt-servicio" style="padding: 0">
                <div class="col text-center"><?=$traduccion_body['NUESTROS_SERVICIOS'];?></div>
            </div>
            <div class="col-12 div-full">
                <div class="row div-full" >

                    <div class="col-12" style="margin-right: 0;padding-right: 0;">
                        <div class="row">
                            <div class="row col">
                                <div class=" col-sm-6 col float-left align-self-center">
                                    <?=$traduccion_body['resultado'];?> <span id="cantidad_resultante"></span> Actividad(es)
                                </div>
                                
                            </div>
                        </div>
                        
                        
                        <div class="row" id="actividades_content">
                            <!-- content here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


            <!-- - - - - - - - - - - - - - - - Modal - - - - - - - - - - - - - - - - - -->
<div class="modal fade" id="modal_filtro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" data-dismiss="modal">Filtrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        



            <div class="col-12 div-full">
                        <div class=" col-sm-6 col float-right  align-self-center">
                                    <span class="  "> <?=$traduccion_body['modo_de_vista'];?></span>
                                    <div class="btn-group   float-right" role="group" aria-label="Basic example">
                                        <span class="btn btn-xs fa fa-th-list text-primary btn-list" title="Lista"></span>
                                        <span class="btn btn-xs fa fa-th-large  btn-square" title="Mosaico"></span>
                                    </div>
                                    <hr>
                                </div>

                        <div class="card card-duration">
                            <div class="card-header">
                                <a data-toggle="collapse" href="#card-duration" aria-expanded="true" aria-controls="card-duration">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    <b><?=$traduccion_body['duraciones'];?></b>
                                    <span class="fa fa-chevron-down" style="float:right;"></span>
                                </a>
                            </div>
                            <div id="card-duration" class="collapse show">
                                <div class="card-body" style="padding: 0">
                                    <ul class="list-group" style="padding: 0" id="duraciones_content">
                                        Espere...
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card card-locations">
                            <div class="card-header">
                                <a data-toggle="collapse" href="#card-locations" aria-expanded="true" aria-controls="card-locations">
                                    <i class="fa fa-map-signs" aria-hidden="true"></i>
                                    <b><?=$traduccion_body['lugares'];?></b>
                                    <span class="fa fa-chevron-down" style="float:right;"></span>
                                </a>
                            </div>
                            <div id="card-locations" class="collapse show">
                                <div class="card-body" style="padding: 0">
                                    <ul class="list-group" style="padding: 0" id="lugares_content">
                                        Espere...
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card card-category">
                            <div class="card-header">
                                <a data-toggle="collapse" href="#card-category" aria-expanded="true" aria-controls="card-category">
                                    <i class="fa fa-cubes" aria-hidden="true"></i>
                                    <b><?=$traduccion_body['categorias'];?></b>
                                    <span class="fa fa-chevron-down" style="float:right;"></span>
                                </a>
                            </div>
                            <div id="card-category" class="collapse show">
                                <div class="card-body" style="padding: 0">
                                    <ul class="list-group" style="padding: 0" id="categorias_content">
                                        Espere...
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>







      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aplicar filtro</button>
      </div>
    </div>
  </div>
</div>
<!-- - - - - - - - - - - - - - - End  Modal  - - - - - - - - - - - - - - - - -->







<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  end mobile - - - - - - - - - - - - - - - -->
  <?php

  }else{
  ?>





<?php
// echo json_encode($destino);

$traduccion_body = arrayTraduccion('body',$language);
?>


<div class="envoltura form-group col-md-12">
                <div class="imagen">
                    <img src="https://placekitten.com/2000/600">
                </div>
                <div class="capa">
                </div>
                <div class="path">
                    <?php
                    $var_destiny='';
                    foreach ($breadcrumb as $key => $value) {
                        if (!empty($value["url"])) {
                           echo '<a href="'.$value["url"].'">'.$value["txt"].'</a> > ';
                        }else{
                            echo $value["txt"];
                            $var_destiny=$value["txt"];
                        }
                       
                    }
                    ?>
                </div>
                <div class="destino">
                   <span><?=$var_destiny?></span>
                </div>
            </div>
        <div class="container-fluid">

            <div class="col-12  div-txt-servicio" style="padding: 0">
                <div class="col text-center"><?=$traduccion_body['NUESTROS_SERVICIOS'];?></div>
            </div>
            <div class="col-12 div-full">
                <div class="row div-full" >
                    <div class="col-lg-2 div-full div-card-filter">
                        
                        <div class="card card-duration">
                            <div class="card-header">
                                <a data-toggle="collapse" href="#card-duration" aria-expanded="true" aria-controls="card-duration">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    <b><?=$traduccion_body['duraciones'];?></b>
                                    <span class="fa fa-chevron-down" style="float:right;"></span>
                                </a>
                            </div>
                            <div id="card-duration" class="collapse show">
                                <div class="card-body" style="padding: 0">
                                    <ul class="list-group" style="padding: 0" id="duraciones_content">
                                        Espere...
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card card-locations">
                            <div class="card-header">
                                <a data-toggle="collapse" href="#card-locations" aria-expanded="true" aria-controls="card-locations">
                                    <i class="fa fa-map-signs" aria-hidden="true"></i>
                                    <b><?=$traduccion_body['lugares'];?></b>
                                    <span class="fa fa-chevron-down" style="float:right;"></span>
                                </a>
                            </div>
                            <div id="card-locations" class="collapse show">
                                <div class="card-body" style="padding: 0">
                                    <ul class="list-group" style="padding: 0" id="lugares_content">
                                        Espere...
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card card-category">
                            <div class="card-header">
                                <a data-toggle="collapse" href="#card-category" aria-expanded="true" aria-controls="card-category">
                                    <i class="fa fa-cubes" aria-hidden="true"></i>
                                    <b><?=$traduccion_body['categorias'];?></b>
                                    <span class="fa fa-chevron-down" style="float:right;"></span>
                                </a>
                            </div>
                            <div id="card-category" class="collapse show">
                                <div class="card-body" style="padding: 0">
                                    <ul class="list-group" style="padding: 0" id="categorias_content">
                                        Espere...
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10" style="margin-right: 0;padding-right: 0;">
                        <div class="row div-options-search">
                            <div class="col  ">
                                <div class="col div-content-options-search">
                                    <div class="div-content-result-txt col-sm-6 col float-left" >
                                        <div class="align-self-center">
                                        <?=$traduccion_body['resultado'];?> <span id="cantidad_resultante"></span> Actividad(es)
                                        </div>
                                    </div>
                                    <div class=" col-sm-6 col float-right text-right align-self-center">
                                        <span class=" solo-grande "> <?=$traduccion_body['modo_de_vista'];?></span>
                                        <div class="btn-group  solo-grande float-right" role="group" aria-label="Basic example">
                                            <span class="btn btn-xs fa fa-th-list text-primary btn-list" title="Lista"></span>
                                            <span class="btn btn-xs fa fa-th-large  btn-square" title="Mosaico"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row" id="actividades_content">
                            <!-- content here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>






  <?php
    }
  ?>






<style>
    /*
    * Es pa cels :v
    */
    @media (max-width: 1023px){
        .solo-grande{
            display: none;
        }
    }
    @media (min-width: 1024px){
        .solo-grande{
            display: block;
        }
    }
    /*
    * * * *
    */
    .div-card-title a{
        color: #337ab7;
        font-weight: bold;
        font-size: 1.2rem;
    }
    /*// Method 1) Pure CSS*/
.star-ratings-css {
  unicode-bidi: bidi-override;
  color: #c5c5c5;
  font-size: 25px;
  height: 25px;
  width: 100px;
  /*margin: 0 auto;*/
  position: relative;
  padding: 0;
  text-shadow: 0px 1px 0 #a2a2a2;
  height: 100%;
}
  
  .star-ratings-css-top {
    color: #e7711b;
    padding: 0;
    position: absolute;
    z-index: 1;
    display: block;
    top: 0;
    left: 0;
    overflow: hidden;
  }
  .star-ratings-css-bottom {
    padding: 0;
    display: block;
    z-index: 0;
  }
}
</style>
<script>
$(document).ready(function(){

$('.btn-square').click(function(){
console.log('asdas');
$('.div-activity').removeClass('col-md-12 ').addClass('col-md-3 div-list-squeare');
$('.div-price').css('height','auto');
$('.solo-para-mobiles').css('display','none');
$(this).addClass('text-primary');
$('.btn-list').removeClass('text-primary');

});
$('.btn-list').click(function(){
console.log('asdas');
$('.div-activity').removeClass('col-md-3 div-list-squeare').addClass('col-md-12');
$('.div-price').css('height','100%');
$('.solo-para-mobiles').css('display','block');
$(this).addClass('text-primary');
$('.btn-square').removeClass('text-primary');
});
});
</script>
<script>
// Memoria
var categoria_selected = null;
var duracion_selected = null;
var lugar_selected = null;

// seteo de horas, min, etc
var tiempo = {};
duraciones.forEach(function(duracion){
    tiempo[duracion.type] = duracion.txt;
});


// Filtrados
var filtrados = [];


// Actividades
function mostrar_actividades(categoria,duracion,lugar){
    if(categoria == 'reset') categoria_selected = null;
    else if(categoria) categoria_selected = categoria;

    if(duracion == 'reset') duracion_selected = null;
    else if(duracion) duracion_selected = duracion;
    
    if(lugar == 'reset')lugar_selected = null;
    else if(lugar) lugar_selected = lugar;

    console.log('mostrando con: ',categoria_selected,duracion_selected,lugar_selected);
    filtrados = actividades;
    if(categoria_selected){
        filtrados = filtrados.filter(function(actividad){
            return actividad.categorias.filter(function(cat){
                return cat.id==categoria_selected;
            }).length != 0;
        });
    }
    if(duracion_selected){
        filtrados = filtrados.filter(function(actividad){
            return actividad.duracion_actividad.filter(function(dur){
                return dur==duracion_selected;
            }).length != 0;
        });
    }
    if(lugar_selected){
        filtrados = filtrados.filter(function(actividad){
            return actividad.ciudad_cercana==lugar_selected;
        });
    }
    mostrar_all_categorias(categoria_selected);
    mostrar_all_duraciones(duracion_selected);
    mostrar_all_lugares(lugar_selected);

    var tmp_html = ``;
    filtrados.forEach(function(actividad){
        let categoria_tmp_html = '';
        if(!!actividad.categorias.length){
            categoria_tmp_html = categoria_tmp_html + `
            <span>
                <span class="fa fa-tag"></span>
            `;
            actividad.categorias.forEach(function(c){
                categoria_tmp_html = categoria_tmp_html +' <span class="tag-category">'+ c.txt + '</span> ';
            });
            categoria_tmp_html = categoria_tmp_html + `
            </span>
            `;
        }
        
        let duracion_tmp_html = '';
        if(!!actividad.duracion_actividad.length){
            duracion_tmp_html = duracion_tmp_html + `
            <span >
                <span class="fa fa-clock-o"></span>
            `;
            actividad.duracion_actividad.forEach(function(d){
                duracion_tmp_html = duracion_tmp_html + tiempo[d.split('!')[1]] + ' ';
            });
            duracion_tmp_html = duracion_tmp_html + `
            </span>
            `;
        }

        let cantidad_horarios_tmp_html = `
            <span style="padding:5px 10px">
                <i class="fa fa-paw"></i>
                ${actividad.duracion_actividad.length} Horario(s) disponibles
            </span>
        `;


        tmp_html = tmp_html + `

                            <div class="col-md-12  div-activity ">
                                <div class="row content-activity">
                                    <div class="col-md-4 div-img-activity">
                                        <a href="http://localhost/web/es/uros/0">
                                            <img class="img-fluid img-activity" src="https://placekitten.com/g/400/300" alt="">
                                        </a>
                                    </div>
                                    <div class="div-full col-md-8 d-flex div-descripcion-prince">
                                        <div class="row content-descripcion-prince">
                                            <div class="col-12 col-md-9 div-description div-content">
                                                
                                                    <div class="col-md-12 div-card-title">
                                                        <a href="${actividad.url_actividad}" target=_blank>
                                                            ${actividad.titulo_actividad}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-12 div-card-category">
                                                        ${categoria_tmp_html}
                                                    </div>
                                                    <div class="row text-left" style="margin:0">
                                                        <div class="col-md-6 div-card-duration">    ${actividad.duracion_actividad_aprox}
                                                        </div>
                                                        <div class="col-md-6 div-card-horarios">    ${actividad.horarios_disponibles}
                                                        </div>
                                                        </div>
                                                    <div class="col-md-12 solo-para-mobiles div-description-txt">
                                                        ${actividad.descripcion_activity}
                                                    </div>
                                                    <!--<div  class="col-md-12">
                                                        <a href="${actividad.url_actividad}">
                                                            Leer más
                                                        </a>
                                                    </div>-->
                                                
                                            </div>
                                            <div class="col-12 col-md-3 div-price div-content">
                                                <div class="row content-price text-center div-full">
                                                    <div class="col align-self-center txt-price div-full">
                                                        ${actividad.txt_desde}
                                                        <br> 
                                                        <label style="font-size: 18px;font-weight: bold;">
                                                            USD ${actividad.precio_actividad}
                                                        </label><br>
                                                        <a href="${actividad.url_actividad}" 
                                                            style="background-color: rgba(0,0,0,0);border: 1px solid white;color: white;padding: 1px 10px;font-size:14px">
                                                            ${actividad.txt_mas_detalle}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        `;
    });
    
    document.getElementById('actividades_content').innerHTML = tmp_html;
    document.getElementById('cantidad_resultante').innerHTML = filtrados.length;
    console.log('filtrados.length',filtrados.length);
}
mostrar_actividades(null,null,null);

// Categorias
function mostrar_all_categorias(id){
    if(!id){
        let tmp_html = "";
        categorias.filter(function(categoria){
            
            if(lugar_selected || duracion_selected){
                return !!filtrados.filter(function(actividad){
                    return duracion_selected?!!actividad.duracion_actividad.filter(function(ddd){
                        return ddd==duracion_selected;
                    }).length:true && lugar_selected?actividad.ciudad_cercana==lugar_selected:true;
                }).filter(function(actividad){
                    return !!actividad.categorias.filter(function(ccc){
                        return ccc.id==categoria.txt.id;
                    }).length;
                }).length;
            }else{
                return true;
            }
            
        }).forEach(function(categoria){
            tmp_html = tmp_html + `
                <li class="list-group-item" onclick="mostrar_actividades('${categoria.txt.id}',null,null)">
                    <!--<span class="badge" id="badge-0">
                        ${categoria.count}
                    </span>-->
                    ${categoria.txt.txt} 
                </li>
            `;
        });
        document.getElementById('categorias_content').innerHTML = tmp_html;
    }else{
        let tmp_html = "";
        categorias.filter(function(categoria){
            return categoria.txt.id==id;
        }).forEach(function(categoria){
            tmp_html = tmp_html + `
                <li class="list-group-item " onclick="mostrar_actividades('reset',null,null)">
                    <span class="badge" id="badge-0">
                        <i class="fa fa-remove"></i>
                    </span>
                    ${categoria.txt.txt} 
                </li>
            `;
        });
        document.getElementById('categorias_content').innerHTML = tmp_html;
    }
}
mostrar_all_categorias(null);

// Duraciones
function mostrar_all_duraciones(id){
    if(!id){
        let tmp_html = "";
        duraciones.filter(function(duracion){

            if(lugar_selected || categoria_selected){
                return !!filtrados.filter(function(actividad){
                    return lugar_selected?actividad.ciudad_cercana==lugar_selected:true && categoria_selected?!!actividad.categorias.filter(function(ccc){
                        return ccc.id==categoria_selected;
                    }).length:true;
                }).filter(function(actividad){
                    return !!actividad.duracion_actividad.filter(function(ddd){
                        return ddd.split('!')[1]==duracion.type;
                    }).length;
                }).length;
            }else{
                return true;
            }

        }).forEach(function(duracion){
            var duraciones='';
            duracion.count.filter(function(dura){
                
                return !!filtrados.filter(function(actividad){
                    return !!actividad.duracion_actividad.filter(function(ddd){
                        return `${dura}!${duracion.type}`==ddd;
                    }).length;
                }).length;
                
            }).forEach((item) => {
                duraciones+=`
                    <li class="list-group-item" onclick="mostrar_actividades(null,'${item}!${duracion.type}',null)">
                        ${item} ${duracion.txt}
                    </li>
                `;
            });
            tmp_html = tmp_html + `
                <li class="list-group-item" >
                    <!--<span class="badge" id="badge-0">
                        ${duracion.count}
                    </span>-->
                    <a data-toggle="collapse" href="#card-category-${duracion.type}" aria-expanded="true" aria-controls="card-category">
                    ${duracion.txt}<span class="fa fa-caret-down float-right"></span>
                    </a>
                    <div id="card-category-${duracion.type}" class="collapse ">
                        <ul class="list-group" style="padding: 0" id="categorias_content" >
                            ${duraciones}
                        </ul>
                    </div>
                </li>
            `;
        });
        document.getElementById('duraciones_content').innerHTML = tmp_html;
    }else{
        let tmp_html = "";
        duraciones.filter(function(duracion){
            return duracion.type==id.split('!')[1];
        }).forEach(function(duracion){           
            tmp_html = tmp_html + `
                <li class="list-group-item " onclick="mostrar_actividades(null,'reset',null)">
                    <span class="badge" id="badge-0">
                        <i class="fa fa-remove"></i>
                    </span>
                    ${id.split('!')[0]} ${duracion.txt}
                </li>
            `;
        });
        document.getElementById('duraciones_content').innerHTML = tmp_html;
    }
}
mostrar_all_duraciones(null);

// Lugares
function mostrar_all_lugares(id){
    if(!id){
        let tmp_html = "";
        lugares.filter(function(lugar){

            if(duracion_selected || categoria_selected){
                return !!filtrados.filter(function(actividad){
                    return duracion_selected?!!actividad.duracion_actividad.filter(function(ddd){
                        return ddd==duracion_selected;
                    }).length:true && categoria_selected?!!actividad.categorias.filter(function(ccc){
                        return ccc.id==categoria_selected;
                    }).length:true;
                }).filter(function(actividad){
                    return actividad.ciudad_cercana==lugar.txt;
                }).length;
            }else{
                return true;
            }

        }).forEach(function(lugar){
            tmp_html = tmp_html + `
            <li class="list-group-item" onclick="mostrar_actividades(null,null,'${lugar.txt}')">
                <!--<span class="badge" id="badge-0">
                    ${lugar.count}
                </span>-->
                ${lugar.txt}
            </li>
            `;
        });
        document.getElementById('lugares_content').innerHTML = tmp_html;
    }else{
        let tmp_html = "";
        lugares.filter(function(lugar){
            return lugar.txt==id;
        }).forEach(function(lugar){
            tmp_html = tmp_html + `
            <li class="list-group-item " onclick="mostrar_actividades(null,null,'reset')">
                <span class="badge" id="badge-0">
                    <i class="fa fa-remove"></i>
                </span>
                ${lugar.txt}
            </li>
            `;
        });
        document.getElementById('lugares_content').innerHTML = tmp_html;
    }
}
mostrar_all_lugares(null);

</script>
