<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends CI_Controller {
    public function index(){
         //set de idiomas para el header para que no genere error
        $data['menu_language'][] = array('codigo'=>'ES','uri_servicio'=>'');
        $data['menu_language'][] = array('codigo'=>'EN','uri_servicio'=>'');
        $data['menu_language'][] = array('codigo'=>'FR','uri_servicio'=>'');
        $data['menu_language'][] = array('codigo'=>'DE','uri_servicio'=>'');
        $data['menu_language'][] = array('codigo'=>'BR','uri_servicio'=>'');
        $data['menu_language'][] = array('codigo'=>'IT','uri_servicio'=>'');

        $data['language'] = $this->uri->segment(1);
        $this->load->view("sitemap",$data);
    }
    
}