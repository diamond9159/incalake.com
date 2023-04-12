<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    public function __construct(){
        parent::__construct();
        $this->load->model("galeria_model");
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }

    public function slider_index($language){
        $response = $this->db->query("SELECT i.codigo,s.titulo_pagina,s.descripcion_pagina,s.imagen_principal,s.uri_servicio,s.ubicacion_servicio FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND s.ver_slider = 1 AND i.codigo = '".trim(strtolower($language))."' LIMIT 5;")->result_array();
        $data = array();
        if ($response) {
            foreach ($response as $key => $value) {
                $arrayUbicacion = explode(",",trim($value['ubicacion_servicio']));
                $responseImagen = $this->galeria_model->obtener_imagen_servicio($value['imagen_principal']);
                
                if (!empty($responseImagen['tipo_archivo']) && !empty($responseImagen['carpeta_archivo']) ) {
                    $data[] = array(
                        "titulo"        => mb_strtolower(trim($value['titulo_pagina'])),         
                        "descripcion"   => trim($value['descripcion_pagina']),
                        "imagen"        => base_url()."galeria/admin/".$this->carpeta($responseImagen["tipo_archivo"])."/".$responseImagen["carpeta_archivo"]."/".$responseImagen["url_archivo"],
                        "url"           => base_url().strip_tags(stripslashes(trim(mb_strtolower($language)))).'/'.trim(strtolower($arrayUbicacion[0])).'/'.$this->uri_amigable(mb_strtolower($value['uri_servicio'])),
                    );
                }else{
                    $data[] = array(
                        "titulo"        => mb_strtolower(trim($value['titulo_pagina'])),         
                        "descripcion"   => trim($value['descripcion_pagina']),
                        "imagen"        => "//incalake.com/img/slider/index/large/taquile-incalake.png",
                        "url"           => base_url().strip_tags(stripslashes(trim(mb_strtolower($language)))).'/'.trim(strtolower($arrayUbicacion[0])).'/'.$this->uri_amigable(mb_strtolower($value['uri_servicio'])),
                    );        
                }
            }
        }else{
            $data[] = array(
                "titulo"        => "Inca Lake Travel Agency",         
                "descripcion"   => ( mb_strtolower(trim($language)) === 'es' ? "Mejor Agencia de viajes y tour operador en la ciudad de Puno y el lago Titicaca | Tours, adventure, outdoors in Puno and Lake Titicaca." : "Offer tours to Uros, Taquile, Amantani | Sillustani, Aramu muru | bus Puno-Cusco-La Paz-Copacabana | Transfer from/to airport." ),
                "imagen"        => "//incalake.com/img/slider/index/large/taquile-incalake.png",
                "url"           => base_url().mb_strtolower(trim($language)),
            );
        }

        return $data;
    }

    /*public function menu_language_location($language,$location){
        return $this->db->query("SELECT i.codigo, s.id_servicio,s.uri_servicio FROM idioma as i LEFT JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND s.ubicacion_servicio LIKE '%".$location."%' GROUP BY i.codigo ORDER BY i.id_idioma;")->result_array();
    }*/
    public function menu_language_location($codigo_servicio=null){
        $codigo_servicio = is_numeric($codigo_servicio)?$codigo_servicio:0;
            return $this->db->query("SELECT i.codigo,s.uri_servicio FROM idioma as i LEFT JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND s.codigo_servicio_id_codigo_servicio = $codigo_servicio  ORDER BY i.id_idioma;")->result_array(); 
        

    }
    public function obtener_monedas(){
        return $this->db->query("SELECT nombre,codigo,simbolo FROM monedas")->result_array();
    }
    public function menu_generate_location($language){
        return $this->db->query("SELECT i.codigo, s.ubicacion_servicio, s.uri_servicio FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".$language."' GROUP BY s.ubicacion_servicio;")->result_array();
    }

    public function list_location($language,$location){

        if ( substr_count($location,'-') === 0 ) {  //conteo de palabras segun caracter (-)
            return $this->db->query("SELECT i.codigo, s.*, p.*, g.*,c.id_categoria,c.nombre_categoria FROM idioma as i INNER JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".$language."' JOIN producto as p ON s.id_servicio = p.id_servicio AND CONCAT_WS(' ' , s.ubicacion_servicio,p.ciudad_cercana) LIKE '%".$location."%' p.estado_producto=1 LEFT JOIN galeria_has_producto as ghp ON p.id_producto = ghp.id_producto LEFT JOIN galeria as g ON g.id_galeria = ghp.id_galeria LEFT JOIN producto_has_categoria as phc ON phc.producto_id_producto = p.id_producto AND  LEFT JOIN categoria as c ON phc.categoria_id_categoria = c.id_categoria GROUP BY p.id_producto;")->result_array();
        }else{
            $find_now = $this->search_text_generate($location);
            // return $this->db->query("SELECT i.codigo, s.*, p.*, g.*, pr.*,c.id_categoria,c.nombre_categoria FROM idioma as i INNER JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".$language."' JOIN producto as p ON s.id_servicio = p.id_servicio LEFT JOIN galeria_has_producto as ghp ON p.id_producto = ghp.id_producto LEFT JOIN galeria as g ON g.id_galeria = ghp.id_galeria LEFT JOIN precio as pr ON pr.id_producto = p.id_producto LEFT JOIN producto_has_categoria as phc ON phc.producto_id_producto = p.id_producto LEFT JOIN categoria as c ON phc.categoria_id_categoria = c.id_categoria WHERE MATCH(s.titulo_pagina,s.ubicacion_servicio) AGAINST('".$find_now."' IN BOOLEAN MODE) OR MATCH(p.subtitulo_producto) AGAINST('".$find_now."' IN BOOLEAN MODE) OR MATCH(p.titulo_producto) AGAINST('".$find_now."') OR MATCH(p.ciudad_cercana) AGAINST('".$find_now."' IN BOOLEAN MODE) GROUP BY p.id_producto;")->result_array();
            return $this->db->query("SELECT i.codigo, s.*, p.*, g.*, pr.*,c.id_categoria,c.nombre_categoria FROM idioma as i INNER JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".$language."' JOIN producto as p ON s.id_servicio = p.id_servicio LEFT JOIN galeria_has_producto as ghp ON p.id_producto = ghp.id_producto LEFT JOIN galeria as g ON g.id_galeria = ghp.id_galeria LEFT JOIN precio as pr ON pr.id_producto = p.id_producto LEFT JOIN producto_has_categoria as phc ON phc.producto_id_producto = p.id_producto LEFT JOIN categoria as c ON phc.categoria_id_categoria = c.id_categoria WHERE MATCH(p.subtitulo_producto) AGAINST('".$find_now."' IN BOOLEAN MODE) OR MATCH(p.titulo_producto) AGAINST('".$find_now."') OR MATCH(p.ciudad_cercana) AGAINST('".$find_now."' IN BOOLEAN MODE) GROUP BY p.id_producto;")->result_array();
        }
    }

    public function json_search($language,$query){
        return $this->db->query("SELECT s.titulo_pagina, s.ubicacion_servicio, s.uri_servicio, p.titulo_producto,p.subtitulo_producto,p.ciudad_cercana FROM idioma as i INNER JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".$language."' LEFT JOIN producto as p ON s.id_servicio = p.id_servicio WHERE MATCH(s.titulo_pagina,s.ubicacion_servicio) AGAINST('+".$query."' IN BOOLEAN MODE) OR MATCH(p.titulo_producto) AGAINST('+".$query."' IN BOOLEAN MODE) OR MATCH(p.subtitulo_producto) AGAINST('+".$query."' IN BOOLEAN MODE) OR MATCH(p.ciudad_cercana) AGAINST('+".$query."' IN BOOLEAN MODE) LIMIT 10;")->result_array();
    }

    private function search_text_generate($expresion){
        $search_text = mb_strtolower(trim($expresion));
        $search_text = str_replace("-"," ",$search_text);
        $search_text = str_replace("+"," ",$search_text);
        $temp_search_text = '';
        if ( substr_count($search_text, ' ' ) > 1 ) {
            $array_search_text = explode(" ",$search_text);
            foreach ($array_search_text as $key => $value) {
                if ( strlen($value) > 4 &&  $value != 'tour' ) {
                    $temp_search_text .= ' +'.$value;
                }else if( strlen($value) < 4 ){
                    $temp_search_text .= ' -'.$value;
                }else{
                    $temp_search_text .= ' *'.$value;
                }
            }
            $search_text = $temp_search_text;
        }else{
            $search_text = ' +'.$search_text;
        }
        return trim($search_text);
    }


    public function searchLocation($language="es",$location=""){
        if ( empty(trim($location)) ) { //Si es que no hay valor de $location retornar todas las localidades y actividades
            $response = $this->db->query("SELECT s.id_servicio, s.ubicacion_servicio, i.codigo,p.id_producto,p.ciudad_cercana,p.titulo_producto,p.duracion,p.estado_producto, s.uri_servicio, t.mapa_tab FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".$language."'  JOIN producto as p ON s.id_servicio = p.id_servicio LEFT JOIN tab as t ON t.producto_id_producto = p.id_servicio WHERE 1 = 1 order by s.id_servicio asc;")->result_array();
        }else{
            $response = $this->db->query("SELECT s.id_servicio,s.ubicacion_servicio, i.codigo,p.ciudad_cercana,p.titulo_producto, p.estado_producto,s.uri_servicio, MATCH(p.titulo_producto,p.ciudad_cercana) AGAINST('".$location."') as relevancia FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".$language."' JOIN producto as p ON s.id_servicio = p.id_servicio AND WHERE MATCH(p.titulo_producto,p.ciudad_cercana) AGAINST('".$location."') order by s.id_servicio asc;")->result_array();
        }    
        // echo json_encode($response);
        // var_dump($response);
        $data = array();
        $data_temp_maps=array();
        $data_temp_location      = [];
        $data_temp_activities    = [];
        $data_location           = [];
        $data_activities         = [];
        $data_location_count=[];
        if (!empty($response)) {
            foreach ($response as $key => $value) {
                if ($value['estado_producto']==1) {
                    array_push($data_temp_location,strtolower($value['ubicacion_servicio']));
                    //array_push($data_temp_location,strtolower($value['ciudad_cercana']));
                    $data_temp_maps[]=json_decode($value['mapa_tab'],true);
                    $data_temp_activities[] = array(
                        'ciudad'    => $value['ciudad_cercana'],
                        'actividad' => $value['titulo_producto'],
                        'uri'       => $value['uri_servicio'],
                        'id_producto'       => $value['id_producto'],
                        'duracion'       => explode(',',$value['duracion'])[0],
                        'id'=>$value['id_servicio']
                    );  
                }
                          
            }
        }
        $string_lugares_temp=$data_temp_location;
        
        foreach ($data_temp_maps as $key => $value) {
            if (@$value['lugares']) {
                foreach ($value['lugares'] as $key2 => $value2) {
                    $string_lugares[]=strtolower($value2['nombre']);
                    $array_lugares[] =count(trim($value2['nombre'])) != 0 ? explode(",",$value2['nombre']) : '' ; 
                    //array_push($data_temp_location,strtolower(strtolower($value2['nombre'])));
                    if (!in_array(strtolower($value2['nombre']), $string_lugares_temp)) {
                        array_push($data_temp_location,strtolower($value2['nombre']));
                    }
                }
            }
        }

        $data_location_count =array_count_values($data_temp_location);

        $data_location_unique = array_unique($data_temp_location);
        // $data_location_unique = $data_temp_location;
        //optimizar search por destinos y actividades
        $temp_id=$data_temp_activities[0]['id'];
        $temp_count=0;
        foreach ($data_temp_activities as $key => $value) {
            $ubicacion = count(trim($value['ciudad'])) != 0 ? explode(",",$value['ciudad']) : ''; 
            if ($temp_id==$value['id']){
                $temp_count++;
            }else{
                $temp_id=$value['id'];
                $temp_count=0;
            }
            $data_activities[] = array(
                "url"          => base_url().mb_strtolower($language).'/'.$this->uri_amigable(mb_strtolower($ubicacion[0])).'/'.mb_strtolower($value['uri'].'#'.$value['id_producto']),
                "descripcion"  => mb_strtolower($value['actividad']), 
                "duracion"  => mb_strtolower($value['duracion']),
                "num"=>$temp_count,
                'id'=>$value['id']
            ); 
        }

        foreach ($data_location_unique as $key => $value) {
            $ubicacion = count(trim($value)) != 0 ? explode(",",$value) : ''; 
            $data_location[] = array(
                "url" => base_url().mb_strtolower($language).'/'.($language == 'es'?'destino':'destination').'/'.$this->uri_amigable(mb_strtolower($ubicacion[0])),
                "descripcion" => $value, 
                "count" => $data_location_count[$value], 
            );
        }

        $data['location'] = $data_location;
        $data['activity'] = $data_activities;
        // $data['response']=$response;
        // echo json_encode($data['activity']);
        // echo json_encode($data['response']);
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

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/

    function exist_language($language_code){
        return $this->db->query("SELECT * FROM idioma WHERE '$language_code'=codigo;")->row_array();
    }

    function exist_place($place){
        $query = $this->db->query("SELECT * FROM `servicio` WHERE ubicacion_servicio like '%$place%'");
        return $query->result();
    }

    function exist_service($language_code,$place,$uri_service){
        $return_value = array();

        $servicios = $this->db->query("
            select * from servicio where uri_servicio ='$uri_service';
        ")->result_array();

        if ( count($servicios) != 0 ) {

            //$return_value['actual'] = $actual;
            $return_value['actual'] = $servicios[0];

            //$id_imagen_principal = !empty($actual['imagen_principal'])?$actual['imagen_principal']:0;
            $id_imagen_principal = !empty($servicios[0]['imagen_principal'])?$servicios[0]['imagen_principal']:0;
            $slider = $this->db->query("
                select * 
                from galeria
                where id_galeria=$id_imagen_principal;
            ")->row_array();
            if (!empty($slider)) {
               $return_value['actual']['slider_img'] = base_url()."galeria/admin/".$this->carpeta($slider["tipo_archivo"])."/".$slider["carpeta_archivo"]."/".$slider["url_archivo"];
               $return_value['actual']['slider_thumbs'] = base_url()."galeria/admin/".$this->carpeta($slider["tipo_archivo"])."/".$slider["carpeta_archivo"]."/thumbs/".$slider["url_archivo"];
            }else{
                $return_value['actual']['slider_img']='';
                $return_value['actual']['slider_thumbs']='';
            }

            

            $actividades = $this->get_products($language_code,$servicios[0]['codigo_servicio_id_codigo_servicio']);

            $categorias_tmp = array();
            foreach($actividades as &$actividad){
                $actividad['galeria'] = $this->get_galeria($actividad['id_actividad']);
                $actividad['tabs_adicionales'] = $this->get_tabs_adicionales(empty($actividad['id_producto'])?0:$actividad['id_producto']);
                //echo json_encode($actividad);
                foreach($this->get_categorias($actividad['id_producto'],$language_code) as $cat){
                    $categorias_tmp[] = $cat['nombre'];
                }
            }



            $return_value['actividades'] = $actividades;

            $categoria_unique = array_unique($categorias_tmp);
            foreach($categoria_unique as &$categoria){
                $categoria = array(
                    'nombre'=>$categoria,
                    'uri'=>$this->uri_categoria($categoria),
                    'url'=>base_url().mb_strtolower($language_code)."/".(mb_strtolower($language_code)=='es'?"categoria":"category")."/".$this->uri_categoria($categoria)
                );
            }

            $return_value['categorias'] = $categoria_unique;
            $return_value['idiomas'] = $servicios;
        }
        return $return_value;
    }

    function get_products($language_code,$codigo_servicio){
        $actividades = $this->db->query("
            SELECT p.id_producto as id_actividad,p.*, tab.*,ta.*,d.* 
            FROM idioma as i 
            join servicio as s 
            on i.id_idioma=s.idioma_id_idioma and 
            i.codigo = '$language_code' 
            and s.codigo_servicio_id_codigo_servicio='$codigo_servicio' 
            left join producto as p 
            on s.id_servicio=p.id_servicio 
            left join tab as 
            tab on p.id_producto=tab.producto_id_producto 
            left join tab_adicional as 
            ta on ta.id_producto=p.id_producto 
            left JOIN disponibilidad as d 
            on d.id_producto=p.id_producto WHERE p.estado_producto = 1 group by p.id_producto order by p.id_producto
        asc;")->result_array();

        return $actividades;
    }

    private function get_galeria($id_producto){
        $imagenes = $this->db->query("
            SELECT GP.id_producto, G.url_archivo, G.detalles_archivo, G.tipo_archivo, G.carpeta_archivo
            from galeria_has_producto GP
            join galeria G 
            on GP.id_galeria=G.id_galeria
            where GP.id_producto = '$id_producto'
        ")->result_array();

        foreach($imagenes as &$imagen){
            $imagen['url_final'] = base_url()."galeria/admin/".$this->carpeta($imagen["tipo_archivo"])."/".$imagen["carpeta_archivo"]."/".$imagen["url_archivo"];
$imagen['url_thumbs']=base_url()."galeria/admin/".$this->carpeta($imagen["tipo_archivo"])."/".$imagen["carpeta_archivo"]."/thumbs/".$imagen["url_archivo"];
        }

        return $imagenes;
    }

    public function get_categorias($id_producto, $language_code){
        $query = $this->db->query("
            select C.nombre_categoria categoria 
            from  producto_has_categoria PC 
            left join categoria C 
            on PC.categoria_id_categoria=C.id_categoria  
            where 
            PC.producto_id_producto = '$id_producto'
        ");
        $categorias = $query->result();
        foreach($categorias as &$categoria){
            $categoria = array(
                'nombre'=>$categoria->categoria,
                //'uri'=>$this->uri_categoria($categoria->categoria),
                //'url'=>base_url().mb_strtolower($language_code)."/".(mb_strtolower($language_code)=='es'?"categoria":"category")."/".$this->uri_categoria($categoria->categoria)
            );
        }
        return $categorias;
    }
    
    private function get_tabs_adicionales($id_producto){
        $data=array();
        $response=$this->db->query("
            select * 
            from tab_adicional 
            where id_producto=$id_producto
        ")->result_array();
        if (!empty($id_producto)) {
           foreach ($response as $key => $value) {
            if (!empty(trim($value['contenido_tab']))&&!empty(trim($value['nombre_tab']))) {
                $data[]= $value;
            }
            
            }
        }
        
        return  $data;
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


    //---------------------- comversion a uri ----------------------
    private function uri_categoria($categoria){
        return str_replace( 
            array('á','é','í','ó','ú',' ','+','ñ'), 
            array('a','e','i','o','u','-','-','n'), 
            trim( mb_strtolower($categoria) ) 
        );
    }

    function get_neighbours($language_id,$place,$service_id){
        $query = $this->db->query("
            SELECT S.titulo_pagina, S.uri_servicio, G.url_archivo, G.tipo_archivo, G.carpeta_archivo  
            FROM servicio S 
            join galeria G 
            on G.id_galeria=S.miniatura
            WHERE 
            S.ubicacion_servicio like '%$place%' and 
            S.idioma_id_idioma = $language_id and
            S.id_servicio!='$service_id'
        ");
        return $query->result();
    }
    function get_foreigners($codigo_servicio_id_codigo_servicio,$id_servicio){
        $query = $this->db->query("
            SELECT s.uri_servicio, i.codigo, i.pais  
            FROM idioma as i 
            JOIN servicio as s 
            ON i.id_idioma = s.idioma_id_idioma
            and s.id_servicio!=$id_servicio and s.codigo_servicio_id_codigo_servicio=$codigo_servicio_id_codigo_servicio
        ");
        return $query->result();
    }

    // Retorna las actividades mas compradas que serán mostradas en el index
    function get_masComprados($language = "EN"){
        $data = [];
        $mascomprados = $this->db->query("SELECT ds.id_producto, COUNT(ds.id_producto) as total_comprados FROM detalle_servicio as ds GROUP BY ds.id_producto ORDER BY total_comprados DESC LIMIT 15;")->result_array();
        if (!empty($mascomprados)) {
            foreach ($mascomprados as $key => $value) {
                $response = $this->db->query("SELECT p.id_producto,p.codigo_producto,i.codigo, s.ubicacion_servicio,s.uri_servicio, p.titulo_producto, s.descripcion_pagina, p.duracion, pr.cantidad, MIN( pr.monto ) AS precio, g. *, cat.nombre_categoria FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".trim($language)."' JOIN producto AS p ON s.id_servicio = p.id_servicio AND p.id_codigo_producto = (SELECT p2.id_codigo_producto FROM producto as p2 WHERE p2.id_producto = '".trim($value['id_producto'])."' LIMIT 1) JOIN detalle_precio AS dp ON dp.id_producto = p.id_producto AND dp.id_etapa_edad = 1 JOIN precios AS pr ON pr.id_detalle_precio = dp.id_detalle_precio JOIN galeria_has_producto AS ghp ON p.id_producto = ghp.id_producto JOIN galeria AS g ON ghp.id_galeria = g.id_galeria LEFT JOIN producto_has_categoria as phc ON p.id_producto = phc.producto_id_producto LEFT JOIN categoria as cat ON cat.id_categoria = phc.categoria_id_categoria GROUP BY p.titulo_producto;")->row_array();
                if (!empty($response)) {
                    $ubicacion = count(trim($response['ubicacion_servicio'])) != 0 ? explode(",",$response['ubicacion_servicio']) : ''; 
                    $data[] = array(
                        'idioma'             => mb_strtolower($response['codigo']),
                        'ubicacion'          => $response['ubicacion_servicio'],
                        'actividad'          => $response['titulo_producto'],
                        'descripcion'        => $response['descripcion_pagina'],
                        'precio_normal'      => number_format($response['precio'],2,'.',''),
                        'duracion'           => $this->formatear_duracion($response['duracion'],mb_strtolower($response['codigo'])),
                        'horarios'           => $this->formatear_horarios($response['duracion'],mb_strtolower($response['codigo'])),
                        'url'                => base_url().strtolower($response['codigo']).'/'.$this->uri_amigable(mb_strtolower($ubicacion[0])).'/'.mb_strtolower($response['uri_servicio']),
                        'imagen'             => base_url().(
    (!empty($response['url_archivo']))?("galeria/admin/".$this->carpeta($response['tipo_archivo'])."/".$response['carpeta_archivo']."/thumbs/".$response['url_archivo']):("assets/img/default-shot-img.png")),
                        'categoria'         => $response['nombre_categoria'],
                        'txt_precio'        => mb_strtolower($response['codigo']) === 'es'? 'Desde' : 'From',
                        'txt_more_info'     => mb_strtolower($response['codigo']) === 'es'? 'Leer Más' : 'More Info',
                        'total_comprados'   => $value['total_comprados'],
                    );
                }
            }
        }
        return $data;
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

    // Retorna si uno de los id Producto consultado tiene el método de pago paypal habilitado
    public  function obtenerMetodoPagoPaypal($stringIdProductos){
        //return $this->db->query("SELECT COUNT(pro.metodo_pago) AS cantidad_metodo_pago FROM producto AS pro WHERE pro.id_producto IN (".trim($stringIdProductos).") AND pro.metodo_pago = 1;" )->row_array();
        $response = $this->db->query('SELECT pro.metodo_pago FROM producto AS pro WHERE pro.id_producto IN ('.trim($stringIdProductos).') GROUP BY pro.metodo_pago;')->result_array();
        $result = 0;
        $suma_metodo_pago = 0;
        if( !empty($response) ){
            foreach( $response as $key => $value ){
                $suma_metodo_pago += (Integer)$value['metodo_pago'];              
            }
        }
        
        if( (Integer)$suma_metodo_pago === 1 ){
            $result = 1; // Paypal
        }
        if( (Integer)$suma_metodo_pago === 3 ){
            $result = 1; // Paypal
        }
        if( (Integer)$suma_metodo_pago === 2 ){ // Culqi
            $result = 2;
        }
        //$result['cantidad_metodo_pago'] = 0;  // Todos los Métodos
        return $result; 
    }
}