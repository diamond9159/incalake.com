
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rastreo_sitemaps extends CI_Controller {
    protected $var_language = null;

    public function __construct() {
      parent::__construct();
      $this->load->model("rastreo_sitemap_model");
   }

  public function index(){
    $data=array();
    $temp_sitemap= $this->rastreo_sitemap_model->get_sitemap();
    $sitemap=array();
		foreach ($temp_sitemap as $key => $value) {
		    $temp_ubicacion_servicio=explode(',',$value['ubicacion_servicio']);
			$sitemap[]='https:'.base_url().strtolower($value['lang']).'/'.strtolower($temp_ubicacion_servicio[0]).'/'.$value['uri_servicio'];
		}
	$data['sitemap']=$sitemap;
	//var_dump($sitemap);
    $this->load->view('rastreo_sitemaps',$data);
  }
}