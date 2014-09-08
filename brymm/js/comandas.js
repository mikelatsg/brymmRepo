/**
 * Use this ScriptDoc file to manage the documentation for the corresponding namespace in your JavaScript library.
 *
 * @author Mikel
 */

function enviarArticuloComanda(url, query, inputid, callback, getxml) {
    var cantidad = $("#" + inputid).get(0).value;
    var sepCampos;
    sepCampos = "&";
    query = query + sepCampos + "cantidad=" + cantidad;
    doAjax(url, query, callback, 'post', getxml);
}

function mostrarComanda(item) {

    var contenido = "<ul>";
    var contenidoMenu = "";
    var existeMenu = false;
    var existeCarta = false;
    var existeArticulo = false;
    var existeArticuloPer = false;
    var contenidoArticulo = "";
    var contenidoArticuloPer = "";
    var contenidoCarta = "";
    var contenidoTemporal = "";
    var existeComanda = 0;
    var funcionBorrar = "";
    var detalleMenu = "";
    var detalleArticuloPer = "";
    var rowid = "";
    var tipoArticulo = "";
    var precioTotal;
    //Vacio el div donde se muestra la comanda
    $("#mostrarComanda").empty();
    $(item).find('pedido').children().each(function() {


        funcionBorrar = "";
        contenidoTemporal = "";
        detalleMenu = "";
        detalleArticuloPer = ""

        //Se obtienen los valores del xml
        var nombre = $.trim($(this).find('name').text());
        var cantidad = $.trim($(this).find('qty').text());
        var precio = $.trim($(this).find('price').text());
        var id = $.trim($(this).find('id').text());
        var tipoComanda = $.trim($(this).find('tipoComanda').text());
        var idTipoComanda = $.trim($(this).find('idTipoComanda').text());
        var tipoArticulo = $.trim($(this).find('tipoArticulo').text());
        rowid = $.trim($(this).find('rowid').text());
        //Si el campo nombre no esta informado no escribimos nada, se trata del total    
        if (nombre != "") {
            existeComanda = 1;
            funcionBorrar = "doAjax('" + site_url + "/comandas/borrarArticuloComanda','rowid=" + rowid
            funcionBorrar = funcionBorrar + "','mostrarComanda','post',1)";
            contenidoTemporal = contenidoTemporal + "<li>" + nombre + " - " + cantidad + " - " + precio;
            contenidoTemporal = contenidoTemporal + "<a onclick=" + funcionBorrar + "> X </a>";
            contenidoTemporal = contenidoTemporal + "</li>";
            if (idTipoComanda == 1) {
                //Articulo
                if (!existeArticulo) {
                    contenidoArticulo = "<h4>" + tipoComanda + "</h4>";
                }
                existeArticulo = true;
                contenidoArticulo = contenidoArticulo + contenidoTemporal;
            } else if (idTipoComanda == 2) {
                //Articulo personalizado
                //Si es el primer articulo personalizado se muestra el titulo
                if (!existeArticuloPer) {
                    contenidoArticuloPer = "<h4>" + tipoComanda + "</h4>";
                }
                existeArticuloPer = true;
                detalleArticuloPer = mostrarDetalleArticuloPer($(this).find('options'), tipoArticulo);
                contenidoArticuloPer = contenidoArticuloPer + contenidoTemporal
                        + detalleArticuloPer;
            } else if (idTipoComanda == 3) {
                //Menu
                //Si es el primer menu se muestra el titulo
                if (!existeMenu) {
                    contenidoMenu = "<h4>" + tipoComanda + "</h4>";
                }
                existeMenu = true;
                detalleMenu = mostrarDetalleMenu($(this).find('options'));
                contenidoMenu = contenidoMenu + contenidoTemporal + detalleMenu;
            } else {
                //Carta
                if (!existeCarta) {
                    contenidoCarta = "<h4>" + tipoComanda + "</h4>";
                }
                existeCarta = true;
                contenidoCarta = contenidoCarta + contenidoTemporal;
            }
        } else {
            precioTotal = "Total : " + $.trim($(item).find('total').text()) + "<br>";
        }
    });

    //Si hay algo en el pedido se muestra el contenido
    if (existeComanda == 1) {
        contenido = contenido + contenidoArticulo + contenidoArticuloPer
                + contenidoMenu + contenidoCarta + "</ul>";
        contenido = contenido + precioTotal

        contenido = contenido + "<a onclick=\"doAjax('" + site_url +
                "/comandas/cancelarComanda','','mostrarComanda','post',1)\">";
        contenido = contenido + "Cancelar";
        contenido = contenido + "</a>";
    }

    //Se habilita el boton de aceptar comanda
    $("#butAceptarComanda").removeAttr("disabled");
    $("#butAnadirComanda").removeAttr("disabled");
    $("#mostrarComanda").html(contenido);

    //Si hay mensaje se muestra 
    if ($(item).find('mensaje').length > 0) {
        var mensaje = $.trim($(item).find('mensaje').text());
        if (mensaje != "") {
            mostrarMensaje(mensaje);
        }
    }
}

