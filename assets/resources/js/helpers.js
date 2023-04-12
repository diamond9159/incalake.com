/**
* ---------------------------------------------------------------------------------------------------------------------
* INCALAKE TRAVEL - Agency @2017
* | Helpers.js 
* Config
* @Variable y @Funciones global que van ser reutilizadas.
* ---------------------------------------------------------------------------------------------------------------------
*/

/**
* Idioma del sitioWeb.
* @param {string} lang - Captura el idioma de la etiqueta <html lang="es">, si no existe retornara 'es'.
* Ej. langApp -> retorna el idioma 
*/
window.langApp = document.getElementsByTagName('html')[0].getAttribute('lang') ? document.getElementsByTagName('html')[0].getAttribute('lang') : 'es';

/*
* @param {number} tasa e impuestos a cobrar
*/

/**
* Function | cookieMinuteExpire 
* @constructor
* @param {number} minutos - Define el tiempo de duración de la cookie en minutos.
* Ej. cookieMinuteExpire(20);
*/
window.cookieMinuteExpire = (minutos) => {
	var expireCookie = new Date();
	return expireCookie.setTime(expireCookie.getTime() + (minutos * 60 * 1000)); 
}

/*
 	Limpia cadenas|string que contengan caracteres raros o de contenido utf-8 
	@cleanedString(string)  
	return string -> proccess
*/

window.cleanedString = function (cadena) {
	var specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";

	for (var i = 0; i < specialChars.length; i++) {
		cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
	}
	cadena = cadena.toLowerCase();
	cadena = cadena.replace(/ /g,"_");
	cadena = cadena.replace(/á/gi,"a");
	cadena = cadena.replace(/é/gi,"e");
	cadena = cadena.replace(/í/gi,"i");
	cadena = cadena.replace(/ó/gi,"o");
	cadena = cadena.replace(/ú/gi,"u");
	cadena = cadena.replace(/ñ/gi,"n");

	return cadena;
}

/* 
	@removeItemFromArray
	Elimina un contenido de un array  ['data', ....]
 */
window.removeItemFromArray = ( arr, item ) => {
    var i = arr.indexOf( item );
 
    if ( i !== -1 ) {
        arr.splice( i, 1 );
    }
}

/*
	@exitItemArray 
	Verifica si exite ese elemento en el array
*/
window.exitItemArray =  (array_, val) => {
	
	var result = false;

		array_.forEach((item) => {
			if(item == val) {
				result = true;
			}
		});
	
	return result;
}

// window.findArray_ = (array_, key, val, return_) => {
// 	array_.forEach((a)=> {
// 		if(a[key] == val) {
// 			return a[return];
// 		}
// 	});
// };



/*
	===========================================================================================
	@arrayFind()
	 - Búsqueda de un array | retorna valor o array
	   arrayFind(array, [clave, valor], return_val(opcional));

	Ejm: nombres = [{ id:1,nombre:'Geoffrey' }, { id:2, nombre: 'Ivan' }, ...]
		 arrayFind(nombres, ['id',2])   		   =>  return  {id:2, name:'ivan'}
		 arrayFind(nombres, ['id',2], 'nombre')    =>  return 'ivan' | string or number
*
**/

window.findArray_ = (array_, key, getValue = undefined) => {
	newArray = array_.filter((item)=> item[key[0]] == key[1]);
	if(newArray.length > 0) {
		if(getValue === undefined) {
			return newArray[0];
		} else {
			return newArray[0][getValue];
		}
	} else {
		return undefined;
	}
} 

/*
	@textLang()
	- Extrae el valor del archivo JSON segun el idioma, default 'en'
*/
window.textLang = (string) => {
	arrayLang = JSON.parse(string.toLowerCase());
 
	return arrayLang[langApp.toLowerCase()] ? arrayLang[langApp.toLowerCase()] == '' ? arrayLang['en'] : arrayLang[langApp.toLowerCase()] : arrayLang['en'];

	//return string?JSON.parse(string.toLowerCase())[langApp.toLowerCase()]: console.error('Array no existe.');
}

