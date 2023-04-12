<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
    protected $var_language = null;

    public function __construct() {
      parent::__construct();
      $this->var_language = $this->uri->segment(1);
      $this->load->model('page_model','Page_model');
   }


public function menuweb($language='es',$style=1){
	// $data['menu_language']     = $this->Page_model->menu_language_location("","");
$data=array('language'=>$language,'style'=>$style,'menu_language'=>$this->Page_model->menu_language_location("",""));
 $this->load->view('header/menu_index',$data);
}

}
