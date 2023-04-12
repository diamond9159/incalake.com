<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CuponController extends CI_Controller {
    protected $var_language = null;
    protected $maxCuponIntent = 32;
    public function __construct() {
      parent::__construct();
        $this->load->library('session');
        $this->load->model("Cupon_model");
        $this->var_language = $this->uri->segment(1);

        if( $this->config->item('php-quick-profiler') ){
          $this->output->enable_profiler(FALSE);          
        }
   }

  public function index(){
   
  }

  public function codigo(){
    $quantityIntent = 0;
    $language       = $this->input->get('lang');
    $codigo_cupon   = $this->input->get('codigo');

    if ( $this->session->userdata('pi') ) {
      $quantityIntent = $this->session->userdata('quantity');
      $ipClient       = $this->session->userdata('pi');
      $quantityIntent = $quantityIntent + 1 ;
      $this->session->unset_userdata(array('pi','quantity'));
      $cookieResponse = array(
        'pi'        => $this->get_realIp(),
        'quantity'  => $quantityIntent,
      );
      $this->session->set_userdata($cookieResponse);
    }else{
      $cookieResponse = array(
        'pi'        => $this->get_realIp(),
        'quantity'  => 0,
      );
      $this->session->set_userdata($cookieResponse);
    }


    if ( $quantityIntent < $this->maxCuponIntent ) {
      $cupon = $this->Cupon_model->get_cupon( trim($codigo_cupon),trim($language) ); 
    }else{
      $cupon['response']  = 'error';
    } 
    $cupon['ip']        = $this->get_realIp();
    echo json_encode( $cupon );
  }

  private function get_realIp(){
    if (isset($_SERVER["HTTP_CLIENT_IP"])){
        return $_SERVER["HTTP_CLIENT_IP"];
    }else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }else if (isset($_SERVER["HTTP_X_FORWARDED"])){
        return $_SERVER["HTTP_X_FORWARDED"];
    }else if (isset($_SERVER["HTTP_FORWARDED_FOR"])){
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }else if (isset($_SERVER["HTTP_FORWARDED"])){
        return $_SERVER["HTTP_FORWARDED"];
    }else{
        return $_SERVER["REMOTE_ADDR"];
    }
  }

}
