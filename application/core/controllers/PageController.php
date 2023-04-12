<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PageController extends CI_Controller {

    public function __construct() {
       parent::__construct();
       $this->load->model('page_model','Page_model');
    }
    /*
		Documentación
		http://jeromejaglale.com/doc/php/codeigniter_template
    */

	public function checkout_availability() //P
    {
        $data['menu_language']     = $this->Page_model->menu_language_location("","");
        $data['language'] = $this->uri->segment(1);
        $this->template->set('title','Formulario de registro para verificar disponibilidad');
        $this->template->load('template', 'cart/checkout_forms_disponiblidad', $data);
    }

    public function checkout_cart()
    {
        $data['menu_language']     = $this->Page_model->menu_language_location("","");
        $data['language'] = $this->uri->segment(1);
        $this->template->set('title','Carro de Compras');
        $this->template->load('template', 'cart/checkout_cart', $data);
    }

    public function checkout_customer()
    {   
        $data['menu_language']     = $this->Page_model->menu_language_location("","");
    	$data['language'] = $this->uri->segment(1);
        $this->template->set('title','Carro de Compras - Datos de usuario');
        $this->template->load('template', 'cart/checkout_customer', $data);
    }

    public function checkout_payment()
    {
        $data['menu_language']     = $this->Page_model->menu_language_location("","");

    	$data['language'] = $this->uri->segment(1);

        $headjs           = '<script src="'.base_url().'assets/resources/js/jquery.blockUI.js" type="text/javascript"></script>';
        $payform          = '<script src="'.base_url().'assets/resources/payform/payform.min.js" type="text/javascript"></script>';
        //$transactjs       = '<script src="'.base_url().'assets/resources/js/config.js" type="text/javascript"></script>';
        //$transactIncalake = '<script src="'.base_url().'assets/resources/js/transact.js" type="text/javascript"></script>';

        $transactjs       = '<script src="'.base_url().'assets/resources/js/config.2.0.js" type="text/javascript"></script>';
        $transactIncalake = '<script src="'.base_url().'assets/resources/js/transact.2.0.js" type="text/javascript"></script>';
        //$paymeScriptTest  = '<script type="text/javascript" src="https://integracion.alignetsac.com/VPOS2/js/modalcomercio.js" ></script>';  
        $paymeScript      = '<script type="text/javascript" src="https://vpayment.verifika.com/VPOS2/js/modalcomercio.js" ></script>';

        $this->template->set('script', '<script src="https://checkout.culqi.com/v2"></script>'.$headjs.$payform.$transactjs.$transactIncalake.$paymeScript);
        
        $this->template->set('title','Carro de Compras - Método de Pago');
        $this->template->load('template', 'cart/checkout_payment', $data);	
    }

    /* Resultado que va a ser visualizado en la vista 
     * directorio Application/view/cart/checkout_confirm.php
    */
    public function checkout_confirm()
    {
        if(!$this->input->get('codr')) {  // Si no existe el codigo reserva redireccionamos a la pagina de inicio
            redirect('/', 'location');
        }

        $data['menu_language']     = $this->Page_model->menu_language_location("","");
        $data['language'] = $this->uri->segment(1);
        $data['codr'] = $this->input->get('codr');

        /* DetalleServicio_Reserva::class - Model table 'detalle_servicio_has_reserva' */
        $detalles = DetalleServicio_Reserva::join('detalle_servicio', 'detalle_servicio_has_reserva.id_detalle_servicio', 'detalle_servicio.id_detalle_servicio')
                ->join('producto', 'producto.id_producto', 'detalle_servicio.id_producto')
                ->join('resumen', 'resumen.id_detalle_servicio', 'detalle_servicio.id_detalle_servicio')
                ->where('id_reserva', $data['codr'])
                ->orderBy('producto.id_producto', 'desc')
                ->get([
                    'producto.tipo_recojo', 'producto.lugar_recojo', 
                    'producto.titulo_producto', 'producto.id_producto',
                    'detalle_servicio.tasas_impuestos',
                    'detalle_servicio.descuento', 
                    'detalle_servicio.url',
                    'detalle_servicio.importe_tasas_impuestos',
                    'detalle_servicio.fecha_servicio', 
                    'detalle_servicio.duracion_servicio', 
                    'detalle_servicio.hora_inicio_servicio',
                    'detalle_servicio.precio_total as precio_total',
                    'resumen.nombre_articulo',
                    'resumen.cantidad as cantidad_articulo', 
                    'resumen.tipo_articulo',
                    'resumen.tipo_articulo',
                    'resumen.precio as precio_articulo',
                ]);


        $array_tour = [];
        $tourReserve = "";     
        $flag = -1;

        /*Ordenamos el resultado de la consulta*/
        foreach ($detalles as $key => $reserva) {
            if($reserva->id_producto != $tourReserve) {
                $resumen = [];
                
                $img = GaleriaHasProducto::join('galeria', 'galeria.id_galeria', 'galeria_has_producto.id_galeria')
                            ->where('galeria_has_producto.id_producto', $reserva->id_producto)->take(1)->get(['url_archivo', 'carpeta_archivo']);


                if(count($img) == 0) {
                    $url_img = 'http://vollrath.com/ClientCss/images/VollrathImages/No_Image_Available.jpg';
                } else {
                    $url_img = url('galeria/admin/short-slider/'.$img[0]->carpeta_archivo.'/thumbs/'.$img[0]->url_archivo);
                }

                array_push($array_tour, [
                     'id_producto' => $reserva->id_producto,
                    'titulo_producto' => $reserva->titulo_producto,
                    'lugar_recojo' => $reserva->lugar_recojo,
                    'fecha_servicio' => $reserva->fecha_servicio,
                    'hora_inicio_servicio' => $reserva->hora_inicio_servicio,
                    'duracion_servicio' => $reserva->duracion_servicio,
                    'img' => $url_img,
                    'url' => $reserva->url,
                    'precio_total' => $reserva->precio_total,
                    'importe_tasas_impuestos' => $reserva->importe_tasas_impuestos,
                    'resumen' => [[
                        'nombre_articulo' => $reserva->nombre_articulo,
                        'cantidad_articulo' => $reserva->cantidad_articulo,
                        'precio_articulo' => $reserva->precio_articulo,
                        'tipo_articulo' => $reserva->tipo_articulo,
                    ]]
                ]);
                $tourReserve = $reserva->id_producto;
                $flag++;
            } else {
                array_push($array_tour[$flag]['resumen'], array(
                    'nombre_articulo' => $reserva->nombre_articulo,
                    'cantidad_articulo' => $reserva->cantidad_articulo,
                    'precio_articulo' => $reserva->precio_articulo,
                    'tipo_articulo' => $reserva->tipo_articulo,
                ));
            }

        }
        $data['payments'] = $array_tour;
        $this->template->set('title','Confirmación de pago');
        $this->template->load('template', 'cart/checkout_confirm', $data);
    }

	public function page_producto()
	{	$data['menu_language']     = $this->Page_model->menu_language_location("","");	
		$data['language'] = $this->uri->segment(1);
		$this->template->load('template', 'producto', $data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */