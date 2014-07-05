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

    $("#dialogMensaje").empty();
    $("#dialogMensaje").html(mensaje);

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
