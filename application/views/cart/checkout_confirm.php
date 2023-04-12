<?php 
     
    $reserva = Reserva_::find($codr);
    use Carbon\Carbon;
    Carbon::setLocale('es');
    $fecha_creacion_reserva = Carbon::parse($reserva->fecha_creacion_reserva);

?><br>
<!-- Event snippet for Confirmación de Compra conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-946004111/xczFCPjS_oABEI_Bi8MD',
      'transaction_id': ''
  });
</script>

<div class="container" style="font-family: Source Sans Pro">
    <div class="row">
        <div class="col-12"> 
            <div class="alert alert-success" rolge="alert">
                <strong><i class="fa fa-check" aria-hidden="true"></i> 
                <?php if($reserva->metodo_pago  == 'giro' || $reserva->metodo_pago == 'transferencia'): ?>
                    <?= translateCart('info_reserve_gt').$fecha_creacion_reserva->addHours(24)->toDayDateTimeString().'</strong></small>'; ?>
                <?php else: ?> 
                    <?= translateCart('info_exito_pago') ?>
                <?php endif; ?>
                </strong>
            </div>         
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-7" >
            <h3><?= translateCart("resumen_compra") ?></h3>
            <!--
            <span>N°<?= translateCart('de_reserva') ?>: <strong><?= $reserva->codigo_reserva ?></strong></span><br>
            -->
            <span>N° <?= translateCart('de_reserva') ?>: <strong><?=date_format(date_create(@$fechas['fecha_servicio']),'dmY').'-'.@$fechas['cantidad_servicios']?></strong></span><br>
            Sr(a). <?= strtoupper($reserva->nombres_cliente.' '.$reserva->apellidos_cliente) ?> 
            <br>
            Cel.  <?= $reserva->telefono_cliente ?> <br><br>
            <table class="table table-sm">
                <?php $sum_tasa = 0; $sum_total = 0;
              
                 foreach($payments as $pay): ?>
                        <tr  style="background: white;">
                            <td width="100px" style="vertical-align: middle;">   
                                <img src="<?= $pay['img'] ?>" width="200px">
                            </td>
                            <td style="vertical-align: top;padding: 10px;">  

                                <strong style="font-size: 24px;"><?= $pay['titulo_producto'] ?>                                     
                                </strong><br> <a href="<?= $pay['url'] ?>" target="_blank" style="color: #eca931;"><i class="fa fa-link"></i> Ref website.</a> <br>
                                <strong><?= translateCart('lugar_recojo') ?>: </strong> <?= $pay['lugar_recojo'] ?><br>
                                <strong style="color:#333;">  <?= translateCart('fecha_servicio') ?>: </strong> 
                                <?= Carbon::parse($pay['fecha_servicio'])->toFormattedDateString() ?> <br>
                                 <?php if(trim($pay['duracion_servicio']) != ''): ?>
                                    <strong style="color:#333;">  <?= translateCart('hora_inicio') ?>: </strong><?= $pay['duracion_servicio'] ?> <br>
                                    <strong style="color:#333;">  <?= translateCart('duracion') ?>: </strong>  <?= $pay['hora_inicio_servicio'] ?> 
                                <?php endif; ?>
                                <table class="table table-sm">
                                <?php 
                                    $sum_tasa += $pay['importe_tasas_impuestos'];
                                    $sum_total += $pay['precio_total']; 
                                ?>
                                    <?php foreach($pay['resumen'] as $resumen): ?>
                                        <tr style="font-size: 14px;">
                                                <td><?= str_replace("General","",$resumen['nombre_articulo']) ?> x <?= $resumen['cantidad_articulo'] ?></td>
                                                <td class="text-right"><?= number_format($resumen['precio_articulo'], 2, '.','') ?> USD</td>
                                        </tr>
                                    <?php 
                                        endforeach; 
                                    ?>                                     
                                </table>
                            </td>
                        </tr>
                <?php endforeach; ?>
                <?php 
                    $descuentoGlobal = 0;
                    if ( $reserva->monto_cupon_descuento != 0 ){
                        $descuentoGlobal = $reserva->monto_cupon_descuento;
                    }
                    $montoTotalGlobal = $sum_total + $sum_tasa - $descuentoGlobal;
                ?>
                <tr>
                    <td></td>
                    <td>
                         <strong><?= translateCart('tasas_impuestos') ?> ( <?= $reserva->tasas_impuestos ?> %)</strong>
                         <strong class="float-right"> <?= number_format($sum_tasa, 2, '.', '') ?>   USD</strong>
                    </td>
                </tr>
                <?php if ($reserva->monto_cupon_descuento != 0 ): ?>
                <tr>  
                    <td></td> 
                    <td>
                        <strong><?= translateCart('descuentos') ?></strong>
                        <strong class="float-right"> - <?= number_format($reserva->monto_cupon_descuento, 2, '.', '') ?>   USD</strong>
                    </td>
                </tr>
                <?php endif ?>
                <tr>
                    <td></td>
                    <td style="font-size: 20px;">    
                        <strong>TOTAL</strong>
                        <!--
                        <strong class="float-right"> <?= number_format($sum_total, 2, '.', '') ?>   USD</strong>
                        -->
                        <!--
                        <strong class="float-right"> <?= number_format($montoTotalGlobal, 2, '.', '') ?>   USD</strong>
                        -->
                        <strong class="float-right"> <?= number_format($reserva->monto_total, 2, '.', '') ?>   USD</strong>
                    </td>
                </tr>
                <?php if ( @$reserva->monto_total > @$cuotas['monto_adelantado'] && @$cuotas['monto_adelantado'] > 0 ): ?>
                    <tr>
                        <td></td>
                        <td style="font-size: 20px;" class="text-success">    
                            <strong><?=translateCart('monto_pagado');?></strong>
                            <!--
                            <strong class="float-right"> <?= number_format($sum_total, 2, '.', '') ?>   USD</strong>
                            -->
                            <strong class="float-right"> <?= number_format( @$cuotas['monto_adelantado'], 2, '.', '') ?>   USD</strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-size: 20px;" class="text-danger">    
                            <strong><?=translateCart('monto_a_pagar');?></strong>
                            <!--
                            <strong class="float-right"> <?= number_format($sum_total, 2, '.', '') ?>   USD</strong>
                            -->
                            <strong class="float-right"> <?= number_format( (@$reserva->monto_total-@$cuotas['monto_adelantado']), 2, '.', '') ?>   USD</strong>
                            <p style="font-size: 13px;">*<?=translateCart('descripcion_monto_a_pagar');?></p>
                        </td>
                    </tr>
                <?php endif ?>
            </table>
            
            <p class="text-right d-none">
                <a href="<?= url($language.'/vaucher/payment?codr='.$codr) ?>" class="btn btn-primary">
                    <strong><i class="fa fa-arrow-down" aria-hidden="true"></i> <?= translateCart('descargar_vaucher') ?></strong>
                </a>
            </p>

            <p style="font-size: 13px;">
                * <?= translateCart('info_envio_correo_vaucher_1') ?>
                <strong><?= $reserva->email_cliente ?></strong>, <?= translateCart('info_envio_correo_vaucher_2') ?>.

            </p>

        </div>
         <div class="col-12 col-lg-5">
         <div class="alert alert-warning" rolge="alert" style="font-size: 14px;border-left: 5px solid #ffd08f;">           
                
                  <?= translateCart('info_requerir_form_tour') ?>
         </div>
         <div >
            <?php foreach($payments as $key => $p): ?>

                        <?php 
                            $array_ = [];

                            $forms =  ProductoModel::where('producto.id_producto', $p['id_producto'])
                            ->join('producto_has_campoform', 'producto_has_campoform.id_producto', 'producto.id_producto')
                            ->join('campo_formulario', 'campo_formulario.id_campo_formulario', 'producto_has_campoform.id_campo_formulario')
                            ->orderBy('campo_formulario.id_campo_categoria', 'asc')
                            ->orderBy('campo_formulario.prioridad_campo', 'asc')
                            ->get(['producto.id_producto', 'producto.forms_multiple', 'campo_formulario.nombre_campo']);
                        ?>
                <div class="card" style="margin-bottom: 10px;">
                 <div class="bg-primary text-light card-header"><strong><?=($key+1).'.- '.strtoupper($p['titulo_producto']) ?> </strong></div>
                 <div class="card-body">    
                    <?php foreach ($forms as $index => $f): ?>
                        <?php if($index == 0): ?>
                            <?php if(!$f->forms_multiple): ?>
                                <strong><?= translateCart("datos_lider") ?>.</strong>
                            <?php else: ?>
                                <span style="background: #ffffb3;"><?= translateCart("datos_pasajeros") ?>  </span>  <br>
                            <?php foreach ($p['resumen'] as $index => $r): ?>  
                                <?php if($r['tipo_articulo'] == 'persona'): ?>
                                    <strong><?= str_replace('General', '',$r['nombre_articulo']) ?> x <?= $r['cantidad_articulo'] ?></strong>, 
                                <?php endif;  ?>
                            <?php endforeach; ?>
                            <ol>
                            <?php endif; ?>
                        <?php endif; ?>
                        <li><?= json_decode($f->nombre_campo, true)[$language]  ?></li>
                    <?php endforeach; ?>
                    </ol>
                    <hr>
                    <a href="<?=base_url().$language."/data/customer?id={$datos_reserva['id_reserva']}&cod={$datos_reserva['codigo_reserva']}";?>" target="_blank" class="btn btn-info"><?= translateCart("enviar_datos_pasajeros");?></a>
                  </div>
                  </div>
                       
            <?php endforeach; ?>
        </div>
        </div>
    </div>
</div>
<hr>

<script type="text/javascript">
    var codRes = "<?=@$codr;?>";
    $.ajax({
        url: '<?=base_url();?>operador/enviarEmail/'+parseInt(codRes),
        type: 'POST',
        dataType: 'json',
        data: {cr: codRes},
    }).done(function(data) {
        console.log("success");
    }).fail(function(e) {
        console.log(e.responseText);
    });
</script>