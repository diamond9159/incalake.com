<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
     /*enviar mail*/
      $para      = 'reservas@incalake.com';
      $titulo    = 'Consulta de: '.$datos['nombre'];
      $mensaje   = $datos['descripcion']."\n <p>Enviado desde: ".$datos['url']."</p>";
      $cabeceras = 'From:"'.$datos['nombre'].'" <'.$datos['email'].'>' . "\r\n" .
      'Reply-To: '.$datos['email']. "\r\n" .
      'X-Mailer: PHP/' . phpversion();

      $envio_mail = mail($para, $titulo, $mensaje, $cabeceras);
      /*fin enviar mail*/


      if($registro_pregunta or $envio_mail)echo 1;
      else echo 0;
      
    }
    else  echo 0;
    
  }
  
}