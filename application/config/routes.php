<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
require_once(APPPATH.'libraries/pigeon.php');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/


Pigeon::map(function($route) {
	$route->get('send', 					   'ReservaController@send');
	
	$route->get('api/producto/forms', 		   'ProductoController@campo_formularios');
	$route->get('api/producto/precios', 	   'ProductoController@precios');
	$route->get('api/producto/disponibilidad', 'ProductoController@disponibilidad');
	$route->get('api/producto/cart',		   'ProductoController@cart');

	$route->get('api/recursos', 			   'ProductoController@recursos');
	$route->get('api/terminos', 			   'ProductoController@terminos_condiciones');	
	$route->get('api/cupon',     			   'CuponController@codigo');
	$route->post('api/reserva', 			   'ReservaController@store');
	$route->post('api/reserva/update',  	   'ReservaController@update');
	$route->post('api/reserva/disponibilidad', 'ReservaController@consultar_disponiblidad');
//REGISTRAR CALENDARIO
	$route->post('api/reserva/setcalendar', 'ReservaController@ingresar_evento_calendario');
	
	$route->get('pdf', 						   'PdfController@checkoutPayment');	
	$route->get('([a-z]{2})/vaucher/payment',  'PdfController@vaucherPayment');

	$route->get('([a-z]{2})/checkout/availability',    'PageController@checkout_availability');

    $route->get('([a-z]{2})/checkout/cart',    'PageController@checkout_cart');
    $route->get('([a-z]{2})/checkout/customer','PageController@checkout_customer');
    $route->get('([a-z]{2})/checkout/payment', 'PageController@checkout_payment');
    $route->get('([a-z]{2})/checkout/confirm', 'PageController@checkout_confirm');
    $route->get('([a-z]{2})/checkout/ivan', 'PageController@checkout_ivan');
    
    // datos del cliente
    $route->get('([a-z]{2})/data/customer','PageController@datos_cliente');
    $route->post('([a-z]{2})/data/customer_reg','PageController@registrar_datos_cliente');
});

$route = Pigeon::draw();  // No borrar 


$route['default_controller'] = "page";

$route['rastreo_sitemap'] 		  = 'rastreo_sitemaps/index';
$route['([a-z]{2})/reservas'] 		  = 'reservas/paquete/$1';
$route['([a-z]{2})/reservas/(:num)']      = 'reservas/paquete/$1/$2';
$route['([a-z]{2})/reserve'] 		  = 'reservas/paquete/$1';
$route['([a-z]{2})/reserve/(:num)']	  = 'reservas/paquete/$1/$2';


$route['([a-z]{2})/ofertas']		  = 'page/get_ofertas/$1';
$route['([a-z]{2})/offers']		  = 'page/get_ofertas/$1';

//mapa de sitio
$route['([a-z]{2})/sitemap']		  = 'sitemap';
//paginas independientes
$route['([a-z]{2})/info/(:any)']		  = 'info';

$route['([a-z]{2})/categorias']		  = 'categoria';
$route['([a-z]{2})/categories']		  = 'categoria';
$route['([a-z]{2})/categoria/(:any)']     = 'categoria/filtrar/$1/$2';
$route['([a-z]{2})/category/(:any)']      = 'categoria/filtrar/$1/$2';
//test paginas
$route['([a-z]{2})/test']      = 'page/testindex';
// destinos
$route['([a-z]{2})/destinos']		  = 'destino';
$route['([a-z]{2})/destino/(:any)/(:any)']   = 'destino/filtrar_destino/$1/$2/$3';
$route['([a-z]{2})/destino/(:any)']   = 'destino/filtrar/$1/$2';
// superventas
$route['([a-z]{2})/superventas']		  = 'page/get_superventas/$1';
$route['([a-z]{2})/bestselling']		  = 'page/get_superventas/$1';;
// contorlador/funcion/variables
$route['([a-z]{2})/destinations']		 = 'destino';
$route['([a-z]{2})/destination/(:any)']  = 'destino/filtrar/$1/$2';

// Muestra el contenido de la página web en su idioma respectivo
$route['([a-z]{2})/(:any)/(:any)'] 		 = 'page/view_page/$1/$2/$3'; 


//Muestra un listado de todas las páginas web que pertenecen a una localidad. Example: http://incalake.com/es/juli-puno
// $route['([a-z]{2})/(:any)']      	= 'page/list_by_location/$1/$2'; 


// Muestra el index de las páginas de cada idioma. Example : http://incalake.com/es, http://incalake.com/en/  
$route['([a-z]{2})/']             	= 'page/index/$1';
$route['([a-z]{2})']             	= 'page/index/$1';



//$route['template']             	= 'page/template';

$route['([a-z]{2})/(:any)'] = "page/error_page";
$route['404_override'] = 'page/pagina_no_encontrada';

/* End of file routes.php */
/* Location: ./application/config/routes.php */



/*
	Microframework Incalake manajo de rutas
*/

