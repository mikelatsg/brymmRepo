/**
 * Use this ScriptDoc file to manage the documentation for the corresponding namespace in your JavaScript library.
 *
 * @author Mikel
 */
function mostrarPedido(item) {

    $("#detallePedido").empty();
    var contenido = "<ul>";
    var existePedido = 0;
    var funcionBorrar = "";
    var rowid = "";
    var precioTotal;
    $(item).find('pedido').children().each(function() {
        existePedido = 1;
        funcionBorrar = "";
        //Se obtienen los valores del xml
        var nombre = $.trim($(this).find('name').text());
        var cantidad = $.trim($(this).find('qty').text());
        var precio = $.trim($(this).find('price').text());
        var idArticulo = $.trim($(this).find('id').text());
        var tipoArticulo = $.trim($(this).find('tipoArticulo').text());
        rowid = $.trim($(this).find('rowid').text());
        funcionBorrar = "doAjax('" + site_url + "/pedidos/borrarArticulo','rowid=" + rowid
        funcionBorrar = funcionBorrar + "','mostrarPedido','post',1)";
        contenido = contenido + "<li>" + nombre + " - " + cantidad + " - " + precio;
        contenido = contenido + "<a onclick=" + funcionBorrar + "> X </a>";
        contenido = contenido + "<br> " + tipoArticulo;
        $(this).find('ingredientes').each(function() {
            var ingrediente = $.trim($(this).find('ingrediente').text());
            contenido = contenido + " - " + ingrediente;
        });
        contenido = contenido + "</li>";
    });
    contenido = contenido + "</ul>";
    //Se obtiene el total
    precioTotal = "Total : " + $.trim($(item).find('total').text()) + "<br>";
    contenido = contenido + precioTotal
    //Se añade la opción de cancelar si hay algo en el pedido
    if (existePedido == 1) {
        contenido = contenido + "<a onclick=\"doAjax('" + site_url +
                "/pedidos/cancelarPedido','','mostrarPedido','post',1)\">";
        contenido = contenido + "Cancelar";
        contenido = contenido + "</a>";
        //contenido = contenido + "<a href=\"" + site_url + "/pedidos/confirmarPedido/1\">Confirmar</a>";

    }

    $("#detallePedido").html(contenido);
    //Si hay mensaje se muestra 
    if ($(item).find('mensaje').length > 0) {
        var mensaje = $.trim($(item).find('mensaje').text());
        if (mensaje != "") {
            mostrarMensaje(mensaje);
        }
    }

    resetFormularios();
}

function actualizarEstadoPedido(item) {
    var estado = $.trim($(item).find("estado").text());
    $("#estadoPedido").empty();
    $("#estadoPedido").text(estado);
}

function moverPedidoEstado(item) {
    var estado = $.trim($(item).find("estado").text());
    var idPedido = $.trim($(item).find("idPedido").text());
    var estadoAbrv = $.trim($(item).find("estadoAbrv").text());
    //Se vacia el div donde se muestran los pedidos
    $("#mostrarPedido").empty();
    var divDestino = "";
    //Se mueve el pedido al div correspondiente
    if (estadoAbrv == "A") {
        divDestino = "pedidosAceptados";
        $("#pedido_" + idPedido).find('#aceptarPedido').empty();
        funcionTerminar = "<a onclick=";
        funcionTerminar = funcionTerminar + "doAjax('" + site_url + "/pedidos/actualizarEstadoPedido','idPedido=" + idPedido;
        funcionTerminar = funcionTerminar + "&estado=T','moverPedidoEstado','post',1)> Terminar </a>";
        $("#pedido_" + idPedido).find('#aceptarPedido').html(funcionTerminar);
    } else if (estadoAbrv == "T") {
        divDestino = "pedidosTerminados";
        $("#pedido_" + idPedido).find('#modificarEstado').empty();
    } else if (estadoAbrv == "R") {
        divDestino = "pedidosRechazados";
        $("#pedido_" + idPedido).find('#modificarEstado').empty();
    }

    $("#pedido_" + idPedido).appendTo("#" + divDestino);
    //Se muestra el mensaje
    var mensaje = $.trim($(item).find('mensaje').text());
    mostrarMensaje(mensaje);
    //Se resetean todos los formularios
    resetFormularios();
}

