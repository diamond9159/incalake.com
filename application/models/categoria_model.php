<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoria_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model("galeria_model");
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }

    public function index($language){
        //return $this->db->query("SELECT i.*, s.titulo_pagina,s.valoracion,s.uri_servicio,s.imagen_principal, s.ver_slider,g.* FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND s.ver_slider != 0 AND i.codigo = '".$language."' JOIN galeria as g ON g.id_galeria = s.imagen_principal ORDER BY RAND() LIMIT 4;")->result_array();
    }


    public function listar_categorias($language){ 
        $data = array();
        $response = $this->db->query("SELECT i.codigo, c.id_categoria, c.nombre_categoria, c.descripcion_categoria,cc.imagen_categoria,count(phc.producto_id_producto) as cantidad_paquetes, AVG(s.valoracion) as valoracion, COUNT(DISTINCT s.codigo_servicio_id_codigo_servicio) as cantidad_servicio FROM idioma AS i INNER JOIN categoria AS c ON i.id_idioma = c.id_idioma AND i.codigo = '".strip_tags(stripslashes(trim(strtolower($language))))."' JOIN codigo_categoria as cc ON c.id_codigo_categoria = cc.id_codigo_categoria LEFT JOIN producto_has_categoria AS phc ON c.id_categoria = phc.categoria_id_categoria LEFT JOIN producto AS p ON p.id_producto = phc.producto_id_producto LEFT JOIN servicio as s ON p.id_servicio = s.id_servicio GROUP BY c.nombre_categoria DESC;")->result_array();
        if ($response) {
            foreach ($response as $key => $value) {
                $galeria = $this->galeria_model->get_archivo( !empty($value['imagen_categoria']) ? $value['imagen_categoria'] : 0 );
                $url_imagen = base_url().'assets/img/default-shot-img.png';
                if ( !empty($galeria['tipo_archivo']) ) {
                    $tipo_archivo   = $this->carpeta(!empty($galeria['tipo_archivo']) ? $galeria['tipo_archivo'] : 6 ) ;
                    $carpeta        = !empty($galeria['carpeta_archivo']) ? $galeria['carpeta_archivo'] : 'categorias';
                    $uri_archivo    = !empty($galeria['url_archivo']) ? $galeria['url_archivo'] : 'default.png';
                    $url_imagen     = base_url()."galeria/admin/".$tipo_archivo."/".$carpeta."/".$uri_archivo;
                }    

                $descripcion_imagen = !empty($galeria['detalle_archivo'])? $galeria['detalle_archivo'] : '';
                $data[] = array(
                      'language'            => mb_strtolower($value['codigo']),
                      //'id_categoria'        => $value['categoria_id_categoria'],
                      'nombre_categoria'    => $value['nombre_categoria'],
                      'descripcion_categoria' => $value['descripcion_categoria'],
                      'imagen_categoria'    => $url_imagen,
                      'descripcion_imagen'  => $descripcion_imagen,
                      'paquetes'            => !empty($value['cantidad_paquetes']) ? $value['cantidad_paquetes'] : 0,
                      'valoracion'          => !empty($value['valoracion']) ? number_format($value['valoracion'],1,".","") : 0,
                      'precio'              => !empty($value['precio_minimo']) ? $value['precio_minimo'] : 0,
                      'servicios'           => !empty($value['cantidad_servicio']) ? $value['cantidad_servicio'] : 0, 
                      "uri_categoria"       => base_url().stripslashes(strip_tags(mb_strtolower(trim($language)))).'/'.(stripslashes(strip_tags(mb_strtolower(trim($language)))) === 'es'?'categoria':'category').'/'.$this->uri_categoria($value['nombre_categoria']), 
                );
            }
        }

        return $data;
    }

    public function menu_categoria($language){
        $response = $this->db->query("SELECT i.codigo,i.pais, c.* FROM idioma as i JOIN categoria as c ON c.id_idioma = i.id_idioma AND i.codigo = '".$language."' GROUP BY c.nombre_categoria ORDER BY c.nombre_categoria DESC;")->result_array();
        $data = array();
        if ($response) {
            foreach ($response as $key => $value) {
                $data[] = array(
                    "codigo" => $value['codigo'],
                    "pais"   => $value['pais'],
                    "nombre_categoria" => $value['nombre_categoria'],
                    "descripcion_categoria" => $value['descripcion_categoria'],
                    "id_categoria" => $value['id_categoria'],
                    "codigo_categoria" => $value['id_codigo_categoria'],
                    "uri_categoria"    => $this->uri_categoria($value['nombre_categoria']),
                );
            }
        }
        return $data;
    }

    public function obtener_slider($language,$category){
        $data=array();
        $response_categoria = $this->db->query("SELECT * FROM idioma as i JOIN categoria as c ON i.id_idioma = c.id_idioma AND i.codigo = '".$language."' AND c.nombre_categoria = '".str_replace("-"," ",trim($category) )."' LIMIT 1;")->row_array();
        $response = array();
        if( !empty( $response_categoria['id_categoria'] )  ){
            $response_codigo = $this->db->query("SELECT * FROM codigo_categoria WHERE id_codigo_categoria = '".$response_categoria['id_codigo_categoria']."' LIMIT 1;")->row_array();
            $slider = $this->galeria_model->get_archivo( !empty($response_codigo['imagen_categoria']) ? $response_codigo['imagen_categoria'] : 0 );
            
            if ( !empty($slider['tipo_archivo']) ) {
                $data['imagen'] = base_url()."galeria/admin/".$this->carpeta($slider["tipo_archivo"])."/".$slider["carpeta_archivo"]."/".$slider["url_archivo"];
            }else{
                $data['imagen'] = "//web.incalake.com/assets/img/slider-default.png";
            }
        }else{
             $data['imagen'] = '//web.incalake.com/assets/img/slider-default.png';
        }
        return $data;
    }
    public function get_destino_categoria($language,$category){
        $response_categoria = $this->db->query("SELECT * FROM idioma as i JOIN categoria as c ON i.id_idioma = c.id_idioma AND i.codigo = '".$language."' AND c.nombre_categoria = '".str_replace("-"," ",trim($category) )."' LIMIT 1;")->row_array();
        $response = array();
        if( !empty( $response_categoria['id_categoria'] ) ){
            $response =$this->db->query("SELECT i.codigo, s.*, p.*, g.*,c.id_categoria,c.nombre_categoria,MIN( pr.monto ) AS precio,tab.descripcion_tab,tab.mapa_tab  FROM idioma as i INNER JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".stripslashes(strip_tags(trim($language)))."' JOIN producto as p ON s.id_servicio = p.id_servicio LEFT JOIN tab as tab on p.id_producto=tab.producto_id_producto LEFT JOIN galeria_has_producto as ghp ON p.id_producto = ghp.id_producto LEFT JOIN galeria as g ON g.id_galeria = ghp.id_galeria LEFT JOIN producto_has_categoria as phc ON phc.producto_id_producto = p.id_producto JOIN categoria as c ON phc.categoria_id_categoria = c.id_categoria AND c.id_categoria = '".$response_categoria['id_categoria']."' LEFT JOIN detalle_precio AS dp ON dp.id_producto = p.id_producto AND dp.id_etapa_edad = 1 LEFT JOIN precios AS pr ON pr.id_detalle_precio = dp.id_detalle_precio GROUP BY p.id_producto;")->result_array();
        }
        

            
        $data=array();
        $data_temp_activities=array();
        $breadcrumb=array();
        

        $data_temp_duration=array();
        $data_temp_duration_temp=array();
        $data_temp_duration_temp2=array();
        $temp_format_duration2=array();
        $data_temp_duration_id_activity=array();
        $data_temp_duration_val=array();
        $data_temp_duration_tipo=array();
        $data_duration_txt="";
        $temp_duration_view=array();
        $temp_count_minutos=0;
        $temp_count_horas=0;
        $temp_count_dias=0;
        $temp_count_semanas=0;
        $temp_count_meses=0;
        $temp_count_duration=array();
        $temp_count_duration2=array();
        $temp_destino2=array();
        $array_destinos_global=array();
        $array_final_map=array();
        foreach ($response as $key => $value) {
            $response_galeria = $this->galeria_model->obtener_imagen_servicio($value['imagen_principal']);
            $slider_carpeta         = !empty($response_galeria['tipo_archivo']) ? $response_galeria['tipo_archivo'] : '-1';
            $slider_uri_imagen      = !empty($response_galeria['url_archivo']) ? $response_galeria['url_archivo'] : 'default.jpg';
            $slider_galeria_carpeta = !empty($response_galeria['carpeta_archivo']) ? $response_galeria['carpeta_archivo'] : 'default';
                

            $thumbs_carpeta         = !empty($value['tipo_archivo']) ? $value['tipo_archivo'] : '-1';
            $thumbs_uri_imagen      = !empty($value['url_archivo']) ? $value['url_archivo'] : 'default.jpg';
            $thumbs_galeria_carpeta = !empty($value['carpeta_archivo']) ? $value['carpeta_archivo'] : 'default';
        // 
            $ciudad_cercana=$value['ciudad_cercana'];
            $reviews=(array)json_decode($value['reviews']);
            $data_temp_activities[] = array(
                    'id_producto'          => $value['id_producto'],
                    'language'          => strtolower($language),
                    'titulo_actividad'          => $value['titulo_producto'],
                    'descripcion_activity'      => $this->format_descripcion_actividad($value['descripcion_tab'],strtolower($value['codigo']),(base_url().strtolower($value['codigo']).'/'.strtolower($this->get_first_element_string($value['ubicacion_servicio'])).'/'.$value['uri_servicio'])),
                    'mapa_lugares'=>$this->get_mapa_destinos(json_decode($value['mapa_tab'],true)),
                    'url_actividad'             => base_url().strtolower($value['codigo']).'/'.str_replace(' ', '-', strtolower($this->get_first_element_string($value['ubicacion_servicio']))).'/'.$value['uri_servicio'],
                    "url_thumbs"         => trim(base_url()."galeria/admin/".$this->carpeta($thumbs_carpeta)."/".$thumbs_galeria_carpeta."/thumbs/".$thumbs_uri_imagen),
                    "url_img"         => trim(base_url()."galeria/admin/".$this->carpeta($thumbs_carpeta)."/".$thumbs_galeria_carpeta."/".$thumbs_uri_imagen),
                    'valoracion_servicio'       => $value['valoracion'],
                    'duracion_actividad'        => $this->format_duration($value['duracion']),
                    'duracion_actividad_aprox'  => $this->format_duration_aprox($value['duracion'],strtolower($value['codigo'])),
                    'horarios_disponibles'      =>$this->get_horarios_disponibles($value['duracion'],strtolower($value['codigo'])),
                    'ubicacion_servicio'        => $value['ubicacion_servicio'],
                    'ciudad_cercana'            => $this->get_first_element_string($value['ciudad_cercana']),
                    'reviews'                   => (!empty($reviews['items'])?count($reviews['items']):0),
                    'hora_inicio_actividad'     => $value['hora_inicio'],
                    'txt_desde'                 =>$this->get_txt_desde(strtolower($value['codigo'])),
                    'txt_mas_detalle'           =>$this->get_txt_mas_detalle(strtolower($value['codigo'])),
                    'precio_actividad'          => number_format($value['precio'], 2, '.', ','),
                    'categoria_actividad'       => $value['nombre_categoria'],
                    'categorias'=>$this->get_categorias_asociadas($value['id_producto'],$language),
                );
            if (!empty($value['mapa_tab'])) {
                $temp_map_destinos=json_decode($value['mapa_tab'],true);
                foreach ($temp_map_destinos['lugares'] as $value_map) {
                    $array_destinos_global[] = $this->get_first_element_string($value_map['nombre']);
                }
            }

            if (!empty($value['duracion'])) {
                $pos = strpos($value['duracion'], ',');
                if ($pos) {
                    $array_duracion = explode(",",$value['duracion']);
                }else{
                    $array_duracion[]=$value['duracion'];
                }
                foreach ($array_duracion as $key2 => $value2) {
                    $temp = explode("!",$value2);
                        $data_temp_duration[] =$temp[1];
                        $data_temp_duration_id_activity[]= $value2;
                }
                $data_temp_duration_temp[]=array_unique($data_temp_duration);
                $data_temp_duration=null;


            }
            if(!empty($temp_count_duraciones=$this->get_categorias_asociadas($value['id_producto'],$language))){
                foreach ($temp_count_duraciones as $key => $value) {
                    $temp_count_duration[]=$value['id'];
                    $temp_count_duration2[$value['id']]=$value;
                }
            }
            if(!empty($ciudad_cercana)){
                $temp_destino2[] =$this->get_first_element_string($ciudad_cercana);
                

            }
        }
        // echo json_encode($data_temp_duration_id_activity);
        foreach (array_unique($data_temp_duration_id_activity) as $key => $value) {
           $temp = explode("!",$value);

           $data_temp_duration_val[$temp[1]][]=$temp[0];

           $data_temp_duration_tipo[]=$temp[1];
           $temp=null;
        }
       
        
        foreach ($data_temp_duration_temp as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $data_temp_duration_temp2[]=$value2;
            }
            
        }
        $temp_format_duration=array_count_values($data_temp_duration_temp2);
        $txt_mini_duration='';
        foreach ($data_temp_duration_val as $key => $value) {
            switch ( $key) {
                    case 0: //minutos
                            $data_duration_txt =( $language === 'es'? 'Minutos' : 'Minutes' );
                                $temp_count_minutos++;
                                $txt_mini_duration='min';
                    break;
                    case 1: // Horas
                            $data_duration_txt =( $language === 'es'? 'Horas' : 'Hours' );
                                $temp_count_horas++;
                                $txt_mini_duration='h';
                    break;
                    case 2: // Días
                            $data_duration_txt =( $language === 'es'? 'Días' : 'Days' );
                                $temp_count_dias++;
                                $txt_mini_duration='d';
                    break;
                    case 3: //semanas
                            $data_duration_txt =( $language === 'es'? 'Semanas' : 'weeks' );
                                $temp_count_semanas++;
                                $txt_mini_duration='s';
                    break;
                    case 4: // meses
                            $data_duration_txt =( $language === 'es'? 'Meses' : 'Months' );
                                $temp_count_meses++;
                                $txt_mini_duration='m';
                    break;
                }
                $temp_duration_view[]=array($data_duration_txt.''=>$value);
                $temp_format_duration2[]=array('type'=>$txt_mini_duration,'count'=>$value,'txt'=>$data_duration_txt);
                
           
        }
        $temp_duracion=array();
         foreach (array_count_values($temp_count_duration) as $key => $value) {
            $temp_txt='';

            $temp_duracion[]=array('id_categoria'=>$key,'count'=>$value,'txt'=> $temp_count_duration2[$key]);
            
        }
        $array_lugares=array();
        foreach (array_count_values($temp_destino2) as $key => $value) {
            $array_lugares[]= array('count'=>$value,'txt'=>$key);
        }
        $array_temp_map=array_unique($array_destinos_global);
        foreach ($array_temp_map as $key => $value) {
            $array_final_map[]=strtolower($value);
        }
        
        $data['activity']=$data_temp_activities;

        $data['duration01']=$temp_format_duration2;

        // 
        $data['categoria3']=$temp_duracion;
        $data['destino2']=$array_lugares;
        $data['all_destinos']=$array_final_map;
        $data['lang']= strtolower($language);

        $data['breadcrumb']=$this->get_breadcrumb($language,$category);
        


        return $data;

    }
    public function get_mapa_destinos($token){
        $data=array();
        if (!empty($token)) {

            foreach ($token['lugares'] as $value) {
                $array_destinos = explode(",",$value['nombre']);
             $data[]=strtolower($array_destinos[0]);
            }
        }
        return $data;


    }

    private function format_descripcion_actividad($token,$lang,$url){
        $data = '';
        $count_caracteres=strlen($token);
        if (!empty($token)) {
            if ($count_caracteres>=300) {
                $data=substr(strip_tags(trim($token)),0,300).'... ';
            }else{
                $data=strip_tags(trim($token));
            }
            switch ( $lang ) {
                    case 'es': //minutos
                        $data .='<a href="'.$url.'" target="_blank">Leer Más</a>';
                    break;
                    case 'en': // Horas
                        $data .='<a href="'.$url.'" target="_blank">Read more</a>';
                    break;                    
                }             
        }

        return $data;
    }

    public function get_first_element_string($token){
        if (!empty($token)) {
            $temp_separte_destino=explode(",",$token);  
        }
        return $temp_separte_destino[0];
    }

    public function format_duration($token){
        $data = array();
        if (!empty($token)) {
            $array_duracion = explode(",",$token);
            foreach ($array_duracion as $key => $value) {
                $temp = explode("!",$value);
                switch ( (Integer)$temp[1] ) {
                    case 0: //minutos
                        $data[] =$temp[0].'!min';
                    break;
                    case 1: // Horas
                        $data[] =$temp[0].'!h';
                    break;
                    case 2: // Días
                        $data[] =$temp[0].'!d';
                    break;
                    case 3: //semanas
                        $data[] =$temp[0].'!s';
                    break;
                    case 4: // meses
                        $data[] =$temp[0].'!m';
                    break;
                }
            }
                       
        }
        return $data;

    }
    public function format_duration_aprox($token,$lang){
        $data ='';
        if (trim($token)) {
            $array_duracion = explode(",",$token);
            foreach ($array_duracion as $key => $value) {
                $temp = explode("!",$value);
                switch ( (Integer)$temp[1] ) {
                    case 0: //minutos
                        $data =( $lang === 'es'? '<span class="fa fa-clock-o"></span> Duración Aprox' : 'Duration Approx' ).': '.$temp[0].' '.( $lang === 'es'? 'minutos' : 'Minutes' );
                    break;
                    case 1: // Horas
                        $data =( $lang === 'es'? '<span class="fa fa-clock-o"></span> Duración Aprox' : 'Duration Approx' ).': '.$temp[0].' '.( $lang === 'es'? 'Horas' : 'Hours' );
                    break;
                    case 2: // Días
                        $data =( $lang === 'es'? '<span class="fa fa-clock-o"></span> Duración' : 'Duration' ).': '.$temp[0].' '.( $lang === 'es'? 'Días' : 'Days' );
                    break;
                    case 3: //semanas
                        $data =( $lang === 'es'? '<span class="fa fa-clock-o"></span> Duración' : 'Duration' ).': '.$temp[0].' '.( $lang === 'es'? 'Semanas' : 'weeks' );
                    break;
                    case 4: // meses
                        $data =( $lang === 'es'? '<span class="fa fa-clock-o"></span> Duración' : 'Duration' ).': '.$temp[0].' '.( $lang === 'es'? 'Meses' : 'Months' );
                    break;
                }
            }            
        }
        return $data;

    }
    public function get_horarios_disponibles($token,$lang){
        $data ='';
        if (trim($token)) {
            $array_duracion = explode(",",$token);
            $count_horarios=count($array_duracion);
            switch ( $lang ) {
                    case 'es': //minutos
                        $data ='<span class="fa fa-list-ol"></span> '.$count_horarios.' Horario(s) Disponible(s)';
                    break;
                    case 'en': // Horas
                        $data ='<span class="fa fa-list-ol"></span> '.$count_horarios.' Schedule(s) Available';
                    break;
                }           
        }
        return $data;

    }
    
    public function get_categorias_asociadas($id_producto, $language_code){
        $data=array();
        $query = $this->db->query("
            select C.*,PC.producto_id_producto  
            from  producto_has_categoria PC 
            left join categoria C 
            on PC.categoria_id_categoria=C.id_categoria  
            where 
            PC.producto_id_producto = '$id_producto'
        ")->result_array();
        foreach ($query as $key => $value) {
             $data[]=array('id'=>$value['id_categoria'],'txt'=>strtolower($value['nombre_categoria']));
              $array_cateorgias[]=$value['id_categoria'];
        }

        return (array)$data;

    }

    public function get_txt_desde($lang){
        $data='';
        switch (strtolower($lang)) {
            case 'es':
                $data='DESDE';
                break;
            default:
                $data='FROM';
                break;
        }
        return $data;

    }

    public function get_txt_mas_detalle($lang){
        $data='';
        switch (strtolower($lang)) {
            case 'es':
                $data='MÁS DETALLES';
                break;
            default:
                $data='MORE DETAILS';
                break;
        }
        return $data;

    }

    // $breadcrumb[]=array('idioma'=>$language,'destino'=>$location);
    public function get_breadcrumb($language,$category){
        $data=array();
        $temp='';
        $temp2='';
        $temp_inicio='';
        switch (strtolower($language)) {
            case 'es':
                $temp='Categorias';
                $temp2='Categoria';
                $temp_inicio='Inicio';
                break;
            default:
                $temp='Categories';
                $temp2='Category';
                $temp_inicio='Home';
                break;
        }
        $data[]=array('url'=>base_url(),'txt'=>$temp_inicio);
        $data[]=array('url'=>base_url().strtolower($language).'/'.strtolower($temp),'txt'=>$temp2);
        $data[]=array('txt'=>strtolower($category));

        return $data;
    }

    private function uri_categoria($categoria){
        return str_replace( 
            array('á','é','í','ó','ú',' ','+','ñ'), 
            array('a','e','i','o','u','-','-','n'), 
            trim( mb_strtolower($categoria) ) 
        );
    }

    public function categorias_asociadas($language,$idproducto){
        $response = $this->db->query("SELECT c.nombre_categoria FROM producto as p INNER JOIN producto_has_categoria as phc ON p.id_producto = phc.producto_id_producto AND p.id_producto = '".$idproducto."' INNER JOIN categoria as c ON phc.categoria_id_categoria = c.id_categoria INNER JOIN idioma as i ON i.id_idioma = c.id_idioma AND i.codigo = '".$language."';")->result_array();
        $data = array();
        foreach ($response as $key => $value) {
            array_push($data, $value['nombre_categoria']);    
        }
        return array_unique($data);
    }

    public function get_precio_minimo($idproducto){
        // Conocer quien es el servicio 
        $query = $this->db->query("
            SELECT id_servicio 
            FROM producto 
            WHERE 
            id_producto = '$idproducto';
        ");
        $idservicio = $query->result()[0]->id_servicio;
        // Traer al precio minimo de todos los hijos del servicio
        $query = $this->db->query("
            SELECT min(monto) as montos   
            FROM detalle_precio 
            right join precios 
            on detalle_precio.id_detalle_precio=precios.id_detalle_precio 
            WHERE 
            id_producto = $idproducto
        ");
        return $query->result()[0]->montos;
        //return 100;
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
            case 6:
                $carpeta = 'other-images';
                break;
            default:
                $carpeta = 'otros';
                break;
        }
        return $carpeta;
    }

}