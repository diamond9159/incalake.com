<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info extends CI_Controller {
    public function __construct() {
        parent::__construct();
          $this->load->model('info_page_model');     
    }

    public function index(){
         //set de idiomas para el header para que no genere error
      /*$data['menu_language'][] = array('codigo'=>'ES','uri_servicio'=>'');
        $data['menu_language'][] = array('codigo'=>'EN','uri_servicio'=>'');
        $data['menu_language'][] = array('codigo'=>'FR','uri_servicio'=>'');
        $data['menu_language'][] = array('codigo'=>'DE','uri_servicio'=>'');
        $data['menu_language'][] = array('codigo'=>'BR','uri_servicio'=>'');
        $data['menu_language'][] = array('codigo'=>'IT','uri_servicio'=>'');*/
        $data['language'] = $this->uri->segment(1);
        $detalles = $this->info_page_model->get_pagina($this->uri->segment(3),$this->uri->segment(1));
        $data['detalles_pagina'] = $detalles['paginas'];

        foreach($detalles['idiomas'] as $value){
            $data['menu_language'][] = array('codigo'=>$value['codigo'],'uri_servicio'=>'#');     
            $data['url_idiomas'][$value['codigo']] = base_url(strtolower($value['codigo']).'/'.$this->uri->segment(2).'/'.$value['url']);
        }
        
        //var_dump($detalles['idiomas']);
        if($data['detalles_pagina']){
            $this->load->view("info",$data);
        } else redirect(base_url('sitemap'));
        
  
    }
    
}