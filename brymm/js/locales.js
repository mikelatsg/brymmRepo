/**
 * Use this ScriptDoc file to manage the documentation for the corresponding
 * namespace in your JavaScript library.
 * 
 * @author Mikel
 */

function listaValoraciones(item) {
	var nick = "";
	var fecha = "";
	var observaciones = "";
	var nota = ""
	var contenido = "";
	var idLocal = "";
	var contador = 0;
	$(item)
			.find('valoracionLocal')
			.each(
					function() {
						contador += 1;
						// Se obtienen los valores del xml
						nick = $.trim($(this).find('nick').text());
						fecha = $.trim($(this).find('fecha').text());
						nota = $.trim($(this).find('nota').text());
						observaciones = $.trim($(this).find('observaciones')
								.text());
						idLocal = $.trim($(this).find('id_local').text());

						contenido += "<div class=\"col-md-12 well\">";

						contenido += "<div class=\"col-md-4\">";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";

						contenido += "<tr>";
						contenido += "<td class=\"titulo\">";
						contenido += "Usuario";
						contenido += "</td>";
						contenido += "<td>";
						contenido += nick;
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "<tr>";
						contenido += "<td class=\"titulo\">";
						contenido += "Fecha";
						contenido += "</td>";
						contenido += "<td>";
						contenido += fecha;
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "<tr>";
						contenido += "<td class=\"titulo\">";
						contenido += "Nota";
						contenido += "</td>";
						contenido += "<td>";
						contenido += "<div class=\"progress\">";
						if (nota <= 3) {
							contenido += "<div class=\"progress-bar progress-bar-danger\" role=\"progressbar\""
									+ "aria-valuenow=\""
									+ nota
									+ "\" aria-valuemin=\"0\" aria-valuemax=\"10\""
									+ "style=\"width: "
									+ (nota * 100 / 10)
									+ "%;\">";
						} else if ((nota > 3 && nota <= 5)) {
							contenido += "<div class=\"progress-bar progress-bar-warning\" role=\"progressbar\""
									+ "aria-valuenow=\""
									+ nota
									+ "\" aria-valuemin=\"0\" aria-valuemax=\"10\""
									+ "style=\"width: "
									+ (nota * 100 / 10)
									+ "%;\">";
						} else if ((nota > 5 && nota <= 7)) {
							contenido += "<div class=\"progress-bar progress-bar-primary\" role=\"progressbar\""
									+ "aria-valuenow=\""
									+ nota
									+ "\" aria-valuemin=\"0\" aria-valuemax=\"10\""
									+ "style=\"width: "
									+ (nota * 100 / 10)
									+ "%;\">";
						} else if ((nota > 7)) {
							contenido += "<div class=\"progress-bar progress-bar-success\" role=\"progressbar\""
									+ "aria-valuenow=\""
									+ nota
									+ "\" aria-valuemin=\"0\" aria-valuemax=\"10\""
									+ "style=\"width: "
									+ (nota * 100 / 10)
									+ "%;\">";
						}
						contenido += nota;
						contenido += "</div>";
						contenido += "</div>";
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";

						contenido += "<div class=\"col-md-8\">";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";

						contenido += "<tr>";
						contenido += "<td class=\"titulo\">";
						contenido += "Observaciones";
						contenido += "</td>";
						contenido += "<td>";
						contenido += observaciones;
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";

						contenido += "</div>";

						// Se genera el contenido de cada articulo
						/*
						 * contenido += "<li>"; contenido += "Usuario : " +
						 * nick + " - Fecha : " + fecha + " - Nota : " + nota + "<br>
						 * Observaciones : " + observaciones; contenido += "</li>";
						 * contador++;
						 */
					});

	if (contador <= 5) {
		contenido += "<div class=\"col-md-12\">";
		contenido += "<a onclick=\"doAjax('" + site_url
				+ "/valoraciones/mostrarTodasValoracionesLocal','idLocal="
				+ idLocal + "','listaValoraciones','post',1)\">"
				+ "<i class=\"fa fa-plus\"></i> Mostrar todas</a>";
		contenido += "</div>";
	}

	// Se vacia la lista para rellenar con el contenido
	$("#listaValoracionesLocal").empty();
	$("#listaValoracionesLocal").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

	resetFormularios();
}

function gestionFavorito(item) {
	$('#enlaceFavorito').empty();
	var favorito = $.trim($(item).find('favorito').text());
	var idLocal = $.trim($(item).find('idLocal').text());
	var button = "";		
	if (favorito == "1") {		
		button += "<a ";
		button += "onclick=\"doAjax('";
		button += site_url + "/locales/quitarLocalFavorito','idLocal=";
		button += idLocal + "','gestionFavorito','post',1)\">";
		button += "<i class=\"fa fa-star starColor fa-2x\"";
		button += " title=\"Eliminar favorito\"></i>";
		button += "</a>";
	} else {
		button += "<a ";
		button += "onclick=\"doAjax('";
		button += site_url + "/locales/anadirLocalFavorito','idLocal=";
		button += idLocal + "','gestionFavorito','post',1)\">";
		button += "<i class=\"fa fa-star-o starColor fa-2x\"";
		button += " title=\"Agregar a favorito\"></i>";
		button += "</a>";
	}

	// alert(button);

	$('#enlaceFavorito').html(button);

	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

}

$(document)
		.ready(
				function() {

					/*
					 * Ventana modal añadir valoracion
					 */
					$('.enlaceAnadirValoracionLocal')
							.click(
									function() {
										$("#dialogAnadirValoracionLocal")
												.dialog(
														{
															width : 600,
															modal : true,
															buttons : {
																"Aceptar" : function() {
																	// Se envia
																	// el
																	// formulario
																	// que
																	// acutaliza
																	// el estado
																	enviarFormulario(
																			site_url
																					+ '/valoraciones/anadirValoracionLocal',
																			'formAnadirValoracionLocal',
																			'listaValoraciones',
																			1);
																	// Se cierra
																	// el
																	// dialogo
																	$(this)
																			.dialog(
																					"close");
																},
																Cancel : function() {
																	// Se cierra
																	// el
																	// dialogo
																	$(this)
																			.dialog(
																					"close");
																}
															},
															close : function(
																	event, ui) {
																// Se cierra el
																// dialogo
																$(this)
																		.dialog(
																				"close");
															}
														});
										$('#dialogAnadirValoracionLocal')
												.dialog('open');
										return false;
									});
				});
