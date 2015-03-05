/**
 * Use this ScriptDoc file to manage the documentation for the corresponding
 * namespace in your JavaScript library.
 * 
 * @author Mikel
 */
function listaDireccionEnvio(item) {

	var nombreDireccion = "";
	var idDireccionEnvio = "";
	var direccion = "";
	var poblacion = "";
	var provincia = "";
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
		contenidoLista += "";
	}

	$(item)
			.find('direccionEnvio')
			.each(
					function() {

						nombreDireccion = $.trim($(this).find('nombre').text());
						idDireccionEnvio = $.trim($(this).find(
								'id_direccion_envio').text());
						direccion = $.trim($(this).find('direccion').text());
						poblacion = $.trim($(this).find('poblacion').text());
						provincia = $.trim($(this).find('provincia').text());

						// Se crea el enlace para poder borrar las direcciones
						enlaceBorrar = "";
						enlaceBorrar += "<button class=\"btn btn-danger btn-sm pull-right\" type=\"button\"";
						enlaceBorrar += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						enlaceBorrar += "onclick=";
						enlaceBorrar += "doAjax('"
								+ site_url
								+ "/usuarios/borrarDireccionEnvio','idDireccionEnvio="
								+ idDireccionEnvio
								+ "','listaDireccionEnvio','post',1)>";
						enlaceBorrar += "<span class=\"glyphicon glyphicon-remove\"></span>";
						enlaceBorrar += "</button>";

						if (hayCombo) {
							contenidoCombo += "<option value=\""
									+ idDireccionEnvio + "\">"
									+ nombreDireccion + "</option>";
						}

						if (hayLista) {
							contenidoLista += "<div class=\"list-div col-md-12\">";
							contenidoLista += "<table class=\"table\">";
							contenidoLista += "<tbody>";

							contenidoLista += "<tr>";
							contenidoLista += "<td class=\"titulo\" colspan=\"4\">"
									+ nombreDireccion + enlaceBorrar
							"</td>";
							contenidoLista += "</tr>";

							contenidoLista += "<tr>";
							contenidoLista += "<td class=\"titulo col-md-2\">Direccion</td>";
							contenidoLista += "<td class=\"col-md-10\" colspan=\"3\">"
									+ direccion + "</td>";
							contenidoLista += "</tr>";

							contenidoLista += "<tr>";
							contenidoLista += "<td class=\"titulo col-md-2\">Poblacion</td>";
							contenidoLista += "<td class=\"col-md-4\">"
									+ poblacion + "</td>";
							contenidoLista += "<td class=\"titulo col-md-2\">Provincia</td>";
							contenidoLista += "<td class=\"col-md-4\">"
									+ provincia + "</td>";
							contenidoLista += "</tr>";

							contenidoLista += "</tbody>";
							contenidoLista += "</table>";
							contenidoLista += "</div>";
						}

					});

	// Enlace a�adir direccion
	contenidoLista += "<div id=\"anadirDireccion\">";
	contenidoLista += " <a onclick=\"anadirDireccion(true)\" data-toggle=\"modal\">";
	contenidoLista += "<i class=\"fa fa-plus\"></i> Anadir direccion</a>";
	contenidoLista += "</div>";

	if (hayCombo) {
		$("#comboDireccionesEnvio").html(contenidoCombo);
	}

	if (hayLista) {
		$("#listaDirecciones").html(contenidoLista);
	}
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
	// Vacio el div donde se muestra la comanda
	$("#muestraDetalle").empty();

	// Cabecera del pedido
	contenido += "<div class=\"col-md-6\">";
	contenido += "<div class=\"pedido col-md-12\">";
	contenido += "<span class=\"badge pull-left\">Pedido " + idPedido
			+ "</span>";
	contenido += "</div>";
	contenido += "<div class=\"well col-md-12\">";
	contenido += "<div class=\"span6\">";
	contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
	contenido += "<tbody>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Precio</td>";
	contenido = contenido + "<td>" + precio
			+ " <i class=\"fa fa-euro\"></i></td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Fecha pedido</td>";
	contenido = contenido + "<td>" + fechaPedido + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Fecha entrega</td>";
	contenido = contenido + "<td>" + fechaEntrega + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Estado</td>";
	contenido = contenido + "<td>" + estado + "</td>";
	contenido = contenido + "</tr>";

	if (envioPedido != "0") {
		contenido += "<tr>";
		contenido += "<td class=\"titulo\">Direccion envio</td>";
		contenido += "<td>" + direccion + "</td>";
		contenido += "</tr>";
	}

	contenido += "<tr>";
	contenido += "<td class=\"titulo\">Observaciones</td>";
	contenido += "<td>" + observaciones + "</td>";
	contenido += "</tr>";

	if (idEstado == "R") {
		contenido += "<tr>";
		contenido += "<td class=\"titulo\">Motivo rechazo</td>";
		contenido += "<td>" + motivoRechazo + "</td>";
		contenido += "</tr>";
	}

	// Cerrar divs y tablas
	contenido += "</tbody>";
	contenido += "</table>";
	contenido += "</div>";
	contenido += "</div>";
	contenido += "</div>";

	contenido += "<div class=\"col-md-6\">";
	$(item)
			.find('detallePedido')
			.each(
					function() {

						articulo = $.trim($(this).find('articulo').text());
						precioArticulo = $.trim($(this).find('precioArticulo')
								.text());
						cantidad = $.trim($(this).find('cantidad').text());
						tipoArticulo = $.trim($(this).find('tipoArticulo')
								.text());
						idTipoArticulo = $.trim($(this).find('idTipoArticulo')
								.text());
						ingredientes = "";
						contadorIngredientes = 0;
						$(this).find('detalleArticulo').each(
								function() {
									ingrediente = $.trim($(this).find(
											'ingrediente').text());
									if (contadorIngredientes == 0) {
										ingredientes += ingrediente;
									} else {
										ingredientes += ", " + ingrediente;
									}
									contadorIngredientes++;
								});

						if (idTipoArticulo != idTipoArticuloAnterior
								&& idTipoArticuloAnterior != 0) {
							contenido += "</tbody>";
							contenido += "</table>";
							contenido += "</div>";
							contenido += "</div>";

						}

						if (idTipoArticulo != idTipoArticuloAnterior) {
							contenido += "<div class=\"row\">";
							contenido += "<span class=\"badge progress-bar-danger\">"
									+ tipoArticulo + "</span>";
							contenido += "</div>";
							contenido += "<div class=\"well col-md-12\">";
							contenido += "<div class=\"span6\">";
							contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
							contenido += "<tbody>";
						}

						contenido += "<tr>";
						contenido += "<td class=\"titulo\">Articulo</td>";
						contenido += "<td>" + articulo + "</td>";
						contenido += "</tr>";

						contenido += "<tr>";
						contenido += "<td class=\"titulo\">Precio</td>";
						contenido += "<td>" + precioArticulo
								+ " <i class=\"fa fa-euro\"></i></td>";
						contenido += "</tr>";

						contenido += "<tr>";
						if (contadorIngredientes > 0) {
							contenido += "<td class=\"titulo\">Cantidad</td>";
						} else {
							contenido += "<td class=\"titulo separadorArticulo\">Cantidad</td>";
						}
						contenido += "<td>" + cantidad + "</td>";
						contenido += "</tr>";

						if (contadorIngredientes > 0) {
							contenido += "<tr>";
							contenido += "<td class=\"separadorArticulo titulo\">Ingredientes</td>";
							contenido += "<td class=\"separadorArticulo\">"
									+ ingredientes + "</td>";
							contenido += "</tr>";
						}

						idTipoArticuloAnterior = idTipoArticulo;
					});
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

	contenido += "<div class=\"col-md-8\">";
	contenido += "<div class=\"pedido col-md-12\">";
	contenido += "<span class=\"badge pull-left\">Reserva " + idReserva
			+ "</span>";
	contenido += "</div>";
	contenido += "<div class=\"well col-md-12\">";
	contenido += "<div class=\"span6\">";
	contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
	contenido += "<tbody>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Fecha</td>";
	contenido = contenido + "<td>" + fecha + " </td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Hora</td>";
	contenido = contenido + "<td>" + horaInicio + " </td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Numero de personas</td>";
	contenido = contenido + "<td>" + numeroPersonas + " </td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Tipo menu</td>";
	contenido = contenido + "<td>" + tipoMenu + " </td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Estado</td>";
	contenido = contenido + "<td>" + estado + " </td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Observaciones</td>";
	contenido = contenido + "<td>" + observaciones + " </td>";
	contenido = contenido + "</tr>";

	if (estado == "RL") {
		contenido = contenido + "<tr>";
		contenido = contenido + "<td class=\"titulo\">Motivo rechazo</td>";
		contenido = contenido + "<td>" + motivoRechazo + " </td>";
		contenido = contenido + "</tr>";
	}

	contenido += "</tbody>";
	contenido += "</table>";
	contenido += "</div>";
	contenido += "</div>";
	contenido += "</div>";

	/*
	 * contenido = "<h4>Reserva " + idReserva + "</h4>" contenido +=
	 * "Reserva : " + idReserva + " - Fecha : " + fecha + " - Hora : " +
	 * horaInicio + " - Numero personas : " + numeroPersonas + " - " + tipoMenu + " -
	 * Estado : " + estado; contenido += "<br>Observaciones : " +
	 * observaciones;
	 */

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
	var provincia = "";
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
		contenidoLista += "";
	}

	$(item)
			.find('direccionEnvio')
			.each(
					function() {

						nombreDireccion = $.trim($(this).find('nombre').text());
						idDireccionEnvio = $.trim($(this).find(
								'id_direccion_envio').text());
						direccion = $.trim($(this).find('direccion').text());
						poblacion = $.trim($(this).find('poblacion').text());
						provincia = $.trim($(this).find('provincia').text());

						// Se crea el enlace para poder borrar los platos del
						// local
						/*
						 * enlaceBorrar = "<a onclick=\"doAjax('" + site_url +
						 * "/usuarios/borrarDireccionEnvio','idDireccionEnvio=" +
						 * idDireccionEnvio +
						 * "','actualizarDirecciones','post',1)\"> Borrar </a>";
						 */
						enlaceBorrar = "";
						enlaceBorrar += "<button class=\"btn btn-danger btn-sm pull-right\" type=\"button\"";
						enlaceBorrar += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						enlaceBorrar += "onclick=";
						enlaceBorrar += "doAjax('"
								+ site_url
								+ "/usuarios/borrarDireccionEnvio','idDireccionEnvio="
								+ idDireccionEnvio
								+ "','actualizarDirecciones','post',1)>";
						enlaceBorrar += "<span class=\"glyphicon glyphicon-remove\"></span>";
						enlaceBorrar += "</button>";

						if (hayCombo) {
							contenidoCombo += "<option class=\"form-control\" value=\""
									+ idDireccionEnvio
									+ "\">"
									+ nombreDireccion + "</option>";
						}

						if (hayLista) {
							contenidoLista += "<div class=\"list-div col-md-12\">";
							contenidoLista += "<table class=\"table\">";
							contenidoLista += "<tbody>";

							contenidoLista += "<tr>";
							contenidoLista += "<td class=\"titulo\" colspan=\"4\">"
									+ nombreDireccion + enlaceBorrar
							"</td>";
							contenidoLista += "</tr>";

							contenidoLista += "<tr>";
							contenidoLista += "<td class=\"titulo col-md-2\">Direccion</td>";
							contenidoLista += "<td class=\"col-md-10\" colspan=\"3\">"
									+ direccion + "</td>";
							contenidoLista += "</tr>";

							contenidoLista += "<tr>";
							contenidoLista += "<td class=\"titulo col-md-2\">Poblacion</td>";
							contenidoLista += "<td class=\"col-md-4\">"
									+ poblacion + "</td>";
							contenidoLista += "<td class=\"titulo col-md-2\">Provincia</td>";
							contenidoLista += "<td class=\"col-md-4\">"
									+ provincia + "</td>";
							contenidoLista += "</tr>";

							contenidoLista += "</tbody>";
							contenidoLista += "</table>";
							contenidoLista += "</div>";
						}

					});

	if (hayCombo) {
		$("#comboDireccionesEnvio").html(contenidoCombo);
	}

	if (hayLista) {
		$("#listaDirecciones").html(contenidoLista);
	}
}