function mostrarDetalleMenu(item) {
    var detalleMenu = "<ul>";
    $(item).find('platosMenu').each(function() {
        var platoMenu = $.trim($(this).find('nombrePlato').text());
        var platoCantidad = $.trim($(this).find('platoCantidad').text());
        detalleMenu = detalleMenu + "<li>" + platoMenu + "-"
                + platoCantidad + "</li>";
    });
    detalleMenu = detalleMenu + "</ul>";
    return detalleMenu;
}

function mostrarDetalleArticuloPer(item, tipoArticulo) {
    var detalleArticuloPer = tipoArticulo;
    var i = 0;
    $(item).find('ingredientes').each(function() {
        var ingrediente = $.trim($(this).find('ingrediente').text());
        if (i == 0) {
            detalleArticuloPer = detalleArticuloPer + " - " + ingrediente;
        } else {
            detalleArticuloPer = detalleArticuloPer + " , " + ingrediente;
        }

        i++;
    });
    detalleArticuloPer = detalleArticuloPer + "";
    return detalleArticuloPer;
}

function mostrarComandaRealizada(item) {

    var contenido = "";
    var contenidoArt = "";
    var contenidoArtPer = "";
    var contenidoMenu = "";
    var contenidoCarta = "";
    var precioTotal = "";
    var destino = ""
    var observaciones = "";
    var nombreMesa = "";
    var nombreCamarero = "";
    var fechaComanda = "";
    var idMesa = "";
    var idComanda = "";
    var detalleComanda = "";
    var estadoComanda = "";
    //Detalle comanda
    var cantidadDetalleComanda = 0;
    var precioDetalleComanda = 0;
    var idTipoComanda = 0;
    var estadoDetalle = "";
    //Se obtienen los datos de la comanda
    $(item).find('datosComanda').each(function() {
        idComanda = $.trim($(this).find('id_comanda').text());
        precioTotal = $.trim($(this).find('precio').text());
        destino = $.trim($(this).find('destino').text());
        observaciones = $.trim($(this).find('observaciones').text());
        idMesa = $.trim($(this).find('id_mesa').text());
        nombreMesa = $.trim($(this).find('nombreMesa').text());
        nombreCamarero = $.trim($(this).find('nombreCamarero').text());
        fechaComanda = $.trim($(this).find('fecha_alta').text());
        estadoComanda = $.trim($(this).find('estado').text());
    });
    contenido += idComanda + " - " + destino + " - " + nombreMesa + " - " + nombreCamarero
            + " - " + precioTotal + " - " + fechaComanda + " - "
            + estadoComanda + "<br>" + observaciones + "<ul>";
    //Se obtienen el detalle de la comanda
    $(item).find('detalleComanda').each(function() {
        var datosEspecificos = "";
        var tipoComanda = "";
        tipoComanda = $.trim($(this).find('tipoComanda').text())

        $(this).find('detalleComandaArticulo').each(function() {
            cantidadDetalleComanda = $.trim($(this).find('cantidad').text());
            precioDetalleComanda = $.trim($(this).find('precio').text());
            idTipoComanda = $.trim($(this).find('id_tipo_comanda').text());
            estadoDetalle = $.trim($(this).find('estado').text());
        });
        switch (parseInt(idTipoComanda)) {
            case 1:
                //Articulo
                datosEspecificos =
                        obtenerDetalleArticuloComandaRealizada($(this))
                //En el primer detalle del tipo de comanda se añade cual es
                if (contenidoArt == "") {
                    contenidoArt += tipoComanda;
                }
                contenidoArt += "<li>" + cantidadDetalleComanda + " - " +
                        precioDetalleComanda + " - " + estadoDetalle + "</li>"
                        + datosEspecificos;
                break;
            case 2:
                //Articulo personalizado
                datosEspecificos =
                        obtenerDetalleArticuloPerComandaRealizada($(this));
                //En el primer detalle del tipo de comanda se añade cual es
                if (contenidoArtPer == "") {
                    contenidoArtPer += tipoComanda;
                }

                contenidoArtPer += "<li>" + cantidadDetalleComanda + " - " +
                        precioDetalleComanda + " - " + estadoDetalle + "</li>"
                        + datosEspecificos;
                break;
            case 3:
                //Menu
                datosEspecificos = obtenerDetalleMenuComandaRealizada($(this));
                //En el primer detalle del tipo de comanda se añade cual es
                if (contenidoMenu == "") {
                    contenidoMenu += tipoComanda;
                }

                contenidoMenu += "<li>" + cantidadDetalleComanda + " - " +
                        precioDetalleComanda + " - " + estadoDetalle + "</li>"
                        + datosEspecificos;
                break;
            case 4:
                //Carta
                datosEspecificos = obtenerDetalleCartaComandaRealizada($(this));
                //En el primer detalle del tipo de comanda se añade cual es
                if (contenidoCarta == "") {
                    contenidoCarta += tipoComanda;
                }

                contenidoCarta += "<li>" + datosEspecificos + " - "
                        + cantidadDetalleComanda + " - " +
                        precioDetalleComanda + " - " + estadoDetalle + "</li>"
                        ;
                break;
        }

    });
    contenido += contenidoArt + contenidoArtPer + contenidoMenu + contenidoCarta + "</ul>";
    //Se desabilita el boton de aceptar comanda
    $("#butAceptarComanda").attr("disabled", "disabled");
    $("#butAnadirComanda").attr("disabled", "disabled");
    //Vacio el div donde se muestra la comanda
    $("#mostrarComanda").empty();
    //Se muestra el contenido
    $("#mostrarComanda").html(contenido);
}

