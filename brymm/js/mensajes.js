/**
 * Use this ScriptDoc file to manage the documentation for the corresponding
 * namespace in your JavaScript library.
 * 
 * @author Mikel
 */

function mostrarMensaje(mensaje) {

	$("#dialogMensaje").dialog({
		width : 600,
		height : 150,
		show : "fade",
		hide : "fade",
		resizable : "false",
		position : {
			at : "right top",
			of : window
		}
	});

	// var contenido = "<div id=\"alertMensaje\" class=\"alert alert-success
	// text-center\" role=\"alert\">";
	var contenido = "<div id=\"alertMensaje\" class=\"well\" role=\"alert\">";
	// contenido += "<strong>";
	contenido += mensaje;
	// contenido += "</strong>";
	contenido += "</div>";
	contenido += "<div id=\"iconoMensaje\"><span id=\"imgInfoMensaje\" class=\"glyphicon glyphicon-info-sign\"></span></div>";

	$("#dialogMensaje").empty();
	$("#dialogMensaje").html(contenido);
	$(".ui-dialog-titlebar").hide()

	setTimeout(function() {
		$("#dialogMensaje").dialog("close")
	}, 5000);
}

function mostrarMensajeXml(item) {
	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}
}

function resetFormularios() {
	$('form').each(function() {
		this.reset();
	});
}

$(document).ready(function() {

});
