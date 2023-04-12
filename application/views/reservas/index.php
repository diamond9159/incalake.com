<?php
//var_dump($datos);

/*funcion para devolder input*/
  $info_tour = $data_calendario;
/*fin de la funcion para devolver input*/

 // var_dump($info_tour);

  //echo $total_personas;
  
  //options_salidas
  function formatoFecha($horainicio,$dur){
            //global $translate;dat
           $tip_tiempo = 0;
           if($dur[1]==0)$tip_tiempo = (60*$dur[0]);
           elseif($dur[1]==1)$tip_tiempo = (60*60*$dur[0]);
           elseif($dur[1]==2)$tip_tiempo = (60*60*24*$dur[0]);
           return 'Inicio: '.date('h:i A',strtotime($horainicio)).' hasta '.date('h:i A',strtotime($horainicio)+$tip_tiempo)." horas ".($dur[1]==2?" dias ".$dur[0]:" del mismo dia.");
  }
  //$inicios_tour = explode(',',$data_calendario['inicio_tour'][0]);
  $duraciones = explode(',',$data_calendario['duracion_tour']);
  $options_salidas = NULL;
  foreach($data_calendario['inicio_tour'] as $key => $value){
    $dur = explode('!',$duraciones[$key]);
    $options_salidas .= '<option value="'.date_format(date_create($value),"H:i").'">'.formatoFecha($value,$dur).'</option>';
  }
  //var_dump($inicio_tour);
?>
<input type="hidden" id="producto_id" value="<?=$info_tour['id']?>" />
<!--	<h1> Reservas para: <?=$info_tour['titulo']?> para una cantidad de <?=$total_personas;?> personas.</h1> -->
	
<div class="container-fluid">
  <?php 
    $data_calendario['data'] = $data_calendario;
    $data_calendario['language'] = $language;
  ?>
