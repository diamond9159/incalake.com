/**
 * Tiempo de duración de la Cookie
*/

var expireCookie = new Date(); //Fecha actual
var minutes_ = 30; //Minutos en que va a durar la Cookie
expireCookie.setTime(expireCookie.getTime() + (minutes_ * 60 * 1000)); //Generamos el tiempo para dar el tiempo de expiración de la Cookie

/*
* @vue
  {var, function} Todas las variables o funciones utilizadas con Vue.*** son para ser utilizadas en cada una de las vistas del componente.
  Todas las variables y functiones estan siendo heredadas del archivo Helper.js
*/
Vue.prototype.minuto_cache = minutes_;
Vue.prototype.langApp = langApp;  //Heredada de helpers.js - Idioma de la página
Vue.round = (string) => string.round(2); //Heredada de helpers.js - Redondea 
Vue.prototype.textLang = (string) => textLang(string);  //Heredada de helpers.js - Extrae de un archivo json el valor segun el idioma
Vue.prototype.dateString = (string) => dateString(string); //Heredada de helpers.js - Convierte fecha en modo textual
Vue.prototype.trans = (string) => trans(string); //Heredada de helpers.js  - Traduce palabras definidas en diferentes idiomas
/*
* Componente <producto-cart> 
* El cliente selecciona su fecha de servicio, horario, la cantidad de personas que van a participar del tour
*/
function cambiarZonaHoraria(elm){
  var zona = elm.val().split('-');
  elm.siblings('p').find('small').html(zona[2]==' BT'?'*BT: Bolivian Time':'*PT: Peruvian Time'); 
}