function mostrarComandaRealizadaCocina(item) {

    var contenido = "";
    var contenidoArt = "";
    var contenidoArtPer = "";
    var contenidoMenu = "";
    var contenidoCarta = "";
    var precioTotal = "";
    var destino = ""
    var observaciones = "";
    var nombreMesa = "";
    var nombreCamarero = "";
    var fechaComanda = "";
    var idMesa = "";
    var idComanda = "";
    var detalleComanda = "";
    var estadoComanda = "";
    //Detalle comanda
    var cantidadDetalleComanda = 0;
    var precioDetalleComanda = 0;
    var idTipoComanda = 0;
    var idDetalleComanda = 0;
    var estadoDetalle = "";
    //Se obtienen los datos de la comanda
    $(item).find('datosComanda').each(function() {
        idComanda = $.trim($(this).find('id_comanda').text());
        precioTotal = $.trim($(this).find('precio').text());
        destino = $.trim($(this).find('destino').text());
        observaciones = $.trim($(this).find('observaciones').text());
        idMesa = $.trim($(this).find('id_mesa').text());
        nombreMesa = $.trim($(this).find('nombreMesa').text());
        nombreCamarero = $.trim($(this).find('nombreCamarero').text());
        fechaComanda = $.trim($(this).find('fecha_alta').text());
        estadoComanda = $.trim($(this).find('estado').text());
    });
    contenido += idComanda + " - " + destino + " - " + nombreMesa + " - " + nombreCamarero
            + " - " + precioTotal + " - " + fechaComanda + " - "
            + estadoComanda + "<br>" + observaciones;

    contenido += "<ul>";
    //Se obtienen el detalle de la comanda
    $(item).find('detalleComanda').each(function() {
        var datosEspecificos = "";
        var funcionTerminarDetalleComanda = "";
        var tipoComanda = "";
        tipoComanda = $.trim($(this).find('tipoComanda').text())

        $(this).find('detalleComandaArticulo').each(function() {
            cantidadDetalleComanda = $.trim($(this).find('cantidad').text());
            precioDetalleComanda = $.trim($(this).find('precio').text());
            idTipoComanda = $.trim($(this).find('id_tipo_comanda').text());
            idDetalleComanda = $.trim($(this).find('id_detalle_comanda').text());
            estadoDetalle = $.trim($(this).find('estado').text());
        });

        //Si el estado es diferente de terminado se da la opcion de terminar
        if (estadoDetalle !== "TC") {
            //Se generan los enlaces
            funcionTerminarDetalleComanda = "<a onclick=\"doAjax('" + site_url
                    + "/comandas/terminarDetalleComanda','idDetalleComanda=" + idDetalleComanda
                    + "&idComanda=" + idComanda
                    + "','mostrarComandaRealizadaCocina','post',1)\"> Realizado </a>";
        }


        switch (parseInt(idTipoComanda)) {
            case 1:
                //Articulo
                datosEspecificos =
                        obtenerDetalleArticuloComandaRealizada($(this))

                //En el primer detalle del tipo de comanda se añade cual es
                if (contenidoArt == "") {
                    contenidoArt += tipoComanda;
                }
                contenidoArt += "<li>" + cantidadDetalleComanda + " - " +
                        precioDetalleComanda + " - " + estadoDetalle
                        + funcionTerminarDetalleComanda + "</li>"
                        + datosEspecificos;
                break;
            case 2:
                //Articulo personalizado
                datosEspecificos =
                        obtenerDetalleArticuloPerComandaRealizada($(this));
                //En el primer detalle del tipo de comanda se añade cual es
                if (contenidoArtPer == "") {
                    contenidoArtPer += tipoComanda;
                }

                contenidoArtPer += "<li>" + cantidadDetalleComanda + " - " +
                        precioDetalleComanda + " - " + estadoDetalle
                        + funcionTerminarDetalleComanda + "</li>"
                        + datosEspecificos;
                break;
            case 3:
                //Menu
                datosEspecificos = obtenerDetalleMenuComandaRealizadaCocina($(this), idComanda);
                //En el primer detalle del tipo de comanda se añade cual es
                if (contenidoMenu == "") {
                    contenidoMenu += tipoComanda;
                }

                contenidoMenu += "<li>" + cantidadDetalleComanda + " - " +
                        precioDetalleComanda + " - " + estadoDetalle
                        + funcionTerminarDetalleComanda +
                        "</li>"
                        + datosEspecificos;
                break;
            case 4:
                //Carta
                datosEspecificos = obtenerDetalleCartaComandaRealizada($(this));
                //En el primer detalle del tipo de comanda se añade cual es
                if (contenidoCarta == "") {
                    contenidoCarta += tipoComanda;
                }

                contenidoCarta += "<li>" + datosEspecificos + " - "
                        + cantidadDetalleComanda + " - " +
                        precioDetalleComanda + " - " + estadoDetalle
                        + funcionTerminarDetalleComanda + "</li>"
                        ;
                break;
        }

    });
    contenidoCarta += "<ul>";

    contenido += contenidoArt + contenidoArtPer + contenidoMenu + contenidoCarta;
    //Se desabilita el boton de aceptar comanda
    $("#butAceptarComanda").attr("disabled", "disabled");
    $("#butAnadirComanda").attr("disabled", "disabled");
    //Vacio el div donde se muestra la comanda
    $("#mostrarComanda").empty();
    //Se muestra el contenido
    $("#mostrarComanda").html(contenido);


    //Si hay mensaje se muestra 
    if ($(item).find('mensaje').length > 0) {
        var mensaje = $.trim($(item).find('mensaje').text());
        if (mensaje != "") {
            mostrarMensaje(mensaje);
        }
    }

}

