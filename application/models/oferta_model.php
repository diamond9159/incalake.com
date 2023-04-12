<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oferta_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }


    public function oferta($lang = 'ES'){
        /*
        $response = $this->db->query("SELECT i.codigo, s.ubicacion_servicio,s.uri_servicio, p.titulo_producto, s.descripcion_pagina, p.duracion, pr.cantidad, MIN( pr.monto ) AS precio, o.valor_oferta, o.tipo_oferta, g. *, cat.nombre_categoria 
            FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma
            AND i.codigo =  '".strtoupper($lang)."' LEFT JOIN producto AS p ON s.id_servicio = p.id_servicio
            LEFT JOIN detalle_precio AS dp ON dp.id_producto = p.id_producto
            AND dp.id_etapa_edad = 1 LEFT JOIN precios AS pr ON pr.id_detalle_precio = dp.id_detalle_precio
            JOIN oferta AS o ON p.id_producto = o.id_producto AND (NOW( )  BETWEEN o.fecha_inicio AND o.fecha_fin) LEFT JOIN galeria_has_producto AS ghp ON p.id_producto = ghp.id_producto
            LEFT JOIN galeria AS g ON ghp.id_galeria = g.id_galeria  LEFT JOIN producto_has_categoria as phc ON p.id_producto = phc.producto_id_producto LEFT JOIN categoria as cat ON cat.id_categoria = phc.categoria_id_categoria GROUP BY p.titulo_producto;")->result_array();
        */
        $response = $this->db->query("SELECT i.codigo, s.ubicacion_servicio,s.uri_servicio, p.titulo_producto, s.descripcion_pagina, p.duracion, pr.cantidad,p.pasajeros_restantes, MIN( pr.monto ) AS precio, o.valor_oferta, o.tipo_oferta, g. *, cat.nombre_categoria 
            FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma
            AND i.codigo =  '".strtoupper($lang)."' LEFT JOIN producto AS p ON s.id_servicio = p.id_servicio
            LEFT JOIN detalle_precio AS dp ON dp.id_producto = p.id_producto
            AND dp.id_etapa_edad = 1 LEFT JOIN precios AS pr ON pr.id_detalle_precio = dp.id_detalle_precio
            JOIN oferta AS o ON p.id_producto = o.id_producto AND (NOW( )  BETWEEN o.fecha_inicio AND o.fecha_fin) LEFT JOIN galeria_has_producto AS ghp ON p.id_producto = ghp.id_producto
            LEFT JOIN galeria AS g ON ghp.id_galeria = g.id_galeria  LEFT JOIN producto_has_categoria as phc ON p.id_producto = phc.producto_id_producto LEFT JOIN categoria as cat ON cat.id_categoria = phc.categoria_id_categoria GROUP BY p.titulo_producto;")->result_array();
        $data = array();
        if (count($response)) {
            foreach ($response as $key => $value) {
                $ubicacion = count(trim($value['ubicacion_servicio'])) != 0 ? explode(",",$value['ubicacion_servicio']) : ''; 
                $data[] = array(
                    'idioma'             => mb_strtolower($value['codigo']),
                    'ubicacion'          => $value['ubicacion_servicio'],
                    'actividad'          => $value['titulo_producto'],
                    'descripcion'        => $value['descripcion_pagina'],
                    'precio_normal'      => number_format($value['precio'],2,'.',''),
                    'precio_oferta'      => $this->obtener_oferta($value['precio'],$value['valor_oferta'],$value['tipo_oferta']),
                    'oferta'             => $this->descripcion_oferta(number_format($value['valor_oferta'],2,'.',''),$value['tipo_oferta']),
                    'duracion'           => $this->formatear_duracion($value['duracion'],mb_strtolower($value['codigo'])),
                    'horarios'           => $this->formatear_horarios($value['duracion'],mb_strtolower($value['codigo'])),
                    'url'                => base_url().strtolower($value['codigo']).'/'.$this->uri_amigable(mb_strtolower($ubicacion[0])).'/'.mb_strtolower($value['uri_servicio']),
                    'imagen'             => base_url().(
(!empty($value['url_archivo']))?("galeria/admin/".$this->carpeta($value['tipo_archivo'])."/".$value['carpeta_archivo']."/thumbs/".$value['url_archivo']):("assets/img/default-shot-img.png")),
                    'categoria'         => $value['nombre_categoria'],
                    'txt_precio'        => mb_strtolower($value['codigo']) === 'es'? 'Desde' : 'From',
                    'txt_more_info'        => mb_strtolower($value['codigo']) === 'es'? 'Leer Más' : 'More Info',
                    'pasajeros_restantes'        => $value['pasajeros_restantes'].($value['codigo']=='es'?' espacios disponibles':' available spaces'),
                );
            }
        }
        return $data;
    }

    private function uri_amigable($token) {
        $separador = '-';//ejemplo utilizado con guión medio
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        //Quitamos todos los posibles acentos
        $url = strtr(utf8_decode($token), utf8_decode($originales), $modificadas);
        //Convertimos la cadena a minusculas
        $url = utf8_encode(strtolower($url));
        //Quitamos los saltos de linea y cuanquier caracter especial
        $buscar = array(' ', '&amp;', '\r\n', '\n', '+');
        $url = str_replace ($buscar, $separador, $url);
        $buscar = array('/[^a-z0-9\-&lt;&gt;]/', '/[\-]+/', '/&lt;[^&gt;]*&gt;/');
        $reemplazar = array('', $separador, '');
        $url = preg_replace ($buscar, $reemplazar, $url);
        return $url;
    }

    private function obtener_oferta($cantidad,$descuento,$tipo){
        $precio_oferta = 0;
        switch ( (Integer)$tipo ) {
            case 0: //Porcentaje
                $precio_oferta = $cantidad - ( ( $cantidad * $descuento ) / 100);       
            break;
            case 1: // En cantidad (USD)
                $precio_oferta = $cantidad - ( $cantidad - $descuento );
            break;
        }
        return number_format($precio_oferta,2,'.','');
    }

    private function descripcion_oferta($descuento,$tipo){
        $descripcion_oferta = 0;
        switch ( (Integer)$tipo ) {
            case 0: //Porcentaje
                $temp = explode('.',$descuento);
                $descripcion_oferta = $temp[0]. ( (Integer)$temp[1] > 0 ? '.'.$temp[1] : '' ).'%';     
            break;
            case 1: // En cantidad (USD)
                $descripcion_oferta = '$ '.$descuento.' USD';
            break;
        }
        return $descripcion_oferta;
    }

    private function carpeta($id){
        $carpeta = '';
        switch ( (integer)$id ) {
            case 0:
                $carpeta = 'docs';
                break;
            case 1:
                $carpeta = 'full-slider';
                break;
            case 2:
                $carpeta = 'short-slider';
                break;
            case 3:
                $carpeta = 'relateds';
                break;
            case 4:
                $carpeta = 'recursos';
                break;
            case 5:
                $carpeta = 'politicas';
                break;
            default:
                $carpeta = 'otros';
                break;
        }
        return $carpeta;
    }

    private function formatear_duracion($token,$lang){
        $data = array();
        if (trim($token)) {
            $array_duracion = explode(",",$token);
            foreach ($array_duracion as $key => $value) {
                $temp = explode("!",$value);
                switch ( (Integer)$temp[1] ) {
                    case 0: //minutos
                        $data[] =( $lang === 'es'? 'Duración' : 'Duration' ).': '.$temp[0].' '.( $lang === 'es'? 'minutos' : 'Minutes' );
                    break;
                    case 1: // Horas
                        $data[] =( $lang === 'es'? 'Duración' : 'Duration' ).': '.$temp[0].' '.( $lang === 'es'? 'Horas' : 'Hours' );
                    break;
                    case 2: // Días
                        $data[] =( $lang === 'es'? 'Duración' : 'Duration' ).': '.$temp[0].' '.( $lang === 'es'? 'Días' : 'Days' );
                    break;
                    case 3: //semanas
                        $data[] =( $lang === 'es'? 'Duración' : 'Duration' ).': '.$temp[0].' '.( $lang === 'es'? 'Semanas' : 'weeks' );
                    break;
                    case 4: // meses
                        $data[] =( $lang === 'es'? 'Duración' : 'Duration' ).': '.$temp[0].' '.( $lang === 'es'? 'Meses' : 'Months' );
                    break;
                }
            }            
        }else{ $data[0] = "";}
        return $data;
    }
    private function formatear_horarios($token,$lang){
        $data = '';
        if (trim($token)) {
            $array_duracion = explode(",",$token);
            if (count($array_duracion)>1) {
                $data=count($array_duracion).' '.( $lang === 'es'? 'Horarios Disponibles' : 'Schedules Available' );
            }else{
                $data=count($array_duracion).' '.( $lang === 'es'? 'Horario Disponible' : 'Available Timetable' );
            }
            

        }
        return $data;

    }
    public function get_precio_minimo($id_actividad){
        $data='';
        $result=$this->db->query("SELECT i.codigo, s.ubicacion_servicio,s.uri_servicio, p.titulo_producto, s.descripcion_pagina, p.duracion, pr.cantidad, MIN( pr.monto ) AS precio FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma LEFT JOIN producto AS p ON s.id_servicio = p.id_servicio and p.id_producto='".$id_actividad."' LEFT JOIN detalle_precio AS dp ON dp.id_producto = p.id_producto AND dp.id_etapa_edad = 1 JOIN precios AS pr ON pr.id_detalle_precio = dp.id_detalle_precio GROUP BY p.titulo_producto")->row_array();
        if (!empty($result)) {
            return number_format($result['precio'], 2, '.', '');;
        }else{
            return "0";
        }
    }
}