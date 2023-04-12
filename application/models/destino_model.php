<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Destino_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('page_model');
        $this->load->model("galeria_model");
    }
    
    public function __destruct(){
        $this->db->close();
    }
    function get_all_destinos(){
        $destinos = $this->db->query("SELECT * FROM destino WHERE 1 = 1 ORDER BY `id_destino` DESC;")->result_array();
        return $destinos;
    }
    public function get_destinos($lang='es'){
      $data= $this->db->query("SELECT i.codigo, s.miniatura , i.id_idioma, s.ubicacion_servicio FROM idioma as i JOIN servicio as s on i.id_idioma = s.idioma_id_idioma and i.codigo = '$lang' group by s.ubicacion_servicio;")->result_array();
      $response=array();
      if (count($data)!=0) {
        foreach ($data as $key => $value) {
          $temp=explode(',', $value['ubicacion_servicio']);
          array_push($response, $temp[0]);
          // $response[]=array($value['miniatura'].""=> $temp[0]);
        }
        $response = array_unique($response);
      }
      return $response;
    }

    // public function get_slider($lang,$destino){
    //     $data = array();
    //     $destino_id = $this->db->query("SELECT * FROM destino WHERE uri_destino = '".mb_strtolower($destino)."' LIMIT 1;")->row_array();
    //     if ($destino_id) {
    //         $response_slider = $this->galeria_model->get_archivo( !empty($destino_id['imagen_slider']) ? $destino_id['imagen_slider'] : 0 );
    //         if ( !empty($response_slider['tipo_archivo']) ) {
    //             $data['imagen'] = base_url()."galeria/admin/".$this->carpeta($response_slider["tipo_archivo"])."/".$response_slider["carpeta_archivo"]."/".$response_slider["url_archivo"];
    //         }else{
    //             $data['imagen'] = "http://incalake.com/img/slider/index/large/taquile-incalake.png";
    //         }                            
    //     }else{
    //         $data['imagen'] = "http://incalake.com/img/slider/index/large/taquile-incalake.png";
    //     }
    //     return $data;
    // }

    public function get_destino($language,$location){
$location_temp='';
        if (strpos($location, '-')==true) {
            $location_temp= str_replace("-"," ",$location);
        }else{
             $location_temp=$location;
        }

      $response =$this->db->query("SELECT i.codigo, s.*, p.*, g.*,c.id_categoria,c.nombre_categoria,MIN( pr.monto ) AS precio,tab.descripcion_tab,tab.mapa_tab
            FROM idioma as i 
            INNER JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".$language."' 
            JOIN producto as p ON s.id_servicio = p.id_servicio  AND p.estado_producto = 1 
            AND CONCAT_WS(' ' , s.ubicacion_servicio,p.ciudad_cercana) LIKE '%".$location_temp."%' 
            LEFT JOIN tab as tab on p.id_producto=tab.producto_id_producto
            LEFT JOIN galeria_has_producto as ghp ON p.id_producto = ghp.id_producto 
            LEFT JOIN galeria as g ON g.id_galeria = ghp.id_galeria 
            LEFT JOIN producto_has_categoria as phc ON phc.producto_id_producto = p.id_producto 
            LEFT JOIN categoria as c ON phc.categoria_id_categoria = c.id_categoria 
            LEFT JOIN detalle_precio AS dp ON dp.id_producto = p.id_producto AND dp.id_etapa_edad = 1 
            LEFT JOIN precios AS pr ON pr.id_detalle_precio = dp.id_detalle_precio 
            GROUP BY p.id_producto")->result_array();

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
        $destino_id = $this->db->query("SELECT * FROM destino WHERE uri_destino = '".mb_strtolower($location)."' LIMIT 1;")->row_array();
        if ($destino_id) {
            $response_slider = $this->galeria_model->get_archivo( !empty($destino_id['imagen_slider']) ? $destino_id['imagen_slider'] : 0 );
            if ( !empty($response_slider['tipo_archivo']) ) {
                $data['actual']['slider_img'] = base_url()."galeria/admin/".$this->carpeta($response_slider["tipo_archivo"])."/".$response_slider["carpeta_archivo"]."/".$response_slider["url_archivo"];
            }else{
                $data['actual']['slider_img'] = "http://incalake.com/img/slider/index/large/taquile-incalake.png";
            }                            
        }else{
            if($response) {
            $slider = $this->db->query("
                select * 
                from galeria
                where id_galeria=".((int)$response[0]['imagen_principal']).";
            ")->row_array();
            }
            if (!empty($slider)) {
               $data['actual']['slider_img'] = base_url()."galeria/admin/".$this->carpeta($slider["tipo_archivo"])."/".$slider["carpeta_archivo"]."/".$slider["url_archivo"];
               
            }else{
                $data['actual']['slider_img']='';
            }
        }
        foreach ($response as $key => $value) {
            $response_galeria = $this->galeria_model->obtener_imagen_servicio($value['imagen_principal']);
            $slider_carpeta         = !empty($response_galeria['tipo_archivo']) ? $response_galeria['tipo_archivo'] : '-1';
            $slider_uri_imagen      = !empty($response_galeria['url_archivo']) ? $response_galeria['url_archivo'] : 'default.jpg';
            $slider_galeria_carpeta = !empty($response_galeria['carpeta_archivo']) ? $response_galeria['carpeta_archivo'] : 'default';
                

            $url_thumbs_uri_imagen  = base_url().'assets/img/default-shot-img.png';
            $url_imagen             = base_url().'assets/img/default-shot-img.png';
            
            $thumbs_carpeta         = !empty($value['tipo_archivo']) ? $value['tipo_archivo'] : '-1';
            $thumbs_uri_imagen      = !empty($value['url_archivo']) ? $value['url_archivo'] : 'default.png';
            $thumbs_galeria_carpeta = !empty($value['carpeta_archivo']) ? $value['carpeta_archivo'] : 'default';

            if ( $thumbs_uri_imagen != 'default.png' ) {
               $url_thumbs_uri_imagen  = trim(base_url()."galeria/admin/".$this->carpeta($thumbs_carpeta)."/".$thumbs_galeria_carpeta."/thumbs/".$thumbs_uri_imagen);
               $url_imagen              = trim(base_url()."galeria/admin/".$this->carpeta($thumbs_carpeta)."/".$thumbs_galeria_carpeta."/".$thumbs_uri_imagen);
            }
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
                    //"url_thumbs"         => trim(base_url()."galeria/admin/".$this->carpeta($thumbs_carpeta)."/".$thumbs_galeria_carpeta."/thumbs/".$thumbs_uri_imagen),
                    "url_thumbs"         => $url_thumbs_uri_imagen,
                    //"url_imagen"         => trim(base_url()."galeria/admin/".$this->carpeta($thumbs_carpeta)."/".$thumbs_galeria_carpeta."/".$thumbs_uri_imagen),
                    "url_imagen"                => $url_imagen,
                    'url_galeria'               =>$slider_carpeta.'/'.$slider_uri_imagen.'/'.$slider_galeria_carpeta.'/'.$thumbs_carpeta.'/'.$thumbs_uri_imagen.'/'.$thumbs_galeria_carpeta,
                    'valoracion_servicio'       => $value['valoracion'],
                    'duracion_actividad'        => $this->format_duration($value['duracion']),
                    'ini_actividad_key'=> $this->format_actividad_duracion_precio($value['duracion'],$value['precio']),
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
            $array_final_map[]=$value;
        }
        
        $data['activity']=$data_temp_activities;

        $data['duration01']=$temp_format_duration2;
        $data['categoria3']=$temp_duracion;
        $data['destino2']=$array_lugares;
        $data['lang']= strtolower($language);
        $data['all_destinos']=$array_final_map;
        $data['location']=$location;
        $data['breadcrumb']=$this->get_breadcrumb($language,$location);
      return $data;

    }
    public function format_actividad_duracion_precio($duration,$price){
        $data='';
        $temp_price=(int)$price;
        if (!empty($duration)) {
            $array_duracion = explode(",",$duration);
            foreach ($array_duracion as $key => $value) {
                $temp = explode("!",$value);
                switch ( (Integer)$temp[1] ) {
                    case 0: //minutos
                        $data=$temp[1].$temp[0].'.'.str_pad($temp_price, 4, '0', STR_PAD_LEFT);
                    break;
                    case 1: // Horas
                        $data=$temp[1].$temp[0].'.'.str_pad($temp_price, 4, '0', STR_PAD_LEFT);
                    break;
                    case 2: // Días
                        $data=$temp[1].$temp[0].'.'.str_pad($temp_price, 4, '0', STR_PAD_LEFT);
                    break;
                    case 3: //semanas
                        $data=$temp[1].$temp[0].'.'.str_pad($temp_price, 4, '0', STR_PAD_LEFT);
                    break;
                    case 4: // meses
                        $data=$temp[1].$temp[0].'.'.str_pad($temp_price, 4, '0', STR_PAD_LEFT);
                    break;
                }
            }
        }
        // echo json_encode($data);
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
        return strtolower($temp_separte_destino[0]) ;
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
        if ($query) {
            foreach ($query as $key => $value) {
                 $data[]=array('id'=>$value['id_categoria'],'txt'=>strtolower($value['nombre_categoria']));
                  $array_cateorgias[]=$value['id_categoria'];
            }
        }
        return (array)$data;

    }
    // $breadcrumb[]=array('idioma'=>$language,'destino'=>$location);
    public function get_breadcrumb($language,$location){
        $data=array();
        $temp='';
        $temp2='';
        $temp_inicio='';
        $temp_destino='';
        switch (strtolower($language)) {
            case 'es':
                $temp='Destinos';
                $temp2='Destino';
                $temp_inicio='Inicio';
                $temp_destino='tenemos diferentes actividades que le pueden interesar en';
                break;
            default:
                $temp='Destinations';
                $temp2='Destination';
                $temp_inicio='Home';
                $temp_destino='We have different activities that may interest you in';
                break;
        }
        $data[]=array('url'=>base_url(),'txt'=>$temp_inicio);
        $data[]=array('url'=>base_url().strtolower($language).'/'.strtolower($temp),'txt'=>$temp2);
        $data[]=array('txt'=>$temp_destino.' '.strtolower($location));

        return $data;
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
    public function carpeta($id){
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



    function get_destinos_for_web($lang){
        $destinos = $this->db->query("SELECT * FROM destino as d JOIN idioma as i ON i.id_idioma = d.id_idioma AND i.codigo = '".trim($lang)."';")->result_array();
        $data = array();
        if ( !empty($destinos[0]) ) {
            foreach ($destinos as $key => $value) {
                $imagen_normal = $this->galeria_model->obtener_imagen_servicio(!empty($value['imagen_normal'])?$value['imagen_normal']:0);
                $imagen_slider = $this->galeria_model->obtener_imagen_servicio(!empty($value['imagen_slider'])?$value['imagen_slider']:0);
                if ( !empty($imagen_slider['tipo_archivo']) ) {
                    $url_imagen_slider = base_url()."galeria/admin/".$this->carpeta($imagen_slider["tipo_archivo"])."/".$imagen_slider["carpeta_archivo"]."/".$imagen_slider["url_archivo"];         
                }else{
                    $url_imagen_slider = base_url().'assets/img/slider-default.png';
                }
                
                if ( !empty($imagen_normal['tipo_archivo']) ) {
                $url_imagen_normal = base_url()."galeria/admin/".$this->carpeta($imagen_normal["tipo_archivo"])."/".$imagen_normal["carpeta_archivo"]."/".$imagen_normal["url_archivo"];
                $url_imagen_thumb=base_url()."galeria/admin/".$this->carpeta($imagen_normal["tipo_archivo"])."/".$imagen_normal["carpeta_archivo"]."/thumbs/".$imagen_normal["url_archivo"];
                }else{
                    $url_imagen_normal = base_url().'assets/img/not-found-image.png';
                    $url_imagen_thumb=base_url().'assets/img/not-found-image.png';
                }
               
                $data[] = array(
                    'id_temp_destino'=>$key+1,
                    'imagen_normal' => $url_imagen_normal,
                    'imagen_thumb' => $url_imagen_thumb,
                    'imagen_slider' => $url_imagen_slider,
                    'descripcion_destino' => mb_strtolower($value['descripcion_destino']),
                    'url_destino' => base_url().strtolower($lang).'/'.(strtolower($lang) == 'es'?'destino':'destination').'/'.strtolower($value['uri_destino']),
                    'actividades' => $this->get_actividades_for_web($value['id_destino'],$lang),
                );
            }
        }

        return $data;
    }

    function get_actividades_for_web($idDestino,$lang = 'EN'){
        //El ultimo SELECT extrae el codigo destino mediante cualquier id_destino, el anti-penultimo extrae el codigo producto mediante el codigo_destino para luego hacer un join con la tabla producto y extraer el registro de todos los ls productos que tengan el mismo id_codigo_producto y finalmente mostrar solo los del idioma requerido.
        $response = $this->db->query("SELECT i.*,s.*,p.* FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma JOIN producto AS p ON p.id_servicio = s.id_servicio AND p.id_codigo_producto IN (SELECT p.id_codigo_producto FROM idioma AS i JOIN destino AS d ON i.id_idioma = d.id_idioma AND i.id_idioma = 1 JOIN destino_has_producto AS dhp ON d.id_destino = dhp.id_destino JOIN producto AS p ON p.id_producto = dhp.id_producto AND d.id_codigo_destino = (SELECT cd2.id_codigo_destino FROM destino AS d2 JOIN codigo_destino AS cd2 ON d2.id_codigo_destino = cd2.id_codigo_destino AND d2.id_destino = '".$idDestino."' LIMIT 1) ) AND i.codigo = '".trim($lang)."' LIMIT 5;")->result_array();
        $data = array();
        if ($response) {
            foreach ($response as $key => $value) {
                $arrayUbicacionServicio = explode(",",trim($value['ubicacion_servicio']) );
                $data[] = array(
                    "titulo_actividad" => mb_strtolower($value['titulo_producto']),
                    "url"              => base_url().strtolower($value['codigo']).'/'.strtolower($arrayUbicacionServicio[0]).'/'.strtolower($value['uri_servicio']), 
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


    function destinos_search($lang = 'es'){
        $response = $this->db->query("SELECT i.id_idioma,i.codigo,i.pais,id_usuarios,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.uri_servicio FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma AND s.codigo_servicio_id_codigo_servicio IN (SELECT ds2.id_codigo_servicio FROM servicio as s2 JOIN destinos_search as ds2 ON s2.id_servicio = ds2.id_servicio ) AND i.codigo = '".trim($lang)."' GROUP BY s.id_servicio;")->result_array();

        $data = array();
        if ($response) {
            foreach ($response as $key => $value) {
                $arrayUbicacionServicio = explode(",",trim($value['ubicacion_servicio']) );
                $data[] = array(
                    'nombre' => mb_strtolower($value['ubicacion_servicio']),
                    'url'    => base_url().strtolower($lang).'/'.(strtolower($lang) == 'es'?'destino':'destination').'/'.strtolower(str_replace(" ","-",$arrayUbicacionServicio[0]) ),
                );
            }
        }

        return $data;
    }

    function actividades_search($lang){
        $response = $this->db->query("SELECT i.id_idioma,i.codigo,i.pais,id_usuarios,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.uri_servicio,p.id_producto,p.id_codigo_producto,p.titulo_producto FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON p.id_servicio = s.id_servicio AND p.id_codigo_producto IN (SELECT as2.id_codigo_producto FROM producto as p2 JOIN actividades_search as as2 GROUP BY as2.id_codigo_producto ) AND i.codigo = '".trim($lang)."' GROUP BY p.titulo_producto;")->result_array();
        $data = array();
        if ($response) {
            foreach ($response as $key => $value) {
                $arrayUbicacionServicio = explode(",",trim($value['ubicacion_servicio']) );
                $data[] = array(
                    'nombre' => mb_strtolower($value['titulo_producto']),
                    'url'    => base_url().strtolower($lang).'/'.strtolower($arrayUbicacionServicio[0]).'/'.strtolower($value['uri_servicio']),     
                );
            }
        }
        return $data;
    }

    /* Lista de todos los datos de destinos turísticos que serán usadas en el footer  */
    function  destinos_footer($lang = 'es'){
        return $this->db->query("SELECT * FROM destino as d JOIN idioma as i ON i.id_idioma = d.id_idioma AND i.codigo = ?;" ,array( trim( mb_strtolower($lang) ) ) )->result_array();
    }

}