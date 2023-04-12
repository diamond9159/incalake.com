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
		$cliente =  $this->input->post('cliente'); // Array data (nombres, apellidos, email, telefono, ...)
		$productos = $this->input->post('productos'); // Array data productos
		$cupon     = $this->input->post('cupon');	// Array Cupón
		$lang = $this->input->post('lang'); // lenguaje del sitio

		$cupon_valor = @$cupon['cupon_valor']?@$cupon['cupon_valor']:0; //valor del cupón para descontar en porcentaje %
		$cupon_valido= @$cupon['cupon_valido']; // Validéz del cupón true, false 
		$cupon_valor_descuento = @$cupon['cupon_valor_descuento']?@$cupon['cupon_valor_descuento']:0; //Monto a decontar en USD

		$precio_valido = 0;
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
            $r->cupon_descuento = $cupon_valor; // Valor del cupón a descontar en porcentaje %
            $r->monto_cupon_descuento = $cupon_valor_descuento; // Valor descontado en USD
		$r->save();	 // Registramos la reserva...

		$total_pago = 0;
		$total_pago_tours = 0;
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


			foreach ($p['personas'] as $person) {
				//Si es que hay cupón obtiene los precios normales y si no hay el precio oferta o precio total
				if ( $cupon_valido === true || $cupon_valido === 'true' ) {
					$precio_valido = $p['precio_normal'];	
				}else{
					$precio_valido = $person['precio'];
				}	
				
				//Guardamos el historial del cobro por persona para el tour
				$resumen = new Resumen_;
				//$resumen->precio = $person['precio'];
				$resumen->precio = $precio_valido;
				$resumen->cantidad = $person['cantidad'];
				$resumen->nombre_articulo = $person['descripcion_etapa_edad'].' '.$person['descripcion_nacionalidad'];
				$resumen->tipo_articulo = 'persona';
				$resumen->id_detalle_servicio = $ds->id_detalle_servicio;
				$resumen->save();
			
				//$total_pago += $person['precio'];	
				$total_pago += $precio_valido;
				$total_pago_tours += $precio_valido;
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
			//Obtenemos el monto a descontar con el cupón válido
			/*
			if ( $cupon_valido === true || $cupon_valido === 'true' ) {
				$cupon_valor_descuento = ($total_pago * $cupon_valor)/100;	
			}
			*/
			$dsr = new DetalleServicio_Reserva;
			$dsr->id_detalle_servicio =  $ds->id_detalle_servicio;
			$dsr->id_reserva = $r->id_reserva;
			$dsr->save();
		}

		$d = DetalleServicio_::find($ds->id_detalle_servicio);
		//$d->precio_total = number_format($total_pago + ($total_pago * $tasa / 100), 2,'.', '');  //Cobro total realizado + tasa cobrada
		$d->precio_total = number_format( ( ($total_pago + ($total_pago_tours * $tasa / 100)) - $cupon_valor_descuento ), 2,'.', '');
		//$d->importe_tasas_impuestos = ($total_pago * $tasa) / 100; // Importe que se cobro segun la tasa
		$d->importe_tasas_impuestos = ($total_pago_tours * $tasa) / 100; // Importe que se cobro segun la tasa
		$d->save();  

		echo  $r->id_reserva;
	}

	/*
	 * @update - Actualización de confirmación de Pago del servicio
	 * 
	*/
	public function update ()
	{
		$r = Reserva_::find($this->input->post('id_reserva'));
		$data['language'] = $r->lang;
		
		/* Si el método de pago es de 'giro' o 'transferencia' la confirmación de pago sera falso */
		$r->confirmacion_pago = ($r->metodo_pago == 'giro' || $r->metodo_pago ==  'transferencia') ? false : true;
		
		$data['codr'] = $this->input->post('id_reserva');
		$html = $this->load->view('cart/pdf_vaucher-payment', $data, true);	

		$options = new Options();
		$options->set('defaultFont','Helvetica');
		$options->set('isRemoteEnabled', TRUE);
		$data['codr'] = $this->input->get('codr');
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$pdf = $dompdf->output();

		file_put_contents('assets/archivos/vaucher_payment/'.$this->input->post('id_reserva').'.pdf', $pdf); //Guardamos el pdf en el servidor

		$mail = new PHPMailer(true);
		$mail->CharSet = 'UTF-8';
    	$mail->setFrom('reservas@incalake.com', 'Incalake Travel Agency');
    	$mail->addAddress('reservas@incalake.com', 'Reserve');     // Add a recipient
    	//$mail->addAddress('edi72391@gmail.com', 'Reserve');     // Add a recipient
    	$mail->addAddress($r->email_cliente); 
	    $mail->Subject = $r->metodo_pago == 'giro' || $r->metodo_pago == 'transferencia' ? 'Reserva - Pago pendiente ['.$r->metodo_pago.']' :'Reserva #: '.$r->codigo_reserva;
		$mail->isHTML(true);                                  // Set email format to HTML
		 
		$mail->Body = $html;
		if($r->metodo_pago == 'giro' || $r->metodo_pago ==  'transferencia') {
			$mail->addAttachment('assets/archivos/metodos_pago/'.$r->metodo_pago.'-'.$r->lang.'.pdf'); 
		}
		$mail->addAttachment('assets/archivos/vaucher_payment/'.$this->input->post('id_reserva').'.pdf'); 
		$mail->send();
		
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
		$mail->setFrom('reservas@incalake.com', 'Incalake Travel Agency');
    	$mail->addAddress('reservas@incalake.com', 'Reserve');     // Add a recipient
    	//$mail->addAddress('edi72391@gmail.com', 'Reserve');     // Add a recipient
    	$mail->addAddress($c->email); 
    	$mail->isHTML(true);                                  // Set email format to HTML
    	$mail->Subject = "Solicitud de disponibilidad de servicio  - ( ".ProductoModel::find($c->id_producto)->titulo_producto." )";
		$mail->Body = $html;
		$mail->send();

 		echo ConsultaDisponibilidadResumen_::get();
	}

}