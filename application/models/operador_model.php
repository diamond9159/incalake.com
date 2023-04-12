<?php

class Operador_model extends CI_Model{
    function __construct(){
        parent::__construct();
        //$this->load->model('admin/idioma_model');
        //$this->load->model('admin/disponibilidad_model');
    }
    
    // Recupera toda la información para enviar el e-mail al operador del servicio
    function get_reserva($idReserva){
    	$data = [];
    	$response = $this->db->query("SELECT res.*,dese.*,pro.titulo_producto,tab.incluye_tab,ope.nombre_operador,ope.email_operador,ope.activo FROM reserva AS res JOIN detalle_servicio_has_reserva AS dshr ON res.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio JOIN producto AS pro ON pro.id_producto = dese.id_producto AND res.id_reserva = '".(Integer)trim(stripcslashes(strip_tags( $idReserva )))."' LEFT JOIN tab AS tab ON pro.id_producto = tab.id_tab LEFT JOIN operador AS ope ON pro.id_producto = ope.id_producto AND ope.activo = 1;")->result_array();
    	if ( !empty($response) ) {
    		foreach ($response as $key => $value) {
    		    
    			if (@$value['activo'] === 1 || @$value['activo'] === '1' ) {
    				$data[] = array(
    					"id_reserva"			=> $value['id_reserva'],
    					"fecha_creacion_reserva" => $value['fecha_creacion_reserva'],
    					"codigo_reserva"		=> $value['codigo_reserva'],
    					"nombres_cliente"		=> $value["nombres_cliente"]." ".$value['apellidos_cliente'],
    					"telefono_cliente"		=> $value['telefono_cliente'],
                        "email_cliente"         => $value['email_cliente']?trim($value['email_cliente']):'',
    					"nacionalidad_cliente"	=> $value['nacionalidad_cliente'],
    					"lang"					=> $value['lang'],
    					"id_detalle_servicio"	=> $value['id_detalle_servicio'],
    					"id_producto"			=> $value['id_producto'],
    					"fecha_servicio"		=> date_format(date_create($value['fecha_servicio']), "d-M-Y"),
    					"duracion_servicio"		=> $value['hora_inicio_servicio'], // Aqui hubo un error al guardar corectamente la información
    					"hora_inicio_servicio"	=> $value['duracion_servicio'],	// Aquí hubo error almacenando datos con el registro anterior
    					"cantidad_clientes"		=> $value['cantidad'],
    					"url_web_servicio"		=> $value['url'],
    					"titulo_producto"		=> $value['titulo_producto']?@$value['titulo_producto']:@$value['   descripcion_servicio'],
    					"incluye_producto"		=> @$value['incluye_tab'], 
    					"nombre_operador"		=> $value['nombre_operador'],
    					"email_operador"		=> $value['email_operador'],
    					"email_activo"			=> $value['activo'],
    					"items" => $this->get_Items(@$value['id_detalle_servicio']), 
    				);
    			}
    		}	
    	}
    	return $data;
    } 

    function get_Items($id_detalle_servicio){
    	return $this->db->query("SELECT * FROM resumen WHERE id_detalle_servicio = '".trim(strip_tags($id_detalle_servicio))."' AND tipo_articulo = 'persona';")->result_array();
    }
    // Actualiza la tabla detalle servicio el campo operador_confirmado 1 = E-mail enviado y 0 = E-mail no enviado
    function actualizarEmailEnviado( $id_detalle_servicio = 0 ){
        $this->db->where('id_detalle_servicio',$id_detalle_servicio);
        return $this->db->update('detalle_servicio',array('operador_confirmado' => 1));
    }
}