Vue.component('producto-cart', {
  template: `
    <div class="card">
      <div class="card-header bg-primary text-light text-center" style="padding:0.45rem;">
          {{cart.producto.titulo_producto}}
      </div>
      <div class="card-body container-fluid" v-show="!loading" style="background:#f9f9f9; ">
        <div class="row">
          <div class="col-12 col-sm-12" :class="{ 'col-md-5' : !editar }">  <!-- @data {editar} agrega la clase 'col-md-5' segun su valor -->
            <div id="calendario-tour" >
              <strong class="title-paso p-1 text-primary">1 {{ trans('paso_fecha_tour') }}</strong>
              <!-- Formulario de fecha de servicio  -->
              <div class="in" class="form-cart" :id="'content_fecha_tour_'+producto_id" @click="mostrarCalendario=true" style="background:#fff;">  <!-- @click {mostrarCalendario}  cambia el valor al hacer click -->
                &nbsp; <i class="fa fa-calendar text-primary" aria-hidden="true"></i> &nbsp; 
                {{ dateString(fecha_servicio) }} <!-- Ejecuta la funcion de Vue.prototype.dateString() -->
              </div>
               <!-- Elemento donde se dibujo o coloca el calendario del tour -->
              <div :id="'calendar-tour-'+producto_id" class="calendar" v-show="mostrarCalendario"></div>
            </div>
            <div>           
              <strong class="title-paso p-1 text-primary">2 {{ trans('paso_hora_inicio_tour') }}</strong>
              <!-- Seleccion de horario -->
              <select onchange="cambiarZonaHoraria($(this))" class="form-cart" v-model="horario" :id="'content_horario_tour_'+producto_id">
                <option value="" disabled>{{ trans('seleccione') }}</option>
                <option :value="h.hora+' - '+h.duracion +' - '+ h.zona_horaria" v-for="h in cart.producto.horarios"> 
                  {{ trans('hora_inicio') }} : {{ h.hora }} - {{ trans('duracion') }} : {{ h.duracion }} &nbsp; *[{{ h.zona_horaria }}]
                </option>               
                </select>
                <p><small></small></p>
                <span class="error" v-html="info_horario"></span> <!-- v-html muestra el contenido con renderizado hmtl-->
            </div>
          </div>
          <div class="col-12 col-sm-12" :class="{ 'col-md-5' : !editar }"  @click="mostrarCalendario=false">
            <strong class="title-paso p-1 text-primary" :id="'content_personas_tour_'+producto_id">3 {{ trans('paso_numero_participantes') }}</strong>
            <div class="col-sm col-md-12" style="padding:0;">
              <div class="row" style="margin:0;padding:3% 0;" v-for="p, index in cart.precios_etapa" v-show="p.visible">
                <div class="col col-sm col-md-4 text-etapa-edad">
                  <strong>{{ p.descripcion_etapa_edad }} {{ p.descripcion_nacionalidad }} </strong> 
                  <span>{{ trans('edad') }} {{ p.edad_minimo }} - {{ p.edad_maximo }}</span>
                </div>
                <div class="col col-sm col-md row text-right" >
                  <div class="col-12 col-sm-12 col-md text-center" style="padding:1%;">
                    {{ precioPersona(p.precios,index).toFixed(2) }} USD
                  </div>
                  <div class="col-12 col-sm-12 col-md-auto" style="padding:0;">
                    <button @click="cantidadMinima(index)"  class="btn-cantidad bg-primary">-</button>
                    <input type="text" v-model="p.cantidad"  class="input-cantidad"/> <!-- v-model valor que puede ser alterado data-binding -->
                    <button @click="cantidadMaxima(index)"  class="btn-cantidad bg-primary">+</button>
                    
                  </div>
                </div>
              </div>
              <a href="#" @click="mostrarPreciosPersona($event);" v-show="btnVerMasOpciones" class="text-right more-person">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>  {{ trans('ver_mas_opciones') }}
              </a>
            </div>
            <div class="col-sm col-md" :class="{ 'ammount' : editar }">
              <strong>TOTAL</strong>
              <strong style="font-family: Arial;">
                <del v-if="precio_normal.toFixed(2) != precio_descuento() " style="color:#c37c48;"> {{ precio_normal.toFixed(2) }} </del> 
                &nbsp; {{ precio_descuento() }} USD
              </strong>
              <div v-html="info_personas" class="error"></div>
            </div>
            
          </div>
          <div class="col-12 col-sm-12 col-md-2"  v-if="!editar">
            <strong class="title-paso p-1 text-primary">4 {{ trans('paso_realizar_compra') }}</strong>
            <p class="mb-0 text-center">
              <!--  
                * Boton para añadir al carro el tour 
                * :disabled {params} true or false
              -->
              <button type="submit" class="btn-cart-add mb-4"  @click="store('crear')">
                {{ cart.producto.requerir_disponibilidad ? 'Consultar Disp.' : trans('comprar') }} 
                <i class="fa fa-chevron-right"></i>
              </button>
            </p>
          </div>
        </div>
        <!-- Contenedor habilitado en modo edicacion para guardar la edicion o cambios que se realize al tour. -->
        <div class="row" v-show="editar">
          <div class="col-12" style="padding:0px;padding-top: 20px;">           
            <button 
              type="button" 
              class="btn btn-primary float-left" 
              @click="store('actualizar')"
              data-dismiss="modal"
              style="width:49%"
              :disabled="desabilitarBottomComprar"
            >{{ trans('guardar') }}</button>
            <button 
                type="button" 
                class="btn btn-default float-right" 
                data-dismiss="modal"
                style="width:49%"
            >{{ trans('cancelar') }}</button>
          </div>
        </div>
      </div>
      <div :class="{ 'msg-tour-selected' : tour_selected }" v-show="tour_selected">
          {{ trans('msg_tour_seleccionado') }}
      </div>
      <!-- Contenedor habilitado al proceso de carga - Loading... -->
      <div class="container-fluid" v-show="loading">
        <div class="row">
          <div class="col-12 text-center"><img src="/assets/icon/25.gif"></div>
        </div>
      </div>
    </div>
  `,
  /*
    {prop} Propiedades que son pasadas al componente 
  */
  props: {
    producto_id: {  // Id del producto que va utilizar el componente
      type: Number,
    },
    editar: {   // Atribute que recibira el componente si va a estar en modo edición, por defecto es falso
      type: Boolean,
      default: false,
    },
    datacliente: Array, // Array del tour o producto que el usuario a seleccionado, solo se utilizara para el modo edición
  }, 
  /*
    {data} definición de variables que van a ser utilizadas en el componente, para llamar la variable es necesario utilizar [this] - Ej. this.loading 
  */
  data: function () {
    return {
      cart: {   //Variable de tipo array que va a recibir los datos el producto
        producto: {
          horarios: [],
          requerir_disponibilidad: 0,
        },
        precios_etapa: []
      },
      flag: 0, 
      mycart: [], // Variable donde va a ser almacenda los tour seleccionados del cliente
      btnVerMasOpciones: true, //
      desabilitarBottomComprar: false, // Varuable que habilitara o deshabilitara el boton para realizar la compra
      descuento: this.datacliente ? this.datacliente.descuento : 0, //Variable para almacenar el descuento de oferta que va a recibirse por el producto, segun la fecha seleccionada - TAMBIEN SERVIRA PARA EL MODO EDICIÓN
      fecha_servicio: this.datacliente ? this.datacliente.fecha_servicio : null, //Variable para almacenar la fecha de servicio
      horario: this.datacliente ? this.datacliente.horario : '', // Variable para almacenar el horario del servicio
      info_horario: '', // Informacion que se va dar
      loading: true, //Variable que permite mostrar el loading al proceso de la carga  dek servucui
      mostrarCalendario: false, //Permite mostrar el calendario o ocultarla / v-show="mostrarCalendario"
      precio_total: 0, //Precio total del tour [NOTA: INCLUYE EL DESCUENTO]
      precio_normal: 0, //Precio normal sin aplicar ningun descuento
      precios_personas: [],  
      tour_selected: false,
      info_personas:'',
    }
  },

  /*
   @mounted
   Ejecuta automaticamente  todo lo que hay dentro
  */
  mounted() {   
    
   

    /*
    * AJAX - PETICION DE TIPO @get 
    * Api que va ser consultado segun el Id del producto
      Muestra todo los datos necesario para mostrar el carro de compras como horarios, fecha disponiles, ofertas, ...
      Ej. <produto-cart producto_id="2">   -    web.incalake.com/api/producto/cart?id=2 
    */

    axios.get(base_url+'api/producto/cart?id='+this.producto_id).then((response) => {
      console.log(response.data);
      this.cart = response.data;  // Almacenamos el resultado de la consulta en la variable this.cart

      precios_etapa = this.cart.precios_etapa;
                this.cart.precios_etapa = [];
        
        precios_etapa.forEach((e, index) => {
          this.cart.precios_etapa.push({
            visible: index == 0 ? true : false, //Permite solo mostrar el primer elemento de los precios x persona
            id_nacionalidad: e.id_nacionalidad,
            id_etapa_edad: e.id_etapa_edad,
            cantidad: this.editar ? this.remplazarCantidadPersona(e.id_etapa_edad, e.id_nacionalidad) : e.cantidad, // Para modo edición reemplazamos los datos de usuario seleccionado 
            edad_minimo: e.edad_minimo,
            edad_maximo: e.edad_maximo,
            descripcion_etapa_edad:   langApp == 'es' ? e.descripcion_etapa_edad :   textLang(e.traducciones_etapa_edad),             
            descripcion_nacionalidad: langApp == 'es' ? e.descripcion_nacionalidad : textLang(e.traducciones_nacionalidad),
            precios: e.precios,
          });
        });

          this.calendar(this.cart.disponibilidad, this.cart.bloqueos, this.cart.ofertas); // Ejecuta la funcion calendar() para generar el calendario
          this.loading = false; //Una vez realizada la consulta ocultamos el proceso de  visualización de carga ...
          
          if(this.cart.precios_etapa.length == 1) { //Si solo hay un tipo persona de etapa_edad  ocultamos el boton "ver_mas_opciones"
            this.btnVerMasOpciones = false;
          }
          if(this.editar) { //Ejecuta si esta en modo edición
            this.mostrarPreciosPersona(); // Si estamos en modo edición mostramos todos los precios por persona
          } else {
             this.checkSelectedTour(); //Verifica si ya se añadio el tour al carro
          }
        });
  },
  /*
    watch 
    Detecta si hay algun cambio en la variable 
  */

  watch: {
    fecha_servicio () {   // variable this.fecha_servicio
      this.validarHorario(); 
    },
    horario () { // variable this.horario
      this.validarHorario();
    },
    cart: { // variable this.cart  -> Como los cambios se realizan en el array se define de otra forma
      handler: function (change) //Ejecuta si hay cambio en el array
      {               
        this.precio_normal = 0; 
        this.precio_total = 0;

        change.precios_etapa.forEach((item, index) => {
          if(item.cantidad < 0) this.cart.precios_etapa[index].cantidad = 0; // Validamos que cantidad de personas no sea menor a cero

          if(item.cantidad > this.cart.producto.capacidad) {          // Validamos que la cantidad de personas no pase el aforo
            this.cart.precios_etapa[index].cantidad = this.cart.producto.capacidad;
          }
          // this.precio_normal += parseInt(item.cantidad) == 0 ? 0 : parseFloat(this.preciosPersona(item.precios, index)) * this.descuento; 

          this.precio_normal += parseInt(item.cantidad) == 0 ? 0 : parseFloat(this.preciosPersona(item.precios, index)); 
        });

        /* 
          @validacion
          Filtramos las personas por etapa que tienen una cantidad > 0 en el carro 
        */

        this.precios_personas = change.precios_etapa.filter((persona) => persona.cantidad > 0); 

        if(this.precios_personas.length == 0) { //Sino hay ninguna persona para comprar deshabilitamos el boton comprar
          this.desabilitarBottomComprar = true;
          // alert("");
          $("#content_personas_tour_"+this.producto_id).addClass('text-danger');
          this.info_personas="1 persona como minimo";
        } else { 
          $("#content_personas_tour_"+this.producto_id).removeClass('text-danger');
          this.info_personas='';
          if(this.fecha_servicio && this.horario){
            this.desabilitarBottomComprar = false;
          }
        }

        if(this.flag > 0 && this.precios_personas.length != 0) { //Validaciones
          this.validarHorario();
        } else {
          this.flag++;
        }
      },
      deep: true, 
    },
  },
  methods: {
    checkSelectedTour() {  //Verificamos si el producto ya ha sido añadido al carrito
        if(Cookies.get('cart')) {
           selected =  JSON.parse(Cookies.get('cart'));
           selected.forEach((c) => {
              if(c.producto_id == this.producto_id) {
                this.tour_selected = true;
              }
           });
        }
    },
    precio_descuento () { // Precio aplicado con descuento
      precio = this.precio_normal - ( this.precio_normal * this.descuento / 100 ).toFixed(2);
      this.precio_total = precio;
      return precio.round(2).toFixed(2); 
    },
    cantidadMinima(index)  
    {
      this.cart.precios_etapa[index].cantidad--; // Disminuimos la cantidad de personas
    },
    cantidadMaxima(index) 
    {
      this.cart.precios_etapa[index].cantidad++; // Aumentamos la cantidad de personas
    },

    precioPersona(precios,index) { //Retorna el precio de las personas segun su precio unitario
    
      var precioFinal = 0;
      precio = findArray_(precios, ['cantidad', this.cart.precios_etapa[index].cantidad], 'monto'); //findArray_() busqueda de array ->  helpers.js
      cantidad = this.cart.precios_etapa[index].cantidad;

      if(precio == undefined) {
        if(cantidad == 0) {
          precioFinal = this.maxPrecio(precios); 
        } else {
          precioFinal = this.minPrecio(precios);
        } 
      } else {
        precioFinal = precio;
      }

      return parseFloat(precioFinal).round(2);
    }, 

    preciosPersona(precios,index) { //Retorna el precio de las personas segun su precio unitario, pero multiplicada por la cantidad de personas
    
      var precioFinal;

      precio = findArray_(precios, ['cantidad', this.cart.precios_etapa[index].cantidad], 'monto'); //findArray_() busqueda de array ->  helpers.js
      cantidad = this.cart.precios_etapa[index].cantidad;

      if(precio == undefined) {     
        if(cantidad == 0) { 
          precioFinal = this.maxPrecio(precios) * 1;
        } else {
          precioFinal = this.minPrecio(precios) * cantidad;
        }
      } else {
        precioFinal = precio * cantidad; 
      } 
      
      this.cart.precios_etapa[index].precio = precioFinal; 

      return precioFinal % 1 == 0 ? precioFinal.round(2) : precioFinal.round(2); 
    }, 

    mostrarPreciosPersona(event) { //Mostras todos los precios x persona etapa | nacionalidad
      if (event) event.preventDefault();
      this.cart.precios_etapa.forEach((p, index) => p.visible = true); //Ver todos los precios por persona, etapa | nacionalidad
      this.btnVerMasOpciones = false; //Ocultamos el boton ver más opciones
    },
    remplazarCantidadPersona(id_etapa_edad, id_nacionalidad) { //Para modo edicion - Reemplazamos las cantidad seleccionadas por persona segun su etapa
      cantidad = 0;
      this.datacliente.personas.forEach((item) => {
        if(item.id_etapa_edad+''+item.id_nacionalidad == id_etapa_edad+''+id_nacionalidad) { //Buscamos que sean de un mismo tipo
          cantidad = item.cantidad;
        }
      });
      return cantidad;
    },
    store(tipo) {   //Funcion para almacenar el producto a Comprar
      this.mycart = [];
      personas = [];
      
      this.precios_personas.forEach((persona, index)=> {
        personas.push({
          id_etapa_edad: persona.id_etapa_edad,
          id_nacionalidad: persona.id_nacionalidad,
          descripcion_etapa_edad: persona.descripcion_etapa_edad,
          descripcion_nacionalidad: persona.descripcion_nacionalidad, 
          cantidad: persona.cantidad,
          precio: persona.precio - (persona.precio * this.descuento) / 100, 
        });
      });
      /*
        @variable 
        this.mycart - Array que va a ser almacenado en la Cookie
      */
      this.mycart.push({
        producto_id: this.producto_id, //id del producto
        tasas_impuestos: parseFloat(this.cart.producto.tasas_impuestos), //tasa e impuesto que se aplicara al producto
        img_thumb: this.cart.producto.img_thumb, //Url Imagen minuatura
        guia: this.cart.producto.guia,  //Guia que tiene el tor
        img: this.cart.producto.img, //Url de la imagen real
        url: window.location.href, // Direccion de página del tour
        descuento: this.descuento, // Descuento a realizarse segun la fecha seleccionada [Oferta],
        fecha_servicio: this.fecha_servicio, //Fecha en que se va a prestar el servicio
        horario: this.horario, //Horario que va a iniciar el servicio 
        titulo_producto: this.cart.producto.titulo_producto, //Nombre del producto o tour
        precio_normal: this.precio_normal, //Precio normal sin aplicar descuento de oferta, ni tasa
        total: this.precio_total, //Precio con aplicacion de descuento de oferta
        personas: personas, //Personas
      });
      
      if(tipo == 'crear') { //Se ejecutará si se esta añadiendo un nuevo producto

        if(this.fecha_servicio)  //Validamos si existe fecha seleccionada por el cliente
                { 
                $("#content_fecha_tour_"+this.producto_id).removeClass('text-danger border border-danger');
                  if(this.horario) //Validamos que el horario hayga sido seleccionado
                  { 
                    $("#content_horario_tour_"+this.producto_id).removeClass('text-danger border border-danger');
                    tiempo_anticipacion = this.cart.producto.tiempo_anticipacion.split(":"); //Capturamos el tiempo de anticipación y lo separamos para convertirlo a minutos, horas o dias.

                    horario = moment(this.horario.split('-')[0], ['h:mm A']).format('HH:mm'); // Seleccionamos el horario de servicio que el cliente realiza para la compra.
                    tiempo = ["minutes", "hours", "days"]; // Variables que van a ser utilizadas para calcular la disponibilidad de la reserva en dicho horario.
                    fecha_seleccionada = Date.parse(moment(this.fecha_servicio).format('YYYY-MM-DD')+' '+horario); // Convertimos a una fecha con el horario de servicio para validar su disponibilidad
                    fecha_seleccionada = moment(fecha_seleccionada);
                    fecha_minima_reserva = fecha_seleccionada.subtract(tiempo_anticipacion[0], tiempo[tiempo_anticipacion[1]]).format('YYYY-MM-DD HH:mm'); //Generamos la fecha minima de reserva
                    if(Date.parse(moment().format('YYYY-MM-DD HH:mm')) <= Date.parse(fecha_minima_reserva)) { // CONDICIONAL (fechaActual <= FechaMinimaReserva)
                      this.info_horario = "";
                      
                      cantidadPersona = this.cart.precios_etapa.filter((persona) => persona.cantidad > 0); // Filtramos si hay personas seleccionadas
                      if(cantidadPersona.length > 0) {  //Validamos  si existe por lo menos una persona seleccionada
                        $("#content_personas_tour_"+this.producto_id).removeClass('text-danger');
                        // this.desabilitarBottomComprar = false; //Habilitamos el boton comprar si se cumple la condición
                        if(Cookies.get('cart')) { 
                          var carrito = JSON.parse(Cookies.get('cart'));
                          carrito.push(this.mycart[0]);
                          Cookies.set('cart', carrito,{ expires : expireCookie });
                        } else {
                          Cookies.set('cart', this.mycart, { expires : expireCookie });
                        }

                        if(Boolean(this.cart.producto.requerir_disponibilidad)){ //Verificamos si el producto require disponibilidad
                          Cookies.remove('cart');
                          Cookies.set('disponibilidad', this.mycart, {expires:expireCookie});
                          window.location.href = base_url+langApp+'/checkout/availability';
                        } else {
                          window.location.href = base_url+langApp+'/checkout/cart'; 

                        }
                      }else{
                        $("#content_personas_tour_"+this.producto_id).addClass('text-danger');
                      }
                      
                    } else {            
                      // this.info_horario = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '+trans('info_tiempo_anticipacion1')+" <strong style='font-weight:bold;'>"+tiempo_anticipacion[0]+' '+trans(tiempo[tiempo_anticipacion[1]])+'</strong> '+trans('info_tiempo_anticipacion2');
                      // this.desabilitarBottomComprar = true;
                      $("#content_fecha_tour_"+this.producto_id).addClass('text-danger border border-danger');
                    }
                    
                  } else {
                    this.info_horario = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Seleccione un horario';
                    $("#content_horario_tour_"+this.producto_id).addClass('text-danger border border-danger');
                    // this.desabilitarBottomComprar = true;

                  }
                } else {
                  $("#content_fecha_tour_"+this.producto_id).addClass('text-danger border border-danger');
                  this.info_horario = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Seleccione una fecha';
                  // this.desabilitarBottomComprar = true;
                  console.log(this.horario);
                }

                 
        }

        if(tipo == 'actualizar') {  //Se ejecutará si se esta editando el producto
        this.$emit('update', this.mycart[0]);
        }
      

    },
    minPrecio: function (precios) { 
          var temp_ = [];
          precios.forEach(function (item) {
            temp_.push(item.monto);
      });
          return Math.min.apply(null, temp_); //Retornamos el precio menor de un array
    },

        maxPrecio: function (precios) {
            var temp_ = [];
            precios.forEach(function (item) {
                temp_.push(item.monto);
            });
            return Math.max.apply(null, temp_); //Retornamos el precio mayor de un array
        },
    validarHorario ()  //Validación de horario segun el tiempo de anticipacion de la reserva del producto
    {         
      this.info_horario = '';
      // this.info_personas='';
      $("#content_fecha_tour_"+this.producto_id).removeClass('text-danger border border-danger');
      if(this.fecha_servicio)  //Validamos si existe fecha seleccionada por el cliente
      { 
        if(this.horario) //Validamos que el horario hayga sido seleccionado
        { 
          $("#content_horario_tour_"+this.producto_id).removeClass('text-danger border border-danger');
          tiempo_anticipacion = this.cart.producto.tiempo_anticipacion.split(":"); //Capturamos el tiempo de anticipación y lo separamos para convertirlo a minutos, horas o dias.

          horario = moment(this.horario.split('-')[0], ['h:mm A']).format('HH:mm'); // Seleccionamos el horario de servicio que el cliente realiza para la compra.
          tiempo = ["minutes", "hours", "days"]; // Variables que van a ser utilizadas para calcular la disponibilidad de la reserva en dicho horario.
          fecha_seleccionada = Date.parse(moment(this.fecha_servicio).format('YYYY-MM-DD')+' '+horario); // Convertimos a una fecha con el horario de servicio para validar su disponibilidad
          fecha_seleccionada = moment(fecha_seleccionada);
          fecha_minima_reserva = fecha_seleccionada.subtract(tiempo_anticipacion[0], tiempo[tiempo_anticipacion[1]]).format('YYYY-MM-DD HH:mm'); //Generamos la fecha minima de reserva
          if(Date.parse(moment().format('YYYY-MM-DD HH:mm')) <= Date.parse(fecha_minima_reserva)) { // CONDICIONAL (fechaActual <= FechaMinimaReserva)
            this.info_horario = "";
            
            cantidadPersona = this.cart.precios_etapa.filter((persona) => persona.cantidad > 0); // Filtramos si hay personas seleccionadas
            if(cantidadPersona.length > 0) {  //Validamos  si existe por lo menos una persona seleccionada
              this.desabilitarBottomComprar = false; //Habilitamos el boton comprar si se cumple la condición
            }
            
          } else {            
            this.info_horario = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '+trans('info_tiempo_anticipacion1')+" <strong style='font-weight:bold;'>"+tiempo_anticipacion[0]+' '+trans(tiempo[tiempo_anticipacion[1]])+'</strong> '+trans('info_tiempo_anticipacion2');
            this.desabilitarBottomComprar = true;
          }
        } else {
          this.desabilitarBottomComprar = true;
        }
      } else {
        this.info_horario = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Seleccione una fecha antes de elegir el horario';
        this.desabilitarBottomComprar = true;
      }
    },

    /** Método para generar el calendario 
     *  @params {arrayUnidimensional, array, array} - ({}, [], [])
     *  Permite generar el calendario segun los dias disponibles, bloqueados, ofertados
     *  API - Ej. https://web.incalake.com/api/producto/cart?id=11
    */
    calendar (disponibilidad, bloqueos, ofertas) {   

      var this_ = this;

      var diasDisponibles = []; //Variable para almacenar los dias habilitados del calendario
      var diasBloqueados = [];  //Variable para almacenar los dias que van a ser bloqueados
      var diasOfertados = [];   //Variable para almacenar los dias que van a ser ofertados

      var dataCalendar = [];    //Variable para habilitar los dias disponibles en el calendario   
      var diasActivos = JSON.parse(disponibilidad.dias_activos); // Dias de la semana que van a estar activos (Ej. Lun, ...)
      
      const range = moment.range(disponibilidad.fecha_inicio, disponibilidad.fecha_fin); //Extraemos el rango de entre dos fechas 
      for(let d of range.by('days')) {  
        if(exitItemArray(diasActivos, d.day())) {
          if(d.format('YYYY-MM-DD') >= moment().format('YYYY-MM-DD')) {
            diasDisponibles.push(d.format('YYYY-MM-DD')); // Almacenos los dias en formato YYYY-MM-DD
          }
        } 
      }

      bloqueos.forEach((b)=> {   // Recorremos las fechas que van a ser bloqueados por el sistema
        rangoFechaBloqueo = moment.range(b.fecha_inicio, b.fecha_fin);
        for(let diaB of rangoFechaBloqueo.by('days')) {
          diasBloqueados.push(diaB.format('YYYY-MM-DD')); //Almacenamos los dias que van a bloqueados
        }
      });

      ofertas.forEach((o) => {
        rangoFechaOferta = moment.range(o.fecha_inicio, o.fecha_fin);
        for(let diaOf of rangoFechaOferta.by('days')) {
          if(diaOf.format('YYYY-MM-DD') >= moment().format('YYYY-MM-DD')) {
            diasOfertados.push({ 
              date: diaOf.format('YYYY-MM-DD'),
              valor: o.valor_oferta,
            });
          }
        }
      });

      diasBloqueados.forEach((dblq)=> {   // Recorremos los dias que son bloqueados para su eliminacion
        removeItemFromArray(diasDisponibles,dblq);   // Eliminamos los dias bloqueados
      });

      diasDisponibles.forEach((d) => {
        dataCalendar.push({
          date: moment(d).format('YYYY-MM-DD'), 
          badge: false,
                    classname: 'day-ability',
                    oferta: findArray_(diasOfertados, ['date',d], 'valor'),
        });
      });

      /**
       * Funcion para graficar el calendario
       * zabuto_calendar
      */

      $("#calendar-tour-"+this.producto_id).zabuto_calendar(
      {
        language: langApp, //Idioma que va a utilizar el calendario
        year: this.fecha? moment(this.fecha).format('YYYY') : moment().format('YYYY'),
        month: this.fecha? moment(this.fecha).format('MM') : moment().format('MM'),
        data: dataCalendar,
        producto_id: this_.producto_id,
        action: function (data) { // La funcion se activa cuando se hace click en algun dia del calendario.   
          if($("#"+this.id).data("hasEvent")) {  // Validamos que el dia sea valido o un dia disponible       
            var valor_oferta = $("#" + this.id).data('oferta'); // capturamos el valor de la oferta que contiene ese dia
            $("#zabuto_calendar" + this_.producto_id + ' td div').removeClass('day-selected');
            $("#" + this.id + '_day').addClass('day-selected');
            this_.fecha_servicio = $("#" + this.id).data("date");
            this_.descuento = valor_oferta != undefined ? valor_oferta : 0;
            this_.mostrarCalendario = false; //Oculta el calendario
          }
          console.log($("#" + this.id).data("date"));

        },
        action_nav: function ()   { 
          setTimeout(function() { // No borar setTimeout() ejecuta solo en el desplazamiento de navegacion del calendario
            this_.drawOferta(ofertas); // Grafica las ofertas al navegador por el calendario
          });
        }
      });

      this.drawOferta(ofertas); 
    },

    drawOferta(ofertas) { // Ponemos las ofertas en el calendario de manera visual
      ofertas.forEach((o) => {
        
        rangoFechaOferta = moment.range(o.fecha_inicio, o.fecha_fin);

        for(let diaO of rangoFechaOferta.by('days')) 
        {
          if(diaO.format('YYYY-MM-DD') >= moment().format('YYYY-MM-DD')) {
            $("#zabuto_calendar" + this.producto_id + "_" + diaO.format('YYYY-MM-DD')).css({
              'position': 'relative',
            });   
            var daySelector = $("#zabuto_calendar" + this.producto_id + "_" + diaO.format('YYYY-MM-DD') + "_day");  
              daySelector.html((daySelector.html() + '<span class="day-oferta">-' + parseInt(o.valor_oferta) + '%</span>'));
          }
        }
      });
    }
  }
});

/*
* Componente <checkout-carro>
* Componente incluido en el directorio -> application/view/cart/checkout_cart.php
*/

Vue.component('checkout-carro', {
  template: `
    <div class="container">
      <div class="row">
        <div class="col-xl-7">
          <div class="checkout-title" socks style="line-height: 25px;">
            <div v-if="cart.length"> <!-- Verifica si hay productos en el carro, sino executa v-else -->
              {{ trans('tienes') }} {{ cart.length }} <!-- Muestra cantidad de productos que hay en el carro -->
              {{ trans('articulo_carrito') }}<br>
            </div>
            <div v-else> <!-- Muestra este sector si no hay productos en el carro -->
              {{ trans('info_carrito_vacio') }}
            </div>
            <small style="font-size:14px;">{{ trans('info_cache_duracion') }} {{ minuto_cache }} {{ trans('minutes') }}.</small>
          </div>
          
          <template v-for="c, index in cart">
            <div class="col-md-12 media div-activity" cart style="margin-bottom: 0px;">
              <div class="row div-full content-activity">
                <div class="  col-md-4 div-img-activity div-full">
                  <img class="img-card img-fluid img-activity" :src="c.img_thumb" alt="" :data-img="c.img" :title="c.titulo_producto" style="width: 100%;">
                  <div class="middle">
                    <div class="fa fa-search-plus"></div>
                  </div>    
                </div>
                <div class=" col-md-8 d-flex div-descripcion-prince">
                  <div class="row div-full d-flex align-items-end flex-column " style="width: 100%;margin: 0;">
                    <div class="" style="width: 100%;margin-top:10px">
                      <h5 class="mt-0">
                        <a :href="c.url"><strong style="color: black; font-family: Arial;">{{ c.titulo_producto }}</strong></a>
                      </h5>

                      <div class="media-labels">
                        <dt class="color-black">{{ trans('fecha') }}: </dt>
                        <span> {{ dateString(c.fecha_servicio) }} </span>
                      </div>
                      
                      <div class="media-labels" v-if="c.horario">
                        <dt class="color-black">{{ trans('hora_inicio') }} / {{ trans('duracion') }}: </dt>
                        <span>{{ c.horario }}</span>
                      </div>
                      <div class="media-labels" v-if="c.guia.tipo_guia != 'guia_nomostrar'">
                        <dt class="color-black">{{ trans('guia') }}: </dt>
                        <span>{{ trans(c.guia.tipo_guia) }} </span>
                        <span v-if="c.guia.lang">[</span> 
                          <span v-for="lang, index in c.guia.lang"><span v-if="index > 0">, </span>{{ lang }}</span>
                        <span v-if="c.guia.lang"> ]</span>
                      </div>
                      <div class="media-labels">
                        <dt class="color-black">{{ trans('participantes') }}: </dt>
                        <span v-for="p, index in c.personas">
                          <span v-if="index!=0">, &nbsp; </span>
                          {{ p.cantidad }} x {{ p.descripcion_etapa_edad }} {{ p.descripcion_nacionalidad }}
                        </span>
                      </div>
                      <div class="media-labels">
                        <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                           <input type="checkbox" checked class=" custom-control-input" disabled>
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-description">
                            <a href="#terminos" data-toggle="modal" data-target="#exampleModalLong" @click="terminosCondiciones(c.producto_id)" class="color-black" style="font-family: Arial;">
                              <strong><u>{{ trans('info_terminos_condiciones') }}</u></strong>
                            </a>
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header" style="background:#3f51b5;color:white;">
                                    <h5 class="modal-title">{{ trans('terminos_condiciones') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body" style="font-size: 14px;color: black;font-family: Source Sans Pro;color: black;">
                                    <div v-html="content_terminos_condiciones" v-show="!loading"></div>
                                    <p class="text-center"><div class="text-center"><img src="/assets/icon/25.gif"  v-show="loading"></div></p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>  
                          </span>
                        </label>
                      </div>
                    </div>
                    <div class="mt-auto " style="width: 100%;">
                        <div class="item-bottom-bar" style="width: 100%;">
                            <span class="float-left">
                                <a href="#" data-toggle="modal" :data-target="'#modalEditar'+index">
                                    <strong class="color-black"> {{ trans('editar') }} </strong>
                                </a>                
                                <!--- Modal editar producto -->
                                <div class="modal fade" :id="'modalEditar'+index"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">          
                                                <producto-cart :producto_id="c.producto_id" :editar="true"  :datacliente="c" @update="actualizarTour(index, $event)">                                      
                                                </producto-cart>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                              <!-- Modal editar producto -->

                            |   <a href="#" @click="eliminarTour($event, index)">
                                    <strong  class="color-black"> {{ trans('quitar') }} </strong>
                                </a>
                            </span>
                            <span class="price float-right">
                                <strong style="color:#f89e42;font-family: Arial;">
                                  <del v-if="c.precio_normal.toFixed(2)  != c.total.toFixed(2)">{{ c.precio_normal.toFixed(2) }}</del>   
                                </strong>                                            
                                <strong>{{ c.total.toFixed(2) }} </strong> USD
                            </span>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <recursos :producto_id = "c.producto_id"  @update="actualizarRecurso()"></recursos>
          </template>
          <div class="total-price" style="padding-right: 23px;" cart>
                        <strong> SUBTOTAL </strong>
                      <span>{{ total.toFixed(2) }} USD</span>
                    </div>                        
                    <a :href="'/'+langApp" class="btn btn-outline-success mt-2 mb-4">
                      <strong> {{ trans('seguir_comprando') }} &nbsp; </strong>
                      <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </a>
        </div>
        <div class="col-xl-5">
          <resumen-carro :cart="cart" :href="'/'+langApp+'/checkout/customer'" :next="cart.length != 0">{{ trans('continuar') }}</resumen-carro>
        </div>
      </div>
    </div>
  `,
  data: function () {
      return {
        cart: [],
        content_terminos_condiciones: '',
        modalEditarIndex: '',
        total: 0,
        loading: true, //login default
      }
    },
  mounted() {
    this.cart = JSON.parse(Cookies.get('cart')); //Cargamos lo elementos contenido el carro y lo asignamos a la variable this.cart 
  },
  methods: {
    terminosCondiciones(id) { //funcion de llamada al tour
      axios.get(base_url+'api/terminos?id='+id+'&&lang='+langApp).then((response) => {  // APi para visualizar los terminos y servicios del tour
        this.loading = false;
        this.content_terminos_condiciones = response.data;
        
      });
    },
    eliminarTour(event, index) { //Funcion que es ejecutada para eliminar un producto, recibimos el indice para eliminar ese array especifico
      if (event) event.preventDefault();
      Vue.delete(this.cart, index);  // Eliminamos el tour
      Cookies.set('cart', this.cart, {expires:expireCookie}); //Volvemos a asignar el nuevo valor a la Cookie

      if(this.cart.length == 0) { 
        Cookies.set('cart', []); 
        Cookies.remove('customer');
      }
      cart = JSON.parse(Cookies.get('cart'));
       $("#count-cart").text(cart.length); //Mandamos a visualizar el conteo realizado al carrito de compras.

    },
    actualizarTour(index, data) { //Funcion que realiza la actualizacion a la cookie al array especifico
    
      this.cart[index].descuento = data.descuento;
      this.cart[index].fecha_servicio = data.fecha_servicio;
      this.cart[index].horario = data.horario;
      this.cart[index].personas = data.personas;
      this.cart[index].precio_normal = data.precio_normal;
      this.cart[index].total = data.total;
      
      Cookies.set('cart', this.cart, {expires:expireCookie});
    
    },
    actualizarRecurso() { 
      this.cart = JSON.parse(Cookies.get('cart')); //
    }
  },
  watch: {
    cart: { //Ejecutada al detectar cualquier cambio en el array
      handler: function (change) {
        this.total = 0;
        change.forEach((c) => {
          this.total += c.total;
        }) ;
      },
      deep: true,
    }
  }
});

