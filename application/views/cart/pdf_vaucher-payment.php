<?php

function translateVoucher($palabra, $lang = "es") {
     $diccionario = [
        "lugar_recojo" => [
            "es" => 'Lugar de recojo',
            "en" => 'Pick up place',
            "br" => 'Local de recolha',
            "de" => 'Standort abholen',
            "fr" => 'Lieu de ramassage',
        ],
        "fecha_servicio" => [
            "es" => "Fecha de servicio",
            "en" => "Date of service",
            "br" => '',
            "de" => '',
            "fr" => '',
        ],
        "hora_inicio" => [
            "es" => "Hora de inicio",
            "en" => "Start time",
        ],
        "duracion" => [
            "es" => "Duración",
            "en" => "Duration",
        ],
        "tasas_e_impuestos" => [
            "es" => "Tasas e impuestos",
            "en" => "Taxes and fees",
        ],
        "a_pagar" => [
            "es" => "A PAGAR",
            "en" => "PAY",
        ],
        "title_resumen_compra" => [
            "es" => "Resumen de compra",
            "en" => "Purchase Summary",
        ],
        "title_terminos_servicio" => [
            "es" => "Términos y condiciones de servicio",
            "en" => "Terms and conditions of service"
        ],
        "title_los_servicios_incluyen" => [
            "es" => "Los servicios incluyen",
            "en" => "The services include"
        ],
        "info_duracion_pago" => [
            "es" => "Esta reserva tiene una duración máxima de 24 horas, termina el",
            "en" => "This reservation has a maximum duration of 24 hours, ends on",
        ],
        "info_envio_correo_vaucher_1" => [
            "es" => "Hemos realizado el envío de su voucher de su compra a su correo electrónico ",
            "en" => "We have sent your proof of purchase to your email",
        ],
        "info_envio_correo_vaucher_2" => [
            "es" => "para más detalles puede comunicarse a reservas@incalake.com o a los números +51949755305 / +51982769453 / +51984434731.",
            "en" => "For more details you can contact reservas@incalake.com or the numbers +51949755305 / +51982769453 / +51984434731.",
        ],
        "title_reserva_num" => [
            "es" => "N° de reserva",
            "en" => "N° of reserve",
        ],

        "title_voucher" => [
            "es" => "VOUCHER DE PAGO - INCALAKE TRAVEL",
            "en" => "PAYMENT VOUCHER - INCALAKE TRAVEL",
        ],
        "title_voucher_gt" => [
            "es" => "RESERVA DE SERVICIO - PAGO PENDIENTE POR ",
            "en" => "SERVICE RESERVATION - PENDING PAYMENT BY ",
        ],
        "datos_requeridos" => [
            "es" => "Datos requeridos",
            "en" => "Data required", 
        ],
        "datos_lider" => [
            "es" => "Proporcione los datos del lider",
            "en" => "Provide leader data",
        ],
        "datos_pasajeros" => [
            "es" => "Datos de los pasajeros",
            "en" => "Passenger information",
        ],
        "no_data" => [
            "es" => "No se require ningun información personal para este tour.",
            "en" => "No personal information is required for this tour.",
        ],
        "descuentos" => [
            "es" => 'Descuentos',
            "en" => 'Discounts',
        ],
        "monto_pagado" => [
            "es" => "MONTO PAGADO",
            "en" => "PAID AMOUNT",
        ],
        "monto_a_pagar" => [
            "es" => "MONTO A PAGAR*",
            "en" => "AMOUNT PAYABLE",
        ],
        "descripcion_monto_a_pagar" => [
            "es" => "MONTO A PAGAR se debe pagar antes de iniciar el tour y recomendamos pagar con dinero
en efectivo. Caso contrario el tour no se podrá iniciar.",
            "en" => "AMOUNT TO PAY must be paid before starting the tour and we recommend paying with cash. Otherwise the tour can not be started.",
        ],
        "mensaje_pasajeros" => [
            "es" => "<b>Importante: </b> Puedes enviar la información requerida desde el siguiente enlace: ",
            "en" => "<b> Important: </ b> Send the requested information through the following link: ",
        ]
         
    ];
        
    if(isset($diccionario[$palabra][$lang])) {
        return $diccionario[$palabra][$lang];
    } else {
        return $diccionario[$palabra]["en"];
    }
}

    use Carbon\Carbon;
    Carbon::setLocale('es');
    $reserva_cliente  = Reserva_::find($codr); 
    $fecha_creacion_reserva = Carbon::parse($reserva_cliente->fecha_creacion_reserva);

    
    $cont_ = 0;
    $detalles = DetalleServicio_Reserva::join('detalle_servicio', 'detalle_servicio_has_reserva.id_detalle_servicio', 'detalle_servicio.id_detalle_servicio')
                ->join('producto', 'producto.id_producto'       , 'detalle_servicio.id_producto')
                ->join('resumen',  'resumen.id_detalle_servicio', 'detalle_servicio.id_detalle_servicio')
                ->where('id_reserva', $codr)
                ->orderBy('producto.id_producto', 'desc')
                ->get([
                    'producto.tipo_recojo', 'producto.lugar_recojo',
                    'producto.titulo_producto', 'producto.id_producto',
                    'producto.politicas_producto',
                    'detalle_servicio.descuento', 'detalle_servicio.importe_tasas_impuestos',
                    'detalle_servicio.fecha_servicio', 'detalle_servicio.duracion_servicio', 'detalle_servicio.hora_inicio_servicio',
                    'resumen.nombre_articulo','resumen.cantidad as cantidad_articulo', 
                    'resumen.tipo_articulo',
                    'resumen.precio as precio_articulo', 'detalle_servicio.precio_total as precio_total',
                ]);

        $array_tour = [];
        $tourReserve = "";     
        $flag = -1;

        foreach ($detalles as $key => $reserva) {
            if($reserva->id_producto != $tourReserve) {
                $resumen = [];
                
                $img = GaleriaHasProducto::join('galeria', 'galeria.id_galeria', 'galeria_has_producto.id_galeria')
                            ->where('galeria_has_producto.id_producto', $reserva->id_producto)->take(1)->get(['url_archivo', 'carpeta_archivo']);

                if(count($img) == 0) {
                    $url_img = 'http://vollrath.com/ClientCss/images/VollrathImages/No_Image_Available.jpg';
                } else {
                    $url_img = url('galeria/admin/short-slider/'.$img[0]->carpeta_archivo.'/thumbs/'.$img[0]->url_archivo);
                }
                //$url_img = 'http://vollrath.com/ClientCss/images/VollrathImages/No_Image_Available.jpg';
                array_push($array_tour, [
                    'id_producto' => $reserva->id_producto,
                    'titulo_producto' => $reserva->titulo_producto,
                    'lugar_recojo' => $reserva->lugar_recojo,
                    'fecha_servicio' => $reserva->fecha_servicio,
                    'hora_inicio_servicio' => $reserva->hora_inicio_servicio,
                    'duracion_servicio' => $reserva->duracion_servicio,
                    'img' => 'https:' . $url_img,
                    'politicas_producto' => $reserva->politicas_producto,
                    'precio_total' => $reserva->precio_total,
                    'str_url' => base_url() . url('galeria/admin/short-slider/'.$img[0]->carpeta_archivo.'/thumbs/'.$img[0]->url_archivo),
                    'importe_tasas_impuestos' => $reserva->importe_tasas_impuestos,
                    'resumen' => [[
                        'nombre_articulo' => $reserva->nombre_articulo,
                        'cantidad_articulo' => $reserva->cantidad_articulo,
                        'precio_articulo' => $reserva->precio_articulo,
                        'tipo_articulo' => $reserva->tipo_articulo,
                    ]]
                ]);
                $tourReserve = $reserva->id_producto;
                $flag++;
            } else {
                array_push($array_tour[$flag]['resumen'], array(
                    'nombre_articulo' => $reserva->nombre_articulo,
                    'cantidad_articulo' => $reserva->cantidad_articulo,
                    'precio_articulo' => $reserva->precio_articulo,
                    'tipo_articulo' => $reserva->tipo_articulo,
                ));
            }

        }
        $data['payments'] = $array_tour;

        // generar enlace para lista de pasajeros
        $enlace_pasajeros = base_url().$reserva_cliente->lang.'/data/customer?id='.$reserva_cliente->id_reserva.'&cod='.$reserva_cliente->codigo_reserva;
 ?>
