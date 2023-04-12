<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rastreo_sitemap_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }
    function get_sitemap(){
        //$sitemap = $this->db->query("SELECT s.uri_servicio,s.ubicacion_servicio from servicio as s JOIN producto as p ON s.id_servicio=p.id_servicio AND p.estado_producto='1' JOIN idioma as i on i.id_idioma=s.idioma_id_idioma and LOWER(i.codigo)='".$lang."' group by s.uri_servicio;")->result_array();
        $sitemap = $this->db->query("SELECT LOWER(i.codigo) as lang ,s.uri_servicio,s.ubicacion_servicio from servicio as s JOIN producto as p ON s.id_servicio=p.id_servicio AND p.estado_producto='1' JOIN idioma as i on i.id_idioma=s.idioma_id_idioma group by s.id_servicio")->result_array();
        return $sitemap;
    }
}