/*
* Resumen de compra - <resumen-carro>
* Componente incluido en el directorio -> application/view/cart/checkout_cart, checkout_customer, checkout_payment *.php
*/
Vue.component('resumen-carro', {
  template: `

    <div class="checkout-sumary"  style="font-family: Source Sans Pro" socks>
            <div class="subtitle">
                <strong style="font-weight: 600;font-size: 22px;"> {{ trans('resumen_compra') }}: </strong>
            </div>
            <template  v-for="c in cart">
                <div class="item-sumary">
                    <div class="row">
                        <div class="col-8">
                            <div class="">
                                {{ c.titulo_producto }} <br>
                                <span v-for="p, index in c.personas" style="font-size: 15px;">
                  <span v-if="index > 0">,</span> &nbsp;  {{ p.descripcion_etapa_edad }} {{ p.descripcion_nacionalidad }}  x {{ p.cantidad }}
                </span> 
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="extra">
                                <div v-show="cupon_valido">
                                  <strong style="font-weight: 600;"> 
                                    {{ c.precio_normal.toFixed(2) }} USD 
                                  </strong>
                                </div>
                                <div v-show="!cupon_valido">
                                  <strong style="font-weight: 600;">
                                    <del v-if="c.precio_normal.toFixed(2) != c.total.toFixed(2)" style="color: #d87a1e;">{{ c.precio_normal.toFixed(2) }}</del> 
                                    {{ c.total.toFixed(2) }} USD 
                                  </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                      

                <div class="item-sumary" v-for="r in c.recursos">
                    <div class="row">
                        <div class="col-8">
                            <div class="">
                               <strong> {{ r.nombre }} x {{ r.cantidad }}</strong> 
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="extra">
                                <strong style="font-weight: 600;">                                            
                                  {{ (r.precio * r.cantidad).toFixed(2) }} USD 
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>                          
            </template>
                <div class="item-sumary">
                    <div class="row">
                        <div class="col-8">
                            <div class="">
                               <strong>{{ trans('tasa_e_impuesto') }} ( {{ tasa_porcentaje() }})</strong> 
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="extra">
                                <strong style="font-weight: 600;">                                            
                                  {{ tasas_impuestos.toFixed(2) }} USD
                                </strong>
                            </div>
                        </div>           
                    </div>
                </div>
                <div class="item-sumary">
                    <div class="row">
                        <div class="col-8">
                            <div class="">
                               <strong>Sub Total ($)</strong> 
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="extra">
                                <strong style="font-weight: 600;">                                            
                                  {{ total().toFixed(2) }} USD
                                </strong>
                            </div>
                        </div>           
                    </div>
                </div>
                <div class="item-sumary">
                  <div class="row">
                    <div class="col-md-12">
                      <a href="javascript:void(0)" class="float-left text-info" data-toggle="modal" data-target="#modalCupon"><strong> <small>{{ trans('cupon_descuento') }}</small> <span>{{ cupon_descripcion }}</span> </strong>&nbsp;</a>
                      <small v-show="cupon_valido" class="fa fa-times-circle text-danger" v-on:click="eliminarCupon" title="Delete"></small>
                      <span class="float-right text-secundary"><small>- {{ ( (total()*cupon_valor)/100 ).toFixed(2) }} USD</small></span>
                      <!--- Modal Cupón -->
                      <div class="modal fade" id="modalCupon"  tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalCuponTitle"><span class="fa fa-gift"></span> {{ trans('cupon') }} </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">          
                                      <div class="form-group">
                                        <label for="codigo cupón" class="form-control-label">{{ trans('ingrese_codigo_cupon') }}:</label>
                                        <input type="text" name="txt-cupon" id="txt-cupon" class="form-control" autofocus v-model="cupon_codigo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-success" v-on:click="operarCupon">{{ trans('aplicar_cupon') }}</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                  </div>
                              </div>
                          </div>
                      </div>  
                    <!-- Modal Cupón -->
                    </div>
                  </div>    
                </div>
            <div class="bottom-subtitle">
                <strong style="font-weight: 700;font-size: 24px;">Total ( {{ cart.length }} {{ trans('actividad') }}):</strong>
            </div>
            <div class="total-price">
                {{ ( total() - ( (total()*cupon_valor)/100 ) ).toFixed(2) }} USD
            </div>
            <!-- Este boton solo aparece si la variable next es igual a true -->
            <a :href="href"  v-if="next" class="btn btn-primary btn-block" @click="accion()"><slot></slot></a>
        </div>
  `,
  // Propiedades de que puede recibir el componente 
  props: {
    cart: Array, 
    href: { //Url que recibira el componente para redireccionarse
      type: String,
    },
    next: { //Permite mostrar el boton para proceder con el proceso de compra
      type: Boolean,
      default: false,
    },
  },
  data () {
    return {
      //precio_total_final: 0,
      tasas_impuestos: 0, //Tasa de impuesto por default 0,
      cupon_descripcion: null,
      cupon_valor:0,
      cupon_codigo:null,
      cupon_valido: false,
      cupon_descuento:0,
      precio_normal: 0,
      cupon_valor_descuento: 0,
    }
  },
  mounted() {
    if ( Cookies.get('cupon') ) {
      dataCupon = JSON.parse(Cookies.get('cupon'));
      this.cupon_descripcion  = dataCupon.cupon_descripcion;
      this.cupon_valor        = dataCupon.cupon_valor;
      this.cupon_codigo       = dataCupon.cupon_codigo;        
      this.cupon_valido       = dataCupon.cupon_valido;
      this.cupon_valor_descuento = dataCupon.cupon_valor_descuento;
    }else{
      cookieCupon = {
        'cupon_descripcion' : this.cupon_descripcion,
        'cupon_valor'       : this.cupon_valor,
        'cupon_codigo'      : this.cupon_codigo,
        'cupon_valido'      : this.cupon_valido,
        'cupon_valor_descuento': this.cupon_valor_descuento,
      };
      Cookies.set('cupon',cookieCupon,{expires:expireCookie});
    }
    //console.log(Cookies.get('cupon'));
  },
  watch: {
    cupon_valor: function(val){
      Cookies.remove('cupon');
      cookieCupon = {
        'cupon_descripcion' : this.cupon_descripcion,
        'cupon_valor'       : this.cupon_valor,
        'cupon_codigo'      : this.cupon_codigo,
        'cupon_valido'      : this.cupon_valido,
        'cupon_valor_descuento': this.cupon_valor_descuento,
      };
      Cookies.set('cupon',cookieCupon,{expires:expireCookie});
      //Cookies.set('cupon',cookieCupon,{ expires:expireCookie, domain: '.incalake.com' };
      //console.log('CUPON VÁLIDO',this.cupon_valido);
    }
  },
  methods: {
    accion: function () {
      this.$emit('accion'); //Ejecuta o llama a un evento cuando es asignado a un componente Ejm. @accion="name_function"
    },
    tasa_porcentaje() { //Retorna el porcentaje de la tasa de los productos añadidos al carro.
      tasa = 0;
      this.cart.forEach((c, index) => {
        tasa += c.tasas_impuestos;
      });

      if(isNaN(tasa/this.cart.length)) { //Default tasa
          return 0+' %';
      } else {
          return tasa/this.cart.length+' %';  //Visualización de la tasa a cobrar por los servicios de tour seleccionados
      }
    },
    total() { //  Retorna el importe total a pagar de los productos agregados
      total_pagar = 0;
      tasa = 0;

      this.cart.forEach((c, index) => {
        if (this.cupon_valido) {
          //console.log('Precio Normal');
          tasa += (c.precio_normal * c.tasas_impuestos) / 100;
          total_pagar += c.precio_normal;
        }else{
          //console.log('Precio Oferta');
          tasa += (c.total * c.tasas_impuestos) / 100;
          total_pagar += c.total;
        }  
        //Extrae los precios de los recursos si es que el cliente lo ha seleccionado
        if(c.recursos) {
          c.recursos.forEach((r, index) => {
            total_pagar += r.precio * r.cantidad;
          });
        } 
      });
      this.tasas_impuestos = tasa; // Tasa cobrada de los diferentes tour
      return (total_pagar+tasa);
    },
    operarCupon(){
      if (this.cupon_codigo.trim().length != 0 ) {
        $('#modalCupon').modal('hide');
        //alert(this.cupon_codigo+" -> "+this.cupon_valor);
        c_codigo = this.cupon_codigo.trim();
        axios.get(base_url+'api/cupon?codigo='+c_codigo+'&&lang='+langApp).then((response) => {  // APi para consultar cupón
          //this.loading = false;
          if ( response.data.response === 'success' ) {
            this.cupon_descripcion = ' -'+response.data.valor+''+response.data.simbolo ;
            this.cupon_valor       = response.data.valor;
            this.cupon_codigo      = response.data.codigo;
            this.cupon_valido      = true;
            this.cupon_valor_descuento = ( (this.total()*this.cupon_valor)/100);
          }     
        });
      }else{
        $("#txt-cupon").focus();
      }
    },
    eliminarCupon(){
      this.cupon_descripcion = null;
      this.cupon_valor       = 0;
      this.cupon_codigo      = null;
      this.cupon_valido      = false;
      this.cupon_descuento   = 0;
      this.precio_normal     = 0;
      this.cupon_valor_descuento = 0;
    },
  }
});