/* 
	@prototype - val.round()
	Prototipo para rendondear numeros 
*/
Number.prototype.round = function(places) {
  	return +(Math.round(this + "e+" + places)  + "e-" + places);
}


/*
 * @toFirtLetterUpperCase 
 * {param} - string
 * Pone primera letra en Mayuscula
*/
window.toFirstLetterUpperCase = function (string) {
	string = string.toLowerCase();
	return string.charAt(0).toUpperCase() + string.slice(1);
};
/*
	Para modo visual de fecha
*/
window.dateString = function (date) {
	if(date == null) {
		lgg =  {
			es: 'Fecha del tour',
			en: 'Date your tour',
		};
		return lgg[langApp] ? lgg[langApp] : lgg['en'];
	}

	var nombres_meses = {
		es: [ 
			"", "de Enero de" ,	"de Febrero de", "de Marzo de"     , "de Abril de"  , "de Mayo de"     , "de Junio de", 
			"de Julio de" , "de Agosto de" , "de Septiembre de", "de Octubre de", "de Noviembre de", "de Diciembre de" 
		],
		en: [ 
			"", "January" ,	"February ", "March"     , "April"  , "May"     , "June", 
			"July" , "August" , "September", "October", "November", "December" 
		],
	}
	
	var fecha = moment(date);

	 dia = fecha.format('DD') ;
	 mes = fecha.format('M');
	 anio = fecha.format('YYYY');
	 
	fecha_humans = ""; 
	if(langApp == 'en') {
		fecha_humans = nombres_meses[langApp][mes]+' '+dia+', '+anio;
	} else {
		if(nombres_meses[langApp]) {
			fecha_humans =  dia+' '+nombres_meses[langApp][mes]+' '+anio;
		} else {
		fecha_humans =  dia+' '+nombres_meses["en"][mes]+' '+anio;		
		}
	}
	console.log(date);
	return fecha_humans;
};

