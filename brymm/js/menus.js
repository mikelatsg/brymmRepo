/**
 * Use this ScriptDoc file to manage the documentation for the corresponding namespace in your JavaScript library.
 *
 * @author Mikel
 */


function listaPlatosLocal(item) {
    var nombre = "";
    var idPlatoLocal = "";
    var idLocal = "";
    var idTipoPlato = "";
    var precio = "";
    var descripcion = "";
    var contenido = "";
    var idTipoPlatoAnterior = 0;
    var enlaceBorrar = "";
    var enlaceModificar = "";
    var enlaceAnadirMenu = "";
    $(item).find('platoLocal').each(function() {
        existePedido = 1;

        //Se obtienen los valores del xml
        nombre = $.trim($(this).find('nombre').text());
        idPlatoLocal = $.trim($(this).find('id_plato_local').text());
        idLocal = $.trim($(this).find('id_local').text());
        idTipoPlato = $.trim($(this).find('id_tipo_plato').text());
        precio = $.trim($(this).find('precio').text());
        descripcion = $.trim($(this).find('descripcion').text());

        //Se crea el enlace para poder borrar los platos del local
        enlaceBorrar = "<a onclick=\"doAjax('" + site_url
                + "/menus/borrarPlatoLocal','idPlatoLocal="
                + idPlatoLocal + "','listaPlatosLocal','post',1)\">B</a>";

        //Se crea el enlace para poder modificar el articulo
        enlaceModificar = "<a href=\"javascript:llenarFormularioModificarPlato('"
                + nombre + "','" + precio + "','" + idPlatoLocal + "','"
                + idTipoPlato + "')\"> M </a>";

        //Se crea el enlace para poder borrar los platos del local
        enlaceAnadirMenu = "<a onclick=\"enviarDatosMenu('" + site_url
                + "/menus/anadirPlatoMenu','formAnadirPlatoMenu','idPlatoLocal="
                + idPlatoLocal + "','mostrarMenu',1)\">A</a>";


        if (idTipoPlato != idTipoPlatoAnterior & idTipoPlatoAnterior != 0) {
            contenido = contenido + "</ul>";
        }

        if (idTipoPlato != idTipoPlatoAnterior) {
            contenido = contenido + "<h2>" + descripcion + "</h2>";
            contenido = contenido + "<ul>";
        }

        idTipoPlatoAnterior = idTipoPlato;
        contenido = contenido + "<li>";
        contenido = contenido + nombre + " - " + precio + " - " + enlaceBorrar
                + " - " + enlaceModificar + " - " + enlaceAnadirMenu;
        contenido = contenido + "</li>";

        //if(idPlatoLocal != idTipoPlatoAnterior ){
        //    contenido="<h2>"+descripcion+"</h2>";    
        //    contenido = contenido + "<ul>";
        //} 
    });

    if (idTipoPlatoAnterior != 0) {
        contenido = contenido + "</ul>";
    }

    $("#listaPlatosLocal").empty();
    $("#listaPlatosLocal").html(contenido);

    //Si hay mensaje se muestra 
    if ($(item).find('mensaje').length > 0) {
        var mensaje = $.trim($(item).find('mensaje').text());
        if (mensaje != "") {
            mostrarMensaje(mensaje);
        }
    }
    
    resetFormularios();

}

function actualizarCalendarioMenu(item) {
    var calendario = "";
    calendario = $.trim($(item).find('calendario').text());
    $("#calendarioMenu").empty();
    $("#calendarioMenu").html(calendario);
}

function actualizarCalendarioMenuUsuario(item) {
    var calendario = "";
    calendario = $.trim($(item).find('calendario').text());
    $("#calendarioMenuUsuario").empty();
    $("#calendarioMenuUsuario").html(calendario);
}