function obtenerDetalleCartaComandaRealizada(item) {
    var contenidoCarta = "";
    $(item).find('datosPlato').each(function() {
        var nombrePlato = $.trim($(this).find('nombre').text());
        var precioPlato = $.trim($(this).find('precio').text());
        contenidoCarta = nombrePlato + " - " + precioPlato + " €";
    });
    return contenidoCarta;
}

function obtenerDetalleMenuComandaRealizada(item) {
    var contenidoMenu = "<ul>";
    var idTipoPlatoAnterior = 0;
    $(item).find('detalleMenu').each(function() {
        var nombrePlato = $.trim($(this).find('nombrePlato').text());
        var cantidadPlato = $.trim($(this).find('cantidad').text());
        var tipoPlato = $.trim($(this).find('tipoPlato').text());
        var idTipoPlato = $.trim($(this).find('idTipoPlato').text());
        var estado = $.trim($(this).find('estado').text());
        //Si se cambio de tipo de plato se muestra el tipo de plato (1er plato ...)
        if (idTipoPlatoAnterior != idTipoPlato) {
            contenidoMenu += tipoPlato;
        }
        contenidoMenu += "<li>" + nombrePlato + " - " + cantidadPlato + " - "
                + estado + "</li>";
        idTipoPlatoAnterior = idTipoPlato;
    });
    contenidoMenu += "</ul>";
    return contenidoMenu;
}