</div>
<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <a href="#step-1" type="button" class="btn btn-primary btn-circle btn-bg-wizard"><i class="glyphicon glyphicon-ok"></i></a>
                <p>REALIZA TU RESERVA</p>
            </div>
            <div class="stepwizard-step">
                <a href="#step-2" type="button" class="btn btn-default btn-circle btn-disabled" disabled="disabled" style="position: absolute;
    top: 0;">
                <i class="glyphicon glyphicon-user"></i></a>
                <p style="padding-left: 80px;">DATOS DE CLIENTE</p>
            </div>
            <div class="stepwizard-step">
                <a href="#step-3" type="button" class="btn btn-default btn-circle btn-disabled" disabled="disabled" style="position: absolute;
    top: 0;"><i class="glyphicon glyphicon-shopping-cart"></i></a>
                <p style="padding-left: 80px;">PROCESO DE PAGO</p>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="container-fluid" id="reserva" style="font-family: Noto Sans">
    
    <form role="form" action="<?= url('/api/reservas') ?>" method="post" id="form_reserva_1" onsubmit="return false">
    <!--form role="form" action="<?=base_url();?>procesar_reservas" method="post" id="form_reserva_1" onsubmit="return false"-->
        <div class="container">
        <div class="row setup-content" id="step-1" style="background: rgb(21, 99, 183);padding-top: 20px;padding-bottom:10px;" >
            
                <div class="col-md-12">
                    <div class="form-group col-lg-7 col-md-7 col-sm-6 col-xs-12">
                        <?php $this->load->view('reservas/calendario',$data_calendario); ?>
                    </div>
                    <div class="form-group col-lg-5 col-md-5 col-sm-6 col-xs-12">
                        <label style="color:white;">Nombre del Servicio</label>
                        <select name="slct_nombre_servicio" id="slct_nombre_servicio" style="border:none;border-radius: 0px;padding: 5px;height: 40px;width: 100%">
                            <option><?=$info_tour['titulo']?></option>
                        </select>
                        <label style="color:white;">Hora de Inicio</label>
                        <select name="slct_hora_inicio" id="slct_hora_inicio" style="border:none;border-radius: 0px;padding: 5px;height: 40px;width: 100%">
                            <!--
                            <option value="">-- Seleccione hora de salida --</option>
                            -->
                            <?=$options_salidas;?>
                        </select>
                        <div class="row">
                            <div class="col-xs-6">
                                <label style="color:white;">Fecha de Servicio</label>
                                <input type="text" readonly placeholder="DD-MM-YYYY" id="txt_fecha_servicio" name="txt_fecha_servicio" style="border:none;border-radius: 0px;padding: 5px;height: 40px;width: 100%">
                            </div>
                            <div class="col-xs-6">
                                <label  style="color:white;">Total de Personas</label>
                                <input type="number" name="total_personas" value="<?=@$total_personas?$total_personas:1;?>" placeholder="Cantidad" id="cantidad_input"  size="2" readonly style="border:none;border-radius: 0px;padding: 5px;height: 40px;width: 100%">
                                <input type="hidden" id="person_array" >
                            </div>
                        </div>
                       
                   
                       

                        <!--button type="button"  @click="min"><i class="glyphicon glyphicon-minus"></i></button>
                        <button type="button" @click="max"><i class="glyphicon glyphicon-plus"></i></button-->

                        <!--label>Seleccione Hora de Inicio del Servicio</label>
                                    <select class="form-control" id="slct_hora_inicio_servicio" placeholder="Seleccione...">
                                      <?php foreach ($data_calendario['inicio_tour'] as $key => $value): ?>
                                        <option value=""><?=$value;?></option>
                                      <?php endforeach ?>
                                    </select-->
                  <br>
                    <div class='preciosLista' data-titulo='Precios' data-value='<?=($info_tour['precio_edad']?$info_tour['precio_edad']:$info_tour['precio_persona']);?>'></div>

                    </div>

                   

                    <button class="btn nextBtn btn-next pull-right" type="button" >Siguiente</button>

                </div>
        </div>
        <div class="row setup-content reserva-forms" id="step-2">
            <div class="col-xs-12">
                <div class="col-md-9">
                <div v-for="item in cantidad_persona" style="background: #f5f8fd;padding: 5px 10px;margin-bottom: 50px;">
                    <h2 class="text-capitalize">{{ personas[item-1] }} {{ item }} <span v-if="cantidad_persona!=1 && item==1">(Principal)</span></h2>
                    <hr>
                    <table v-for="f, index in forms"  class="table" v-if="f.group_id != 6 && f.group_id != 3 && f.group_id != 4 && f.group_id != 5">
                        <tbody>
                        <tr>
                            <td style="font-weight: 700;font-size: 20px;">
                                {{ f.group }}
                            </td>
                        </tr>
                        <tr v-for="i in f.inputs" v-if="i.name != 'txt_direccion_hotel'">
                            <td style="font-weight: 700;width: 350px;border:none;">
                                - {{ i.label }} *
                            </td>
                            <td style="border:none">
                                 <input :type="i.type" :name="i.name" :placeholder="i.placeholder" class="form-control" />
                            </td>
                        </tr>

                        <tr v-for="i in f.inputs" v-if="i.name == 'txt_direccion_hotel' && item == 1">
                             <td style="font-weight: 700;width: 350px;border:none;">
                                - {{ i.label }} *
                            </td>
                            <td style="border:none">
                                 <input :type="i.type" :name="i.name" :placeholder="i.placeholder" class="form-control" />
                            </td>
                        </tr>
                        </tbody>
                      </table>
                      <table v-for="f, index in forms"  class="table" v-if="f.group_id == 6 && item==1">
                        <tbody >
                        <tr>
                            <td style="font-weight: 700;font-size: 20px;">
                                {{ f.group }}
                            </td>
                        </tr>
                        <tr v-for="i in f.inputs">
                            <td style="font-weight: 700;width: 350px;border:none;">
                                - {{ i.label }} *
                            </td>
                            <td style="border:none">
                                 <input :type="i.type" :name="i.name" :placeholder="i.placeholder" class="form-control" />
                            </td>
                        </tr>
                        </tbody>
                      </table>
                     <hr>
                </div>
                <h1>Información de viaje</h1>                
                <table class="table table-striped">
                    <thead>
                    <tr>
                    <template v-for="f, index in forms">
                        <td  v-if="f.group_id == 3"/><label><input type="radio" name="viaje" v-model="viaje" :value="3"> &nbsp; Vuelo</label></td>
                        <td  v-if="f.group_id == 4"><label><input type="radio" name="viaje" v-model="viaje" :value="4"/> &nbsp; Tren</label></td>
                        <td  v-if="f.group_id == 5"><label><input type="radio" name="viaje" v-model="viaje" :value="5"/> &nbsp; Carro</label></td>
                    </template>
                    </tr>
                    </thead>
                </table>
                <table class="table">    
                    <tbody v-for="f, index in forms"  class="table" v-if="f.group_id == 3 || f.group_id == 4 || f.group_id == 5" v-show="viaje == f.group_id" >
                    <tr>
                        <td style="font-weight: 700;font-size: 20px;">
                            {{ f.group }}
                        </td>
                    </tr>
                    <tr v-for="i in f.inputs">
                        <td style="font-weight: 700;width: 350px;border:none;">
                            - {{ i.label }} *
                        </td>
                        <td style="border:none">
                             <input :type="i.type" :name="i.name" :placeholder="i.placeholder" class="form-control" />
                        </td>
                    </tr>
                    </tbody>
                  </table>
                    <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Back</button>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                </div>
            </div>
        </div>
        <div class="row setup-content" id="step-3">
            <div class="col-xs-12">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <td>TOTAL</td><td><i class="glyphicon glyphicon-user"></i> x {{ $("#cantidad_input").val() }} =  <small>$</small> {{ $(".totalprice").text() }} <small>USD</small></td>
                        </tr>
                        <tr>
                            <td>Tours</td><td>{{ $("#slct_nombre_servicio").find('option').first().text() }}</td>
                        </tr>
                        <tr>
                            <td>Hora de inicio</td><td>{{ $("#slct_hora_inicio").find(':selected').text() }}</td>
                        </tr>
                        <tr>
                            <td>Fecha de servicio</td><td> <span id="resumen_fecha_servicio"></span> </td>
                        </tr>
                        <tr>
                            <td>Clientes</td><td><span class="resumen-info-cliente-1"></td>
                        </tr>
                    </table>
                    
                    <?=($info_tour['precio_edad']?$info_tour['precio_edad']:$info_tour['precio_persona']);?>
                    <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Back</button>
                    <button class="btn btn-success btn-lg pull-right sendBtn" type="submit" onclick="procesarForm();">Send Reserve!</button>
                </div>
            </div>
        </div>
    </form>
        </div>
        <div  class="col-xs-12 col-md-1"></div>
        </div>
</div>

<script>
    $(document).on('change', '#resumen-info-cliente-1', function (event) {
        $(".resumen-info-cliente-1").text($("#resumen-info-cliente-1").val());
    });
</script>