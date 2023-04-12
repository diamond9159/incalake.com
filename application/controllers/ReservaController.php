<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  DOMPDF
  Cargamos la libreria DOMPDF, ubicada en vendor/dompdf. 
  @documentacion -  {github} https://github.com/dompdf/dompdf
 */
require_once 'vendor/dompdf/autoload.inc.php'; // Cargamos las librerias DOMPDF 
use Dompdf\Dompdf;   // Inicializamos la clase Dompdf para apoder ser utilizada.
use Dompdf\Options;  // Inicializamos la clase Options para apoder ser utilizada.

/**
  PHP Mailer
  Cargamos las librerias PHPMAILER ubicada en vendor/phpmailer
  @documentacion - {github} https://github.com/PHPMailer/PHPMailer
*/
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer; // Inicializamos la clase PHPMailer que vamos a utilizar 
use PHPMailer\PHPMailer\Exception; // Inicializamos la clase Exception que vamos a utilizar

class ReservaController extends CI_Controller {   // Controlador ReservaController

    public function __construct() {
      parent::__construct();
		$this->load->model('cuota_model');
		$this->load->model('datos_reserva');
      	if( $this->config->item('php-quick-profiler') ){
            $this->output->enable_profiler(FALSE);          
      	}
   	}

	/*
	 * @function - method store
	 * Este método permite insertar o registrar la reserva o compra de los tours que el cliente va a realizar.
	 * Este metodo se ejecuta a travez de AJAX - METHOD POST
	 * Ruta http://web.incalake.com/api/reserva
	*/
	public function store()
	{	
		// Reserva_::class - table 'reserva'
		$reserve_num = Reserva_::where('fecha_creacion_reserva', 'LIKE', '%'.date('Y-m-d').'%')->count();  // Consulta para contar el numero de reserva o compra realizada en la fecha actual
		$cliente        = $this->input->post('cliente'); // Array data (nombres, apellidos, email, telefono, ...)
		$productos      = $this->input->post('productos'); // Array data productos
		$lang           = $this->input->post('lang'); // lenguaje del sitio
		$cuota 		    = $this->input->post('cuota'); // Objeto que contiene  los datos de la cuota

		/**
		 * Registramos los datos del cliente, metodo de apgo que realiza la reserva
		*/
		$tasa = 0;
		foreach($productos as $p) {	$tasa += $p['tasas_impuestos']; } // Sumamos las tasas

		$tasa = $tasa / count($productos); //Sacamos la media de la tasa a cobrar 

		$r = new Reserva_;
			$r->fecha_creacion_reserva = date('Y-m-d h:i:s'); //Fecha de creación de reserva 
			$r->codigo_reserva = date('dmY').'-'.str_pad(($reserve_num+1), 2, "0", STR_PAD_LEFT); //Generacion de codigo de reserva
			$r->nombres_cliente = $cliente['nombres'];
			$r->apellidos_cliente = $cliente['apellidos'];
			$r->email_cliente = $cliente['email'];
			$r->telefono_cliente = $cliente['telefono'];
			$r->nacionalidad_cliente = $cliente['pais'];
			$r->metodo_pago = $this->input->post('metodo_pago'); //Metodo de pago data => 'paypal, culqi, giro, transferencia'
			$r->tasas_impuestos = $tasa; 
            $r->lang = $lang; 
            $r->monto_total = @$cuota['montoTotal']; // Monto total a pagar por el contenido del carro de compras
		$r->save();	 // Registramos la reserva...

		$total_pago = 0;
		$personas_total = 0; // Cantidad de personas por tour/servicio
		foreach($productos as $p)
		{
			if(isset($p['horario'])) {  //El horario recibido esta en formato '7:AM - 4h' 
				$array_shd = explode('-',$p['horario']);  //Separamos segun '-'
			}
			/**
			 * Registramos el tour a comprar o reserva
			*/
			$ds = new DetalleServicio_; // Instanciamos el modelo app/models/eloquent/DetalleServicio_.php  =>  tabla 'detalle_servicio` 
			$ds->id_producto = $p['producto_id']; 
			$ds->fecha_servicio = $p['fecha_servicio'];	
			$ds->url = $p['url'];	
			if(isset($array_shd)) {
				$ds->duracion_servicio = $array_shd[0];	
				$ds->hora_inicio_servicio = $array_shd[1];
			}
			$ds->cantidad = 1;
			$ds->precio_total = 0; // temporalmente guardamos en 0 en precio combrado, mas abajo se actualiza
			$ds->tasas_impuestos = $tasa; // Tasa de impuestos del 5%;
			$ds->save();

            $personas_total = 0; // Cantidad de personas por tour/servicio
			foreach ($p['personas'] as $person) {
			/*
				Guardamos el historial del cobro por persona para el tour
			*/
				$resumen = new Resumen_;
				$resumen->precio = $person['precio'];
				$resumen->cantidad = $person['cantidad'];
				$resumen->nombre_articulo = $person['descripcion_etapa_edad'].' '.$person['descripcion_nacionalidad'];
				$resumen->tipo_articulo = 'persona';
				$resumen->id_detalle_servicio = $ds->id_detalle_servicio;
				$resumen->save();

				$total_pago += $person['precio'];
				$personas_total += $person['cantidad']; //Suma cantidad de personas que hay por tour
			}
			
			/*
				Guardamos el historial del cobro de los recursos
			*/
			if(isset($p['recursos'])) {
				foreach ($p['recursos'] as $rec) {
					$recurso = new Resumen_;
					$recurso->precio = $rec['precio']*$rec['cantidad'];
					$recurso->cantidad = $rec['cantidad'];
					$recurso->nombre_articulo = $rec['nombre'];
					$recurso->tipo_articulo = 'recurso';
					$recurso->id_detalle_servicio = $ds->id_detalle_servicio;
					$recurso->save();
				}
				$total_pago += $rec['precio'] * $rec['cantidad'];
			}

			$dsr = new DetalleServicio_Reserva;
			$dsr->id_detalle_servicio =  $ds->id_detalle_servicio;
			$dsr->id_reserva = $r->id_reserva;
			$dsr->save();
			
			// Actualizando cantidad de personas, precio_total, etc; en la Tabla Detalle_Servicio.
			$d = DetalleServicio_::find($ds->id_detalle_servicio);
			$d->cantidad = $personas_total; // Cantidad de Personas por Servicio/tour.
			$d->save();
		}

		$d = DetalleServicio_::find($ds->id_detalle_servicio);
		$d->precio_total = number_format($total_pago + ($total_pago * $tasa / 100), 2,'.', '');  //Cobro total realizado + tasa cobrada
		$d->importe_tasas_impuestos = ($total_pago * $tasa) / 100; // Importe que se cobro segun la tasa
		$d->save();  
		
		/********************* GUARDANDO CUOTA **********************/
		$objectCuota = array(
			'monto'			=> @$cuota['montoAdelanto'],
			'porcentaje'	=> @$cuota['porcentajeAdelanto'],
			'fecha_cuota'	=> date('Y-m-d H:i:s'), // Fecha en que se genera el registro
			'tipo_cuota'	=> mb_strtolower('TARJETA'), // El registro proviene desde el carro de compras por lo tanto el monto a adelantar se paga mediante tarjeta
			'detalle_cuota'	=> 'Pagado con tarjeta desde el carro de compras',
			'confirmacion_pago'	=> '0', // Se guarda el registro para no perder la información durante la transacción
			'id_reserva'		=> $r->id_reserva,
		);
		$this->cuota_model->add_cuota($objectCuota);

		echo  $r->id_reserva;
		
	}