function obtenerDetalleMenuComandaRealizadaCocina(item, idComanda) {
    var contenidoMenu = "<ul>";
    var idTipoPlatoAnterior = 0;
    $(item).find('detalleMenu').each(function() {
        var funcionTerminarPlatoMenu = "";
        var nombrePlato = $.trim($(this).find('nombrePlato').text());
        var idComandaMenu = $.trim($(this).find('id_comanda_menu').text());
        var cantidadPlato = $.trim($(this).find('cantidad').text());
        var tipoPlato = $.trim($(this).find('tipoPlato').text());
        var idTipoPlato = $.trim($(this).find('idTipoPlato').text());
        var estadoPlatoMenu = $.trim($(this).find('estado').text());

        //Si el estado es diferente de terminado se da la opcion de terminar
        if (estadoPlatoMenu !== "TC") {
            //Se generan los enlaces
            funcionTerminarPlatoMenu = "<a onclick=\"doAjax('" + site_url
                    + "/comandas/terminarPlatoMenu','idComandaMenu=" + idComandaMenu
                    + "&idComanda=" + idComanda +
                    "','mostrarComandaRealizadaCocina','post',1)\"> Realizado </a>"
        }

        //Si se cambio de tipo de plato se muestra el tipo de plato (1er plato ...)
        if (idTipoPlatoAnterior != idTipoPlato) {
            contenidoMenu += tipoPlato;
        }
        contenidoMenu += "<li>" + nombrePlato + " - " + cantidadPlato + " - "
                + estadoPlatoMenu + " - " + funcionTerminarPlatoMenu + "</li>";
        idTipoPlatoAnterior = idTipoPlato;
    });
    contenidoMenu += "</ul>";
    return contenidoMenu;
}

function obtenerDetalleArticuloPerComandaRealizada(item) {
    var contenidoPer = "<ul>";
    var tipoArticulo = "";
    tipoArticulo = $.trim($(item).find('tipoArticulo').text());
    contenidoPer += tipoArticulo;
    $(item).find('detalleArticuloPer').each(function() {
        var ingrediente = $.trim($(this).find('ingrediente').text());
        var precioIngrediente = $.trim($(this).find('precio').text());
        contenidoPer += "<li>" + ingrediente + " - "
                + precioIngrediente + " €" + "</li>";
    });
    contenidoPer += "</ul>";
    return contenidoPer;
}

function obtenerDetalleArticuloComandaRealizada(item) {
    //var contenidoArt = "<ul>";
    var contenidoArt = "";
    var contador = 0;
    $(item).find('datosArticulo').each(function() {
        var articulo = $.trim($(this).find('articulo').text());
        var precioArticulo = $.trim($(this).find('precio').text());
        var tipoArticulo = $.trim($(this).find('tipo_articulo').text());
        contenidoArt += tipoArticulo + " - " + articulo + " - "
                + precioArticulo + " €";
    });


    $(item).find('detalleArticulo').each(function() {
        if ($(this).find('ingrediente').length > 0) {
            if (contador == 0) {
                contenidoArt += "<ul>";
            }
            var ingrediente = $.trim($(this).find('ingrediente').text());
            contenidoArt += "<li>" + ingrediente + "</li>";
            contador++;
        }
    });
    if (contador > 0) {
        contenidoArt += "</ul>";
    }

    //contenidoArt += "</ul>";

    return contenidoArt;
}

function listaComandas(item) {
    mostrarComandasActivas(item)
    mostrarComandasCerradas(item)

    //Se muestra el mensaje
    var mensaje = $.trim($(item).find('mensaje').text());
    mostrarMensaje(mensaje);

    //Se resetean todos los formularios
    resetFormularios();
}

function listaComandasCocina(item) {
    mostrarComandasActivasCocina(item)
    mostrarComandasCerradas(item)

    //Se muestra el mensaje
    var mensaje = $.trim($(item).find('mensaje').text());
    mostrarMensaje(mensaje);

    //Se resetean todos los formularios
    resetFormularios();
}