/*
	@trans
	{param} - string
	Funcion utilizada para poder dar una visualizacion de un contenido según el idioma deseado
*/
window.trans = (string) => {
	traduccion_word = {

			//* Tiempo anticipacion*/
			info_tiempo_anticipacion1: {
				es: 'No puede seleccionar este horario, cambie a otra fecha o seleccione otro horario. El tiempo de la reserva debe ser',
				en: 'You can not select these times, change to another date or select another time. Reservation time must be',
			},
			info_tiempo_anticipacion2: {
				es: 'antes de iniciar el servicio.',
				en: 'before starting the service.',
			},
			hours: {
				es: 'horas',
				en: 'hours',
			},
			days: {
				es: 'dias',
				en: 'days',
			},
			minutes: {
				es: 'minutos',
				en: 'minutes',
			},
			/*
				Checkout availability
				https://web.incalake.com/en/checkout/availability
			*/
			'info_disponibilidad_contact': {
				es: 'Para ponernos en contacto con usted necesitamos que nos proporcione la siguiente información.',
				en: 'To contact us, we need you to provide us with the following information.',
			},
			'btn_consultar': {
				es: 'Consultar',
				en: 'Consult',
			},
			fecha_servicio: {
				es: 'Fecha de servicio',
				en: 'Date of service',
			},
			'success_send_disponibilidad': {
				es: 'Muchas gracias, recibimos sus datos satisfactoriamente!<br>Dentro de un máximo de 48 horas, uno de nuestros representantes de ventas se pondrá en contacto con usted para darle la respuesta de disponibilidad. <br>Por favor agregue a reservas@incalake.com a su lista de contactos, para evitar que nuestro correo le llegue a la carpeta de Spam.',
				en: 'Thank you, we receive your data satisfactorily! <br> Within a maximum of 48 hours, one of our sales representatives will contact you to give you the availability response. <br> Please add to reservas@incalake.com to your contact list, to prevent our mail from reaching your Spam folder.',
			},
			'contact_disponibilidad': {
				es: 'Si tu solicitud de disponibilidad es urgente, por favor, escribanos a reservas@incalake.com o llámenos a los siguientes números:<br><ul><li>+51 949755305</li> <li>+51 982769453 </li><li>+51 949755305</li></ul>',
				en: 'If your request for availability is urgent, please write to reservas@incalake.com or call us at the following numbers: <br> <ul> <li> +51 949755305 </ li> <li> +51 982769453 </ li > <li> +51 949755305</ li> </ ul>',
			},
			horario: {
				es: 'Horario',
				en: 'Schedule',
			},
			'title_solicitud_disponibilidad': {
				es: 'Solicitud de verificicación de disponibilidad de servicio',
				en: 'Verification request for service availability',
			},
			'info_servicio_bottom': {
				es: 'Si el servicio cuenta con disponibilidad, nos comunicaremos con usted lo mas antes posible para confirmar su reserva.',
				en: 'If the service is available, we will contact you as soon as possible to confirm your reservation.',
			},
			info_servicio_bottom2: {
				es: 'Para más detalles puede llamar al numero 98443431 o reservas@incalake.com',
				en: 'For more details you can call the number 98443431 or reservas@incalake.com',
			},
			info_nota_disponibilidad: {
				es: 'NOTA: El precio de este servicio puede estar sujeto alguna tasa e impuesto',
				en: 'NOTE: The price of this service may be subject to some tax and tax',
			},
			//msg-loading blockUI and unBlockUI
			'msg_loading_transaction': {
				es: 'Espere un momento porfavor, estamos procesando su reserva.',
				en: 'Please wait a moment, we are processing your reservation',
			},

			//Pasos para proceder la compra.
			paso_fecha_tour: {
				es: 'Seleccione la fecha de su tour.',
				en: 'Select the date of your tour.',
			}, 
			paso_hora_inicio_tour: {
				es: 'Seleccione la hora de inicio de su tour.',
				en: 'Select the start time of your tour.',
			},
			paso_numero_participantes: {
				es: 'Seleccione número de participantes.',
				en: 'Select number of participants.',
			},
			paso_realizar_compra: {
				es: 'Realizar la compra.',
				en: 'Make purchases.',
			},

			//

			'info_shop_recurso' : {
				es: 'Quizás te interese comprar algunos de estos artículos.',
				en: 'You may be interested in buying some of these items.',
			},
			//Formularios traduccion
			//https://web.incalake/checkout/customer
			name: {
				es: 'Nombre(s)',
				en: 'Name'
			},
			last_name: {
				es: 'Apellido(s)',
				en: 'Last Name',
			},
			email: {
				es: 'Correo electrónico',
				en: 'Confirm email'
			},
			phone: {
				es: 'Teléfono / celular',
				en: 'Phone Number'
			},
			country: {
				es: 'País',
				en: 'Country',
			},


			/*
			 	// traduccion component <precio-producto></precio-producto>
			*/
			total: {
				es: 'Total',
				en: 'Total',
			},
			actividad: {
				es: 'actividad',
				en: 'actity',
			},
			edad: {
				es: 'Edad de ',
				en: 'Age of '
			},
			seleccione: {
				es: 'Seleccione',
				en: 'select',
			},
			guardar: {
				es: 'Guardar',
				en: 'Save'
			},
			horarios_disponibles: {
				es: 'horarios disponibles',
				en: 'schedules available',
			},
			comprar: {
				es: 'Comprar',
				en: 'Buy',
			},
			hora_inicio: {
				es: 'Hora de inicio ',
				en: 'Start time',
			},
			duracion: {
				es: 'duración',
				en: 'duration',
			},
			ver_mas_opciones: {
				es: 'Ver más opciones',
				en: 'See more options',
			},
			msg_tour_seleccionado: {
				es: 'Este tour ya ha sido seleccionado',
				en: 'This tour has already been selected',
			},
			tasa_e_impuesto: {
				es: 'Tasas de transacción',
				en: 'Transaction fees',
			},
			cupon_descuento:{
				es:'Aplicar cupón de descuento',
				en:'Apply discount coupon'
			},
			cupon:{
				es:'Cupón',
				en: 'Coupon',
			},
			ingrese_codigo_cupon:{
				es:'Ingrese su código de cupón',
				en:'Enter your coupon code',
			},
			aplicar_cupon:{
				es:'Aplicar Cupón',
				en:'Apply Coupon',
			},
			eliminar:{
				es: 'Eliminar Cupón',
				en: 'Delete Coupon',
			},
precio_sin_igv:{
				es:'Precio no incluye IGV',
				en:'Price does not include TAXES',
			},
			
			//Checkout/cart

			editar: {
				es: 'Editar',
				en: 'Edit',
			},
			quitar: {
				es: 'Quitar',
				en: 'Remove'
			},
			info_terminos_condiciones: {
				es: 'He leido los términos y condiciones',
				en: 'I have read terms and conditions',
			},
			terminos_condiciones: {
				es: 'Términos y condiciones',
				en: 'Terms and Conditions',
			},
			participantes: {
				es: 'Participantes',
				en: 'Participants'
			},
			fecha: {
				es: 'Fecha',
				en: 'Date',
			},
			seguir_comprando: {
				es: 'Seguir navegando',
				en: 'Continue browsing',
			},
			info_cache_duracion: {
				es: 'Guardaremos tu selección de artículos durante',
				en: 'We will save your selection of articles for',
			},
			info_carrito_vacio: {
				es: 'Tu carrito esta vacío',
				en: 'Your cart is empty',
			},
			tienes: {
				es: 'Tienes',
				en: 'You have'
			},
			articulo_carrito: {
				es: 'artículos en tu carrito',
				en: 'items in your cart',
			},
			resumen_compra: {
				es: 'Resumen de la compra',
				en: 'Purchase summary',
			},
			total_pagar: {
				es: 'Total a pagar',
				en: 'Total to pay',
			},
			continuar: 
			{
				es: 'Pagar',
				en: 'Pay',
			},

			tus_datos: {
				es: 'Información de Contacto',
				en: 'Contact Information',
			},
			continuar_pagar: {
				es: 'Continuar y Pagar',
				en: 'Continue and Pay',
			},
			cancelar: {
				es: 'Cancelar',
				en: 'Cancel',
			},
			total_a_pagar:{
				es: 'total a pagar',
				en: 'Total to pay',
			},
			modalidad_de_pago:{
				es: 'modalidad de pago: Pago minimo',
				en: 'Modality of Payment: Minimum payment',
			},
			paga_ahora:{
				es: 'pagar ahora',
				en: 'pay now',
			},
			paga_al_llegar:{
				es: 'pagar al llegar',
				en: 'pay upon arrival',
			},
			txt_pago_igv:{
				es: 'Considere que el pago del impuesto general a las ventas (IGV o IVA) es obligatorio según las leyes, la exoneración de este impuesto aplica solamente a gastos de alojamientos, todos los demás servicios si aplican al impuesto.',
				en: 'Consider that according to the legislation it is mandatory to pay the general sales tax (IGV). Only accommodation costs exempted from paying this tax, all other services do applied.',
			},
			precio_minimo:{
				es:'Activar / Desactivar precio mínimo',
				en:'Activate / Deactivate minimum price',
			},
			txt_tooltip_precio_minimo:{
				es:'Si aplica esta opción, puede pagar un precio mínimo para garantizar su reserva, el resto lo debe de pagar en EFECTIVO en la ciudad destino.',
				en:'If you check this option, you can pay a minimum amount to guarantee your booking, the difference must to be paid in CASH on destination city.',
			},
			//checokit/confirm
			info_pago_realizado: {
				es: 'Tu pago se ha realizado con éxito.',
				en: 'Your payment was successful.',
			},
			guia: {
				es: 'Guia',
				en: 'Guide',
			},
			guia_vivo: {
				es: 'Guia de tour en vivo',
				en: 'Live tour guide',
			},
			guia_audio: {
				es: 'Audio guia',
				en: 'Audio guide',
			},
			guia_folleto: {
				es: 'folletos informativos',
				en: 'information leaflets',
			},
			guia_notiene: {
				es: 'No',
				en: 'Do not',
			},

		}

	return traduccion_word[string][langApp] ? traduccion_word[string][langApp]: traduccion_word[string]['en'];
};