	/*
	 * @update - Actualización de confirmación de Pago del servicio
	 * 
	*/
	public function update()
	{
		$r = Reserva_::find($this->input->post('id_reserva'));
		$data['language'] = $r->lang;
		
		/* Si el método de pago es de 'giro' o 'transferencia' la confirmación de pago sera falso */
		$r->confirmacion_pago = ($r->metodo_pago == 'giro' || $r->metodo_pago ==  'transferencia') ? false : true;
		
		$data['codr'] = $this->input->post('id_reserva');
		
		//Recuperando coutas de pago del cliente
        $data['cuotas'] = $this->cuota_model->get_cuotaIdReserva(@$data['codr']);
        //$data['includes'] = $this->servicesInclude( @$data['codr'] ); // Obteniendo incluye de cada servicio.
        
		$html = $this->load->view('cart/pdf_vaucher-payment', $data, true);	
        //$html = $this->load->view('cart/ejemplo', $data, true);	

		$options = new Options();
		$options->set('defaultFont','Helvetica');
		$options->set('isRemoteEnabled', TRUE);
		$data['codr'] = $this->input->get('codr');
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		//$dompdf->render();
		//$pdf = $dompdf->output();

		//file_put_contents('assets/archivos/vaucher_payment/'.$this->input->post('id_reserva').'.pdf', $pdf); //Guardamos el pdf en el servidor

		$mail = new PHPMailer(true);
		$mail->CharSet = 'UTF-8';
        //$mail->isSMTP();
        
        //$mail->SMTPDebug = 0; // 0 = Off, 1 = Client Message, 2 = Client and Server Messages
        //Set the hostname of the mail server
        //$mail->Host = 'smtp.gmail.com';
        //$mail->Port = 587;
        //$mail->SMTPSecure = 'tls';
        //$mail->SMTPAuth = true;
        //$mail->Username = "sistemas@incalake.com";  
        //$mail->Password = "Glaltoqu1@_";			// Este password debe ser la misma con la que se entra a gmail.
		
    	$mail->setFrom('reservas@incalake.com', 'Incalake Travel Agency');
    	$mail->addAddress('reservas@incalake.com', 'Reserve');     // Add a recipient
    	$mail->addAddress($r->email_cliente); 
	    $mail->Subject = $r->metodo_pago == 'giro' || $r->metodo_pago == 'transferencia' ? 'Reserva - Pago pendiente ['.$r->metodo_pago.']' :'Reserva #: '.$r->codigo_reserva;
		$mail->isHTML(true);                                  // Set email format to HTML
		 
		$mail->Body = $html;
		if($r->metodo_pago == 'giro' || $r->metodo_pago ==  'transferencia') {
			//$mail->addAttachment('assets/archivos/metodos_pago/'.$r->metodo_pago.'-'.$r->lang.'.pdf'); 
		}
		//$mail->addAttachment('assets/archivos/vaucher_payment/'.$this->input->post('id_reserva').'.pdf'); 
		
		$mail->send();
		
		$this->set_calendar($this->input->post('id_reserva'));
		
		$r->update();
	}
	/*
	 * Registro donde se va a registrar la consulta de disponibilidad de servicio
	*/
	public function consultar_disponiblidad() 
	{
		header("Content-type:application/json");
		$persona = $this->input->post('persona');
		$producto = $this->input->post('producto');
		$data['language'] = 'es';

		$c = new ConsultaDisponibilidad_;
		$c->id_producto = $producto[0]['producto_id'];
		$c->fecha_servicio = $producto[0]['fecha_servicio'];
		$c->horario = $producto[0]['horario'];
		$c->url_page = $producto[0]['url'];
		$c->img_thumb = $producto[0]['img_thumb'];
		$c->nombres = $persona['nombres'];
		$c->apellidos = $persona['apellidos'];
		$c->email = $persona['email'];
		$c->telefono = $persona['telefono'];
		$c->pais = $persona['pais'];
 		$c->save();

 		foreach($producto as $p) 
 		{
 			foreach ($p['personas'] as $r) 
 			{
 				$cd = new ConsultaDisponibilidadResumen_;
 				$cd->id_consultar_disponibilidad = $c->id;
		 		$cd->descripcion = $r['descripcion_etapa_edad'].' '.$r['descripcion_nacionalidad'];;
		 		$cd->cantidad = $r['cantidad'];
		 		$cd->precio = $r['precio'];
		 		$cd->save();
 			}	 		
		}

		$data['id_consultar_disponibilidad'] = $c->id;
		
		$html = $this->load->view('cart/resumen_consulta_disponibilidad', $data, true);	

 		$mail = new PHPMailer(true);
 		$mail->CharSet = 'UTF-8';
		$mail->setFrom('sistemas@incalake.com', 'Incalake Travel Agency');
    	$mail->addAddress('reservas@incalake.com', 'Reserve');     // Add a recipient
    	$mail->addAddress($c->email); 
    	$mail->isHTML(true);                                  // Set email format to HTML
    	$mail->Subject = "Solicitud de disponibilidad de servicio  - ( ".ProductoModel::find($c->id_producto)->titulo_producto." )";
		$mail->Body = $html;
		$mail->send();

 		echo ConsultaDisponibilidadResumen_::get();

	}
	
	
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
        echo("aqui: ".CREDENTIALS_PATH);

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
                echo("si hay");
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
	
	
	private function set_calendar($id_reserva=0){
	    echo("entra seteo calendario: " . $id_reserva);
		/* insertar evento al calendario */
		$reserva_actividades = DetalleServicio_Reserva::join('detalle_servicio', 'detalle_servicio_has_reserva.id_detalle_servicio', 'detalle_servicio.id_detalle_servicio')
				->join('producto', 'producto.id_producto', 'detalle_servicio.id_producto')
				->join('reserva', 'reserva.id_reserva', 'detalle_servicio_has_reserva.id_reserva')
				->join('cuotas', 'cuotas.id_reserva', 'reserva.id_reserva')
                ->where('detalle_servicio_has_reserva.id_reserva', $id_reserva)
                ->orderBy('producto.id_producto', 'desc')
                ->get([
					'reserva.nombres_cliente',
					'reserva.apellidos_cliente',
					'reserva.metodo_pago',
					'reserva.email_cliente',
                    'producto.tipo_recojo', 'producto.lugar_recojo', 
                    'producto.titulo_producto', 'producto.id_producto',
                    'producto.hora_inicio', 'producto.zona_horaria',
                    'producto.ciudad_cercana',
                    'detalle_servicio.id_detalle_servicio',
					'detalle_servicio.cantidad',
                    'detalle_servicio.descuento', 
                    'detalle_servicio.url',
                    'detalle_servicio.importe_tasas_impuestos',
                    'detalle_servicio.fecha_servicio', 
                    'detalle_servicio.duracion_servicio', 
					'detalle_servicio.hora_inicio_servicio',
					'detalle_servicio.descripcion_servicio',
                    'detalle_servicio.precio_total as precio_total',
					'detalle_servicio.id_calendar_event',
					'cuotas.porcentaje',
					'cuotas.monto'
				]);
				print_r($reserva_actividades);
				/* funcion para setear calendario */
				
				function enviar_calendario($data,$google_calendar_service){
					   
					$service = $google_calendar_service;
			
					$event = new Google_Service_Calendar_Event($data);
			
					$calendarId = 'reservas@incalake.com';
					$event = $service->events->insert($calendarId, $event);
					return $event->id;
					
				}
				
				$service = $this->get_calendar_service();
				foreach($reserva_actividades as $value){
				    echo($value);
					/* calcular fechas */
					/* restar una hora en caso de hora boliviana */
					// si ya esta seteado el evento evitar que se duplica
					if($value->id_calendar_event)continue;
					$hora_inicio = explode(',',$value->hora_inicio);
					$clave = array_search(trim($value->duracion_servicio), $hora_inicio);
					$hora_bol = explode(',',$value->zona_horaria);
				
					/* fin restar una hora en caso hora boliviana */
					$hora=date("H:i", strtotime($value->duracion_servicio.($hora_bol[$clave]?' -1 hour':'')));
					$fecha = $value->fecha_servicio;
					$duracion = $value->hora_inicio_servicio;
					// $nombres_tiempo = array('m'=>'minutes','h'=>'hours','d'=>'days');
					$duracion = explode(' ',trim($duracion));
				
					$fecha_llegada = new DateTime("$fecha $hora");
					// $fecha_llegada->modify("+{$duracion[0]} {$nombres_tiempo[$duracion[1]]}");
					$fecha_llegada->modify("+30 minutes");
				
					$fecha_start=$fecha.'T'.$hora.':00-05:00';
					$fecha_end=$fecha_llegada->format('Y-m-d\TH:i:00-05:00');
					//exit($fecha_end);
					/* fin calcular fechas 
					round(+(100 / +$value->porcentaje * +$value->monto),2);
					*/
				   $monto_faltante = round(+(100 / +$value->porcentaje * +$value->monto),2)- +$value->monto;
				   $porcentaje_faltante = 100 - +$value->porcentaje;
				   $titulo_servicio = $value->descripcion_servicio?$value->descripcion_servicio:$value->titulo_producto; 
				   //$monto_faltante = 'ejemplo';
				   $data = array(
						'summary' => $value->nombres_cliente.' '.$value->apellidos_cliente.' | x'.@$value->cantidad.' | '.$titulo_servicio.' | '.$value->metodo_pago.' | Pagado: $'.(+$value->monto).' '.+$value->porcentaje.'%'.' | Por Cobrar: $'.$monto_faltante.' '.$porcentaje_faltante.'%',
						'location' => $value->ciudad_cercana,
						'description' => ($hora_bol[$clave]?'Hora boliviana':' Hora peruana').', url: '.@$value->url.', Email: '.$value->email_cliente,
						'start' => array(
						  'dateTime' => $fecha_start
						),
						'end' => array(
						  'dateTime' => $fecha_end
						),
						'reminders' => array(
						  'useDefault' => FALSE,
						  'overrides' => array(
							array('method' => 'email', 'minutes' => 24 * 60),
							array('method' => 'popup', 'minutes' => 10),
						  ),
						),
						'colorId' => 8
					);
					// google_client from PageController.php
					$this->datos_reserva->guardar_id_evento($value->id_detalle_servicio,enviar_calendario($data,$service));
						
				}
	}

}