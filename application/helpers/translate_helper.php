<?php
$CI =& get_instance();

function arrayTraduccion($archivo,$idioma='en',$default='en'){
    require 'translates/'.$archivo.'.php';//buscar archivo que tiene variable $palabras.
    foreach($palabras as $key => $value)
        $palabra[$key] = !empty($palabras[$key][$idioma])?$palabras[$key][$idioma]:$palabras[$key][$default];
    return $palabra;
}


function translateCart($palabra, $lang = null) {

    $CI =& get_instance();

    $idioma = $CI->uri->segment(1); //Capturamos el idioma https://web.incalake.com/es

    if(!isset($idioma)) {
        $idioma = "es";
    }

    if(strlen($idioma) == 2) {
        $diccionario = [
            "horas" => [
                "es" => "horas",
                "en" => "hours",
            ],
            "minutos" => [
                "es" => "minutos",
                "en" => "minutes",
            ],
            "dias" => [
                "es" => "dias",
                "en" => "days",
            ],
            "lugar_recojo" => [
                "es" => 'Lugar de recojo',
                "en" => 'Pick up place',
            ],
            "fecha_servicio" => [
                "es" => "Fecha de servicio",
                "en" => "Date of service",
            ],
            "hora_inicio" => [
                "es" => "Hora de inicio",
                "en" => "Start time",
            ],
            "de_reserva" => [
                "es" => "de reserva",
                "en" => "of reserve",
            ],
            "duracion" => [
                "es" => "Duración",
                "en" => "Duration",
            ],
            
            "datos_lider" => [
                "es" => "Proporcione los datos del lider",
                "en" => "Provide leader data",
            ],
            "datos_pasajeros" => [
                "es" => "Datos de los pasajeros: ",
                "en" => "Passenger information: ",
            ],
            "enviar_datos_pasajeros" => [
                "es" => "Enviar datos de pasajeros ahora",
                "en" => "Send travellers information",
            ],

            "info_reserve_gt" => [
                "es" => "<strong> Su reserva a sido realizada.</strong><br>Tiene un plazo maximo de 48 horas para completar el pago por su servicio, esta reserva caducará el, ",
                "en" => "<strong> Your reservation has been made. </ strong> <br><small> You have a maximum period of 48 hours to complete payment for your service, this reservation will expire on,",
            ],
            "info_envio_correo_vaucher_1" => [
                "es" => "Hemos realizado el envio de su voucher a su correo electronico",
                "en" => "We have sent your order to your email",
            ],
            "info_envio_correo_vaucher_2" => [
                "es" => "para mas detalles puede comunicarse a reservas@incalake.com o a los números 984434731 | 984434731.",
                "en" => "For more details you can contact reservas@incalake.com or the numbers 984434731 | 984434731.",
            ],                                                                                             

            "info_requerir_form_tour" => [
                "es" => "Necesitamos que nos porporcione algunos datos para el servicio de su tour. Envie los datos solicitados a   
                <strong> reservas@incalake.com   </strong> o al whatsapp <strong> +51949755305 / +51982769453 / +51984434731.</strong>.",
                "en" => "                                                        
                We need you to provide some information for the service of your tour. You can send it to
                <strong> reservas@incalake.com </ strong> or whatsapp to <strong> +51949755305 / +51982769453 / +51984434731. </ strong>",
            ],

            "descargar_vaucher" => [
                "es" => 'Descargar voucher',
                "en" => 'Download voucher',
            ],
            "tasas_impuestos" => [
                "es" => 'Tasas de transacción',
                "en" => 'Transaction fees',
            ],
            "info_required_form" => [
                "es" => "Necesitamos que nos envíe la siguiente información para los tours a reservas@incalake.com, o al whatsapp +51 949755305; +51 984434731.",
                "en" => "We need you to send us the following information for tours to reservas@incalake.com or whatsapp +51 949755305; +51 984434731.",
            ],
            "info_exito_pago" => [
                "es" => " La transacción ha sido realizado con éxito.",
                "en" => " The transaction has been successful.",
            ],
            "resumen_compra" => [
                "es" => "Resumen de la compra",
                "en" => "Purchase summary",
            ],
            /*** BEGIN TRANSLATE VIEW checkout_payment.php ***/
            "seleccione_metodo_de_pago" => [
                "es" => "SELECCIONE MÉTODO DE PAGO",
                "en" => "SELECT PAYMENT METHOD",
            ],
            "pagar_con_tarjeta" => [
                "es" => "PAGAR CON TARJETA",
                "en" => "PAY WITH CARD",
            ],
            "email" => [
                "es" => "Correo Electrónico",
                "en" => "E-mail",
            ],
            "numero_tarjeta" => [
                "es" => "Número de Tarjeta",
                "en" => "Card Number",
            ],
            "codigo_seguridad" => [
                "es" => "Código Seguridad (CCV)",
                "en" => "Security Code (CCV)",
            ],
            "fecha_expiracion" => [
                "es" => "Fecha de  Expiración (MM/YYYY)",
                "en" => "Expiration Date (MM/YYYY)",
            ],
            "pagar_ahora" => [
                "es" => "PAGAR AHORA",
                "en" => "PAY NOW",
            ],
            "pagar_con_paypal" => [
                "es" => "PAGAR CON PAYPAL",
                "en" => "PAY WITH PAYPAL",
            ],
            "transferencia_bancaria" => [
                "es" => "TRANSFERENCIA BANCARIA",
                "en" => "WIRE TRANSFER",
            ],
            "giro_internacional" => [
                "es" => "GIRO INTERNACIONAL",
                "en" => "INTERNATIONAL MONEY TRANSFER",
            ],
            "pagar_por_giro" => [
                "es" => "Realizar pago por Giro",
                "en" => "Make pay per International Money Transfer",
            ],
            "pagar_por_transferencia" => [
                "es" => "Pagar por Transferencia bancaria",
                "en" => "Pay by bank transfer",
            ],

            "descuentos" => [
                "es" => 'Descuentos',
                "en" => 'Discounts',
            ],

            "nombres" => [
                "es" => 'Nombres',
                "en" => 'First Name',
            ],
            "apellidos" => [
                "es" => 'Apellidos',
                "en" => 'Last Name',
            ],

            "pagar_con" => [
                "es" => 'Pagar con Moneda',
                "en" => 'Pay with Currency',
            ],
            "dolares" => [
                "es" => 'Dólar (USD)',
                "en" => 'Dollars (USD)',
            ],
            "soles" => [
                "es" => 'Sol (PEN)',
                "en" => 'Sol (PEN)',
            ],
            "mensaje_tipo_moneda" => [
                "es" => '* La conversión del monto a pagar se realizará de acuerdo al tipo de cambio del dólar (USD)',
                "en" => '* The conversion of the amount to be paid will be made according to the exchange rate of the dollar(USD)',
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
            /*** END TRANSLATE VIEW checkout_payment.php ***/
        ];
    }

    if(isset($diccionario[$palabra][isset($lang) ? $lang : $idioma])) {
       return $diccionario[$palabra][isset($lang) ? $lang : $idioma];
    } else {
       return $diccionario[$palabra]["en"];
    }
} 