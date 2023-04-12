<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservas extends CI_Controller {
  //  protected $var_language = null;
    public function __construct(){
      parent::__construct();
      $this->load->model('page_model','Page_model');
	    $this->load->model('reservas_model');
      $this->load->model('categoria_model');
   }


  public function index(){
    /*se procesara las reservas aqui*/

     $resultado['datos'] = $this->reservas_model->get_detalles_producto(@$_GET['id']);
     $resultado['data_calendario'] = array();
     $resultado['data_calendario'] = $this->reservas_model->data_calendario( @$_GET['id'] );
     $resultado['language']        = 'es';
     $this->load->view('reservas/index.php',$resultado);
    /*  foreach($_POST['cantidades'] as $key => $value){
      
        echo $key.' : '.$value;
      }*/
    
  //  var_dump($_POST);
    //echo 'hola';
  }

  public function store()
  {
     // echo json_encode($this->input->post());
      print_r(array_keys($this->input->post()));
  }

  public function paquete($language,$id_paquete = 0 ){
    $resultado['language']          = $language;
    $resultado['menu_language']     = $this->Page_model->menu_language_location("","");
    $resultado['menu_location']     = $this->menu_generate_location( $language );
    $resultado['menu_categoria']    = $this->categoria_model->menu_categoria($language);
    if ( $id_paquete === 0 ) {
      echo "<h2> RESERVA: ".$language." (Implementar vista)</h2>";
    }else{
      //echo "<h2> RESERVAR: ".$language." - ".$id_paquete."</h2>"; 
     // $resultado['datos']           = $this->reservas_model->get_detalles_producto($id_paquete);
      $resultado['data_calendario'] = array();
      $resultado['data_calendario'] = $this->reservas_model->data_calendario( $id_paquete );

      //$this->load->view('reservas/index.php',$resultado);

      $this->load->view('reservas',$resultado);     
      
    }
  }

  private function menu_generate_location($language){
    $response = $this->Page_model->menu_generate_location($language);
    $data = array();
    foreach ($response as $key => $value) {
      $data[] = mb_strtoupper( $this->uri_localidad($value['ubicacion_servicio']) );
    }
    $data = array_unique($data);
    return $data;
  }

  private function uri_localidad($location){
    $uri_string = $location;
    if ( !empty($uri_string) ) {
      $uri_string = mb_strtolower(trim($location));
      $uri_string_temp = str_replace(", ",",",$uri_string);
      $uri_string_temp = str_replace(" ", "", $uri_string_temp);
      $uri_string_temp = str_replace("-", "", $uri_string_temp);
      $uri_string_temp = str_replace("_", "-",$uri_string_temp);
      $uri_string_temp = str_replace(",,",",",$uri_string_temp);
      $uri_string_temp = explode(",",$uri_string_temp);
      $uri_string    = $uri_string_temp[0];
    }
    return $uri_string;
  }

     public function apiform_producto()
     {
         echo json_encode($this->reservas_model->getFormProducto(@$_GET['id']));
     }
  
}