<?php
class Reservas_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }

    public function getFormProducto($id)
    {
        return $this->db->select('config_form')
                        ->from('producto')
                        ->where('id_producto', $id)
                        ->get()->row_array();
    }
   /* public function get_detalles_producto($id_producto){
        $resultado = $this->db->select('id_producto,titulo_producto,politicas_producto,requerimiento_datos,config_form')
               ->from('producto')
               ->where('id_producto', $id_producto)
               ->get()->row_array();

        return $resultado;
        
        //return $this->db->query("SELECT g.* FROM galeria as g JOIN galeria_has_producto as ghp ON g.id_galeria = ghp.id_galeria AND ghp.id_producto = '".$id_producto."' ORDER BY g.id_galeria ASC LIMIT 1;")->row_array();
    }*/

    public function data_calendario($id_producto){
        $response = $this->db->query("SELECT p.id_producto,p.titulo_producto,p.hora_inicio,p.duracion,p.anticipacion_reserva_producto,p.capacidad,p.requerimiento_datos,o.data_oferta,d.tipo_disponibilidad,d.data_disponibilidad, precio.precio_persona, precio.precio_edad, precio.precio_detalles FROM producto as p INNER JOIN oferta as o ON p.id_producto = o.id_producto AND p.id_producto = '".$id_producto."' INNER JOIN disponibilidad as d ON p.id_producto = d.id_producto INNER JOIN precio ON precio.id_producto = p.id_producto;")->result_array();
        $data = array();
        $data['titulo'] = $response[0]['titulo_producto'];
        $data['id'] = $response[0]['id_producto'];
        $data['precio_persona'] = $response[0]['precio_persona'];
        $data['precio_edad'] = $response[0]['precio_edad'];
        $data['precio_detalles'] = $response[0]['precio_detalles'];

        $data_disponibilidad= array();
        $data_bloqueo       = array();
        $data_oferta        = array();
        $inicio_disponibilidad = null;
        $fin_disponibilidad    = null;
        $dias_activos          = array();
        $dias_no_activos       = array();
        if ( count($response) > 0  ) {
            $temp_data_disponibilidad = json_decode($response[0]['data_disponibilidad'],true);
            $inicio_disponibilidad    = $temp_data_disponibilidad[0]['start'];
            $fin_disponibilidad       = $temp_data_disponibilidad[0]['end'];
            $dias_activos             = !empty($temp_data_disponibilidad[0]['dias_activos'])?$temp_data_disponibilidad[0]['dias_activos']:array();
            $dias_no_activos          = !empty($temp_data_disponibilidad[0]['dias_no_activos'])?$temp_data_disponibilidad[0]['dias_no_activos']:array();

            foreach ($response as $key => $value) {
                switch ($value['tipo_disponibilidad'] ) {
                    case 'disponibilidad':
                        $data_disponibilidad = !empty($value['data_disponibilidad'])?json_decode( trim($value['data_disponibilidad']),true ):array();

                    break;
                    case 'bloqueo':
                        $data_bloqueo = !empty($value['data_disponibilidad'])?json_decode( trim($value['data_disponibilidad']),true ):array();
                    break;
                    default:

                    break;
                }
            }
        }

        //$data['disponibilidad'] = $data_disponibilidad;
        $data['inicio_disponibilidad']  = $inicio_disponibilidad;
        $data['fin_disponibilidad']     = $fin_disponibilidad;
        $data['dias_activos']           = $dias_activos;
        $data['dias_no_activos']        = $dias_no_activos;
        $data['inicio_tour']            = $this->formatear_inicio_tour( $response[0]['hora_inicio'] );
        $data['duracion_tour']          = !empty( $response[0]['duracion'] ) ? $response[0]['duracion'] : '' ;
        $data['anticipacion_reserva']   = $this->formatear_anticipacion_reserva( $response[0]['anticipacion_reserva_producto'] );
        $data['bloqueo']        = $data_bloqueo;
        $data['oferta']         = $data_oferta;
        $data['aforo']         = $response[0]['capacidad'];
        $data['requerimiento_datos']    = $response[0]['requerimiento_datos'];
        return $data;
    }

    private function formatear_anticipacion_reserva($anticipacion_reserva){
        $data = array();
        if ( !empty($anticipacion_reserva) ) {
            $array_anticipacion_reserva = explode(":",$anticipacion_reserva);           
            switch ($array_anticipacion_reserva[1] ) {
                case '0':
                    $data = array('cantidad' => $array_anticipacion_reserva[0] , 'tiempo' => 'minutes' );
                break;
                case '1':
                    $data = array('cantidad' => $array_anticipacion_reserva[0] , 'tiempo' => 'hours' );
                break;
                case '2':
                    $data = array('cantidad' => $array_anticipacion_reserva[0] , 'tiempo' => 'days' );
                break;
                default:
                    $data = array('cantidad' => $array_anticipacion_reserva[0] , 'tiempo' => 'days' );
                break;
            }
        }
        return $data;
    }

    private function formatear_inicio_tour($horarios){
        $data = array();
        $array_horarios = null;
        if ( !empty($horarios) ) {
            $array_horarios = explode(",",$horarios);
            foreach ($array_horarios as $key => $value) {
                array_push($data,$value);
            }
        }
        return $data;
    }
}