<!Doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
    <style type="text/css">
    @page { margin: 0px; }
    body { margin: 0px; }
    table
    {
        padding: 10px;
    }
    </style>
</head>
<body>
    <div style="background: <?= $reserva_cliente->metodo_pago == 'giro' || $reserva_cliente->metodo_pago == 'transferencia'? '#cd2222':'#1c5fb0' ?>;color:white;padding: 30px">
        <strong>
            <?=
            $reserva_cliente->metodo_pago == 'giro' || $reserva_cliente->metodo_pago == 'transferencia'? translateVoucher('title_voucher_gt', $reserva_cliente->lang).' [ '.strtoupper($reserva_cliente->metodo_pago).' ]': translateVoucher('title_voucher', $reserva_cliente->lang) ?> 
        </strong>
    </div>
<div style="padding: 20px">
        
    <div class="row">
        <div class="col-12 col-lg-7" >
        <div style="background: #fff585;color:#8b2d18;">
        <?php if($reserva_cliente->metodo_pago  == 'giro' || $reserva_cliente->metodo_pago == 'transferencia'): ?>
            <?= translateVoucher('info_duracion_pago', $reserva_cliente->lang).'<strong>'.$fecha_creacion_reserva->addHours(24)->toDayDateTimeString().'</strong></small>'; ?>
        <?php endif; ?> 
        </div>

        <h3 style="margin-bottom: 0px;padding-bottom: 0px;"><?= translateVoucher('title_resumen_compra', $reserva_cliente->lang) ?></h3>
        
        <span><?= translateVoucher("title_reserva_num", $reserva_cliente->lang) ?>: <strong><?= $reserva_cliente->codigo_reserva ?></strong></span><br>
        
        <!--
        <span><?= translateVoucher("title_reserva_num", $reserva_cliente->lang) ?>: <strong><?=date_format(date_create(@$fechas['fecha_servicio']),'dmY').'-'.@$fechas['cantidad_servicios']?></strong></span><br>
        -->
       <small>Sr(a). <?= strtoupper($reserva_cliente->nombres_cliente.' '.$reserva_cliente->apellidos_cliente) ?>. </small><br>
       Tel: <?= $reserva_cliente->telefono_cliente ?><br>
        <table style="width:100%;">
            <?php $sum_tasa = 0; $sum_total = 0;
             foreach($array_tour as $pay): ?>
                    <tr>
                        <td width="100px" style="vertical-align: top;border-top:1px solid #ccc;">   
                            <img src="<?= $pay['img'] ?>" width="150px">
                        </td>
                        <td style="vertical-align: top;padding: 10px;padding-top:0px;font-size: 14px;"> 
                            <strong style="font-size: 18px;"><?= strtoupper($pay['titulo_producto']) ?> </strong><br>
                            <strong><?= translateVoucher('lugar_recojo', $reserva_cliente->lang) ?>: </strong> 
                            <?= $pay['lugar_recojo'] ?><br>
                            <strong style="color:#333;">  <?= translateVoucher('fecha_servicio', $reserva_cliente->lang) ?>: </strong> <?= Carbon::parse($pay['fecha_servicio'])->toFormattedDateString() ?> <br>
                            <?php if(trim($pay['duracion_servicio'])!=''): ?>
                                <strong style="color:#333;">  <?= translateVoucher('hora_inicio', $reserva_cliente->lang) ?> : </strong><?= $pay['duracion_servicio'] ?> <br>
                                <strong style="color:#333;">  <?= translateVoucher('duracion', $reserva_cliente->lang) ?>: </strong>  <?= $pay['hora_inicio_servicio'] ?> 
                            <?php endif; ?>
                            <table style="width:100%;border-top:1px solid #ccc;">
                            <?php 
                                $sum_tasa += $pay['importe_tasas_impuestos'];
                                $sum_total += $pay['precio_total']; 
                            ?>

                                <?php foreach($pay['resumen'] as $resumen): ?>
                                    <tr style="font-size: 14px;">
                                            <td><?= str_replace("General","",$resumen['nombre_articulo']) ?> x <?= $resumen['cantidad_articulo'] ?></td>
                                            <td style="text-align: right;">
                                                <span style="text-align: right;float:right;">
                                                    <?= number_format($resumen['precio_articulo'], 2, '.','') ?> USD
                                                </span>
                                            </td>
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
                <td>
                   
                </td>
                <td style="border-top:1px solid #ccc;">
                     <strong><?= translateVoucher('tasas_e_impuestos', $reserva_cliente->lang) ?> ( <?= $reserva_cliente->tasas_impuestos ?> % )</strong>
                     <strong style="float:right;"> <?= number_format($sum_tasa, 2, '.', '') ?>  USD </strong>
                </td>
            </tr>
            <?php if ($reserva_cliente->monto_cupon_descuento != 0 ): ?>
            <tr>  
                <td></td> 
                <td>
                    <strong><?= translateVoucher('descuentos') ?></strong>
                    <strong  style="float:right;"> - <?= number_format($reserva_cliente->monto_cupon_descuento, 2, '.', '') ?>   USD</strong>
                </td>
            </tr>
            <?php endif ?>
            <tr>
                <td></td>
                <td style="font-size: 20px;">    
                    <strong>TOTAL <?= $reserva_cliente->metodo_pago == 'giro' || $reserva_cliente->metodo_pago == 'transferencia'? translateVoucher('a_pagar', $reserva_cliente->lang):'' ?> </strong>
                    <!--
                    <strong style="float:right;"> <?= number_format($sum_total, 2, '.', '') ?>  USD </strong>
                    -->
                        <!--
                        <strong class="float-right"> <?= number_format($montoTotalGlobal, 2, '.', '') ?>   USD</strong>
                        -->
                        <strong style="float:right;"> <?= number_format($reserva_cliente->monto_total, 2, '.', '') ?>   USD</strong>
                </td>
            </tr>
            <?php if ( @$reserva_cliente->monto_total > @$cuotas['monto_adelantado'] && @$cuotas['monto_adelantado'] > 0 ): ?>
                <tr>
                    <td></td>
                    <td style="font-size: 20px;color:#28a745;" class="text-success">    
                        <strong><?=translateVoucher('monto_pagado');?> </strong>
                        <!--
                        <strong class="float-right"> <?= number_format($sum_total, 2, '.', '') ?>   USD</strong>
                        -->
                        <strong  style="float:right;"> <?= number_format( @$cuotas['monto_adelantado'], 2, '.', '') ?>   USD</strong>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-size: 20px; color:#dc3545;" class="text-danger">    
                        <strong><?=translateVoucher('monto_a_pagar');?></strong>
                        <!--
                        <strong class="float-right"> <?= number_format($sum_total, 2, '.', '') ?>   USD</strong>
                        -->
                        <strong  style="float:right;"> <?= number_format( (@$reserva_cliente->monto_total-@$cuotas['monto_adelantado']), 2, '.', '') ?>   USD</strong>
                        <p style="font-size: 13px;">*<?=translateVoucher('descripcion_monto_a_pagar');?></p>
                    </td>
                </tr>
            <?php endif ?>
        </table>
            <p style="font-size: 13px;"><?= translateVoucher('info_envio_correo_vaucher_1', $reserva_cliente->lang) ?>
            <strong><?= $reserva_cliente->email_cliente ?></strong>, <?= translateVoucher('info_envio_correo_vaucher_2', $reserva_cliente->lang) ?> </p>
        </div>
        <hr>
        <h2><?= translateVoucher('datos_requeridos', $reserva_cliente->lang) ?></h2>

        <?php foreach($array_tour as $key => $p): ?>
                <?php 
                    $array_ = [];

                    $forms =  ProductoModel::where('producto.id_producto', $p['id_producto'])
                    ->join('producto_has_campoform', 'producto_has_campoform.id_producto', 'producto.id_producto')
                    ->join('campo_formulario', 'campo_formulario.id_campo_formulario', 'producto_has_campoform.id_campo_formulario')
                    ->orderBy('campo_formulario.id_campo_categoria', 'asc')
                    ->orderBy('campo_formulario.prioridad_campo', 'asc')
                    ->get(['producto.id_producto', 'producto.forms_multiple', 'campo_formulario.nombre_campo']);
                ?>
             <div style="border-bottom: 1px solid #ccc;"><strong><?= strtoupper($p['titulo_producto']) ?></strong></div>      
             <?php if(count($forms) > 0): ?>
                <?php foreach ($forms as $index => $f): ?>
                    <?php if($index == 0): ?>
                        <?php if($f->forms_multiple): ?>
                            <strong><?= translateVoucher('datos_lider', $reserva_cliente->lang) ?></strong>
                        <ol>
                        <?php else: ?>
                            <span style="background: #ffffb3;"><?= translateVoucher('datos_pasajeros') ?> </span>  <br>
                        <?php foreach ($p['resumen'] as $index => $r): ?>  
                            <?php if($r['tipo_articulo'] == 'persona'): ?>
                                <strong><?= str_replace('General', '',$r['nombre_articulo']) ?> x <?= $r['cantidad_articulo'] ?></strong>, 
                            <?php endif; ?> 
                        <?php endforeach; ?>
                        <ol>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li><?= json_decode($f->nombre_campo, true)[$language]  ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <?= translateVoucher("no_data") ?>
            <?php endif; ?>
                </ol>      
        <?php endforeach; ?>
        <p style="background:#ffff80"><?= translateVoucher('mensaje_pasajeros', $reserva_cliente->lang) ?> <a href="<?=$enlace_pasajeros;?>"><?=$enlace_pasajeros;?></a></p>
        <hr>
        <!---- Listar incluye de todos los servicios ---->
        <?php if( @$includes && @$includes === 'success' ){ ?>    
        <h4>
            <?=translateVoucher('title_los_servicios_incluyen', $reserva_cliente->lang) ?>
        </h4>
        <hr>
        <?php foreach(@$includes['data'] as $include): ?>   
            <strong><?=strtoupper(@$include['title']) ?></strong>   
            <div style="font-size: 11px;">   
            <?=@$include['content'] ?>
            </div>
        <?php endforeach; ?>
        <hr>
        <?php } ?>
        <h4><?=translateVoucher('title_terminos_servicio', $reserva_cliente->lang) ?></h4>
        <hr>
        <?php foreach($array_tour as $t): ?>   
            <strong><?= strtoupper($t['titulo_producto']) ?>  </strong>   
            <div style="font-size: 11px;">   
            <?= strlen(trim($t['politicas_producto'])) != 0 ? $t['politicas_producto']: file_get_contents('./assets/archivos/politicas/'.strtoupper($language).'.txt', true) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
</body>
</html>