function verPedido(item) {

    var contenido = "";
    var idPedido = $.trim($(item).find('idPedido').text());
    var estado = $.trim($(item).find('estado').text());
    var idEstado = $.trim($(item).find('idEstado').text());
    var fechaPedido = $.trim($(item).find('fechaPedido').text());
    var fechaEntrega = $.trim($(item).find('fechaEntrega').text());
    var precio = $.trim($(item).find('precio').text());
    var envioPedido = $.trim($(item).find('envioPedido').text());
    var direccion = "";
    var observaciones = $.trim($(item).find('observaciones').text());
    var motivoRechazo = $.trim($(item).find('motivoRechazo').text());
    var articulo = "";
    var precioArticulo = "";
    var cantidad = "";
    var tipoArticulo = "";
    var idTipoArticulo = "";
    var idTipoArticuloAnterior = 0;
    var ingredientes = "";
    var ingrediente = "";
    var contadorIngredientes;
    //Vacio el div donde se muestra la comanda
    $("#mostrarPedido").empty();
    contenido = "Pedido : " + idPedido + " - Precio : " + precio +
            " - Fecha pedido : " + fechaPedido
            + " - Fecha entrega : " + fechaEntrega + " - Estado : " + estado;
    //Se obtiene la direccion
    $(item).find('direccion').first().each(function() {
        direccion = $.trim($(this).find('direccion').text());
    });

    if (envioPedido != "0") {
        contenido += "<br>Direccion envio : " + direccion;
    }
    contenido += "<br>Observaciones : " + observaciones;
    /*
     * Si el pedido esta rechazado se muestra el motivo
     */
    if (idEstado == "R") {
        contenido += "<br>Motivo rechazo : " + motivoRechazo;
    }
    contenido += "<ul>";
    $(item).find('detallePedido').each(function() {

        articulo = $.trim($(this).find('articulo').text());
        precioArticulo = $.trim($(this).find('precioArticulo').text());
        cantidad = $.trim($(this).find('cantidad').text());
        tipoArticulo = $.trim($(this).find('tipoArticulo').text());
        idTipoArticulo = $.trim($(this).find('idTipoArticulo').text());
        ingredientes = "";
        contadorIngredientes = 0;
        $(this).find('detalleArticulo').each(function() {
            ingrediente = $.trim($(this).find('ingrediente').text());
            if (contadorIngredientes == 0) {
                ingredientes += ingrediente;
            } else {
                ingredientes += " - " + ingrediente;
            }
            contadorIngredientes++;
        });
        if (idTipoArticulo != idTipoArticuloAnterior) {
            contenido += tipoArticulo;
        }
        contenido += "<li>";
        contenido += articulo + " - " + precioArticulo + " - " + cantidad;
        contenido += "<br>" + ingredientes;
        contenido += "</li>";
        idTipoArticuloAnterior = idTipoArticulo;
    });
    contenido += "</ul>";
    $("#mostrarPedido").html(contenido);
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
     * Datepicker fecha recogida pedido (Usuario)
     */
    $("#datepickerFechaRecogidaPedido").datepicker();
    $("#datepickerFechaRecogidaPedido").datepicker("option", "dateFormat", "yy-mm-dd");
    $("#datepickerFechaRecogidaPedido").val(today);
    /*
     * Datepicker fecha entrega pedido (local)
     */
    $("#datePickerFechaEntregaPedido").datepicker();
    $("#datePickerFechaEntregaPedido").datepicker("option", "dateFormat", "yy-mm-dd");
    $("#datePickerFechaEntregaPedido").val(today);
    /*
     * Ventana modal aceptar pedido
     */
    $('.enlaceAceptarPedido').click(function() {
        $("#dialog").dialog({
            width: 600,
            modal: true,
            buttons: {
                "Aceptar": function() {
//Se envia el formulario que acutaliza el estado
                    enviarFormulario(site_url + '/pedidos/actualizarEstadoPedido'
                            , 'formAceptarPedido', 'moverPedidoEstado', 1);
                    //Se cierra el dialogo        
                    $(this).dialog("close");
                },
                Cancel: function() {
//Se cierra el dialogo
                    $(this).dialog("close");
                }
            },
            close: function(event, ui) {
//Se cierra el dialogo
                $(this).dialog("close");
            }
        });
        /*
         * Se añade al campo oculto el id del pedido
         */
        $('#idPedidoForm').val($(this).data('id'));
        $('#dialog').dialog('open');
        return false;
    });
    /*
     * Ventana modal rechazar pedido
     */
    $('.enlaceRechazarPedido').click(function() {
        $("#dialogRechazar").dialog({
            width: 600,
            modal: true,
            buttons: {
                "Aceptar": function() {
//Se envia el formulario que acutaliza el estado
                    enviarFormulario(site_url + '/pedidos/actualizarEstadoPedido'
                            , 'formRechazarPedido', 'moverPedidoEstado', 1);
                    //Se cierra el dialogo        
                    $(this).dialog("close");
                },
                Cancel: function() {
//Se cierra el dialogo
                    $(this).dialog("close");
                }
            },
            close: function(event, ui) {
//Se cierra el dialogo
                $(this).dialog("close");
            }
        });
        /*
         * Se añade al campo oculto el id del pedido
         */
        $('#idPedidoFormRechazar').val($(this).data('id'));
        $('#dialogRechazar').dialog('open');
        return false;
    });
});
