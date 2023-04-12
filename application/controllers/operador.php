<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/dompdf/autoload.inc.php'; // Cargamos las librerias DOMPDF 
use Dompdf\Dompdf;   // Inicializamos la clase Dompdf para apoder ser utilizada.
use Dompdf\Options;  // Inicializamos la clase Options para apoder ser utilizada.

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer; // Inicializamos la clase PHPMailer que vamos a utilizar 
use PHPMailer\PHPMailer\Exception; // Inicializamos la clase Exception que vamos a utilizar

class Operador extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('operador_model');
    } 

    function index(){
        /*
        $idProducto         = $this->input->post('idProducto');
        $idCodigoProducto   = $this->input->post('idCodigoProducto');

        $response = $this->operador_model->get_operador( trim(strip_tags(stripcslashes($idProducto))), trim(strip_tags(stripcslashes($idCodigoProducto))) );
        echo json_encode($response);
        */
    }

  /*** ENVIAR EMAIL CON LOS DATOS DEL CLIENTE AL OPERADOR QUE SE ENCARGARÁ CON EL SERVICIO ***/
    function enviarEmail($idReserva){
        $response  = $this->operador_model->get_reserva($idReserva);
        //echo json_encode($response);
        
        if (!empty($response)) {
            foreach ($response as $key => $value) {
                if ( $value['email_activo'] === 1 || $value['email_activo'] === '1' ) {
                    $data['data'] = $value;
                    $html = $this->load->view("operador/email",$data,true);  
                    //echo $html;
                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('reservas@incalake.com', 'Incalake Travel Agency');
                    //$mail->addAddress('reservas@incalake.com', 'Reserve');     // Add a recipient
                    //$mail->addAddress('sistemas@incalake.com', 'Reserve');     // Add a recipient
                    
                    $mail->addAddress( mb_strtolower($value['email_operador']) );
                    //$mail->addAddress( "edwin72391@gmail.com" );
                    
                    $mail->Subject = 'Reserva #: '.trim(@$value['codigo_reserva']).'-'.@$value['id_detalle_servicio'];
                    $mail->isHTML(true);                                  // Set email format to HTML 
                    $mail->Body = $html;
                    $emailEnviado = $mail->send();
                    if($emailEnviado){
                        $this->operador_model->actualizarEmailEnviado(@$value['id_detalle_servicio']);
                    }else{
                        //Cuando el email no se ha podido enviar.
                    }
                    $mail = null;
                    $html = null;
                }    
            }
        }
        
    }
    
    //PRUEBA DE ENVIO DE CORREO
    function enviarEmailPrueba($idReserva){
        $response  = $this->operador_model->get_reserva($idReserva);
        //echo json_encode($response);
        
        if (!empty($response)) {
            foreach ($response as $key => $value) {
                if ( $value['email_activo'] === 1 || $value['email_activo'] === '1' ) {
                    $data['data'] = $value;
                    $html = $this->load->view("operador/email",$data,true);  
                    //echo $html;
                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('reservas@incalake.com', 'Incalake Travel Agency');
                    //$mail->addAddress('reservas@incalake.com', 'Reserve');     // Add a recipient
                    //$mail->addAddress('sistemas@incalake.com', 'Reserve');     // Add a recipient
                    
                    //$mail->addAddress( mb_strtolower($value['email_operador']) );
                    $mail->addAddress( "alejandro.diaz@syncromind.net" );
                    
                    $mail->Subject = 'Reserva #: '.trim(@$value['codigo_reserva']).'-'.@$value['id_detalle_servicio'];
                    $mail->isHTML(true);                                  // Set email format to HTML 
                    $mail->Body = $html;
                    $emailEnviado = $mail->send();
                    if($emailEnviado){
                        //$this->operador_model->actualizarEmailEnviado(@$value['id_detalle_servicio']);
                    }else{
                        //Cuando el email no se ha podido enviar.
                    }
                    $mail = null;
                    $html = null;
                }    
            }
        }
    }
}
