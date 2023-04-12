 /*
 	@lang = es  | default
	*****   <html lang="es"> 
*/
window.igv = 5;
window.lang = document.getElementsByTagName('html')[0].getAttribute('lang') ? document.getElementsByTagName('html')[0].getAttribute('lang') : 'es';
//document.getElementsByTagName("H1")[0].getAttribute("class");
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
	===========================================================================================
	@arrayFind()
	 - Búsqueda de un array | retorna valor o array
	   arrayFind(array, [clave, valor], return_val(opcional));

	Ejm: nombres = [{ id:1,nombre:'Geoffrey' }, { id:2, nombre: 'Ivan' }, ...]
		 arrayFind(nombres, ['id',2])   		   =>  return  {id:2, name:'ivan'}
		 arrayFind(nombres, ['id',2], 'nombre')    =>  return 'ivan' | string or number
*
**/

window.arrayFind = (array_, key, getValue = undefined) => {
	newArray = array_.filter((item)=> item[key[0]] == key[1]);
	if(newArray.length > 0) {
		if(getValue === undefined) {
			return newArray[0];
		} else {
			return newArray[0][getValue];
		}
	} else {
		return false;
	}
} 

/*
	@textLang()
	- Extrae el valor del archivo JSON segun el idioma
*/
window.textLang = (string) => {
	return string?JSON.parse(string.toLowerCase())[lang.toLowerCase()]: console.error('Array no existe.');
}

Date.prototype.yyyymmdd = function() {
  var mm = this.getMonth() + 1; // getMonth() is zero-based
  var dd = this.getDate();

  return [this.getFullYear()+'-',
          (mm>9 ? '' : '0') + mm+'-',
          (dd>9 ? '' : '0') + dd
         ].join('');
};

Number.prototype.round = function(places) {
  return +(Math.round(this + "e+" + places)  + "e-" + places);
}

window.toFirstLetterUpperCase = function (string) {
	string = string.toLowerCase();
	return string.charAt(0).toUpperCase() + string.slice(1);
};

window.dateString = function (date) {
	if(date == null) {
		lgg =  {
			es: 'Seleccione su fecha de su tour',
			en: 'Select the date of your tour',
		};
		return lgg[lang];
	}
	var nombres_meses = {
		es: [ 
			"de Enero de" ,	"de Febrero de", "de Marzo de"     , "de Abril de"  , "de Mayo de"     , "de Junio de", 
			"de Julio de" , "de Agosto de" , "de Septiembre de", "de Octubre de", "de Noviembre de", "de Diciembre de" 
		],
		en: [ 
			"January" ,	"February ", "March"     , "April"  , "May"     , "June", 
			"July" , "August" , "September", "October", "November", "December" 
		],
	}
	
	var fecha = new Date(date);
	 dia = fecha.getDate() + 1 ;
	 mes = fecha.getMonth();
	 anio = fecha.getFullYear();
	 
	if(lang == 'en')
		return nombres_meses[lang][mes]+' '+dia+', '+anio;
	else
		return dia+' '+nombres_meses[lang][mes]+' '+anio;
};

window.trans = (string) => {
	traduccion_word = {
			//Formularios traduccion
			//https://web.incalake/checkout/customer
			name: {
				es: 'Nombre',
				en: 'Name'
			},
			last_name: {
				es: 'Apellido(s)',
				en: 'Last Name',
			},
			email: {
				es: 'Dirección de correo electrónico',
				en: 'Confirm email'
			},
			phone: {
				es: 'Telefono / celular',
				en: 'Phone Number'
			},
			country: {
				es: 'Pais',
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
				en: 'To Buy',
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
				es: 'He leido los terminos y condiciones',
				en: 'I have read terms and conditions',
			},
			terminos_condiciones: {
				es: 'Terminos y condiciones',
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
				es: 'Seguir comprando',
				en: 'Keep buying',
			},
			info_cache_duracion: {
				es: 'Guardaremos tu selección de artículos durante 15 minutos',
				en: 'We will save your selection of articles for 15 minutes',
			},
			info_carrito_vacio: {
				es: 'Tu carrito esta vacio',
				en: 'Your cart is empty',
			},
			tienes: {
				es: 'Tienes',
				en: 'You have'
			},
			articulo_carrito: {
				es: 'articulos en tu carrito',
				en: 'items in your cart',
			},
			resumen_compra: {
				es: 'Resumen de compra',
				en: 'Purchase summary',
			},
			total_pagar: {
				es: 'Total a pagar',
				en: 'Total to pay',
			},
			continuar: 
			{
				es: 'Continuar',
				en: 'Continue',
			},

			tus_datos: {
				es: 'Tus datos',
				en: 'Your data',
			},
			continuar_pagar: {
				es: 'Continuar y pagar',
				en: 'Continue and pay',
			},
			cancelar: {
				es: 'Cancelar',
				en: 'Cancel',
			}
		}

	return traduccion_word[string][lang];
};
