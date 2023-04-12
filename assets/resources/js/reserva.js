var app = new Vue({
    el: "#reserva",
    data: {
        producto_id: $("#producto_id").val(),
        viaje: 3,
        cantidad_persona: parseInt($("#cantidad_input").val()),
        personas: [],
        forms: [],
    },
    mounted: function () {
       // this.formProducto();
        
        /*
            *
            * retorna valores de los campos de formularios segun al tipo de producto 
            *
        */
        var _this = this;
        var lang = $("html").attr('lang');
        var flag = "";
        var i = -1;

        $.getJSON('/web/api/producto/forms?id='+_this.producto_id, function (response) {  
            response.forEach(function (item, index) {
                if(item.id_categoria_campo != flag) {
                    i++;
                    categoria = JSON.parse(item.nombre_categoria)[$("html").attr('lang')];
                   _this.forms.push({ group:categoria, group_id: item.id_categoria_campo, inputs: [] });
                   _this.forms[i].inputs.push({
                        name: item.name_campo,
                        label: JSON.parse(item.nombre_campo)[$("html").attr('lang')],
                        placeholder:  JSON.parse(item.placeholder_campo)[$("html").attr('lang')],
                        type: item.tipo_campo
                   });
                   flag = item.id_categoria_campo; 

                } else {
                     _this.forms[i].inputs.push({
                        name: item.name_campo,
                        label: JSON.parse(item.nombre_campo)[$("html").attr('lang')],
                        placeholder:  JSON.parse(item.placeholder_campo)[$("html").attr('lang')],
                        type: item.tipo_campo
                   });
                }  
            });
        });


    },
    computed: {

    },
    methods:  {
        formProducto: function () {
            var _this = this;
            var formArray = new Array();
            $.getJSON('/web/reservas/apiform_producto?id='+_this.producto_id, function (data) {
               
               formArray = data.config_form.split(",");
               _this.formularios.forEach(function (form, index) {
                   if(formArray[index] == 1){
                        _this.formQuery.push({name: form.name, label: form.label, placeholder: form.placeholder,type: form.type? form.type:'text', categoria: form.categoria});
                        _this.categoria.push(form.categoria);
                   }
               });
            });
        }
    },
});

$(document).ready(function () {
    $("#cantidad_input").on('change', function () {
       app.cantidad_persona = parseInt($("#cantidad_input").val());

        var new_persona_array = [];
        var personas_array = $.map(JSON.parse($("#person_array").val()), function(el) { if(el.cantidad != 0) { return el; }});
        

        personas_array.forEach(function (p) {

            for(i=0;i<p.cantidad;i++)
            {
                new_persona_array.push(//{
                    /*tipo:*/  p.persona.substring(0,p.persona.length-1) //Se elimina "," colocada al final de la línea sin corresponder 
                  //  nacionalidad: p.nacionalidad,
                //}
                );
            }
        });
        app.personas = new_persona_array;
    });

});