function listaTipoMenuLocal(item) {
    var idTipoMenuLocal = "";
    var nombreMenu = "";
    var precioMenu = "";
    var descripcion = "";
    var contenido = "";
    var contenidoCombo = "";
    var optionCombo = "";
    var enlaceBorrar = "";
    var enlaceModificar = "";
    var idLocal = 0;

    //Si existen datos para mostrar ...
    if ($(item).find('tipoMenuLocal').length > 0) {
        contenido = contenido + "<ul>";
        $(item).find('tipoMenuLocal').each(function() {

            //Se obtienen los valores del xml
            nombreMenu = $.trim($(this).find('nombre_menu').text());
            idTipoMenuLocal = $.trim($(this).find('id_tipo_menu_local').text());
            idLocal = $.trim($(this).find('id_local').text());
            precioMenu = $.trim($(this).find('precio_menu').text());
            descripcion = $.trim($(this).find('descripcion').text());

            enlaceBorrar = "<a onclick=\"doAjax('" + site_url + "/menus/borrarTipoMenuLocal','idTipoMenuLocal="
                    + idTipoMenuLocal + "','listaTipoMenuLocal','post',1)\">B</a>";

            enlaceModificar = "<a onclick=\"doAjax('" + site_url + "/menus/cargarTipoMenuLocal','idTipoMenuLocal="
                    + idTipoMenuLocal + "','cargarTipoMenuLocal','post',1)\">M</a>";

            //Contenido de la lista
            contenido = contenido + "<li>";
            contenido = contenido + nombreMenu + " - " + descripcion + " - "
                    + precioMenu + " - " + enlaceBorrar + " - " + enlaceModificar;
            contenido = contenido + "</li>";

            //Contenido del combo
            optionCombo = "<option value = \"" + idTipoMenuLocal + "\">"
                    + nombreMenu + "</option>";
            contenidoCombo = contenidoCombo + optionCombo;
        });
        contenido = contenido + "</ul>";
    }

    $('select[name="tipoMenuLocal"]').empty();
    $('select[name="tipoMenuLocal"]').html(contenidoCombo);
    $("#listaTipoMenuLocal").empty();
    $("#listaTipoMenuLocal").html(contenido);

    //Si hay mensaje se muestra 
    if ($(item).find('mensaje').length > 0) {
        var mensaje = $.trim($(item).find('mensaje').text());
        if (mensaje != "") {
            mostrarMensaje(mensaje);
        }
    }
    
    resetFormularios();

}

function cargarTipoMenuLocal(item) {
    var idTipoMenuLocal = "";
    var nombreMenu = "";
    var precioMenu = "";
    var idTipoMenu = "";
    var esCarta = "";

    $(item).find('xml').children().each(function() {

        //Se obtienen los valores del xml
        nombreMenu = $.trim($(this).find('nombre_menu').text());
        idTipoMenuLocal = $.trim($(this).find('id_tipo_menu_local').text());
        precioMenu = $.trim($(this).find('precio_menu').text());
        idTipoMenu = $.trim($(this).find('id_tipo_menu').text());
        esCarta = $.trim($(this).find('es_carta').text());

        $('input[name="nombreMenuModificar"]').val(nombreMenu);
        $('input[name="precioMenuModificar"]').val(precioMenu);
        $('select[name="idTipoMenuModificar"]').val(idTipoMenu)
                .attr('selected', true);
        $('input[name="idTipoMenuLocalModificar"]').val(idTipoMenuLocal);
        $('input:radio[name="esCarta"][value="' + esCarta + '"]').prop('checked', true);

    });
}

//Funcion que muestra en el div menuDia el menu recibido
function mostrarMenu(item) {
    var tipoMenu = "";
    var idLocal = "";
    var fechaMenu = "";
    var idTipoMenu = "";
    var precioMenu = "";
    var nombreMenu = "";
    var esCarta = "";
    var contenido = "";
    var existeMenu = false;
    var hayTitulo = false;    
    $(item).find('menuDia').each(function() {
        //Se obtienen los valores del xml
        tipoMenu = $.trim($(this).find('tipoMenu').text());
        idTipoMenu = $.trim($(this).find('idTipoMenu').text());
        fechaMenu = $.trim($(this).find('fechaMenu').text());
        idLocal = $.trim($(this).find('idLocal').text());
        precioMenu = $.trim($(this).find('precioMenu').text());
        nombreMenu = $.trim($(this).find('nombreMenu').text());
        esCarta = $.trim($(this).find('esCarta').text());       
        
        //Se inserta la fecha en el formulario en el campo fechaMenu
        $('input[name="fechaMenu"]').val(fechaMenu);

        //El titulo (comida,cena, desayuno) solo se pone una vez
        if (!hayTitulo) {
            contenido = contenido + "<h2>" + tipoMenu + "</h2>";
        }
        hayTitulo = true;

        var idTipoPlato = "";
        var nombrePlato = "";
        var precioPlato = "";
        var idTipoPlatoAnterior = 0;
        var tipoPlato = "";

        //Se muestra el nombre del menu
        contenido = contenido + "<h3>" + nombreMenu + "</h3>";
        $(this).find('detalleMenu').each(function() {
            existeMenu = true;
            var idDetalleMenuLocal = "";
            var enlaceBorrar = "";
            /*
             * Se obtienen los datos para poder borrar el plato del menu
             */
            idDetalleMenuLocal = $.trim($(this).find('idDetalleMenuLocal').text());
            enlaceBorrar = "<a onclick=\"doAjax('" + site_url + "/menus/borrarPlatoMenu','idDetalleMenuLocal="
                    + idDetalleMenuLocal
                    + "&idTipoMenu=" + idTipoMenu + "&idLocal=" + idLocal
                    + "&fechaMenu=" + fechaMenu + "','mostrarMenu','post',1)\">B</a>"
                        

            /*
             * En la carta se muestran los precios de los platos
             */
            if (esCarta == "1") {
                idTipoPlato = $.trim($(this).find('idTipoPlato').text());
                tipoPlato = $.trim($(this).find('tipoPlato').text());
                if (idTipoPlato != idTipoPlatoAnterior & idTipoPlatoAnterior != 0) {
                    contenido = contenido + "</ul>";
                }

                if (idTipoPlato != idTipoPlatoAnterior) {
                    contenido = contenido + "<h4>" + tipoPlato + "</h4>";
                    contenido = contenido + "<ul>";
                }
                nombrePlato = $.trim($(this).find('nombrePlato').text());
                precioPlato = $.trim($(this).find('precioPlato').text());
                idTipoPlatoAnterior = idTipoPlato;
                contenido = contenido + "<li>";
                contenido = contenido + nombrePlato + " - " + precioPlato + "-"
                        + enlaceBorrar;
                contenido = contenido + "</li>";
            }
            else {
                /*
                 * Desayunos, comidas y cenas
                 */
                idTipoPlato = $.trim($(this).find('idTipoPlato').text());
                tipoPlato = $.trim($(this).find('tipoPlato').text());
                if (idTipoPlato != idTipoPlatoAnterior & idTipoPlatoAnterior != 0) {
                    contenido = contenido + "</ul>";
                }

                if (idTipoPlato != idTipoPlatoAnterior) {
                    contenido = contenido + "<h4>" + tipoPlato + "</h4>";
                    contenido = contenido + "<ul>";
                }
                nombrePlato = $.trim($(this).find('nombrePlato').text());
                idTipoPlatoAnterior = idTipoPlato;
                contenido = contenido + "<li>";
                contenido = contenido + nombrePlato + "-"
                        + enlaceBorrar;
                contenido = contenido + "</li>";
            }


        });
        contenido = contenido + "</ul>";
        if ((esCarta == "0") && existeMenu) {
            contenido = contenido + "Precio menu : " + precioMenu;
        }

    });

    $("#menuDia").empty();
    $("#menuDia").html(contenido);        
    
    //Si hay mensaje se muestra 
    if ($(item).find('mensaje').length > 0) {
        var mensaje = $.trim($(item).find('mensaje').text());
        if (mensaje != "") {
            mostrarMensaje(mensaje);
        }
    }    

}

//Funcion que muestra en el div menuDia el menu recibido
function mostrarMenuUsuario(item) {
    var tipoMenu = "";
    var idLocal = "";
    var fechaMenu = "";
    var idTipoMenu = "";
    var precioMenu = "";
    var nombreMenu = "";
    var esCarta = "";
    var contenido = "";
    var existeMenu = false;
    var hayTitulo = false;
    $(item).find('xml').children().each(function() {
        //Se obtienen los valores del xml
        tipoMenu = $.trim($(this).find('tipoMenu').text());
        idTipoMenu = $.trim($(this).find('idTipoMenu').text());
        fechaMenu = $.trim($(this).find('fechaMenu').text());
        idLocal = $.trim($(this).find('idLocal').text());
        precioMenu = $.trim($(this).find('precioMenu').text());
        nombreMenu = $.trim($(this).find('nombreMenu').text());
        esCarta = $.trim($(this).find('esCarta').text());

        //El titulo (comida,cena, desayuno) solo se pone una vez
        if (!hayTitulo) {
            contenido = contenido + "<h2>" + tipoMenu + "</h2>";
        }
        hayTitulo = true;

        var idTipoPlato = "";
        var nombrePlato = "";
        var precioPlato = "";
        var idTipoPlatoAnterior = 0;
        var tipoPlato = "";

        //Se muestra el nombre del menu
        contenido = contenido + "<h3>" + nombreMenu + "</h3>";
        $(this).find('detalleMenu').each(function() {
            existeMenu = true;
            /*
             * En los desayunos se muestran los platos como en carta
             */
            if (esCarta == "1") {
                idTipoPlato = $.trim($(this).find('idTipoPlato').text());
                tipoPlato = $.trim($(this).find('tipoPlato').text());
                if (idTipoPlato != idTipoPlatoAnterior & idTipoPlatoAnterior != 0) {
                    contenido = contenido + "</ul>";
                }

                if (idTipoPlato != idTipoPlatoAnterior) {
                    contenido = contenido + "<h4>" + tipoPlato + "</h4>";
                    contenido = contenido + "<ul>";
                }
                nombrePlato = $.trim($(this).find('nombrePlato').text());
                precioPlato = $.trim($(this).find('precioPlato').text());
                idTipoPlatoAnterior = idTipoPlato;
                contenido = contenido + "<li>";
                contenido = contenido + nombrePlato + " - " + precioPlato;
                contenido = contenido + "</li>";
            }
            else {
                /*
                 * Desayunos, comidas y cenas
                 */
                idTipoPlato = $.trim($(this).find('idTipoPlato').text());
                tipoPlato = $.trim($(this).find('tipoPlato').text());
                if (idTipoPlato != idTipoPlatoAnterior & idTipoPlatoAnterior != 0) {
                    contenido = contenido + "</ul>";
                }

                if (idTipoPlato != idTipoPlatoAnterior) {
                    contenido = contenido + "<h4>" + tipoPlato + "</h4>";
                    contenido = contenido + "<ul>";
                }
                nombrePlato = $.trim($(this).find('nombrePlato').text());
                idTipoPlatoAnterior = idTipoPlato;
                contenido = contenido + "<li>";
                contenido = contenido + nombrePlato;
                contenido = contenido + "</li>";

            }


        });
        contenido = contenido + "</ul>";
        if ((esCarta == "0") && existeMenu) {
            contenido = contenido + "Precio menu : " + precioMenu;
        }

    });

    $("#menuDiaUsuario").empty();
    $("#menuDiaUsuario").html(contenido);

}

function enviarDatosMenu(url, formid, query, callback, getxml) {

    var formulario = document.getElementById(formid);
    var cadenaFormulario = "";
    var sepCampos;
    sepCampos = "";
    for (var i = 0; i <= formulario.elements.length - 1; i++) {
        if (formulario.elements[i].type == "checkbox") {
            if (formulario.elements[i].checked) {
                cadenaFormulario += sepCampos + formulario.elements[i].name + '=' + encodeURI(formulario.elements[i].value);
            } else {
                cadenaFormulario += sepCampos + formulario.elements[i].name + '=false';
            }
        } else {
            cadenaFormulario += sepCampos + formulario.elements[i].name + '=' + encodeURI(formulario.elements[i].value);
        }

        sepCampos = "&";
    }
    cadenaFormulario += sepCampos + query;
    doAjax(url, cadenaFormulario, callback, 'post', getxml);

}

function llenarFormularioModificarPlato(nombrePlato, precioPlato
        , idPlatoLocal, idTipoPlato) {
    //Se rellena los campos del formulario.
    $("#formModificarPlato").find('input[name="nombre"]').val(nombrePlato);
    $("#formModificarPlato").find('input[name="idTipoPlato"]').val(idTipoPlato);
    $("#formModificarPlato").find('input[name="precio"]').val(precioPlato);
    $("#formModificarPlato").find('input[name="idPlatoLocal"]').val(idPlatoLocal);
}

$(document).ready(function() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }
    today = yyyy + '-' + mm + '-' + dd;

    /*
     * Datepicker fecha añadir plato menu (local)
     */
    $("#datepickerFechaPlatoMenu").datepicker();
    $("#datepickerFechaPlatoMenu").datepicker("option", "dateFormat", "yy-mm-dd");
    $("#datepickerFechaPlatoMenu").val(today);

});