/*
* Componente <recursos></recursos> - uso en directory application/view/cart/checkout_cart.php
*  Permite mostrar los recursos que son relacionados al producto
*/

Vue.component('recursos', {
  //Propiedades
  props: {
    producto_id: Number,  //Recibe el Id del producto
  },
  data () {
    return {
      recursos: [], //Variable donde serán almacenados los recursos
      close: false, //Variable para sacar de vista los recursos relacionados a ese producto
    }
  },
  template:`
    <div>
      <div class="row recurso" v-if="recursos.length!=0" v-show="!close">   
        <!--<h1>{{ producto_id }} {{ recursos }} {{ recursos.length }}</h1> -->
        <div class="col-12"">  
          <strong>{{ trans('info_shop_recurso') }}</strong>
          <a class="float-right" title="Cerrar" style="cursor:pointer" @click="cerrar_recurso()">x cerrar</a>
        </div>
        <div class="col-12 col-md-6" v-for="r, index in recursos">
          <div :class="{gift_selected:r.cantidad!=0}" style="padding-top: 5px;">
              <div class="row" style="margin:0">
                <div class="col card-img-gif" style="vertical-align: top;padding-right: 5px;padding:0;">
                  <img class="img-card d-flex mr-3" :src="r.img_thumbs" :data-img="r.img" width="100%" height="50px" :title="r.nombre">
                  <div class="middle">
                    <div class="fa fa-search-plus"></div>
                  </div>
                </div>
                <div  style="vertical-align: top;font-size: 12px;line-height: 13px;" class="col text-left">
                  <div class="text-capitalize">
                    <strong style="display: block;">{{ r.nombre }}</strong> {{ r.descripcion }}
                  </div>
                </div>
                <div class="col" style="padding:0;vertical-align: top;text-align: center">
                  <div>
                    <button @click="quantityMin(index)">-</button>
                        <input type="text" v-model="r.cantidad"/>
                      <button @click="quantityMax(index)">+</button>
                    </div>
                    <strong>{{ (r.cantidad == 0 ? r.precio * 1 : r.precio * r.cantidad).toFixed(2) }} USD</strong>
                </div>
              </div>
          </div>
        </div>  
      </div>
    </div>
  `,
  mounted() {
    
    var flag = Cookies.get('close-recurso'+this.producto_id); // Verificamos en la cacje si el recurso esta para ocultar.
    if(flag) {
      this.close = flag;
      return null;
    }

    var recursosCookie = [];  
    if(Cookies.get('cart')) {
      JSON.parse(Cookies.get('cart')).forEach((item) => {
        if(item.producto_id == this.producto_id) {
          if(item.recursos) {
            item.recursos.forEach((r) => {
              recursosCookie.push({
                recurso_id: r.recurso_id,
                cantidad: r.cantidad,
              });
            });
          }
        }
      });
    }

    console.log(findArray_(recursosCookie, ['recurso_id', 2]));

    axios.get(base_url+'api/recursos?id='+this.producto_id).then((response) => 
    {  
      response.data.forEach((item) =>  this.recursos.push({
        recurso_id: item.id_recurso,
        nombre: textLang(item.nombre_recurso),
        descripcion: textLang(item.descripcion_recurso),
        img: base_url+'galeria/admin/recursos/'+item.carpeta_archivo+'/'+item.url_archivo, 
        img_thumbs: base_url+'galeria/admin/recursos/'+item.carpeta_archivo+'/thumbs/'+item.url_archivo,
        precio: parseFloat(textLang(item.precio_recurso)),
        /* Cantidad - Si el usuario selecciono algun recurso al carro lo recuperamos*/
        cantidad: findArray_(recursosCookie, ['recurso_id', item.id_recurso]) == undefined ? 0 : findArray_(recursosCookie, ['recurso_id', item.id_recurso], 'cantidad'),
      }));

    

    });
    
  },
  methods: {
    quantityMin(index) {
      this.recursos[index].cantidad--; // Disminuimos la cantidad
    },
    quantityMax(index) {
      this.recursos[index].cantidad++; // Aumentamos la cantidad
    },

    addCart() { //Añadimos al carro los recursos seleccionados
      cartSelect = this.recursos.filter((item) => item.cantidad != 0 );
      data = JSON.parse(Cookies.get('cart'));

      data.forEach((item) => {        
        if(item.producto_id == this.producto_id) {
          item.recursos = cartSelect;         
        }
      });
      Cookies.set('cart', data, {expires:expireCookie}); //Guardamos el nuevo array con recursos
      this.$emit('update'); //mandamos a actualizar 
    }, 
    cerrar_recurso() {
      this.close = true;
      Cookies.set('close-recurso'+this.producto_id, true, {expires:expireCookie});
    }
  },
  watch: {
    recursos: { //Ejecutamos si hay algun cambio en array de this.recursos
      handler: function (change) {
        change.forEach((item, i) => {
          if(item.cantidad < 0) this.recursos[i].cantidad = 0; //Si es menor a cero le ponemos por default 0
        });
        this.addCart(); //Ejecutamos la funcion addCart();
      },
      deep: true,
    }
  } 
});