function mostrarComandasActivas(item) {

    var contenidoComandasActivas = "";
    var contenidoCmbComandasActivas = "";
    var precioTotal = "";
    var destino = ""
    var nombreMesa = "";
    var nombreCamarero = "";
    var fechaComanda = "";
    var idMesa = "";
    var idComanda = "";
    var estadoComanda = "";
    var comandasActivas = false;



    //Se obtienen los datos de la comanda
    $(item).find('comandaActiva').each(function() {
        var funcionCerrar = "";
        var funcionVer = "";
        var funcionCancelar = "";

        //Si hay comandas activas se genera la lista
        if ($(this).find('id_comanda').size() > 0 && !comandasActivas) {
            contenidoComandasActivas = "<ul>";
            comandasActivas = true;
        }


        idComanda = $.trim($(this).find('id_comanda').text());
        precioTotal = $.trim($(this).find('precio').text());
        destino = $.trim($(this).find('destino').text());
        idMesa = $.trim($(this).find('id_mesa').text());
        nombreMesa = $.trim($(this).find('nombreMesa').text());
        nombreCamarero = $.trim($(this).find('nombreCamarero').text());
        fechaComanda = $.trim($(this).find('fecha_alta').text());
        estadoComanda = $.trim($(this).find('estado').text());

        //Se genera el contenido del combo de comandas activas
        contenidoCmbComandasActivas += "<option value=\"" + idComanda + "\">";

        //Se generan los enlaces
        funcionCerrar = "<a onclick=\"doAjax('" + site_url
                + "/comandas/cerrarComandaCamarero','idComanda=" + idComanda
                + "','listaComandas','post',1)\"> Cerrar </a>"

        funcionCancelar = "<a onclick=\"doAjax('" + site_url
                + "/comandas/cancelarComandaCamarero','idComanda=" + idComanda
                + "','listaComandas','post',1)\"> Cancelar </a>"

        funcionVer = "<a onclick=\"doAjax('" + site_url
                + "/comandas/verComandaCamarero','idComanda=" + idComanda
                + "','mostrarComandaRealizada','post',1)\"> Ver </a>"

        //Si la comanda es para enviar se muestra el destino, si no la mesa.
        if (idMesa == "0") {
            //Se genera el contenido del combo de comandas activas
            contenidoCmbComandasActivas += idComanda + " - " + destino;

            contenidoComandasActivas += "<li>" + idComanda + " - " + destino
                    + " - " + nombreCamarero + " - "
                    + precioTotal + " - " + estadoComanda + " - " + fechaComanda
                    + funcionCerrar + funcionCancelar + funcionVer + "</li>";
        } else {
            //Se genera el contenido del combo de comandas activas
            contenidoCmbComandasActivas += idComanda + " - " + nombreMesa;

            contenidoComandasActivas += "<li>" + idComanda + " - " + nombreMesa
                    + " - " + nombreCamarero + " - "
                    + precioTotal + " - " + estadoComanda + " - " + fechaComanda
                    + funcionCerrar + funcionCancelar + funcionVer + "</li>";
        }

        //Se genera el contenido del combo de comandas activas
        contenidoCmbComandasActivas += "</option>";

    });

    //Vacio el div donde se muestra las comandas activas y el combo
    $("#listaComandasActivas").empty();
    $("#cmbComandasActivas").empty();

    //Se cierra la lista si hay contenido y se añade al div
    if (comandasActivas) {
        contenidoComandasActivas += "</ul>";
        //Se muestra el contenido
        $("#listaComandasActivas").html(contenidoComandasActivas);

        //Se regenera el combo que contiene las comandas abiertas.    
        $("#cmbComandasActivas").html(contenidoCmbComandasActivas);
    }

    //Se comprueba el valor recibido en el xml para saber si hay que vaicar el div
    if ($.trim($(item).find('vaciarDivComanda').text()) == "1") {
        //Se vacia el div donde se muestran las comandas
        $("#mostrarComanda").empty();
    }

    //Si hay mensaje se muestra 
    if ($(item).find('mensaje').length > 0) {
        var mensaje = $.trim($(item).find('mensaje').text());
        if (mensaje != "") {
            mostrarMensaje(mensaje);
        }
    }

    resetFormularios();


}

