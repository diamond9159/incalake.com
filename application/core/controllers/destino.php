<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Destino extends CI_Controller {
    protected $var_language = null;

    public function __construct() {
      parent::__construct();
        $this->load->model('page_model','Page_model');
        $this->load->model("galeria_model");
      $this->load->model("categoria_model");
      $this->load->model("destino_model");
      $this->var_language = $this->uri->segment(1);
      if( $this->config->item('php-quick-profiler') ){
            $this->output->enable_profiler(FALSE);          
      }
   }

  public function index(){
    $language = $this->uri->segment(1);
    $data['language']=$language;
    $data['menu_language']     = $this->Page_model->menu_language_location("","");
    // $data['destinos'] = $this->destino_model->get_destinos($language);
    $data['destinos']          = $this->destino_model->get_destinos_for_web($language);
    // echo json_encode($data);
    $this->load->view('page-destinos',$data);
  }

  public function filtrar($lang,$destino){
    // $language = $this->uri->segment(1);
    $data['language']=$lang;
    $data['menu_language']  = $this->Page_model->menu_language_location("","");
    $data['destino']        = $this->destino_model->get_destino($lang,$destino);
    // $data['slider']         = $this->destino_model->get_slider($lang,$destino);       

    $this->load->view('page-destino',$data);
  }
}
