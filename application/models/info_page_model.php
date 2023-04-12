<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info_page_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }

    public function get_pagina($uri,$lang){
      $lang = strtoupper($lang);
      
      $resultado['paginas'] = $this->db->query("SELECT pagina_html.* FROM pagina_html INNER JOIN idioma ON idioma.id_idioma = pagina_html.id_idioma WHERE url = '$uri' AND idioma.codigo = '$lang'")->row_array();

    $resultado['idiomas'] = $this->db->query("SELECT url,codigo FROM pagina_html INNER JOIN idioma ON idioma.id_idioma = pagina_html.id_idioma WHERE id_pagina = {$resultado['paginas']['id_pagina']}")->result_array();

      return $resultado;
    }

    public function get_paginasss($lang,$destino){
        
        $resultado = $this->db->query("SELECT * FROM destino WHERE uri_destino = '".mb_strtolower($destino)."' LIMIT 1;")->row_array();
        
        return $resultado;
    }

    
}