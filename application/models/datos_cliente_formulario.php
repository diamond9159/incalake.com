<?php

class Datos_cliente_formulario extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }

    public function obtener_formulario($id_reserva = 0,$codigo=0){
       /* $this->db->set('fecha', 'NOW()', FALSE);
        $this->db->insert('preguntas', $datos);
        return $this->db->insert_id();*/
        // verificar si existen clientes con la id de reserva indicada
        if(count($this->db->query("SELECT id FROM clientes_info WHERE id_reserva = $id_reserva")->result_array()))return false;
        // obtener lista de actividades relacionadas a un id de reserva
        $response = $this->db->query("SELECT ds.id_producto,ds.cantidad,ds.id_calendar_event,reserva.fecha_creacion_reserva,reserva.nombres_cliente,reserva.apellidos_cliente,reserva.id_reserva,reserva.codigo_reserva,producto.titulo_producto
        FROM detalle_servicio_has_reserva AS shd
        INNER JOIN detalle_servicio AS ds ON shd.id_detalle_servicio = ds.id_detalle_servicio
        INNER JOIN reserva ON reserva.id_reserva = shd.id_reserva
        INNER JOIN producto ON producto.id_producto = ds.id_producto
        /* seleccionar fechas que no hayan caducado (10 dias)*/
        WHERE reserva.id_reserva = $id_reserva AND reserva.codigo_reserva = '$codigo'/*AND NOW() <= DATE_ADD(fecha_creacion_reserva, INTERVAL 10 DAY)*/
        ")->result_array();

       /* $response = array(
            array('id_producto'=>71,
                  'cantidad'=>3,
                  'titulo_producto'=>'Primer tour hacia los uros',
                  'id_reserva'=>481,
                  'nombres_cliente'=>'Froilan',
                  'apellidos_cliente'=>'Pruebas',
                  'codigo_reserva'=>'FR656'
                ),
            array('id_producto'=>72,
                  'cantidad'=>2,
                  'titulo_producto'=>'Segundo tour hacia el norte',
                  'id_reserva'=>481,
                  'nombres_cliente'=>'Usuarios',
                  'apellidos_cliente'=>'Probando..',
                  'codigo_reserva'=>'FR656'
                  )
        );*/

        $productos = [];
        //echo $response[0]['fecha_creacion_reserva'];
        foreach($response as $key => $value){
            $productos[$key]['cantidad'] = $value['cantidad'];
            $productos[$key]['id_calendar_event'] = $value['id_calendar_event'];
            $productos[$key]['nombre_actividad'] = $value['titulo_producto'];
            $productos[$key]['id_actividad'] = $value['id_producto'];
            $productos[$key]['id_reserva'] = $value['id_reserva'];
            $productos[$key]['nombres_titular'] = $value['nombres_cliente'].' '.$value['apellidos_cliente'];
            $productos[$key]['codigo_reserva'] = $value['codigo_reserva'];
            $productos[$key]['inputs'] = $this->db->query("SELECT cf.*,cc.*
            FROM producto 
          /*  INNER JOIN detalle_servicio ON shd.id_detalle_servicio = ds.id_detalle_servicio */
            INNER JOIN producto_has_campoform AS phc ON producto.id_producto = phc.id_producto
            INNER JOIN campo_formulario AS cf ON cf.id_campo_formulario = phc.id_campo_formulario
            INNER JOIN campo_categoria AS cc ON cf.id_campo_categoria = cc.id_campo_categoria
            WHERE producto.id_producto = {$value['id_producto']}
            
            ")->result_array();
        }   

        return $productos;
    }

    public function guardar_clientes($datos){

        // iniciar registro de clientes en bucles
        /*$this->db->set('fecha', 'NOW()', FALSE);
        $this->db->insert('preguntas', $datos);
        return $this->db->insert_id();*/


        foreach($datos as $key => $value){
            foreach($value as $key2 => $value2){
                
                foreach($value2 as $key3 => $value3){
                    $datos1['id_reserva'] = $key;
                    $datos1['id_producto'] = $key2;
                    $this->db->insert('clientes_info', $datos1);

                    //obtener ultimo id
                    $last_id = $this->db->insert_id();
                    foreach($value3 as $key4 => $value4){
                        $datos2['id_campo_formulario'] = $key4;
                        $datos2['value_campo_formulario'] = $value4;
                        $datos2['id_clientes_info'] = $last_id;
                        $this->db->insert('cliente_has_campo', $datos2);
                    }
                    
                }
            }
        }

        return $this->db->insert_id();
    }
    /* retorna lista de pasajeros segun una reserva */
    public function retornar_clientes_reserva($id_reserva){
        $results = array();
        // obtener lista de archivos desde la base de datos
        $result_clientes = $this->db->query("SELECT clientes_info.*,producto.titulo_producto FROM clientes_info INNER JOIN producto ON producto.id_producto = clientes_info.id_producto WHERE id_reserva = $id_reserva")->result_array();


        $resultados = array();
        if($result_clientes){
            foreach($result_clientes as $value){
                $result_campos = $this->db->query("SELECT cliente_has_campo.value_campo_formulario,campo_formulario.nombre_campo FROM cliente_has_campo INNER JOIN campo_formulario ON cliente_has_campo.id_campo_formulario = campo_formulario.id_campo_formulario   WHERE id_clientes_info = {$value['id']}")->result_array();
                $resultados[$value['id_producto']]['titulo_producto'] = $value['titulo_producto'];
                $resultados[$value['id_producto']]['datos_clientes'][] = $result_campos;
            }
            
            
            
        } 
        // retornar json
        return $resultados;
    }

    public function retornar_detalles_reserva($id_reserva=0){
       return $this->db->query("SELECT * FROM reserva WHERE id_reserva = $id_reserva")->row_array();
    }
}