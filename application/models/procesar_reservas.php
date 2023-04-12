<?php
class Reservas_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function registrar_reserva($datos)
    {
        $this->db->insert('reserva',$datos);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
?>