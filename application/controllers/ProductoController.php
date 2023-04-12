<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductoController extends CI_Controller {

    /*
     * @function - cart
     * {return} json
     */
    public function cart()
    {
        $id_producto = $this->input->get('id'); // Recogemos el id del producto [CLAVE PRIMARIA]

        $etapas = [];

        /*
        ----------------------------------------------------------
            Models Database 
            Directorio application/models/eloquent/*.php
        ----------------------------------------------------------
        
            DetallePrecio::class - Model table 'detalle_precio'
        */
        $preciosXetapas = DetallePrecio:: 
            join('precios', function ($join) {
                $join->on('detalle_precio.id_detalle_precio', '=', 'precios.id_detalle_precio');
            })
            ->join('etapa_edad',   function ($join) {
                $join->on('detalle_precio.id_etapa_edad', '=', 'etapa_edad.id_etapa_edad');
            })
            ->join('nacionalidad', function ($join) {
                $join->on('detalle_precio.id_nacionalidad', '=', 'nacionalidad.id_nacionalidad');
            })
            ->where('detalle_precio.id_producto', $id_producto)
            ->get([
                'detalle_precio.edad_maximo',   
                'detalle_precio.edad_minimo',
                'detalle_precio.id_detalle_precio',          
                'etapa_edad.descripcion_etapa_edad',
                'etapa_edad.id_etapa_edad',
                'etapa_edad.traducciones as traducciones_etapa_edad',   
                'nacionalidad.descripcion_nacionalidad',
                'nacionalidad.id_nacionalidad',
                'nacionalidad.traducciones_nacionalidad',
                'precios.cantidad',
                'precios.monto'
        ]);

        $flag = 0;
        $indexArray = -1;

       
        /*
         * Organizamos el resultado de $preciosXetapa 
         * @transform json 
        */
        foreach($preciosXetapas as $index => $e) {

            if($e->id_detalle_precio != $flag) {
                array_push($etapas, [
                    'id_etapa_edad' => $e->id_etapa_edad,
                    'id_nacionalidad' => $e->id_nacionalidad, 
                    'descripcion_etapa_edad' => $e->descripcion_etapa_edad,
                    'traducciones_etapa_edad' => $e->traducciones_etapa_edad,//json_decode(strtolower($e->traducciones_etapa_edad), true),
                    'edad_minimo' => $e->edad_minimo,
                    'edad_maximo' => $e->edad_maximo,
                    'cantidad' => $index == 0 ? 2 : 0,
                    'descripcion_nacionalidad' => $e->id_nacionalidad == 1 ? '' : $e->descripcion_nacionalidad,
                    'traducciones_nacionalidad' => $e->traducciones_nacionalidad, //json_decode(strtolower($e->traducciones_nacionalidad), true),
                    'precios' => [[
                        'cantidad' => $e->cantidad,
                        'monto' => $e->monto,
                    ]],                   
                ]);
                $flag = $e->id_detalle_precio;
                $indexArray++;
            } else {
                array_push($etapas[$indexArray]['precios'], [
                    'cantidad' => $e->cantidad,
                    'monto' => $e->monto,
                ]);
            }
        } 

        /*
         * Disponibilidad::class - model table 'disponibilidad'
         * fechas disponibles
        */

        $fechas_disponibles =  Disponiblidad::where('id_producto', $id_producto)->first([
            'fecha_inicio', 
            'fecha_fin', 
            'dias_activos', 
            'dias_no_activos'
        ]);
       
        /*
         * Bloqueo::class - model table 'bloqueo'
         * Bloqueos de fechas
        */

        $bloqueos = Bloqueo::where('id_producto', $id_producto)->where('fecha_fin', '>=', date('Y-m-d'))->get([
            'fecha_inicio', 
            'fecha_fin'
        ]);

         /*
         * Oferta::class - model table 'oferta'
         * Oferta asignadas a diferentes fechas
        */

        $ofertas = Oferta::where('id_producto', $id_producto)->where('fecha_fin', '>=', date('Y-m-d'))->get([
            'fecha_inicio', 
            'fecha_fin', 
            'valor_oferta'
        ]);

        /*
         * ProductoModel::class - model table 'producto'
        */

        $p = ProductoModel::where('id_producto', $id_producto)->first([
            'id_producto',
            'titulo_producto',
            'zona_horaria',
            'requerir_disponibilidad',
            'hora_inicio', 
            'duracion', 
            'capacidad',
            'anticipacion_reserva_producto',
            'tasas_impuestos',
            'porcentaje_adelanto',
        ]);
        
        /*
         * GaleriaHasProducto::class - model table 'galeria_has_producto'
        */

         $img = GaleriaHasProducto::join('galeria', 'galeria.id_galeria', 'galeria_has_producto.id_galeria')
            ->where('galeria_has_producto.id_producto', $id_producto)
            ->take(1)
            ->get(['url_archivo', 'carpeta_archivo']);


        /*
         * Tabla 'producto' => campos ('hora_inicio', 'duracion')
         * Generar el array para los Horarios
        */
        $horarios = [];
        $horas_inicio = explode(',',$p->hora_inicio);
        $duraciones = explode(',',$p->duracion);
        $zona_horaria = explode(',',$p->zona_horaria);
                       

        foreach($horas_inicio as $index => $t) {
            array_push($horarios, [
               'hora' =>  $t,
               'duracion' => $this->formatTime($duraciones[$index]), // Metodo $this->formatTime(@duracion) -  Cambiamos el formato "1!2,..."
               'order' => date('H:i', strtotime($t)), //Convertimos la hora a 24 horas 
               'zona_horaria' => @$zona_horaria[$index]?'BT':'PT', //Convertimos la hora a 24 horas
            ]);
        }

        /*
        * Ordenación de horario
        * AM .... PM
        */
        $orderByHorario = [];
        foreach($horarios as $h) {
             $orderByHorario[] = $h['order'];  //Variable 'order', por el cual va a ser ordenado
        }
        array_multisort($orderByHorario, SORT_ASC, $horarios); // Ordenamos el horario segun la hora 

        if(count($img) == 0) {
            $url_img_thumbs = 'http://vollrath.com/ClientCss/images/VollrathImages/No_Image_Available.jpg';
            $url_img = 'http://vollrath.com/ClientCss/images/VollrathImages/No_Image_Available.jpg';
        } else {
            $url_img_thumbs =url('galeria/admin/short-slider/'.$img[0]->carpeta_archivo.'/thumbs/'.$img[0]->url_archivo);
            $url_img = url('galeria/admin/short-slider/'.$img[0]->carpeta_archivo.'/'.$img[0]->url_archivo);
        }
        /* 
         * ProductoHasGuia::class   -    Model
         * table 'producto_has_guia'
        */
        $guiaTour = ProductoHasGuia::join('guia', function ($join) {
            $join->on('producto_has_guia.id_guia', '=', 'guia.id_guia');
        })
        ->where('id_producto', $p->id_producto)
        ->get(['tipo_guia', 'servicio_guia']); //Retornamos tipo_guia, servicio_guia 'es|en'

        $guiaTypeKey = ['guia_vivo', 'guia_audio', 'guia_folleto', 'guia_notiene', 'guia_nomostrar']; //Palabras key del tipo de guia que serviran para las traducciones en el backend
        
        if(count($guiaTour) != 0) { //Si hay resultados mostramos 
            $guia_type = $guiaTypeKey[$guiaTour[0]['tipo_guia']];
            $guia_lang = [];
            foreach($guiaTour as $guia) {
                array_push($guia_lang, $guia['servicio_guia']);
            }
        } else { // **********
            $guia_type = 'guia_notiene';
            $guia_lang = [];
        }

       $results = [
            'producto' => [
                'id_producto' => $p->id_producto,
                'titulo_producto' => $p->titulo_producto,
                'tasas_impuestos' => $p->tasas_impuestos,
                'img_thumb' => $url_img_thumbs, 
                'img' => $url_img,
                'horarios' => $horarios,
                'requerir_disponibilidad' => $p->requerir_disponibilidad,
                'capacidad' => $p->capacidad,
                'tiempo_anticipacion' => $p->anticipacion_reserva_producto,
                'guia' => [
                    'tipo_guia' => $guia_type,
                    'lang' => $guia_type == 'guia_notiene' ? [] : $guia_lang,
                ],
                'porcentaje_adelanto' => $p->porcentaje_adelanto, // Porcentaje mediante el cual se calcula el monto para adelantar el pago.
            ],
            'precios_etapa' => $etapas,
            'disponibilidad' => $fechas_disponibles,
            'bloqueos' => $bloqueos,
            'ofertas' => $ofertas,
        ];        

      echo json_encode($results); 
    }

    /*
     * Recursos JSON - @function
     * Muestra los recursos relacionados a un tour 
    */
    public function recursos()
    {
        /**
         * Modelo encontrado en => app/models/eloquent/RecursoProducto_.php
         * Tabla "recurso_has_producto"
        */
        $codigo_producto = ProductoModel::find($this->input->get('id'))->id_codigo_producto;
        $productos = ProductoModel::where('id_codigo_producto', $codigo_producto)->get(['id_producto']);
        $ids= [];

        foreach ($productos as $p) {
            array_push($ids, $p['id_producto']); 
        }

        $recurso = RecursoProducto_::join('recurso', function ($join) {
            $join->on('recurso.id_recurso', 'recurso_has_producto.id_recurso');
        })
        ->join('recurso_has_galeria', function ($join) {
            $join->on('recurso_has_galeria.recurso_id_recurso', 'recurso.id_recurso');
        })
        ->join('galeria', function ($join) {
            $join->on('recurso_has_galeria.galeria_id_galeria' ,'galeria.id_galeria');
        })
        ->distinct()
        ->whereIn('id_producto', $ids)
        ->get();

       echo json_encode($this->unique_multidim_array($recurso,'id_recurso')); 

    }

    public function unique_multidim_array($array, $key) {  //Elimina array duplicados
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    } 
    /* 
     * @function formatNumber() 
     * return {integer, decimal}
    */
    public function formatNumber($number)
    {
        $num = explode('.',(float)$number);
        return isset($num[1])?$num[0].'.'.str_pad($num[1],2, '0',STR_PAD_RIGHT):$num[0]; // formateamos el numero. Ej. 12.000 => 12 o 12.3 => 12.30
    }

    public function formatTime($tiempo)
    {
        if(!empty($tiempo)) {
            $t = explode('!',$tiempo);
            $getTime = ['min', "h", "d"];
            return $t[0].' '.$getTime[$t[1]];
        } else {
            return '';
        }
    }
    /**
        Términos y condiciones de un tour
    */

    public function terminos_condiciones() {
       $producto_id = $this->input->get('id'); // Id de producto tour
       $politica = ProductoModel::find($producto_id)->politicas_producto;  //Extraemos el valor del campo "politicas_producto" de la tabla "producto";
       
       /*
        Si hay contenido en el campo "politicas_producto" de la tabla "producto" mostramos el contenido de la misma, caso contrario
        realizamos la carga del archivo de politicas que esta establecida de manera estandar para los diferentes
       */
       echo strlen(trim($politica)) != 0 ? $politica: file_get_contents('./assets/archivos/politicas/'.strtoupper($this->input->get('lang')).'.txt', true); 
    }
}
