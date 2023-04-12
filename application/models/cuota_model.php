<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuota_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_cuota($id_cuota){
        $cuota = $this->db->query("SELECT * FROM cuotas WHERE id_cuotas = ? ;",array($id_cuota))->row_array();
        return $cuota;
    }

    function get_cuotaIdReserva($idReserva){
        return $this->db->query("SELECT SUM(monto) as monto_adelantado FROM cuotas WHERE id_reserva = ? AND confirmacion_pago = 0 ;",array($idReserva))->row_array();
        //return $this->db->query("SELECT SUM(monto) as monto_adelantado FROM cuotas WHERE id_reserva = ? AND confirmacion_pago = 1;",array($idReserva))->row_array();
    }
/*
    function get_code_cuota($codigo_cuota){
        $cuota = $this->db->query("SELECT * FROM cuotas WHERE codigo = '".strip_tags(stripslashes(trim(mb_strtoupper($codigo_cuota))))."';" )->row_array();
        $codigo = FALSE;
        if ( !empty( $cuota['codigo'] ) ) {
            //$codigo = mb_strtolower($cuota['codigo']);   
            $codigo = TRUE;
        }   
        return $codigo;
    }
*/
    function get_all_cuotas(){
        $cuotas = $this->db->query("SELECT * FROM cuotas WHERE 1 = 1 ORDER BY id_cuotas DESC;")->result_array();
        return $cuotas;
    }
    
    function add_cuota($params){
        $this->db->insert('cuotas',$params);
        return $this->db->insert_id();
    }
    
    function update_cuota_IdReserva($id_reserva,$params){
        $this->db->where('id_reserva',$id_reserva);
        return $this->db->update('cuotas',$params);
    }

    /*
    function update_cuota($id_cuota,$params){
        $this->db->where('id_cuota',$id_cuota);
        return $this->db->update('cuota',$params);
    }
    
    function delete_cuota($id_cuota){
        return $this->db->delete('cuota',array('id_cuota'=>$id_cuota));
    }
    */
}