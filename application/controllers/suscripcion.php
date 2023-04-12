<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suscripcion extends CI_Controller {
    protected $var_language = null;

    public function __construct() {
      parent::__construct();
      //   $this->load->model('page_model','Page_model');
      //   $this->load->model("galeria_model");
      // $this->load->model("categoria_model");
      $this->load->model("suscripcion_model");
      $this->load->model("suscripcion_has_destino_model");
      $this->load->model('destino_model');
      
      $this->var_language = $this->uri->segment(1);
      if( $this->config->item('php-quick-profiler') ){
            $this->output->enable_profiler(FALSE);          
      }
   }

  public function index(){
    echo "funciono";
  }
  /*
     * Adding a new categoria
     */
  public  function add()
    {   
        $all_destinos=$this->destino_model->get_all_destinos();
         $datos_de_suscripciones=$this->input->post('datos_de_suscripcion');
         $destinos='';
         $params_suscripcion=array();
         $params_suscripcion = array(
              'nombre_suscripcion' => $datos_de_suscripciones['nombre'],
              'email_suscripcion' => $datos_de_suscripciones['email'],
            );
        $suscripcion_id = $this->suscripcion_model->add_suscripcion($params_suscripcion);
         $suscripcion_has_destino_id='';
        foreach ($datos_de_suscripciones['destinos'] as $key => $value) {
            $params_suscripcion_has_destino=array(
                'id_suscripcion'=>$suscripcion_id,
                'id_destino'=>$value['destino'],
                'duracion_viaje'=>$value['duracion_viaje'],
                'fecha_viaje'=>$value['fecha_viaje'],
            );
            $destinos.="".
            "<tr>".
                "<td>".$all_destinos[(int)$value['destino']]['nombre_destino']."</td>".
                "<td>".$value['duracion_viaje']."</td>".
                "<td>".$value['fecha_viaje']."</td>".
              "</tr>";
            $suscripcion_has_destino_id = $this->suscripcion_has_destino_model->add_suscripcion_has_destino($params_suscripcion_has_destino);
         }
$to = "reservas@incalake.com, marketing@incalake.com";
//$to = "geochan94@gmail.com";
$subject = "Nueva suscripcion";

$message = "
            <html>
            <head>
            <title>HTML email</title>
            </head>
            <body>
            <h3>Nueva suscripcion</h3>
            <table width='100%'>
              <tr style='background: #2196F3;color: #fff;'>
                <th>NOMBRE</th>
                <th>EMAIL</th>
                <th>FECHA DE VIAJE</th>
              </tr>
              <tr>
                <td>".$datos_de_suscripciones['nombre']."</td>
                <td>".$datos_de_suscripciones['email']."</td>
                <td>".$datos_de_suscripciones['destinos'][0]['fecha_viaje']."</td>
              </tr>
              <tr style='background: #2196F3;color: #fff;'>
                <th>DESTINO</th>
                <th>DURACION</th>
                <th>FECHA DE VIAJE</th>
              </tr>".
              $destinos.
            "</table>
            </body>
            </html>
            ";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <reservas@incalake.com>' . "\r\n";
$headers .= 'Cc: reservas@incalake.com' . "\r\n";




            $envio_email=mail($to,$subject,$message,$headers);
            echo json_encode($envio_email);

          
        
    } 
public function state_suscripcion(){
    $result=0;
    $state=$this->suscripcion_model->get_state_suscripcion($this->input->post('email'));
    if (!empty($state)) {
      $result=1;
    }
    echo json_encode($result);
  }

}
