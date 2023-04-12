<?php
    require ('PHPMailer/PHPMailerAutoload.php');
    //Variable para almacenar toda la información que llega desde el formulario de resrfvas
   /* $_POST['datos']['nombre_cliente'][] = 'Froilan quispe flores';
    $_POST['datos']['nombre_cliente'][] = 'dante esteban';
    $_POST['datos']['edad_cliente'][] = '26';
    $_POST['datos']['edad_cliente'][] = '18';
    $_POST['datos']['edad_cliente'][] = '55';
    $_POST['datos']['nombre_cliente'][] = 'Jose carlos';
    $_POST['datos']['nombre_cliente'][] = 'Pedro pablo';
    $_POST['datos']['edad_cliente'][] = '33';
    $_POST['datos']['nombre_cliente'][] = 'Jose manuekl';

    $_POST['datos']['edad_cliente'][] = '50';

    $_POST['datos']['aeropuerto_cercano'] = 'arequipa';
    $_POST['datos']['aeropuerto_lejano'] = 'Juliaca';
    $_POST['datos']['aeropuerto_mediano'] = 'bolivia';*/

    $cliente_principal = array();//datos del cliente principal
    $otros_clientes = array();//array de los clientes adicionales
    $informacion_cliente = array();//informaciones adiciones del cliente

    $data_form = array();

    foreach($_POST['datos'] as $key => $value){
        if(is_array($value)){
            $cliente_principal[$key] = $value[0];
            if(count($value)>1){
                array_shift($value);//eliminar datos del cliente principal
               /* foreach ($value as $key2 => $value2) {
                    $value['val'.$key2]=$value2;
                    unset($value[$key2]);
                }*/
                $otros_clientes[$key] = $value;
                //$otros_clientes[$key]= $value;//agregar otros clientes al array
            }
        }
        else $informacion_cliente[$key] = $value;

    }
    function reordenar($array){
        $newarray = array();
        foreach($array as $key => $value){
            foreach ($value as $key2 => $value2) {
                $newarray[$key2][$key]=$value2;  
            }
        }
       return $newarray;
    }

    $data_form["cliente_principal"]     =  $cliente_principal;
    $data_form["otros_clientes"]        =  reordenar($otros_clientes);
    $data_form["informacion_cliente"]   =  $informacion_cliente;

    //echo json_encode(reordenar($otros_clientes));
    //echo json_encode($data_form);
    //$otros_clientes = reordenar($otros_clientes);
    // print_r($otros_clientes);

   /* $cliente_principal = array('nombre_cliente'=>$_POST['datos']['nombre_cliente'][0],
                               'nombre_cliente'=>$_POST['datos']['nombre_cliente'][0]
                        );*/


    $data = array();
    //exit;
    $data = array(
        "nombre_servicio"       => $_POST['slct_nombre_servicio'],
        "hora_inicio_servicio"  => $_POST['slct_hora_inicio'],
        "fecha_servicio"        => $_POST['txt_fecha_servicio'],
        "total_personas"        => $_POST['total_personas'],         
        "datos_cliente"         => array()
    );

    $geo_location = '';
    try{
        $geo_location =  unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])); 
        $geo_location['geoplugin_credit'] = "";  
    }catch (Exception $e) {
        $geo_location = "".$e->getMessage();
    }

    /*
    function validateDate($date){
        $d = DateTime::createFromFormat('d-M-Y', $date);
        return $d && $d->format('d-M-Y') === $date;
    }
    */
    function ip() {
        $ip = "";
        if ( isset($_SERVER)) {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
            } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }
        if (strstr($ip, ',')) {
            $ip = array_shift(explode(',', $ip));
        }
        return $ip;
    }



    $data["geo_location"]  = $geo_location;
    $data["ip"]            = ip();    


    $html_informacion_cliente   = '';
    $html_otros_clientes        = '';
    $html_cliente_principal     = '';

    foreach ($data_form['informacion_cliente'] as $key => $value) {
        $html_informacion_cliente .= '<tr><td colspan="2">'.str_replace("_"," ",ucfirst($key) ).'</td><td>'.$value.'</td></tr>';
    }
    $color = "#D4D3D3";
    $estado = false;
    foreach ($data_form['otros_clientes'] as $key => $value) {
        $estado = false;
        if (!$estado) {
            $color = "#D4D3D3";
        }else{ $color= "#fff";}
        foreach ($value as $k => $v) {
            
                    
            $html_otros_clientes .= '<tr style="background-color:'.$color.'"><td colspan="2">'.str_replace("_"," ",ucfirst($k) ).'</td><td>'.$v.'</td></tr>';
            
        }
        $estado = true;
    }
    foreach ($data_form['cliente_principal'] as $key => $value) {
        $html_cliente_principal .= '<tr style="background-color:#91A09E;"><td colspan="2">'.str_replace("_"," ",ucfirst($key) ).'</td><td>'.$value.'</td></tr>';
    }
    $email_incalake           = '';
    $email_cliente            = '';

    $contenido_email_header   = '';
    $contenido_email_body     = '';
    $contenido_email_footer   = '';

    $contenido_email_body     = '<table border="1" cellspacing="0" style="border-color:#1570a6;">
                                    <thead>
                                       <tr>
                                            <th colspan="3" style="text-align:center; background-color:#1570a6; color:#fff;">'.utf8_decode('INFORMACION DEL SERVICIO').'</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Nombre del Servicio</td>
                                            <td colspan="2">'.$data['nombre_servicio'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Fecha del Servicio</td>
                                            <td colspan="2">'.date_format(date_create($data['fecha_servicio']),"d-M-Y").'</td>
                                        </tr>
                                        <tr>
                                            <td>Total de Personas</td>
                                            <td colspan="2">'.$data['total_personas'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Hora de Inicio del Servicio</td>
                                            <td colspan="2">'.$data['hora_inicio_servicio'].'</td>
                                        </tr>
                                        
                                    </tbody>
                                    <thead>
                                       <tr>
                                            <th colspan="3" style="text-align:center; background-color:#1570a6;color:#fff;">'.utf8_decode('INFORMACION DEL CLIENTE').'</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        '.$html_cliente_principal.$html_otros_clientes.'                                        
                                    </tbody>
                                    <thead>
                                       <tr>
                                            <th colspan="3" style="text-align:center; background-color:#1570a6;color:#fff;">'.utf8_decode('INFORMACION ADICIONAL').'</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        '.$html_informacion_cliente.'                                        
                                    </tbody>
                                </table>';


    $contenido_email_header = '<div style="text-align: center; font-weight: bold; color:#2980b9;">'.
                    '<b style="font-size:24px;">INCALAKE TRAVEL AGENCY EIRL</b><br>'.
                    '<span>Jr. Cajamarca 619 (Oficina 04 -Primer Piso) - Puno </span><br>'.
                    '<span>Fijo: +51 (51) 622270 | Cel. Claro RPC: 949755305 - Cel. Movistar RPM: #957585843<br>'.
                    'Cel RPM: #956060988 | Cel RPM: #951020700</span>'.
                    '</div><hr>';
    $contenido_email_footer = '<p><small>IP: '.ip().'</small></p>';
    $email_incalake = $contenido_email_body.$contenido_email_footer;
    $email_cliente  = $contenido_email_header.$contenido_email_body;

    $data['email'] = $email_incalake;


    //echo json_encode($data);
    //echo "<h3>EMAIL PARA RESERVAS@INCALAKE.COM</h3> <hr/><br/>";
    //echo $email_incalake;

    //echo "<h3>EMAIL PARA EL CLIENTE</h3><hr/><BR/><BR/>";
    //echo $email_cliente;

    $correo_incalake = "reservas@incalake.com";
    //$correo_incalake = "sistemas@incalake.com";
    //$correo_incalake = "edi72391@gmail.com";

    $mail = new PHPMailer(true);
    $mail->IsSendmail();
    try {
        //$mail->setFrom( $email, strtoupper($nombres) );
        $mail->setFrom( 'inc0910d@server.hostingperucloud.com', 'inc0910d' );
        //$mail->addReplyTo( $email, strtoupper($nombres) );
        $mail->addAddress( $correo_incalake, 'Incalake Travel Agency' );
        $mail->Subject = utf8_decode('Consulta para el servicio ');
        $mail->msgHTML( utf8_decode($email_incalake) );
        $mail->AltBody = 'Incalake Travel Agency EIRL';
        $mail->Send();

        //$msg_error = $mensaje;
        $msg_success = '<div class="col-md-12" style="background: #34495e none repeat scroll 0 0;
        border-radius: 10px;
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
        padding: 20px;
        text-align: center;">
        ¡Muchas gracias, recibimos sus datos satisfactoriamente!<br>
        Dentro de un máximo de 48 horas, uno de nuestros representantes de ventas se pondrá en contacto 
        con usted para darle las indicaciones necesarias para finalizar su reserva. 
        Por favor agregue a reservas@incalake.com a su lista de contactos, para evitar que nuestro 
        correo le llegue a la carpeta de Spam.<br>
        <button class="btn btn-danger nueva_reserva">Nueva Reserva!</button></div><script>$(function(){$(".nueva_reserva").click(function(){document.location.reload();});})</script>';

        echo json_encode(array('state' => 'success', 'msg' => $msg_success));

    } catch (phpmailerException $e) {
        echo json_encode(array(
                'state' => 'error', 
                'msg'   => "No hemos podido enviar su correo a reservas@incalake.com. Intente nuevamente por favor..!",
                'data'  => json_encode( $e->errorMessage() ),
            )
        );
    } catch (Exception $e) {
        echo json_encode(array(
                'state' => 'error', 
                'msg'   => "No hemos podido enviar su correo a reservas@incalake.com. Intente nuevamente por favor..!",
                'data'  => json_encode( $e->getMessage() ),
            )
        );
    } 

             
?>