function mostrarComandasActivasCocina(item) {

    var contenidoComandasActivas = "";
    var contenidoCmbComandasActivas = "";
    var precioTotal = "";
    var destino = ""
    var nombreMesa = "";
    var nombreCamarero = "";
    var fechaComanda = "";
    var idMesa = "";
    var idComanda = "";
    var estadoComanda = "";
    var comandasActivas = false;
    //Si hay comandas activas se genera la lista
    if ($(item).find('comandaActiva').size() > 0) {
        contenidoComandasActivas = "<ul>";
        comandasActivas = true;
    }

    //Se obtienen los datos de la comanda
    $(item).find('comandaActiva').each(function() {
        var funcionVer = "";
        var funcionTerminar = "";


        idComanda = $.trim($(this).find('id_comanda').text());
        precioTotal = $.trim($(this).find('precio').text());
        destino = $.trim($(this).find('destino').text());
        idMesa = $.trim($(this).find('id_mesa').text());
        nombreMesa = $.trim($(this).find('nombreMesa').text());
        nombreCamarero = $.trim($(this).find('nombreCamarero').text());
        fechaComanda = $.trim($(this).find('fecha_alta').text());
        estadoComanda = $.trim($(this).find('estado').text());

        //Se genera el contenido del combo de comandas activas
        contenidoCmbComandasActivas += "<option value=\"" + idComanda + "\">";

        //Se generan los enlaces
        if (estadoComanda == "EC") {
            funcionTerminar = "<a onclick=\"doAjax('" + site_url
                    + "/comandas/terminarComandaCocina','idComanda=" + idComanda
                    + "','listaComandasCocina','post',1)\"> Terminar </a>";
        }

        funcionVer = "<a onclick=\"doAjax('" + site_url
                + "/comandas/verComandaCamarero','idComanda=" + idComanda
                + "','mostrarComandaRealizadaCocina','post',1)\"> Ver </a>";

        //Si la comanda es para enviar se muestra el destino, si no la mesa.
        if (idMesa == "0") {
            //Se genera el contenido del combo de comandas activas
            contenidoCmbComandasActivas += idComanda + " - " + destino;

            contenidoComandasActivas += "<li>" + idComanda + " - " + destino
                    + " - " + nombreCamarero + " - "
                    + precioTotal + " - " + estadoComanda + " - " + fechaComanda
                    + funcionTerminar + funcionVer + "</li>";
        } else {
            //Se genera el contenido del combo de comandas activas
            contenidoCmbComandasActivas += idComanda + " - " + nombreMesa;

            contenidoComandasActivas += "<li>" + idComanda + " - " + nombreMesa
                    + " - " + nombreCamarero + " - "
                    + precioTotal + " - " + estadoComanda + " - " + fechaComanda
                    + funcionTerminar + funcionVer + "</li>";
        }

        //Se genera el contenido del combo de comandas activas
        contenidoCmbComandasActivas += "</option>";

    });

    //Se cierra la lista si hay contenido
    if (comandasActivas) {
        contenidoComandasActivas += "</ul>";

    }

    //Se comprueba el valor recibido en el xml para saber si hay que vaicar el div
    if ($.trim($(item).find('vaciarDivComanda').text()) == "1") {
        //Se vacia el div donde se muestran las comandas
        $("#mostrarComanda").empty();
    }

    //Vacio el div donde se muestra las comandas activas
    $("#listaComandasActivas").empty();

    //Se muestra el contenido
    $("#listaComandasActivas").html(contenidoComandasActivas);

    //Se regenera el combo que contiene las comandas abiertas.
    $("#cmbComandasActivas").empty();
    $("#cmbComandasActivas").html(contenidoCmbComandasActivas);
}

function mostrarComandasCerradas(item) {

    var contenidoComandasCerradas = "";
    var precioTotal = "";
    var destino = ""
    var nombreMesa = "";
    var nombreCamarero = "";
    var fechaComanda = "";
    var idMesa = "";
    var idComanda = "";
    var estadoComanda = "";
    var comandasCerradas = false;

    //Si hay comandas activas se genera la lista
    if ($(item).find('comandaCerrada').children().size() > 0) {
        contenidoComandasCerradas = "<ul>";
        comandasCerradas = true;
    }

    if (comandasCerradas) {
        //Se obtienen los datos de la comanda
        $(item).find('comandaCerrada').each(function() {
            var funcionVer = "";
            idComanda = $.trim($(this).find('id_comanda').text());
            precioTotal = $.trim($(this).find('precio').text());
            destino = $.trim($(this).find('destino').text());
            idMesa = $.trim($(this).find('id_mesa').text());
            nombreMesa = $.trim($(this).find('nombreMesa').text());
            nombreCamarero = $.trim($(this).find('nombreCamarero').text());
            fechaComanda = $.trim($(this).find('fecha_alta').text());
            estadoComanda = $.trim($(this).find('estado').text());
            funcionVer = "<a onclick=\"doAjax('" + site_url
                    + "/comandas/verComandaCamarero','idComanda=" + idComanda
                    + "','mostrarComandaRealizada','post',1)\"> Ver </a>"

            //Si la comanda es para enviar se muestra el destino, si no la mesa.
            if (idMesa == 0) {
                contenidoComandasCerradas += "<li>" + idComanda + " - " + destino
                        + " - " + nombreCamarero + " - "
                        + precioTotal + " - " + estadoComanda + " - " + fechaComanda
                        + funcionVer + "</li>";
            } else {
                contenidoComandasCerradas += "<li>" + idComanda + " - " +
                        nombreMesa + " - " + nombreCamarero + " - "
                        + precioTotal + " - " + estadoComanda + " - " + fechaComanda
                        + funcionVer + "</li>";
            }


        });

        contenidoComandasCerradas += "</ul>";
    }

//Vacio el div donde se muestra las comandas activas
    $("#listaComandasCerradas").empty();
    //Se muestra el contenido
    $("#listaComandasCerradas").html(contenidoComandasCerradas);
}

