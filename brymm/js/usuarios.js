/**
 * Use this ScriptDoc file to manage the documentation for the corresponding namespace in your JavaScript library.
 *
 * @author Mikel
 */
function listaDireccionEnvio(item) {

    alert('listaServiciosLocal');
}

function verPedidoHomeUsuario(item) {

    var contenido = "";
    var idPedido = $.trim($(item).find('idPedido').text());
    var estado = $.trim($(item).find('estado').text());
    var idEstado = $.trim($(item).find('idEstado').text());
    var fechaPedido = $.trim($(item).find('fechaPedido').text());
    var fechaEntrega = $.trim($(item).find('fechaEntrega').text());
    var precio = $.trim($(item).find('precio').text());
    var envioPedido = $.trim($(item).find('envioPedido').text());
    var direccion = $.trim($(item).find('direccion').text());
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
    $("#muestraDetalle").empty();
    contenido = "<h4>Pedido " + idPedido + "</h4>"
    contenido += "Pedido : " + idPedido + " - Precio : " + precio +
            " - Fecha pedido : " + fechaPedido
            + " - Fecha entrega : " + fechaEntrega + " - Estado : " + estado;
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
    $("#muestraDetalle").html(contenido);
}

function mostrarReservaHomeUsuario(item) {
    var contenido = "";
    var idReserva = $.trim($(item).find('idReserva').text());
    var estado = $.trim($(item).find('estado').text());
    var fecha = $.trim($(item).find('fecha').text());
    var numeroPersonas = $.trim($(item).find('numeroPersonas').text());
    var tipoMenu = $.trim($(item).find('tipoMenu').text());
    var horaInicio = $.trim($(item).find('horaInicio').text());
    var observaciones = $.trim($(item).find('observaciones').text());
    var motivoRechazo = $.trim($(item).find('motivo').text());

    contenido = "<h4>Reserva " + idReserva + "</h4>"
    contenido += "Reserva : " + idReserva + " - Fecha : " + fecha +
            " - Hora : " + horaInicio +
            " - Numero personas : " + numeroPersonas
            + " - " + tipoMenu + " - Estado : " + estado;
    contenido += "<br>Observaciones : " + observaciones;

    /*
     * Si el pedido esta rechazado se muestra el motivo
     */
    if (estado == "RL") {
        contenido += "<br>Motivo rechazo : " + motivoRechazo;
    }

    $("#muestraDetalleReserva").empty();
    $("#muestraDetalleReserva").html(contenido);
}

function eliminarLocalFavorito(item) {

    var idLocal = $.trim($(item).find("idLocal").text());
    $("#localesFavoritos").find('#local_' + idLocal).remove();
}

function actualizarDirecciones(item) {

    var nombreDireccion = "";
    var idDireccionEnvio = "";
    var direccion = "";
    var poblacion = "";
    var contenidoCombo = "";
    var contenidoLista = "";
    var hayCombo = false;
    var hayLista = false;
    var enlaceBorrar = "";

    if ($("#comboDireccionesEnvio").length) {
        hayCombo = true;
        $("#comboDireccionesEnvio").empty();
    }

    if ($("#listaDirecciones").length) {
        hayLista = true;
        $("#listaDirecciones").empty();
        contenidoLista += "<ul>";
    }

    $(item).find('direccionEnvio').each(function() {



        nombreDireccion = $.trim($(this).find('nombre').text());
        idDireccionEnvio = $.trim($(this).find('id_direccion_envio').text());
        direccion = $.trim($(this).find('direccion').text());
        poblacion = $.trim($(this).find('poblacion').text());

        //Se crea el enlace para poder borrar los platos del local
        enlaceBorrar = "<a onclick=\"doAjax('" + site_url
                + "/usuarios/borrarDireccionEnvio','idDireccionEnvio="
                + idDireccionEnvio + "','actualizarDirecciones','post',1)\"> Borrar </a>";


        if (hayCombo) {
            contenidoCombo += "<option value=\"" + idDireccionEnvio + "\">" + nombreDireccion + "</option>";
        }

        if (hayLista) {
            contenidoLista += "<li>";
            contenidoLista += " Nombre direccion : " + nombreDireccion;
            contenidoLista += " - Direccion : " + direccion;
            contenidoLista += " - Poblacion : " + poblacion;
            contenidoLista += enlaceBorrar;
            contenidoLista += "</li>";
        }

    });
    if (hayCombo) {
        $("#comboDireccionesEnvio").html(contenidoCombo);
    }

    if (hayLista) {
        contenidoLista += "</ul>";
        $("#listaDirecciones").html(contenidoLista);
    }

    //<option value="<?php echo $linea->id_direccion_envio; ?>"><?php echo $linea->nombre; ?></option>
}

$(document).ready(function() {
    /*
     * Ventana modal añadir direccion
     */
    $('.enlaceAnadirDireccion').click(function() {
        $("#dialogAnadirDireccion").dialog({
            width: 600,
            modal: true,
            buttons: {
                "Aceptar": function() {
                    //Se envia el formulario que acutaliza el estado
                    enviarFormulario(site_url + '/usuarios/anadirDireccionEnvio'
                            , 'formAnadirDireccionEnvio', 'actualizarDirecciones', 1);
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
        $('#dialog').dialog('open');
        return false;
    });
});