<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datos_reserva extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }

    public function get_codigo($id=0){
        $data = $this->db->query("SELECT id_reserva,codigo_reserva FROM reserva WHERE id_reserva=$id")->row_array();
       
        return $data;
    } 
    /* metodo para almacenar el id del evento calendario relacionado al detalle servicio */
    public function guardar_id_evento($id_detalle_servicio=0,$id_evento_calendario=0){
        $param['id_calendar_event'] = $id_evento_calendario;
        $this->db->where('id_detalle_servicio', $id_detalle_servicio)->update('detalle_servicio', $param);
        return $this->db->affected_rows();
    }
    
    function getFirstService($idReserva = null ){
        $data = [];
        $responseFechas = $this->db->query("SELECT rese.id_reserva, rese.fecha_creacion_reserva AS fecha_reserva, dese.fecha_servicio FROM reserva AS rese JOIN detalle_servicio_has_reserva AS desere ON rese.id_reserva = desere.id_reserva JOIN detalle_servicio AS dese ON desere.id_detalle_servicio = dese.id_detalle_servicio AND rese.id_reserva = ? ORDER BY dese.fecha_servicio ASC LIMIT 1;",array($idReserva))->row_array();
        if(!empty($responseFechas)){
            $data['id_reserva']         = $responseFechas['id_reserva'];
            $data['fecha_reserva']      = $responseFechas['fecha_reserva'];
            $data['fecha_servicio']     = $responseFechas['fecha_servicio'];
            $responseCantidadServiciosDeLaFecha = $this->db->query('SELECT COUNT(dese.fecha_servicio) AS cantidad FROM detalle_servicio AS dese WHERE dese.fecha_servicio = ?;',array(@$responseFechas['fecha_servicio']))->row_array();
            $data['cantidad_servicios'] = @$responseCantidadServiciosDeLaFecha['cantidad'];
        }else{
            $data['id_reserva']         = 'FR-'.date('dmY');
            $data['fecha_reserva']      = 'FR-'.date('dmY');
            $data['fecha_servicio']     = 'FR-'.date('dmY');
            $data['cantidad_servicios'] = 'FR-00';
        }
        return $data;
    }
    
    function get_ServicesInclude( $id_reserva = null ){
        return $this->db->query('SELECT rese.id_reserva, dese.id_producto, prod.titulo_producto, tab.incluye_tab FROM reserva AS rese JOIN detalle_servicio_has_reserva AS dsre ON rese.id_reserva = dsre.id_reserva AND rese.id_reserva = ? JOIN detalle_servicio AS dese ON dsre.id_detalle_servicio = dese.id_detalle_servicio JOIN producto AS prod ON dese.id_producto = prod.id_producto JOIN tab AS tab ON prod.id_producto = tab.producto_id_producto;', array( $id_reserva ) )->result_array();
    }
}
