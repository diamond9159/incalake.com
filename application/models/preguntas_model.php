<?php

class Preguntas_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }

    public function registrar_pregunta($datos){
        $this->db->set('fecha', 'NOW()', FALSE);
        $this->db->insert('preguntas', $datos);
        return $this->db->insert_id();
    }
}