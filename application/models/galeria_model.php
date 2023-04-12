<?php

class Galeria_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }

    public function obtener_imagen($id_producto = 0){
        $data = array();
        if ( $id_producto != 0 ) {
            $data = $this->db->query("SELECT g.* FROM galeria as g JOIN galeria_has_producto as ghp ON g.id_galeria = ghp.id_galeria AND ghp.id_producto = '".$id_producto."' ORDER BY g.id_galeria ASC LIMIT 1;")->row_array();   
        }
        return $data;
    }

    public function obtener_galeria($id_producto){
        return $this->db->query("SELECT g.* FROM galeria as g JOIN galeria_has_producto as ghp ON g.id_galeria = ghp.id_galeria AND ghp.id_producto = '".$id_producto."' ORDER BY g.id_galeria ASC;")->result_array();
    }


    public function obtener_imagen_servicio($id_galeria = 0 ){
        $data = array();
        if ( $id_galeria != 0) {
            $data = $this->db->query("SELECT * FROM galeria as g WHERE g.id_galeria = ".$id_galeria.";")->row_array();
        }
        return $data;
    }
    public function get_archivo($id_galeria){
        return $this->db->query("SELECT * FROM galeria as g WHERE g.id_galeria = ".$id_galeria.";")->row_array();
    }
}