function anadirDireccion(esListaHome) {
	esListaHome = (typeof esListaHome === "undefined") ? false : esListaHome;

	$("#dialogAnadirDireccion").dialog(
			{
				width : 600,
				modal : true,
				buttons : {
					"Aceptar" : function() {
						if (esListaHome) {
							// Se envia el formulario que acutaliza el estado
							enviarFormulario(site_url
									+ '/usuarios/anadirDireccionEnvio',
									'formAnadirDireccionEnvio',
									'listaDireccionEnvio', 1);
						} else {
							// Se envia el formulario que acutaliza el estado
							enviarFormulario(site_url
									+ '/usuarios/anadirDireccionEnvio',
									'formAnadirDireccionEnvio',
									'actualizarDirecciones', 1);
						}

						// Se cierra el dialogo
						$(this).dialog("close");
					},
					Cancel : function() {
						// Se cierra el dialogo
						$(this).dialog("close");
					}
				},
				close : function(event, ui) {
					// Se cierra el dialogo
					$(this).dialog("close");
				}
			});
	/*
	 * Se añade al campo oculto el id del pedido
	 */
	$('#dialog').dialog('open');
	return false;
}

function listaPedidosUsuario(item) {
	var idPedido = "";
	var precio = "";
	var estado = "";
	var idEstado = "";
	var idLocal = "";
	var nombreLocal = "";
	var contenido = "";
	var fechaPedido = "";

	var d = new Date();
	var curr_date = d.getDate();
	var curr_month = d.getMonth() + 1;
	var curr_year = d.getFullYear();
	if (curr_month < 10) {
		curr_month = "0" + curr_month;
	}
	var fechaActual = curr_year + "-" + curr_month + "-" + curr_date;
	var fecha = "";

	$(item)
			.find('xml')
			.children('pedido')
			.each(
					function() {
						idPedido = $.trim($(this).find('idPedido').text());
						precio = $.trim($(this).find('precio').text());
						estado = $.trim($(this).find('estado').text());
						idEstado = $.trim($(this).find('idEstado').text());
						idLocal = $.trim($(this).find('idLocal').text());
						nombreLocal = $
								.trim($(this).find('nombreLocal').text());
						fechaPedido = $
								.trim($(this).find('fechaPedido').text());
						fecha = fechaPedido.split(" ")[0];

						// Se crea el enlace para poder anular la reserva
						botonVer = "<button class=\"btn btn-default btn-sm pull-right\""
								+ "type=\"button\" data-toggle=\"tooltip\""
								+ "data-original-title=\"Remove this user\" onclick=\""
								+ "doAjax('"
								+ site_url
								+ "/pedidos/verPedido','idPedido="
								+ idPedido
								+ "','verPedidoHomeUsuario','post',1)\" title=\"Ver detalle del pedido\">"
								+ "<span class=\"glyphicon glyphicon-eye-open\"></span>"
								+ "</button>";

						botonRegenerar = "<a class=\"btn btn-warning btn-sm pull-right\""
								+ "role=\"button\""
								+ "href=\""
								+ site_url
								+ "/pedidos/generarPedidoAntiguo/"
								+ idPedido
								+ "\""
								+ "title=\"Cargar el pedido para realizar un nuevo pedido\">"
								+ "<i class=\"fa fa-refresh\"></i> </a>";

						botonVerEstado = "<a class=\"btn btn-primary btn-sm pull-right\""
								+ "role=\"button\""
								+ "href=\""
								+ site_url
								+ "/pedidos/mostrarEstadoPedido/"
								+ idPedido
								+ "\""
								+ "title=\"Ver el estado del pedido\">"
								+ "<i class=\"fa fa-tag\"></i> </a>";

						contenido += "<div class=\"col-md-12 list-div\">";
						contenido += "<table class=\"table\">";
						contenido += "<tbody>";

						contenido += "<tr>";
						contenido += "<td colspan=\"3\" class=\"text-left titulo\">";
						contenido += "Pedido " + idPedido;
						contenido += botonVer;
						if (fecha == fechaActual) {
							contenido += botonVerEstado;
						}
						contenido += botonRegenerar;
						/*
						 * if (estado == 'P' || estado == 'AL') { contenido +=
						 * botonAnular; }
						 */
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "<tr>";
						contenido += "<td>";
						contenido += precio + " <i class=\"fa fa-euro\" title=\"Precio\"></i>";
						contenido += "</td>";
						contenido += "<td>";
						contenido += estado + " <i class=\"fa fa-tag\" title=\"Estado\"></i>";
						contenido += "</td>";
						contenido += "<td>";
						contenido += "<a href=\"" + site_url
								+ "/locales/mostrarLocal/" + idLocal + "\">"
								+ nombreLocal
								+ " <i class=\"fa fa-home\" title=\"Local\"></i></a>";
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";

					});

	// Vacion el div
	$('#collapseUltimosPedidos').empty();
	$('#collapseUltimosPedidos').html(contenido);
}

function valorarUsuario() {
	/*
	 * Ventana modal añadir valoracion
	 */

	$("#dialogAnadirValoracionUsuario").dialog(
			{
				width : 600,
				modal : true,
				buttons : {
					"Aceptar" : function() {
						// Se envia el formulario
						// que acutaliza el estado
						enviarFormulario(site_url
								+ '/valoraciones/anadirValoracionUsuario',
								'formAnadirValoracionUsuario',
								'listaValoracionesUsuario', 0);
						// Se cierra el dialogo
						$(this).dialog("close");
					},
					Cancel : function() {
						// Se cierra el dialogo
						$(this).dialog("close");
					}
				},
				close : function(event, ui) {
					// Se cierra el dialogo
					$(this).dialog("close");
				}
			});
	$('#dialogAnadirValoracionUsuario').dialog('open');
	return false;

}

function listaValoracionesUsuario(data) {
	var contenido = "";
	var idUsuario = "";
	var contadorVal = 0;
	var json = $.parseJSON(data);
	var jsonValoraciones = json.valoraciones;
	$
			.each(
					jsonValoraciones,/* $.parseJSON(data), */
					function(key, value) {
						var nota = value.nota;
						var fecha = value.fecha;
						var observaciones = value.observaciones;
						var local = value.local.nombre;
						idUsuario = value.usuario.idUsuario;

						contadorVal += 1;

						contenido += "<div class=\"col-md-12 well\">";

						contenido += "<div class=\"col-md-5\">";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";

						contenido += "<tr>";
						contenido += "<td class=\"titulo\">";
						contenido += "Local";
						contenido += "</td>";
						contenido += "<td>";
						contenido += local;
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

						contenido += "<div class=\"col-md-7\">";
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
					});

	if (contadorVal <= 5) {
		contenido += "<div class=\"col-md-12\">";
		contenido += "<a onclick=\"doAjax('" + site_url
				+ "/valoraciones/mostrarTodasValoracionesUsuario','idUsuario="
				+ idUsuario + "','listaValoracionesUsuario','post',0)\">"
				+ "<i class=\"fa fa-plus\"></i> Mostrar todas</a>";
		contenido += "</div>";
	}

	// Si hay mensaje se muestra
	if (json.mensaje.length > 0) {
		var mensaje = json.mensaje;
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

	$('#valoracionesUsuario').empty();
	$('#valoracionesUsuario').html(contenido);

}

$(document).ready(function() {
	/*
	 * Ventana modal añadir direccion
	 */
	$('.enlaceAnadirDireccion').click(function() {
		anadirDireccion();
	});

	$('.enlaceAnadirValoracionUsuario').click(function() {
		valorarUsuario();
	});
});