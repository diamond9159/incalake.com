<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class PageController extends CI_Controller {

    public function __construct() {
       parent::__construct();
       $this->load->model('page_model','Page_model');
       $this->load->model("cuota_model");
   	   $this->load->model('datos_reserva');
    }
    /*
		Documentacion
		http://jeromejaglale.com/doc/php/codeigniter_template
    */

	public function checkout_availability() //P
    {
        $data['menu_language']     = $this->Page_model->menu_language_location("","");
        $data['language'] = $this->uri->segment(1);
        $this->template->set('title','Formulario de registro para verificar disponibilidad');
        $this->template->load('template', 'cart/checkout_forms_disponiblidad', $data);
    }

    public function checkout_cart()
    {
        $data['menu_language']     = $this->Page_model->menu_language_location("","");
        $data['language'] = $this->uri->segment(1);
        $this->template->set('title','Carro de Compras');
        $this->template->load('template', 'cart/checkout_cart', $data);
    }

    public function checkout_customer()
    {   
        $data['menu_language']     = $this->Page_model->menu_language_location("","");
    	$data['language'] = $this->uri->segment(1);
        $this->template->set('title','Carro de Compras - Datos de usuario');
        $this->template->load('template', 'cart/checkout_customer', $data);
    }

    public function checkout_payment()
    {
        $data['menu_language']     = $this->Page_model->menu_language_location("","");

    	$data['language'] = $this->uri->segment(1);

        //Obtenemos la cookie y extraemos la id de los productos para ver sus métodos de pago
        $arrayIdProductos = [];
        if( !empty($_COOKIE['cart']) ){
            if (count(json_decode($_COOKIE['cart'], true)) > 0 ) {
                $arrayCart = json_decode($_COOKIE['cart'],true);
                foreach ($arrayCart as $key => $value) {
                    array_push($arrayIdProductos, $value['producto_id']);
                }
            }
        }
        $stringIdProductos = '0';
        if (count($arrayIdProductos) > 0 ) {
            foreach ($arrayIdProductos as $key => $value) {
                $stringIdProductos .= $stringIdProductos.','.$value;
            }
        }
        $data['idProductos'] = $arrayIdProductos;
        $response_metodo_pago = $this->Page_model->obtenerMetodoPagoPaypal($stringIdProductos); 
        $data['string_id_productos'] = $stringIdProductos;
        //$data['metodo_pago_paypal'] = (Integer)$response_metodo_pago['cantidad_metodo_pago'];
        $data['metodo_pago_paypal'] = (Integer)$response_metodo_pago;

        $headjs           = '<script src="'.base_url().'assets/resources/js/jquery.blockUI.js" type="text/javascript"></script>';
        $payform          = '<script src="'.base_url().'assets/resources/payform/payform.min.js" type="text/javascript"></script>';
        //$transactjs       = '<script src="'.base_url().'assets/resources/js/config.js" type="text/javascript"></script>';
        //$transactIncalake = '<script src="'.base_url().'assets/resources/js/transact.js" type="text/javascript"></script>';

        $transactjs       = '<script src="'.base_url().'assets/resources/js/config.2.0.js" type="text/javascript"></script>';
        $transactIncalake = '<script src="'.base_url().'assets/resources/js/transact.2.0.js?v='.date('Ymdhis').'" type="text/javascript"></script>';
        //$paymeScriptTest  = '<script type="text/javascript" src="https://integracion.alignetsac.com/VPOS2/js/modalcomercio.js" ></script>';  
        $paymeScript      = '<script type="text/javascript" src="https://vpayment.verifika.com/VPOS2/js/modalcomercio.js" ></script>';

        $this->template->set('script', '<script src="https://checkout.culqi.com/v2"></script>'.$headjs.$payform.$transactjs.$transactIncalake.$paymeScript);
        
        $this->template->set('title','Carro de Compras - Método de Pago');
        $this->template->load('template', 'cart/checkout_payment', $data);	
    }

    /* Resultado que va a ser visualizado en la vista 
     * directorio Application/view/cart/checkout_confirm.php
    */
    public function checkout_confirm()
    {
        if(!$this->input->get('codr')) {  // Si no existe el codigo reserva redireccionamos a la pagina de inicio
            redirect('/', 'location');
        }

        $data['menu_language']     = $this->Page_model->menu_language_location("","");
        $data['language'] = $this->uri->segment(1);
        $data['codr'] = $this->input->get('codr');
        $data['fechas']  = $this->datos_reserva->getFirstService($data['codr']);
        //Recuperando coutas de pago del cliente
        $data['cuotas'] = $this->cuota_model->get_cuotaIdReserva(@$data['codr']);

        /* DetalleServicio_Reserva::class - Model table 'detalle_servicio_has_reserva' */
        $detalles = DetalleServicio_Reserva::join('detalle_servicio', 'detalle_servicio_has_reserva.id_detalle_servicio', 'detalle_servicio.id_detalle_servicio')
                ->join('producto', 'producto.id_producto', 'detalle_servicio.id_producto')
                ->join('resumen', 'resumen.id_detalle_servicio', 'detalle_servicio.id_detalle_servicio')
                ->where('id_reserva', $data['codr'])
                ->orderBy('producto.id_producto', 'desc')
                ->get([
                    'producto.tipo_recojo', 'producto.lugar_recojo', 
                    'producto.titulo_producto', 'producto.id_producto',
                    'producto.hora_inicio', 'producto.zona_horaria',
                    'producto.ciudad_cercana',
                    'detalle_servicio.id_detalle_servicio',
                    'detalle_servicio.tasas_impuestos',
                    'detalle_servicio.descuento', 
                    'detalle_servicio.url',
                    'detalle_servicio.importe_tasas_impuestos',
                    'detalle_servicio.fecha_servicio', 
                    'detalle_servicio.duracion_servicio', 
                    'detalle_servicio.hora_inicio_servicio',
                    'detalle_servicio.precio_total as precio_total',
                    'detalle_servicio.id_calendar_event',
                    'resumen.nombre_articulo',
                    'resumen.cantidad as cantidad_articulo', 
                    'resumen.tipo_articulo',
                    'resumen.tipo_articulo',
                    'resumen.precio as precio_articulo',
                ]);


        $array_tour = [];
        $tourReserve = "";     
        $flag = -1;

        /*Ordenamos el resultado de la consulta*/
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

                array_push($array_tour, [
                     'id_producto' => $reserva->id_producto,
                    'titulo_producto' => $reserva->titulo_producto,
                    'hora_inicio' => $reserva->hora_inicio,
                    'zona_horaria' => $reserva->zona_horaria,
                    'ciudad_cercana' => $reserva->ciudad_cercana,
                    'lugar_recojo' => $reserva->lugar_recojo,
                    'id_detalle_servicio' => $reserva->id_detalle_servicio,
                    'id_calendar_event' => $reserva->id_calendar_event,
                    'fecha_servicio' => $reserva->fecha_servicio,
                    'hora_inicio_servicio' => $reserva->hora_inicio_servicio,
                    'duracion_servicio' => $reserva->duracion_servicio,
                    'img' => $url_img,
                    'url' => $reserva->url,
                    'precio_total' => $reserva->precio_total,
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
        
        $this->template->set('title','Confirmación de pago');
        /* obtener datos de la reserva id,codigo */
        $this->load->model('datos_reserva');
        $data['datos_reserva']=$this->datos_reserva->get_codigo($data['codr']);
        
        //Comentar abajo 2 Lineas
        $data['google_calendar_service']=$this->get_calendar_service();
        $data['datos_reserva_model'] = $this->datos_reserva;
        //Comentar Arriba 2 lineas
        /* fin de obtener datos de la reserva */
        $this->template->load('template', 'cart/checkout_confirm', $data);
    }

	public function page_producto()
	{	$data['menu_language']     = $this->Page_model->menu_language_location("","");	
		$data['language'] = $this->uri->segment(1);
		$this->template->load('template', 'producto', $data);
	}

 // gestionar datos de cliente luego de la reserva
    public function datos_cliente()
	{	
        if(!empty($_GET['id'])){
            $this->load->model('datos_cliente_formulario');
            $datos['language'] = $this->uri->segment(1);
            $datos['campos_formulario'] = $this->datos_cliente_formulario->obtener_formulario(@$_GET['id'],@$_GET['cod']);
    
            // REDIRECCIONAR SI NO HAY DATOS
            if(!$datos['campos_formulario'])redirect(base_url());
            /*inicio de las funciones para las urls*/
        
            
               $datos['menu_language'][] = array('codigo'=>'ES','uri_servicio'=>'');
               $datos['menu_language'][] = array('codigo'=>'EN','uri_servicio'=>'');

    
            $this->load->view('reservas/formulario', $datos);
            //var_dump($datos);
        } else redirect(base_url());

	}

    public function registrar_datos_cliente()
	{	
        if($_POST){
            $id_reserva = $_POST['id_reserva'];
            $this->load->model('datos_cliente_formulario');
            $resultado = $this->datos_cliente_formulario->guardar_clientes($_POST['inputs']);
            if($resultado){
                // retornar detalles de reserva 
                $detalles_reserva = $this->datos_cliente_formulario->retornar_detalles_reserva($id_reserva);
                /* enviar email */
                $para      = 'reservas@incalake.com';
                $titulo    = 'Datos de pasajeros de la reserva de '.$detalles_reserva['nombres_cliente'].' '.$detalles_reserva['apellidos_cliente'];
               
                $email_rem = 'incalake@incalake.com';
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                $headers .= 'From:"' . $detalles_reserva['nombres_cliente'].' '.$detalles_reserva['apellidos_cliente']. '" <' .$email_rem.'>' . " \r\n" .
                            'Reply-To: '.  $email_rem . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();
                //$headers .= "X-Mailer: PHP/".phpversion();
              
                $html_detalles = '<div style="font-family:sans-serif"><h1 style="font-size:20px;">Detalles de la reserva</h1>
                <table>
                 <tr><td>Nombre</td><td>: '.$detalles_reserva['nombres_cliente'].' '.$detalles_reserva['apellidos_cliente'].'</td></tr>
                 <tr><td>Email</td><td>: '.$detalles_reserva['email_cliente'].'</td></tr>
                 <tr><td>Fecha reserva</td><td>: '.$detalles_reserva['fecha_creacion_reserva'].'</td></tr>
                 <tr><td>Codigo reserva</td><td>: '.$detalles_reserva['codigo_reserva'].'</td></tr>
                </table>
                </div>';

                $datos_cliente= $this->extraer_clientes($id_reserva,$detalles_reserva['email_cliente'],@$_POST['id_calendar_event']);
                $mensaje = $html_detalles.$datos_cliente;
                $envio_email = mail($para, $titulo, $mensaje, $headers);
                
                /* fin enviar email */
               
            }
             echo $resultado;
             //var_dump($envio_email);
        }

    }
    private function extraer_clientes($id_reserva=0,$email_titular,$id_evento_calendario=array()){
        $this->load->model('datos_cliente_formulario');
        $resultado = $this->datos_cliente_formulario->retornar_clientes_reserva($id_reserva);
        
        $html = '<div style="font-family:sans-serif;">';
        $event_key = 0; // id del evento a cambiar solo se trabajara segun el orden en que llega
        $service = $this->get_calendar_service(); // llamar al servicio de google calendar
        
        foreach($resultado as $value){
            $trs = array();
            foreach($value['datos_clientes'] as $key2 => $value2){
                $trs[$key2] = "\n".'<tr style="background:#eeeef7"><th colspan="2">Pasajero '.($key2+1).": </th></tr>\n";
                foreach($value2 as $value3){
                    $nombre_campo = json_decode($value3['nombre_campo']);
                    $trs[$key2] .= '<tr><td>'.@$nombre_campo->es.'</td><td>: '.$value3['value_campo_formulario']."</td></tr>\n";
                }
            }
            $html .= '<h2 style="font-size:15px;background:#005984;color:white;padding:3px">'.$value['titulo_producto']."</h2>\n";
            $pasajeros_tabla = implode('',$trs);
            $html .= '<table>'.$pasajeros_tabla.'</table>';
             // actualizar descripcion del evento en el calendario de la reserva
            /* $cliente_google = $this->get_cliente_google();
             $service = new Google_Service_Calendar($cliente_google);*/
             // var_dump($id_evento_calendario);
             
             $calendarId = 'reservas@incalake.com';
             $event = $service->events->get($calendarId, @$id_evento_calendario[$event_key++]);
             // enviar al calendario solo datos del primer pasajero sin html
             $contenido_calendario = 'Actividad: '.$value['titulo_producto']."\n";
             $contenido_calendario .= strip_tags(@$pasajeros_tabla);
             $contenido_calendario .= 'Correo del titular de la reserva: '.$email_titular.', Lista detallada pasajeros: http://admin.incalake.com/admin/reservas/datos_pasajeros/'.$id_reserva;
             $event->setDescription($contenido_calendario);
             $updatedEvent = $service->events->update($calendarId, $event->getId(), $event);
             // Print the updated date.
             // echo $updatedEvent->getUpdated();
             // fin actualizar calendario
        }
        return $html.'</div>';
    }
    /* configurar para hacer el llamado a las apis del calendario */
    public function get_calendar_service(){
        $dir = 'assets/resources/google-api-php-client-2.2.1/';
        require_once $dir.'vendor/autoload.php';

        define('APPLICATION_NAME', 'Calendario-reservas');
        define('CREDENTIALS_PATH', $dir.'token.json');
        //define('CREDENTIALS_PATH', 'https://incalake.com/assets/resources/google-api-php-client-2.2.1/token.json');
        define('CLIENT_SECRET_PATH', $dir.'client_secret.json');

        define('SCOPES', implode(' ', array(
        Google_Service_Calendar::CALENDAR)
        ));
        //echo("aqui: ".CREDENTIALS_PATH);

        function getClient() {
            $client = new Google_Client();
            $client->setApplicationName(APPLICATION_NAME);
            //$client->setScopes(SCOPES);
            $client->addScope("https://www.googleapis.com/auth/calendar");
            $client->addScope("https://www.googleapis.com/auth/calendar.events");
            $client->setAuthConfig(CLIENT_SECRET_PATH);
            $client->setAccessType('offline');
    
            // Load previously authorized credentials from a file.
            $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
            // echo $credentialsPath;
            if (file_exists($credentialsPath)) {
                //echo("si hay");
                $accessToken = json_decode(file_get_contents($credentialsPath), true);
            } else {
                // Request authorization from the user.
                //$authUrl = $client->createAuthUrl();
                //printf("Open the following link in your browser:\n%s\n", $authUrl);
                //print 'Enter verification code: ';
                $authCode = '4/qQFkDKNo37PzGdWlaWCRELX1bTwk1Wx_jP1zc-2v8OMVFF2KEEiewbc';
    
                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    
                // Store the credentials to disk.
                if(!file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
                }
                file_put_contents($credentialsPath, json_encode($accessToken));
                //printf("Credentials saved to %s\n", $credentialsPath);
            }
            $client->setAccessToken($accessToken);
    
            // Refresh the token if it's expired.
            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
            }
            return $client;
        }


        function expandHomeDirectory($path) {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }
        return str_replace('~', realpath($homeDirectory), $path);
        }

        // Get the API client and construct the service object.
        $service = new Google_Service_Calendar(getClient());
        return $service;
    }
    
    /* fin de configurar el calendario */
    public function checkout_ivan(){
        $this->load->helper('url');
        $data['language'] = "es";
        $data['menu_language']     = $this->Page_model->menu_language_location("","");
        $data['idProductos'] = "arrayIdProductos";
        $headjs           = '<script src="'.base_url().'assets/resources/js/jquery.blockUI.js" type="text/javascript"></script>';
        $payform          = '<script src="'.base_url().'assets/resources/payform/payform.min.js" type="text/javascript"></script>';
        
        $transactjs       = '<script src="'.base_url().'assets/resources/js/config.2.0.js" type="text/javascript"></script>';
        $transactIncalake = '<script src="'.base_url().'assets/resources/js/transact.2.0.js?v='.date('Ymdhis').'" type="text/javascript"></script>';
        $paymeScript      = '<script type="text/javascript" src="https://vpayment.verifika.com/VPOS2/js/modalcomercio.js" ></script>';

        $this->template->set('script', '<script src="https://checkout.culqi.com/v2"></script>'.$headjs.$payform.$transactjs.$transactIncalake.$paymeScript);
        
        $this->template->set('title','Carro de Compras - Método de Pago');
        $this->template->load('template', 'cart/checkout_ivan', $data);	
        
    }
    
   
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */