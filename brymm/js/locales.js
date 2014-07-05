/**
 * Use this ScriptDoc file to manage the documentation for the corresponding namespace in your JavaScript library.
 *
 * @author Mikel
 */

function listaValoraciones(item) {
    var nick = "";
    var fecha = "";
    var observaciones = "";
    var nota = ""
    var contenido = "";
    var contador = 0;
    $(item).find('valoracionLocal').each(function() {
        if (contador === 0) {
            contenido = contenido + "<ul>";
        }

        //Se obtienen los valores del xml
        nick = $.trim($(this).find('nick').text());
        fecha = $.trim($(this).find('fecha').text());
        nota = $.trim($(this).find('nota').text());
        observaciones = $.trim($(this).find('observaciones').text());


        //Se genera el contenido de cada articulo
        contenido += "<li>";
        contenido += "Usuario : " + nick
                + " - Fecha : " + fecha
                + " - Nota : " + nota
                + "<br> Observaciones : " + observaciones;
        contenido += "</li>";
        contador++;
    });
    if (contador > 0) {
        contenido = contenido + "</ul>";
    }

    //Se vacia la lista para rellenar con el contenido
    $("#listaValoraciones").empty();
    $("#listaValoraciones").html(contenido);
    
    //Si hay mensaje se muestra 
    if ($(item).find('mensaje').length > 0) {
        var mensaje = $.trim($(item).find('mensaje').text());
        if (mensaje != "") {
            mostrarMensaje(mensaje);
        }
    }

    resetFormularios();
}

$(document).ready(function() {

    /*
     * Ventana modal añadir valoracion
     */
    $('.enlaceAnadirValoracionLocal').click(function() {
        $("#dialogAnadirValoracionLocal").dialog({
            width: 600,
            modal: true,
            buttons: {
                "Aceptar": function() {
                    //Se envia el formulario que acutaliza el estado
                    enviarFormulario(site_url + '/valoraciones/anadirValoracionLocal'
                            , 'formAnadirValoracionLocal', 'listaValoraciones', 1);
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
        $('#dialogAnadirValoracionLocal').dialog('open');
        return false;
    });
});
