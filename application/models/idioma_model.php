<?php

class Idioma_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_idioma($id_idioma){
        $idioma = $this->db->query("SELECT * FROM idioma WHERE id_idioma = ? ;",array($id_idioma))->row_array();
        return $idioma;
    }

    function get_code_idioma($codigo_idioma){
        $idioma = $this->db->query("SELECT * FROM idioma WHERE codigo = '".strip_tags(stripslashes(trim(mb_strtoupper($codigo_idioma))))."';" )->row_array();
        $codigo = FALSE;
        if ( !empty( $idioma['codigo'] ) ) {
            //$codigo = mb_strtolower($idioma['codigo']);   
            $codigo = TRUE;
        }   
        return $codigo;
    }

    function get_all_idiomas(){
        $idiomas = $this->db->query("SELECT * FROM idioma WHERE 1 = 1 ORDER BY id_idioma DESC;")->result_array();
        return $idiomas;
    }
    /*    
    function add_idioma($params){
        $this->db->insert('idioma',$params);
        return $this->db->insert_id();
    }
    
    function update_idioma($id_idioma,$params){
        $this->db->where('id_idioma',$id_idioma);
        return $this->db->update('idioma',$params);
    }
    
    function delete_idioma($id_idioma){
        return $this->db->delete('idioma',array('id_idioma'=>$id_idioma));
    }
    */
}