/*function mostrarComandaCocina(item) {
 
 var contenido = "";
 var contenidoArt = "";
 var contenidoArtPer = "";
 var contenidoMenu = "";
 var contenidoCarta = "";
 var precioTotal = "";
 var destino = ""
 var observaciones = "";
 var nombreMesa = "";
 var nombreCamarero = "";
 var fechaComanda = "";
 var idMesa = "";
 var idComanda = "";
 var detalleComanda = "";
 var estadoComanda = "";
 //Detalle comanda
 var cantidadDetalleComanda = 0;
 var precioDetalleComanda = 0;
 var idTipoComanda = 0;
 var estadoDetalle = "";
 //Se obtienen los datos de la comanda
 $(item).find('datosComanda').each(function() {
 idComanda = $.trim($(this).find('id_comanda').text());
 precioTotal = $.trim($(this).find('precio').text());
 destino = $.trim($(this).find('destino').text());
 observaciones = $.trim($(this).find('observaciones').text());
 idMesa = $.trim($(this).find('id_mesa').text());
 nombreMesa = $.trim($(this).find('nombreMesa').text());
 nombreCamarero = $.trim($(this).find('nombreCamarero').text());
 fechaComanda = $.trim($(this).find('fecha_alta').text());
 estadoComanda = $.trim($(this).find('estado').text());
 });
 contenido += idComanda + " - " + destino + " - " + nombreMesa + " - " + nombreCamarero
 + " - " + precioTotal + " - " + fechaComanda + " - "
 + estadoComanda + "<br>" + observaciones + "<ul>";
 //Se obtienen el detalle de la comanda
 $(item).find('detalleComanda').each(function() {
 var datosEspecificos = "";
 var tipoComanda = "";
 tipoComanda = $.trim($(this).find('tipoComanda').text())
 
 $(this).find('detalleComandaArticulo').each(function() {
 cantidadDetalleComanda = $.trim($(this).find('cantidad').text());
 precioDetalleComanda = $.trim($(this).find('precio').text());
 idTipoComanda = $.trim($(this).find('id_tipo_comanda').text());
 estadoDetalle = $.trim($(this).find('estado').text());
 });
 switch (parseInt(idTipoComanda)) {
 case 1:
 //Articulo
 datosEspecificos =
 obtenerDetalleArticuloComandaRealizada($(this))
 //En el primer detalle del tipo de comanda se añade cual es
 if (contenidoArt == "") {
 contenidoArt += tipoComanda;
 }
 contenidoArt += "<li>" + cantidadDetalleComanda + " - " +
 precioDetalleComanda + " - " + estadoDetalle + "</li>"
 + datosEspecificos;
 break;
 case 2:
 //Articulo personalizado
 datosEspecificos =
 obtenerDetalleArticuloPerComandaRealizada($(this));
 //En el primer detalle del tipo de comanda se añade cual es
 if (contenidoArtPer == "") {
 contenidoArtPer += tipoComanda;
 }
 
 contenidoArtPer += "<li>" + cantidadDetalleComanda + " - " +
 precioDetalleComanda + " - " + estadoDetalle + "</li>"
 + datosEspecificos;
 break;
 case 3:
 //Menu
 datosEspecificos = obtenerDetalleMenuComandaRealizada($(this));
 //En el primer detalle del tipo de comanda se añade cual es
 if (contenidoMenu == "") {
 contenidoMenu += tipoComanda;
 }
 
 contenidoMenu += "<li>" + cantidadDetalleComanda + " - " +
 precioDetalleComanda + " - " + estadoDetalle + "</li>"
 + datosEspecificos;
 break;
 case 4:
 //Carta
 datosEspecificos = obtenerDetalleCartaComandaRealizada($(this));
 //En el primer detalle del tipo de comanda se añade cual es
 if (contenidoCarta == "") {
 contenidoCarta += tipoComanda;
 }
 
 contenidoCarta += "<li>" + datosEspecificos + " - "
 + cantidadDetalleComanda + " - " +
 precioDetalleComanda + " - " + estadoDetalle + "</li>"
 ;
 break;
 }
 
 });
 contenido += contenidoArt + contenidoArtPer + contenidoMenu + contenidoCarta + "</ul>";
 //Se desabilita el boton de aceptar comanda
 $("#butAceptarComanda").attr("disabled", "disabled");
 $("#butAnadirComanda").attr("disabled", "disabled");
 //Vacio el div donde se muestra la comanda
 $("#mostrarComanda").empty();
 //Se muestra el contenido
 $("#mostrarComanda").html(contenido);
 }*/

$(document).ready(function() {


})