/*
* Componente para visualizar el mapa - page-details.php 
* View Tour details
*/
Vue.component('map-incalake', {
  props: {
    id_map : String,
    tmp: String,
  },
  template: `<div><div :id='id_map'></div></div>`,
  mounted: function () {
    var waypoints = JSON.parse(this.tmp);
    var _this = this;

        var mapa = new IncalakeMap(_this.id_map);
        mapa.setBaseUrl(base_url+'assets/incalakemap');
        mapa.addWaypoints(waypoints.lugares); 
        mapa.showNumberedMarkers();
  }
});

/* https://github.com/baianat/vee-validate  - Validate form documentation*/
/*
* Componente para realizar la solicitud de disponiblidad del servicio.
* <customer-disponibilidad>
*/
Vue.component('customer-disponibilidad', {
  template: `
    <div class="container-fluid" style="font-family: Source Sans Pro">
      <div class="row" v-show="!successSend">
        <div class="col-12 col-sm-6">
          <div style="background:#fff;border:1px solid #e5e5e5;padding: 30px 20px;">
                    
                    <h5><strong>{{ trans('tus_datos') }}</strong></h5>
                    <p>{{ trans('info_disponibilidad_contact') }}</p>

                    <form >
                        <label for="nombres" class="col-form-label">{{ trans('name') }}:</label>
                        <input v-model="person.nombres" type="text" name="nombres" v-validate="'required|alpha_spaces'"  :class="{'form-control':true,'form-control-danger':errors.has('nombres')}" />
                        <span v-show="errors.has('nombres')"  class="form-control-feedback" style="color:red;">{{ errors.first('nombres') }}</span>
               
                        <div class="form-group" :class="{'has-danger':errors.has('apellidos')}">
                            <label for="apellidos" class="col-form-label">{{ trans('last_name') }}:</label>
                            <input v-model="person.apellidos" type="text" name="apellidos" v-validate="'required|alpha_spaces'"  :class="{'form-control':true,'form-control-danger':errors.has('apellidos')}" />
                            <span v-show="errors.has('apellidos')"  class="form-control-feedback" style="color:red;">{{ errors.first('apellidos') }}</span>
                        </div>

                        <div class="form-group" :class="{'has-danger':errors.has('email')}">
                            <label for="email" class="col-form-label"> {{ trans('email') }}:</label>
                            <input v-model="person.email" type="email" name="email" v-validate="'required|email'"  :class="{'form-control':true,'form-control-danger':errors.has('email')}" />
                            <span v-show="errors.has('email')"  class="form-control-feedback" style="color:red;">{{ errors.first('email') }}</span>
                        </div>

                        <div class="form-group" :class="{'has-danger':errors.has('telefono')}">
                            <label for="telefono" class="col-form-label">{{ trans('phone') }}:</label>
                            <input v-model="person.telefono" type="text" name="telefono" v-validate="'required|numeric'"  :class="{'form-control':true,'form-control-danger':errors.has('telefono')}" />
                            <span v-show="errors.has('telefono')"  class="form-control-feedback" style="color:red;">{{ errors.first('telefono') }}</span>
                        </div>

                         <div class="form-group" :class="{'has-danger':errors.has('pais')}">
                              <label for="pais" class="col-form-label"> {{ trans('country') }}:</label>
                              <select v-model='person.pais' style="padding: 8px;" v-select>
                                  <option  v-for="pais, index in paises" :value="pais">
                                      {{ pais }}
                                  </option>
                              </select>
                          </div>
                    </form>
                </div>              
                <hr>
                <p class="text-center"> 
                  <button type="submit" @click="consultar()" class="btn btn-primary">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i> {{ trans('btn_consultar') }}
                  </button>
                </p>
        </div>
        <div class="col-12 col-sm-6"><br>
        
              <h4>{{ trans('title_solicitud_disponibilidad') }}</h4>
              <hr>
              <ul>
                <div class="media" v-for="c in cart">
                <img class="d-flex align-self-center mr-3" :src="c.img_thumb" alt="Generic placeholder image">
                  <div class="media-body">
                <h5 class="mt-0">{{ c.titulo_producto }}</h5>
                    <p>
                      <strong>{{ trans('fecha_servicio') }} : </strong> {{ dateString(c.fecha_servicio) }}<br>
                      <strong>{{ trans('horario') }} : </strong> {{ c.horario }} <br>
                      <table class="table table-sm">
                        <tr v-for="pe in c.personas">
                          <td><strong>{{ pe.descripcion_etapa_edad }} {{ pe.descripcion_nacionalidad }} x {{ pe.cantidad }} </strong></td>
                          <td class="text-right">{{ c.total }} USD</td>
                        </tr>
                      </table>
                  </p><small>
                  {{ trans('info_nota_disponibilidad') }}</small>
               </div>
            </div>
              </ul><hr>
        
            <div v-html="trans('contact_disponibilidad')"></div>

        </div>
      </div>
      <div class="row text-center" v-show="successSend"> <!-- @var successSend,  Si el envio es exitoso se habilita v-show.-->
          <div class="col-12"  style="height: 70vh;">
              <div style="margin-top: 13%;">
                  <i class="fa fa-check" aria-hidden="true"></i> &nbsp; 
                  <span v-html="trans('success_send_disponibilidad')"></span>
                  <hr>
                  <div v-html="trans('contact_disponibilidad')"></div>
              </div>
          </div>
      </div>
      <div style="background: rgba(0,0,0,0.5);color:white;width: 100%;height: 100vh;position: fixed;top:0;left:0px;padding-top: 14%;" class="text-center" v-show="loading">
        <img src="http://jxnblk.com/loading/loading-bubbles.svg" width="150px"> <br>
        <strong>Realizando envio...</strong>
      </div>
    </div>
  `,
  data () {
    return {
      cart: Cookies.get('disponibilidad')?JSON.parse(Cookies.get('disponibilidad')):[],
      person: {
        nombres: null,
        apellidos: null,
        email: null,
        telefono: null,
        pais: 'United States',
      },
      paises: [],
      successSend: false, //
      loading: false,
    }
  },
  mounted() {
    axios.get(base_url+'assets/resources/js/countrynames.json').then((response) => { //Api paises 
        this.paises = response.data;
    });

  },
  methods: {
    consultar() {
      var _this = this; 
      this.$validator.validateAll().then((result) => { //Validación del formulario
        if(result) {
          _this.loading = true;
          /*
          * Api para registro de consulta de disponibilidad de reserva.
          */
          $.post(base_url+'api/reserva/disponibilidad', {
            persona: _this.person,
            producto: _this.cart,
          }).done(function (data) { 
            _this.loading = false;          
            _this.successSend = true;
            Cookies.remove('disponibilidad');
            setTimeout(function () {
              window.location.href = "/";
            }, 30000); //Depues de 30 segundos redireccionamos a la página de inicio
          });
        }
      });
    },
  }
});


