<?php
	// llama modelo destino_model
	$ci = &get_instance();
	$ci->load->model("destino_model");
	$destinos_suscripcion=$ci->destino_model->destinos_footer($language);
?>
<style type="text/css">
      .text-muted {
          color: #9e9e9e !important;
      }
    .modal-body .bullets span {
    content: '';
    width: 10px;
    height: 10px;
    border-radius: 100%;
    background: #ced4da;
    display: inline-block;
    margin-right: 5px;
    z-index: 1;
    transition: all .2s ease-in;
}
.modal-body  .bullets span.active {
    background: #007bff;
}
.suscripcion_gracias{
  display: none;
}
.border-danger:focus {
    color: #f30000;
    border-color: #ff0909;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(255, 47, 0, 0.25);
}
#nombre_email_resgistradoHelp{
  display: none;
}
    </style>
<div class="row" style="background: #e9ecef;">
  <div class="container mt-3 mb-3">
      <div class="row" >
        <div class="col-12"><h4><?=($language=='es'?'Boletín de suscripción':'Subscription bulletin')?></h4></div>
        <div class="col-12 col-md">
          <div class="form-group">
            <!-- <label for="nombre_suscripcion">Nombre</label> -->
            <input type="text" class="form-control" id="nombre_suscripcion" aria-describedby="nombre_suscripcionHelp" placeholder="Nombre" data-toggle="tooltip" title="<?=($language=='es'?'Escriba su nombre':'Write your name')?>">
            <small id="nombre_suscripcionHelp" class="text-muted"><?=($language=='es'?'Nuestros boletines son Personalizados para usted.':'Our bulletins are customized for you.')?></small>
          </div>
        </div>
        <div class="col-12 col-md">
          <div class="form-group">
            <!-- <label for="nombre_email">Email</label> -->
            <input type="email" class="form-control" id="nombre_email" aria-describedby="nombre_emailHelp" placeholder="micorreo@es.asi" data-toggle="tooltip" title="<?=($language=='es'?'Escriba su email':'Write your email')?>">
            <small id="nombre_emailHelp" class="text-muted"><?=($language=='es'?'Dirección donde le enviamos nuestros boletines.':'Address where we send our newsletters.')?></small>
