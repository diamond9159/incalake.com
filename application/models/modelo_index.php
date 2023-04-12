<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelo_index extends CI_Model {


   public function obtener_valorados($idioma){
        $id_idioma = $this->db->query("SELECT id_idioma FROM idioma WHERE codigo='$idioma'")->row();
        //var_dump($id_idioma);
        $data = array();
        if ( !empty($id_idioma->id_idioma) ) {
            $data = $this->db->query("SELECT servicio.*,galeria.url_archivo,galeria.carpeta_archivo FROM servicio  JOIN galeria ON galeria.id_galeria = servicio.miniatura  WHERE idioma_id_idioma = {$id_idioma->id_idioma} ORDER BY valoracion DESC LIMIT 6;")->result_array();   
        } 
        return $data;
    }

    

}