/*
 * Componente <customer-form> route -> http://web.incalake.com/es/checkout/customer
  Petición de datos de contacto para el proceso de compra
*/

Vue.component('customer-form', {
  template: 
    `
      <div class="container-fluid pt-4 pb-4">
          <div class="row justify-content-md-center">
              <div class="col-xl-6">             
            <div style="background:#fff;border:1px solid #e5e5e5;padding: 30px 20px;">
                      <h5><strong>{{ trans('tus_datos') }}</strong></h5>
                      <form @submit.prevent="validateForm('form-1')">
                          <label for="nombres" class="col-form-label">{{ trans('name') }}:</label>
                          <input v-model="person.nombres" type="text" name="nombres" v-validate="'required|alpha_spaces'"  :class="{'form-control':true,'form-control-danger':errors.has('nombres')}" />
                          <span v-show="errors.has('nombres')"  class="form-control-feedback" style="color:red;">{{ errors.first('nombres') }}</span>
                 
                          <div class="form-group" :class="{'has-danger':errors.has('apellidos')}">
                              <label for="apellidos" class="col-form-label">{{ trans('last_name') }}:</label>
                              <input v-model="person.apellidos" type="text" name="apellidos" v-validate="'required|alpha_spaces'"  :class="{'form-control':true,'form-control-danger':errors.has('apellidos')}" />
                              <span v-show="errors.has('apellidos')"  class="form-control-feedback" style="color:red;">{{ errors.first('apellidos') }}</span>
                          </div>
                          <div class="form-group" :class="{'has-danger':errors.has('email')}">
                              <label for="email" class="col-form-label"> {{ trans('email') }}:</label>
                              <input v-model="person.email" type="email" name="email" v-validate="'required|email'"  :class="{'form-control':true,'form-control-danger':errors.has('email')}" />
                              <span v-show="errors.has('email')"  class="form-control-feedback" style="color:red;">{{ errors.first('email') }}</span>
                          </div>
                          <div class="form-group" :class="{'has-danger':errors.has('telefono')}">
                              <label for="telefono" class="col-form-label">{{ trans('phone') }}:</label>
                              <input v-model="person.telefono" type="text" name="telefono" v-validate="'required|numeric'"  :class="{'form-control':true,'form-control-danger':errors.has('telefono')}" />
                              <span v-show="errors.has('telefono')"  class="form-control-feedback" style="color:red;">{{ errors.first('telefono') }}</span>
                          </div>

                           <div class="form-group" :class="{'has-danger':errors.has('pais')}">
                              <label for="pais" class="col-form-label"> {{ trans('country') }}:</label>
                              <select v-model='person.pais' style="padding: 8px;" v-select>
                                  <option  v-for="pais, index in paises" :value="pais">
                                      {{ pais }}
                                  </option>
                              </select>
                          </div>
                      </form>
                  </div>
           </div>
              <div class="col-xl-4" >
                  <!-- @accion  evento que se ejecuta desde el boton -->
                  <resumen-carro :cart="cart" href="#" @form_pago="validateform()" @accion="validarFormNext()" :next="true">
                    {{ trans('continuar_pagar') }}
                  </resumen-carro>
          </div>
          </div>
      </div>
      </div>

    `,
  data () {
    return {
      cart: Cookies.get('cart')?JSON.parse(Cookies.get('cart')):[],
      paises: [],
      person: {
        nombres: null,
        apellidos: null,
        email: null,
        telefono: null,
        pais: 'United States',
      },
    }
  },
  mounted() {

    if(Cookies.get('customer')) {
      customer = JSON.parse(Cookies.get('customer'));
      this.person = {
        nombres: customer.nombres,
        apellidos: customer.apellidos,
        email: customer.email,
        telefono: customer.telefono,
        pais: customer.pais
      }
    }

    axios.get(base_url+'assets/resources/js/countrynames.json').then((response) => { //Api country 
      this.paises = response.data;
    });
  },
  methods: {
    validarFormNext: function () {
      this.$validator.validateAll().then((result) => { //Realiza la validación del formulario
        if(result) { //Si la validación es correcta ingresa 
          window.location.href = base_url+langApp+'/checkout/payment';
        }
      });
    }
  },
  watch : { 
    person: { //Si hay algun cambio en el formulario se ejecuta automaticamente el codigo siguiente
      handler: function (change) {        
        Cookies.set('customer', change, {expires:expireCookie});
      },
      deep: true,
    }
  }
});


