<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Preguntas extends CI_Controller {
  //  protected $var_language = null;
    public function __construct(){
      parent::__construct();
      //$params['secret'] = '6LcrXzEUAAAAAG1bscBK2ucCHM21uXq8ZVBeMduP';
      //$this->load->library('recaptcha',$params);
     $this->load->model('preguntas_model');

   }


  public function index(){
    /*se procesara las reservas aqui*/
    /*  foreach($_POST['cantidades'] as $key => $value){
      
        echo $key.' : '.$value;
    i
      }*/
    include_once 'application/libraries/recaptchalib.php';
    @$reCaptcha = new ReCaptcha('6LcrXzEUAAAAAG1bscBK2ucCHM21uXq8ZVBeMduP');
    
    
    //  var_dump($_POST);
    $response = null;
     if ($this->input->post('g-recaptcha-response')){
          @$response = $reCaptcha->verifyResponse(
          $_SERVER["REMOTE_ADDR"],
          $_POST["g-recaptcha-response"]
         );
      }
    //var_dump($_POST);
    if ($response != null && $response->success){
        $datos['nombre'] = $this->input->post('nombres');
        $datos['descripcion'] = $this->input->post('descripcion');
        $datos['email'] = $this->input->post('email');
        $datos['actividad'] = $this->input->post('actividad');
        $datos['url'] = $this->input->post('url');
        $registro_pregunta = $this->preguntas_model->registrar_pregunta($datos);

        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        
        $mail->SMTPDebug = 0; // 0 = Off, 1 = Client Message, 2 = Client and Server Messages
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "sistemas@incalake.com";  
        $mail->Password = "Glaltoqu1@_";			// Este password debe ser la misma con la que se entra a gmail.

        //$mail->setFrom('reservas@incalake.com', 'Incalake Travel Agency');
        $mail->setFrom('sistemas@incalake.com', "Consulta de ".ucwords(mb_strtolower($datos['nombre'])) );
        $mail->addAddress('reservas@incalake.com', 'Inca Lake Travel' );
        //$mail->addReplyTo('reservas@incalake.com', 'Inca Lake Travel' );
        $mail->addReplyTo(trim($datos['email']), ucwords(mb_strtolower($datos['actividad'])) );
        $mail->Subject = "Consulta sobre ".ucwords(mb_strtolower($datos['actividad']));
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Body = "<p><b>Nombres</b>: ".$datos['nombre']."</p><p><b>Email</b>: ".$datos['email']."</p><p><b>Actividad</b>: ".ucwords(mb_strtolower($datos['actividad']))."</p><br/>".$datos['descripcion']."<br/><p>Enviado desde: https://incalake.com".$datos['url']."</p>";
        $mail->send();
	    
        /*enviar mail*/
        /*
        $para      = 'reservas@incalake.com';
        //$para      = 'froy.90@gmail.com';
        $titulo    = 'Consulta de: '.$datos['nombre'];
        $mensaje   = $datos['descripcion']."\n <p>Enviado desde: ".$datos['url']."</p>";
        $cabeceras = 'From:"'.$datos['nombre'].'" <'.$datos['email'].'>' . "\r\n" .
        'Reply-To: '.$datos['email']. "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        $envio_mail = mail($para, $titulo, $mensaje, $cabeceras);
        */
        /*fin enviar mail*/
        
        if($registro_pregunta or @$envio_mail)echo 1;
        else echo 0;
    }
    else  echo 0;
  }
  
}