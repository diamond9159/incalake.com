<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
    protected $var_language = null;
    public function __construct() {
      parent::__construct();
      $this->load->model('page_model','Page_model');
      $this->load->model('categoria_model');
      $this->load->model("galeria_model");
      $this->load->model("modelo_index");
      $this->load->model("oferta_model");
      $this->load->model("destino_model");
      $this->load->model("idioma_model");
$this->load->model("sliderindex_model");

      $this->var_language = $this->uri->segment(1);
      if( $this->config->item('php-quick-profiler') ){
        $this->output->enable_profiler(FALSE);          
      }
   }

    public function masterindex($language = 'es'){
        if( !$this->idioma_model->get_code_idioma($language) ){
           redirect(base_url());
        }
        $this->var_language = mb_strtolower($language);
        $data = array();
        $data['language'] = $language;
        $data['menu_language']     = $this->Page_model->menu_language_location("","");
        //$data['monedas']     = $this->Page_model->obtener_monedas();
        $data['menu_location']     = $this->menu_generate_location($language);
        $data['menu_categoria']    = $this->categoria_model->menu_categoria($language);

        $data['destinos']          = $this->destino_model->get_destinos_for_web($language);
        $data['url_destinos']      = base_url().mb_strtolower($language).'/'.( mb_strtolower($language)=='es'?'destinos':'destinations' );
        $data['descripcion_url_destinos'] = (mb_strtolower($language)=='es'?'Ver más destinos':'See more destinations');
        $data['titulo_url_destinos'] = (mb_strtolower($language)=='es'?'Destinos disponibles':'Available destinations');

        $data['destinos_search']   = $this->destino_model->destinos_search($language);
        $data['actividades_search']= $this->destino_model->actividades_search($language);
        /*obtener tours con valoracion alta*/
        $data['tours_valorados']    = $this->modelo_index->obtener_valorados($language);
        /*fin asignar a array tours valorados*/
        $data['data']     = array();
        $data['oferta']   = $this->oferta_model->oferta(strtoupper($language));

        $data['url_mas_ofertas']=base_url().''.$language.'/'.(($language)=='es'?'ofertas':'offers');
        $data['txt_ofertas']     = ($language)=='es'?'Ofertas':'offers';
        $data['txt_disponibles']     = ($language)=='es'?'Disponibles':'Available';
        $data['txt_ver_mas_ofertas']     = ($language)=='es'?'Ver Más Ofertas':'View More Offers';

$data['url_mas_superventas']=base_url().''.$language.'/'.(($language)=='es'?'superventas':'bestselling');
        $data['txt_super']     = ($language)=='es'?'Super':'Best';
        $data['txt_ventas']     = ($language)=='es'?'Ventas':'Selling';
        $data['txt_ver_superventas']     = ($language)=='es'?'Ver Más superVentas':'View More BestSelling';

        $data['search']= $this->ajaxSearch($language,'');
        // $data['slider_index'] = $this->Page_model->slider_index($language);
        $data['slider_index']=$this->sliderindex_model->sliderindex($language);
        $data['mas_comprados'] = $this->Page_model->get_masComprados($language);
        
        //echo json_encode($data['language']).'<br/>';
        //echo json_encode($data['menu_language']);
        $this->load->view("page",$data);
    }
    public function index($language = 'es'){
        if( !$this->idioma_model->get_code_idioma($language) ){
           redirect(base_url());
        }
        $this->var_language = mb_strtolower($language);
        $data = array();
        $data['language'] = $language;
        $data['menu_language']     = $this->Page_model->menu_language_location("","");
        //$data['monedas']     = $this->Page_model->obtener_monedas();
        $data['menu_location']     = $this->menu_generate_location($language);
        $data['menu_categoria']    = $this->categoria_model->menu_categoria($language);

        $data['destinos']          = $this->destino_model->get_destinos_for_web($language);
        $data['url_destinos']      = base_url().mb_strtolower($language).'/'.( mb_strtolower($language)=='es'?'destinos':'destinations' );
        $data['descripcion_url_destinos'] = (mb_strtolower($language)=='es'?'Ver más destinos':'See more destinations');
        $data['titulo_url_destinos'] = (mb_strtolower($language)=='es'?'Destinos disponibles':'Available destinations');

        $data['destinos_search']   = $this->destino_model->destinos_search($language);
        $data['actividades_search']= $this->destino_model->actividades_search($language);
        /*obtener tours con valoracion alta*/
        $data['tours_valorados']    = $this->modelo_index->obtener_valorados($language);
        /*fin asignar a array tours valorados*/
        $data['data']     = array();
        $data['oferta']   = $this->oferta_model->oferta(strtoupper($language));

        $data['url_mas_ofertas']=base_url().''.$language.'/'.(($language)=='es'?'ofertas':'offers');
        $data['txt_ofertas']     = ($language)=='es'?'Ofertas':'offers';
        $data['txt_disponibles']     = ($language)=='es'?'Disponibles':'Available';
        $data['txt_ver_mas_ofertas']     = ($language)=='es'?'Ver Más Ofertas':'View More Offers';

$data['url_mas_superventas']=base_url().''.$language.'/'.(($language)=='es'?'superventas':'bestselling');
        $data['txt_super']     = ($language)=='es'?'Super':'Best';
        $data['txt_ventas']     = ($language)=='es'?'Ventas':'Selling';
        $data['txt_ver_superventas']     = ($language)=='es'?'Ver Más superVentas':'View More BestSelling';

        $data['search']= $this->ajaxSearch($language,'');
        //$data['slider_index'] = $this->Page_model->slider_index($language);
$data['slider_index']=$this->sliderindex_model->sliderindex($language);
$data['mas_comprados'] = $this->Page_model->get_masComprados($language);
        
        //echo json_encode($data['language']).'<br/>';
        //echo json_encode($data['menu_language']);
        $this->load->view("test",$data);
    }
        // search inicio
    public function list_by_location($language, $location){
        if( !$this->idioma_model->get_code_idioma($language) ){
           redirect(base_url());
        }
        
        $uri_extra = str_replace(" ","-",$location);
        $location  = str_replace("-"," ",$location);
        $location  = str_replace("+"," ",$location);
        $location  = str_replace("'","", $location);

        $data = array();
        $data['language'] = mb_strtolower($language);
        $data['location'] = mb_strtolower($location);

        $response_language= $this->Page_model->menu_language_location( $language,urldecode($location) );
        foreach ($response_language as $key => $value) {
            $data['menu_language'][] = array(
                    "codigo"         => $value['codigo'],
                    "id_servicio"    => $value['id_servicio'],
                    "uri_servicio"   => $value['uri_servicio'], 
                    "uri_extra"      => $uri_extra,
            );
        }

        $data['menu_location']     = $this->menu_generate_location($language);
        $data['menu_categoria']    = $this->categoria_model->menu_categoria($language);
        
        $response = $this->Page_model->list_location($language,$location);
        $data['data']     = array();
        $data['slider']   = array();
        $data['data2']    = $response;
        //$data['data']     = $response;
        $array_categorias = array();    
        $array_duraciones = array();
        $data_temp_activities= array();
        $data_temp_duration_id_activity=array();
        $temp_format_duration2 = array();
        $data_temp_duration_temp=array();
        $data_temp_duration_temp2=array();
        $data_temp_duration_val=array();
        $temp_count_duration=array();
        $temp_destino2=array();
        $string_tipo_duraciones = '';
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
                    'url_actividad'             => base_url().strtolower($value['codigo']).'/'.strtolower($this->get_first_element_string($value['ubicacion_servicio'])).'/'.$value['uri_servicio'],
                    "url_thumbs"         => trim(base_url()."galeria/admin/".$this->carpeta($thumbs_carpeta)."/".$thumbs_galeria_carpeta."/thumbs/".$thumbs_uri_imagen),
                    'url_galeria'               =>$slider_carpeta.'/'.$slider_uri_imagen.'/'.$slider_galeria_carpeta.'/'.$thumbs_carpeta.'/'.$thumbs_uri_imagen.'/'.$thumbs_galeria_carpeta,
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
        $data['activity']=$data_temp_activities;

        $data['duration']=$temp_format_duration2;

        // 
        $data['category']=$temp_duracion;
        $data['destiny']=$array_lugares;
        $data['lang']= strtolower($language);

        $data['breadcrumb']=$this->get_breadcrumb($language,$location);

        
        $this->load->view('page-lists',$data);
    }

    public function format_descripcion_actividad($token,$lang,$url){
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
    // $breadcrumb[]=array('idioma'=>$language,'destino'=>$location);
    public function get_breadcrumb($language,$location){
        $data=array();
        $temp='';
        $temp2='';
        $temp_inicio='';
        switch (strtolower($language)) {
            case 'es':
                $temp='Destinos';
                $temp2='Destino';
                $temp_inicio='Inicio';
                break;
            default:
                $temp='Destinations';
                $temp2='Destination';
                $temp_inicio='Home';
                break;
        }
        $data[]=array('url'=>base_url(),'txt'=>$temp_inicio);
        $data[]=array('url'=>base_url().strtolower($language).'/'.strtolower($temp),'txt'=>$temp2);
        $data[]=array('url'=>base_url().$language.'/'.($language=='es'?'destino':'destination').'/'.strtolower($location),'txt'=>strtolower($location));

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
    // ------search fin



    public function view_page($language, $location, $uri_service){
        if( !$this->idioma_model->get_code_idioma($language) ){
           redirect(base_url());
        }
        
        
        $resultado = $this->Page_model->exist_service($language, $location, $uri_service);
        $codigo_servicio = @$resultado['actual']['codigo_servicio_id_codigo_servicio'];
        
       // $dato_envio['menu_language']  = $this->Page_model->menu_language_location($language, $location);
        $dato_envio['menu_language']  = $this->Page_model->menu_language_location($codigo_servicio);
       // var_dump($dato_envio['menu_language']);
       // echo $this->uri->segment(2);
        $dato_envio['resultado'] = $resultado;
        $dato_envio['language'] = $language;
$dato_envio['breadcrumb']=$this->get_breadcrumb($language,$location);
        if($resultado==false){
            redirect(base_url().mb_strtolower($language));
        }else{
            $this->load->view('page-details',$dato_envio);
        }
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

    private function menu_generate_location($language){
        $response = $this->Page_model->menu_generate_location($language);
        $data = array();
        foreach ($response as $key => $value) {
            $data[] = mb_strtoupper( $this->uri_localidad($value['ubicacion_servicio']) );
        }
        $data = array_unique($data);
        return $data;
    }

    private function uri_localidad($location){
        $uri_string = $location;
        if ( !empty($uri_string) ) {
            $uri_string = mb_strtolower(trim($location));
            $uri_string_temp = str_replace(", ",",",$uri_string);
            $uri_string_temp = str_replace(" ", "", $uri_string_temp);
            $uri_string_temp = str_replace("-", "", $uri_string_temp);
            $uri_string_temp = str_replace("_", "-",$uri_string_temp);
            $uri_string_temp = str_replace(",,",",",$uri_string_temp);
            $uri_string_temp = explode(",",$uri_string_temp);
            $uri_string      = $uri_string_temp[0];
        }
        return $uri_string;
    }
    private function extraer_tipo_duracion($data){
        $tipo = '';
        if ( strpos(",",$data) ) {
            $array_data = explode(",",$data);   
            foreach ($array_data as $key => $value) {
                $temp_value = explode("!",$value);
                $tipo .= $temp_value[1].',';
            }
        }else{
            $temp_value = explode("!",$data);
            $tipo .= $temp_value[1].',';
        }
        return $tipo;
    }

    private function tipo_tiempo_en_letras($token){
        $tipo = array();
        $array_tipo = explode(",",$token);
        array_unique($array_tipo);
        foreach ($array_tipo as $key => $value) {
            switch ((integer)$value) {
                case 0:
                    array_push($tipo,'Minutos');
                    break;
                case 1:
                    array_push($tipo,'Horas');
                break;
                case 2:
                    array_push($tipo,'Dias');
                break;
                default:
                    array_push($tipo,'Todos');  
                break;
            }
        }
        return array_unique($tipo);
    }
    
    //Configura el buscador del Index con los datos de localidad y actividades
    public function ajaxSearch($language,$location){
        // $language = $this->input->post("language");
        // $location = $this->input->post("location");
        $data = $this->Page_model->searchLocation(trim($language),trim($location));
        return $data;
    }

    public function search(){
        $lang  = !empty( trim( $this->input->post("language") ) ) ? trim( $this->input->post("language") ) : 'es';
        $query = trim( $this->input->post("query") );
        $response = $this->Page_model->json_search($lang,$query);
        $array_data1 = array();
        $array_data2 = array();
        $array_data3 = array();
        $array_data4 = array();
        $full_array_data = array();

        $array_temp_localidades = array();
        foreach ($response as $key => $value) {
            array_push(
                $array_temp_localidades,
                ucwords( mb_strtolower(trim($value['ubicacion_servicio'])) ),
                ucwords( mb_strtolower(trim($value['ciudad_cercana'])) ) 
            );
            array_push(
                $array_data2,
                array(
                    "descripcion" => ucwords( mb_strtolower(trim($value['titulo_pagina'])) ),
                    "uri"         => $this-> uri_localidad($value['ciudad_cercana']).'/'.$value['uri_servicio'],
                ),
                array(
                    "descripcion" => ucwords( mb_strtolower(trim($value['titulo_producto'])) ),
                    "uri"         => $this->uri_localidad($value['ubicacion_servicio']).'/'.$value['uri_servicio'],
                )
            );
        }

        foreach ( array_unique($array_temp_localidades) as $key => $value) {
            array_push( $array_data1, 
                array(
                    "descripcion" => $value,
                    "uri" => $this->uri_localidad( mb_strtolower($value) ),
                )
            );
        }

        $full_array_data = array_merge($array_data1,$array_data2);
        echo json_encode( $full_array_data );
    }
    public function get_ofertas($language){
        if( !$this->idioma_model->get_code_idioma($language) ){
           redirect(base_url());
        }
        $data = array();
        $data['menu_language']  = $this->Page_model->menu_language_location("","");
        $data['language']=$language;
        $data['oferta']   = $this->oferta_model->oferta(strtolower($language));

        $this->load->view("page_ofertas",$data);
        // echo json_encode($data['menu_language']);

    }
public function get_superventas($language){
        if( !$this->idioma_model->get_code_idioma($language) ){
           redirect(base_url());
        }
        $data = array();
        $data['menu_language']  = $this->Page_model->menu_language_location("","");
        $data['language']=$language;
        $data['mas_comprados'] = $this->Page_model->get_masComprados($language);

        $this->load->view("page_mas_comprados",$data);
        // echo json_encode($data['menu_language']);

    }

    public function pagina_no_encontrada(){
        $language = $this->uri->segment(1);
        if( !$this->idioma_model->get_code_idioma($language) ){
           redirect(base_url());
        }else if ( strlen(strip_slashes(strip_tags(trim($language)))) != 2 ) {
           redirect(base_url().'es');    
        }else{
           redirect(base_url());
        }
    }
    
    public function error_page(){
       redirect(base_url());
    }
}