/* Select 2 Jquery component  */

function updateFunction (el, binding) {
  let options = binding.value || {};

  $(el).select2(options).on("select2:select", (e) => {
    el.dispatchEvent(new Event('change', { target: e.target }));
  });
}
Vue.directive('select', {
  inserted: updateFunction ,
  componentUpdated: updateFunction,
});

function formatFunction (state) {
    var $state = $(
        '<span style="color: red">' + state.text + '</span>'
    );
    return $state;
}


Vue.config.ignoredElements = ['script']; //Ingora etiquetas a ejecutarlas en este caso tag <script>
if($("#app").length) //Verificamos si existe elemento #app -> id="app"
{
  var vm = new Vue({
    el: '#app',
    data: {
        cart: Cookies.get('cart') ? JSON.parse(Cookies.get('cart')):[],
    }
  });
}

var modal_slider = `
    <div class="modal fade" id="modalImg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header text-right">
            <div class="title-img text-capitalize font-weight-bold"></div>            
              <div class="btn btn-danger fa fa-close" data-dismiss="modal"></div>
            </div>
            <div class="modal-body">
              <div class="container-fluid "><img class="img_full" style="width: 100%;" src="" alt="" /></div>
          </div>
        
        </div>
      </div>
    </div>`;
  
  $('body').append(modal_slider);

  $(document).on('click', 'img.img-card', function(event) {
  console.log('as');
  console.log($(this));
  $('.title-img').html(($(this).attr('title'))?$(this).attr('title'):'');
  // $('.img_full').attr('src', $(this).attr('src'));
  $('.img_full').attr('src', ($(this).data('img')? $(this).data('img'):$(this).attr('src')));
  $('#modalImg').modal('show');
});