<small id="nombre_email_resgistradoHelp" class="text-danger font-weight-bold"><?=($language=='es'?'Email ya está registrado':'Email is already registered')?></small>
          </div>
        </div>
        <div class="col-12  col-md text-center">
          <span class="w-100 btn btn-success text-uppercase font-weight-bold btn_modal_suscripcion"><?=($language=='es'?'Si Quiero':'Yes, I want')?></span>
        </div>
      </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="suscrípcionMoldal" tabindex="-1" role="dialog" aria-labelledby="suscrípcionMoldalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="suscripcion_datos">
        <div class="modal-header p-0">
          <div class="" style="position: relative;">
              <div class="h-100 w-100 row p-0 m-0 text-center" style="position: absolute;">
                <div class="align-self-center text-center w-100">
                  <h4 class="font-weight-bold text-white text-uppercase"><?=($language=='es'?'Boletin IncaLake':'IncaLake Newsletter')?></h4>
                </div>
              </div>
              <img title="Lago Titicaca: : las mejores atracciones del lado peruano" src="https://s3.amazonaws.com/bk-static-prd-newctn/files/styles/full_image_block_experience_960x539/s3/2016-08/960x539_Header-novo.jpg?itok=Hq1PC5AC" class="w-100">
            </div><button type="button" class="close  m-0" data-dismiss="modal" aria-label="Close" style="right:  0;top: 0;position: absolute;padding: 1rem;">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <h4 class="text-uppercase text-primary text-center font-weight-bold form-group"><?=($language=='es'?'¿quieres saber más sobre tu próximo destino?':'Do you want to know more about your next destination?')?></h4>
          <p>
            <small class="text-capitalize text-muted  text-center"><?=($language=='es'?'Enterate de novedades promoción y noticias suscribiendote a nuestro boletín':'Find out about news and promotion news by subscribing to our newsletter')?></small>
          </p>
          <div class="row form-group">
            <div class="col-12 col-md">
              <div class="form-group">
                <label for="destino_suscripcion" id='destino_suscripcion_txt' data-toggle="tooltip" title="<?=($language=='es'?'Seleccione por lo menos 1 destino':'Select at least 1 destination')?>"><?=($language=='es'?'Seleccione su destino que planea visitar':'Select your destination you plan to visit')?></label>
                <!-- <input type="email" class="form-control" id="nombre_suscripcion" aria-describedby="nombre_suscripcionHelp" placeholder="Nombre"> -->
                <!-- <small id="nombre_suscripcionHelp" class="form-text text-muted">Nuestros boletines son Personalizados para usted.</small> -->
                <div class="container">
                  <div class="col-12">
					<?php
					foreach ($destinos_suscripcion as $key => $value) {?>
					   <div class="form-check">
					     <input class="form-check-input" type="checkbox" name="flavours" value="<?=$value['id_destino']?>" id="Check<?=$value['id_destino']?>">
					     <label class="form-check-label" for="Check<?=$value['id_destino']?>">
					       <?=$value['nombre_destino']?>
					     </label>
					   </div>  
					<?php } ?>
					 </div>
                </div>

                
            </div>
            </div>
            <div class="col-12 col-md">
              <div class="form-group">
                <label for="fecha_viaje" id="fecha_viaje_txt" data-toggle="tooltip" title="<?=($language=='es'?'Seleccione el mes que planea viajar':'Select the month you plan to travel')?>"><?=($language=='es'?'Seleccione cuando planea viajara':'Select your destination you plan to visit')?></label>
                <div class="input-group date">
                  <input type="text" class="form-control" id="fecha_viaje" aria-describedby="nombre_suscripcionHelp" placeholder="2018-01">
                </div>
              </div>
              <div class="form-group">
                <label for="duracion_viaje" id="duracion_viaje_txt" data-toggle="tooltip" title="<?=($language=='es'?'Seleccione la duración de su viaje':'Select the duration of your trip')?>"><?=($language=='es'?'Seleccione la duración de su viaje':'Select the duration of your trip')?></label>
                <div class="input-group date">
                  <!-- <input type="email" class="form-control" id="duracion_viaje" aria-describedby="nombre_suscripcionHelp" placeholder="1 Dia"> -->
                  <select class="form-control" id="duracion_viaje">
                    <option value="" selected><?=($language=='es'?'Duración':'Duration')?></option>
                    <option value="1d">1 <?=($language=='es'?'Día':'Day')?></option>
                    <option value="2d">2 <?=($language=='es'?'Días':'Days')?></option>
                    <option value="3d">3 <?=($language=='es'?'Días':'Days')?></option>
                    <option value="5d">+5 <?=($language=='es'?'Días':'Days')?></option>
                    <option value="1s">+1 <?=($language=='es'?'Semana':'week')?></option>
                    <option value="1m">+1 <?=($language=='es'?'Mes':'Month')?></option>
                  </select>
                </div>
              </div>
              
            </div>
            <div class="col-12 text-center" >
              <!-- <span class="btn btn-secondary" data-dismiss="modal">Close</span> -->
              <span class="btn btn-danger btn_suscribirme">!<?=($language=='es'?'Suscribirme':'Subscribe')?>¡</span>
            </div>
          </div>
          
        
        
        <div class="container text-center">
            <div class="bullets"> 
              <span class="step-1 active"></span> 
              <span class="step-2"></span> 
            </div>
        </div>
        </div>
      </div>
      <hr>
      <div class="suscripcion_gracias">
        <!-- <div class="modal-header "></div> -->
        <h4 class="text-uppercase font-weight-bold text-center text-primary"><?=($language=='es'?'¡Muchas gracias':'Thank you very much')?> <span id="nombre_suscripcion_tooltip_txt"></span> <?=($language=='es'?'por suscribirse!':'for subscribing!')?></h4>
        <div class="modal-body">
          <div class="row p-3">
            <div class="col-12 bg-primary text-white p-3 form-group">
              <div class="row">
                <div class="col-auto align-self-center text-center">
                  <span class="fa fa-info-circle fa-3x "></span>
                </div>
                <div class="col pl-0">
                  <span><?=($language=='es'?'Te enviamos un email a':'We send you an email to')?> <span id="nombre_email_tooltip_txt"></span> <?=($language=='es'?'dias antes de su viaje. Si no lo encuentras, recuerda que puede estar en correo no deseado.':'for days before your trip. If you can not find it, remember that it may be in junk mail.')?></span>
                </div>
              </div>
            </div>
            <div class="col-12 text-center" >
              <!-- <span class="btn btn-secondary" data-dismiss="modal">Close</span> -->
              <span class="btn btn-danger" data-dismiss="modal"><?=($language=='es'?'Entiendo':'Understand')?></span>
            </div>
          </div>

          <div class="container text-center">
              <div class="bullets"> 
                <span class="step-1 "></span> 
                <span class="step-2 active"></span> 
              </div>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer text-center">
      </div> -->
    </div>
  </div>
</div>
<!-- fin modal -->