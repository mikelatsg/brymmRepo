/**
 * Use this ScriptDoc file to manage the documentation for the corresponding namespace in your JavaScript library.
 *
 * @author Mikel
 */

function mostrarMensaje(mensaje) {

    $("#dialogMensaje").dialog({
        width: 400,
        height: 150,
        show: "clip",
        hide: "clip",
        resizable: "false",
        position: {at: "right top", of: window}
    });

    var contenido = "<div class=\"alert alert-warning\" role=\"alert\">";
    contenido += "<span class=\"glyphicon glyphicon-info-sign\">";
    contenido += "</span>";
    contenido += " " + mensaje;    
    contenido += "</div>";
    
    $("#dialogMensaje").empty();
    $("#dialogMensaje").html(contenido);

    setTimeout(function() {
        $("#dialogMensaje").dialog("close")
    }, 5000);
}

function resetFormularios() {
    $('form').each(function() {
        this.reset();
    });
}


$(document).ready(function() {

});
