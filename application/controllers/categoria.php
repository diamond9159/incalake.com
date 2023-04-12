<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoria extends CI_Controller {
    protected $var_language = null;

    public function __construct() {
      parent::__construct();
        $this->load->model('page_model','Page_model');
        $this->load->model("galeria_model");
      $this->load->model("categoria_model");
      $this->var_language = $this->uri->segment(1);
      if( $this->config->item('php-quick-profiler') ){
            $this->output->enable_profiler(FALSE);          
      }
   }

   public function indexPage()
   {

   }

  public function index(){
    $data = array();
    $language = $this->uri->segment(1);
    $data['location']       = 'Categorias';
    $data['menu_language']  = $this->Page_model->menu_language_location("","");
    $data['menu_location']  = $this->menu_generate_location($language);
    //$data['menu_categoria'] = $this->categoria_model->menu_categoria($language);
    $data['menu_categoria'] = $this->categoria_model->listar_categorias($language);
    $data['language'] = $this->uri->segment(1);
    $this->load->view('categoria',$data);
  }

  public function filtrar($language,$category){
    $language = $this->uri->segment(1);
    $data['language']       = stripslashes(strip_tags(trim($language)));
    $data['menu_language']  = $this->Page_model->menu_language_location("","");
    $data['destino']        = $this->categoria_model->get_destino_categoria($language,$category);
    $data['slider']         = $this->categoria_model->obtener_slider($language,$category);

    $this->load->view('categoria-list',$data);
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
      $uri_string = $uri_string_temp[0];
    }
    return $uri_string;
  }

  private function carpeta($id){
    $carpeta = '';
    switch ( (integer)$id ) {
      case 0:
        $carpeta = 'docs';
        break;
      case 1:
        $carpeta = 'full-slider';
        break;
      case 2:
        $carpeta = 'short-slider';
        break;
      case 3:
        $carpeta = 'relateds';
        break;
      case 4:
        $carpeta = 'recursos';
        break;
      case 5:
        $carpeta = 'politicas';
        break;
      case 6:
        $carpeta = 'other-images';
        break;
      default:
        $carpeta = 'otros';
        break;
    }
    return $carpeta;
  }
}