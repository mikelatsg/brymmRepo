/**
 * Use this ScriptDoc file to manage the documentation for the corresponding
 * namespace in your JavaScript library.
 * 
 * @author Mikel
 */

function listaMesasLocal(item) {
	var nombreMesa = "";
	var idMesaLocal = "";
	var idLocal = "";
	var capacidad = "";
	var contenido = "";
	var enlaceBorrar = "";
	var contador = 0;
	$(item)
			.find('xml')
			.children('mesaLocal')
			.each(
					function() {
						if (contador == 0) {
							contenido = contenido + "<ul>";
						}
						// Se obtienen los valores del xml
						nombreMesa = $.trim($(this).find('nombre_mesa').text());
						idMesaLocal = $.trim($(this).find('id_mesa_local')
								.text());
						idLocal = $.trim($(this).find('id_local').text());
						capacidad = $.trim($(this).find('capacidad').text());

						// Se crea el enlace para poder borrar los platos del
						// local
						enlaceBorrar = "<a onclick=\"doAjax('" + site_url
								+ "/reservas/borrarMesaLocal','idMesaLocal="
								+ idMesaLocal
								+ "','listaMesasLocal','post',1)\">B</a>";

						contenido = contenido + "<li>";
						contenido = contenido + nombreMesa + " - " + capacidad
								+ " - " + enlaceBorrar;
						contenido = contenido + "</li>";
						contador++;
					});
	if (contador > 0) {
		contenido = contenido + "</ul>";
	}

	// Se vacia la lista para rellenar con el contenido
	$("#listaMesasLocal").empty();
	$("#listaMesasLocal").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

	resetFormularios();

}

function listaReservasUsuario(item) {

	var nombreLocal = "";
	var idReserva = "";
	var idLocal = "";
	var numeroPersonas = "";
	var fecha = "";
	var horaInicio = "";
	var estado = "";
	var contenido = "";
	var enlaceAnular = "";
	var contadorReservas = 0;

	contenido = "";
	$(item)
			.find('xml')
			.children('reservaUsuario')
			.each(
					function() {
						contadorReservas += 1;
						// Se obtienen los valores del xml
						nombreLocal = $
								.trim($(this).find('nombreLocal').text());
						fecha = $.trim($(this).find('fecha').text());
						idLocal = $.trim($(this).find('id_local').text());
						horaInicio = $.trim($(this).find('hora_inicio').text());
						numeroPersonas = $.trim($(this).find('numero_personas')
								.text());
						estado = $.trim($(this).find('estado').text());
						idReserva = $.trim($(this).find('id_reserva').text());

						// Se crea el enlace para poder anular la reserva
						botonAnular = "<button class=\"btn btn-danger btn-sm pull-right\""
								+ "type=\"button\" data-toggle=\"tooltip\""
								+ "data-original-title=\"Remove this user\" onclick=\""
								+ "doAjax('"
								+ site_url
								+ "/reservas/anularReservaUsuario','idReserva="
								+ idReserva
								+ "','listaReservasUsuario','post',1)\" title=\"Anular reserva\">"
								+ "<span class=\"glyphicon glyphicon-remove\"></span>"
								+ "</button>";

						contenido += "<div class=\"col-md-12 list-div\">";
						contenido += "<table class=\"table\">";
						contenido += "<tbody>";

						contenido += "<tr>";
						contenido += "<td colspan=\"3\" class=\"text-left titulo\">";
						contenido += "Reserva " + idReserva;
						if (estado == 'P' || estado == 'AL') {
							contenido += botonAnular;
						}
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "<tr>";
						contenido += "<td>";
						contenido += fecha
								+ " <i class=\"fa fa-calendar\"></i>";
						contenido += "</td>";
						contenido += "<td>";
						contenido += estado + " <i class=\"fa fa-tag\"></i>";
						contenido += "</td>";
						contenido += "<td>";
						contenido += "<a href=\"" + site_url
								+ "/locales/mostrarLocal/" + idLocal + "\">"
								+ nombreLocal
								+ " <i class=\"fa fa-home\"></i></a>";
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";

					});
	
	if (contadorReservas <= 5) {
		contenido += "<div class=\"col-md-12 text-center\">";
		contenido += "<a onclick=\"doAjax('"
				+ site_url
				+ "/reservas/mostrarTodasReservasUsuario','','listaUltimasReservasUsuario','post',1)\">";
		contenido += "<i class=\"fa fa-plus\"></i> Mostrar todas</a>";
		contenido += "</div>";
	}

	$("#listaReservasUsuario").empty();
	$("#listaReservasUsuario").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

	resetFormularios();

}

function listaUltimasReservasUsuario(item) {

	var nombreLocal = "";
	var idReserva = "";
	var idLocal = "";
	var numeroPersonas = "";
	var fecha = "";
	var horaInicio = "";
	var estado = "";
	var contenido = "";
	var enlaceAnular = "";
	var contadorReservas = 0;

	contenido = "";
	$(item)
			.find('xml')
			.children('reservaUsuario')
			.each(
					function() {
						contadorReservas += 1;
						// Se obtienen los valores del xml
						nombreLocal = $
								.trim($(this).find('nombreLocal').text());
						fecha = $.trim($(this).find('fecha').text());
						idLocal = $.trim($(this).find('id_local').text());
						horaInicio = $.trim($(this).find('hora_inicio').text());
						numeroPersonas = $.trim($(this).find('numero_personas')
								.text());
						estado = $.trim($(this).find('estado').text());
						idReserva = $.trim($(this).find('id_reserva').text());

						// Se crea el enlace para poder anular la reserva
						botonVer = "<button class=\"btn btn-default btn-sm pull-right\""
								+ "type=\"button\" data-toggle=\"tooltip\""
								+ "data-original-title=\"Remove this user\" onclick=\""
								+ "doAjax('"
								+ site_url
								+ "/reservas/mostrarReservaUsuario','idReserva="
								+ idReserva
								+ "','mostrarReservaHomeUsuario','post',1)\" title=\"Ver detalle reserva\">"
								+ "<span class=\"glyphicon glyphicon-eye-open\"></span>"
								+ "</button>";

						botonAnular = "<button class=\"btn btn-danger btn-sm pull-right\""
								+ "type=\"button\" data-toggle=\"tooltip\""
								+ "data-original-title=\"Remove this user\" onclick=\""
								+ "doAjax('"
								+ site_url
								+ "/reservas/anularReservaUsuario','idReserva="
								+ idReserva
								+ "','listaReservasUsuario','post',1)\" title=\"Anular reserva\">"
								+ "<span class=\"glyphicon glyphicon-remove\"></span>"
								+ "</button>";

						contenido += "<div class=\"col-md-12 list-div\">";
						contenido += "<table class=\"table\">";
						contenido += "<tbody>";

						contenido += "<tr>";
						contenido += "<td colspan=\"3\" class=\"text-left titulo\">";
						contenido += "Reserva " + idReserva;
						contenido += botonVer;
						if (estado == 'P' || estado == 'AL') {
							contenido += botonAnular;
						}
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "<tr>";
						contenido += "<td>";
						contenido += fecha
								+ " <i class=\"fa fa-calendar\"></i>";
						contenido += "</td>";
						contenido += "<td>";
						contenido += estado + " <i class=\"fa fa-tag\"></i>";
						contenido += "</td>";
						contenido += "<td>";
						contenido += "<a href=\"" + site_url
								+ "/locales/mostrarLocal/" + idLocal + "\">"
								+ nombreLocal
								+ " <i class=\"fa fa-home\"></i></a>";
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";

					});

	if (contadorReservas <= 5) {
		contenido += "<div class=\"col-md-12 text-center\">";
		contenido += "<a onclick=\"doAjax('"
				+ site_url
				+ "/reservas/mostrarTodasReservasUsuario','','listaUltimasReservasUsuario','post',1)\">";
		contenido += "<i class=\"fa fa-plus\"></i> Mostrar todas</a>";
		contenido += "</div>";
	}

	// Vacio el detalle de la reserva
	$("#muestraDetalleReserva").empty();

	// Vacio la lista de las reservas
	$("#listaReservasUsuario").empty();
	$("#listaReservasUsuario").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

}

function datosReservaLocal(item) {
	var idReserva = "";
	var numeroPersonas = "";
	var fecha = "";
	var horaInicio = "";
	var estado = "";
	var nombreUsuario = "";
	var idTipoMenu = "";
	var tipoMenu = "";
	var nick = "";
	var idUsuario = "";
	var contenido = "";
	var observaciones = "";
	var enlaceAsignarMesa = "";
	var enlaceBorrarMesaAsignada = "";
	var enlaceAceptarReserva = "";
	var enlaceRechazarReserva = "";

	idReserva = $.trim($(item).find('idReserva').text());
	fecha = $.trim($(item).find('fecha').text());
	horaInicio = $.trim($(item).find('horaInicio').text());
	numeroPersonas = $.trim($(item).find('numeroPersonas').text());
	estado = $.trim($(item).find('estado').text());
	nombreUsuario = $.trim($(item).find('nombreUsuario').text());
	nick = $.trim($(item).find('nick').text());
	tipoMenu = $.trim($(item).find('tipoMenu').text());
	observaciones = $.trim($(item).find('observaciones').text());
	idUsuario = $.trim($(item).find('idUsuario').text());

	// Se genera el enlace para aceptar la reserva
	enlaceAceptarReserva += "<button class=\"btn btn-success pull-right\" type=\"button\"";
	enlaceAceptarReserva
			+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
	enlaceAceptarReserva += "onclick=";
	enlaceAceptarReserva += "doAjax('" + site_url
			+ "/reservas/aceptarReservaLocal','idReserva=" + idReserva
			+ "','actualizarReservas','post',1)>";
	enlaceAceptarReserva += "<span class=\"glyphicon glyphicon-ok\"></span>";
	enlaceAceptarReserva += "</button>";

	// Se genera el enlace para rechazar la reserva
	enlaceRechazarReserva += "<button class=\"btn btn-danger pull-right\" type=\"button\"";
	enlaceRechazarReserva
			+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
	enlaceRechazarReserva += "onclick=";
	enlaceRechazarReserva += "\"mostrarVentanaRechazarReserva(" + idReserva
			+ ")\">";
	enlaceRechazarReserva += " <span class=\"glyphicon glyphicon-remove\"></span>";
	enlaceRechazarReserva += "</button>";

	// Vacio el div donde se muestra la comanda
	$("#mostrarPedido").empty();
	contenido += "<div class=\"col-md-6\">";
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
	contenido = contenido + "<td class=\"titulo\">A nombre de</td>";
	contenido = contenido + "<td>" + nombreUsuario + " </td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Tipo menu</td>";
	contenido = contenido + "<td>" + tipoMenu + " </td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Observaciones</td>";
	contenido = contenido + "<td>" + observaciones + " </td>";
	contenido = contenido + "</tr>";

	contenido += "</tbody>";
	contenido += "</table>";
	contenido += enlaceAceptarReserva;
	contenido += enlaceRechazarReserva;
	contenido += "</div>";
	contenido += "</div>";
	contenido += "</div>";

	var nombreMesa = "";
	var capacidad = "";
	var idMesaLocal = "";
	var idReservaMesa = "";

	contenido += "<div class=\"col-md-6\">";
	contenido += "<div class=\"row\">";
	contenido += "<span class=\"badge progress-bar-danger\">Mesas asignadas</span>";
	contenido += "</div>";

	// Se muestran las mesas asignadas a la reserva.
	var contador = 0;
	$(item)
			.find('xml')
			.children('detalleMesasReserva')
			.each(
					function() {
						nombreMesa = $.trim($(this).find('nombreMesaReserva')
								.text());
						capacidad = $.trim($(this).find('capacidadMesaReserva')
								.text());
						idReservaMesa = $.trim($(this).find('idReservaMesa')
								.text());
						idMesaLocal = $
								.trim($(this).find('idMesaLocal').text());

						enlaceBorrarMesaAsignada = "";

						enlaceBorrarMesaAsignada += "<button class=\"btn btn-danger pull-right btn-sm\" type=\"button\"";
						enlaceBorrarMesaAsignada
								+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						enlaceBorrarMesaAsignada += "onclick=";
						enlaceBorrarMesaAsignada += "doAjax('"
								+ site_url
								+ "/reservas/borrarMesaReserva','idReservaMesa="
								+ idReservaMesa + "&idReserva=" + idReserva
								+ "','datosReservaLocal','post',1)>";
						enlaceBorrarMesaAsignada += "<span class=\"glyphicon glyphicon-remove\"></span>";
						enlaceBorrarMesaAsignada += "</button>";

						contenido += "<div class=\"well col-md-12\">";
						contenido += "<div class=\"span6\">";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";

						// Se compruba que existen mesas asignadas para
						// mostrarlas
						if (idMesaLocal != "") {

							contenido = contenido + "<tr>";
							contenido = contenido
									+ "<td class=\"titulo\">Mesa</td>";
							contenido = contenido + "<td>" + nombreMesa
									+ " </td>";
							contenido = contenido + "<td>"
									+ enlaceBorrarMesaAsignada + " </td>";
							contenido = contenido + "</tr>";

							contenido = contenido + "<tr>";
							contenido = contenido
									+ "<td class=\"titulo\">Capacidad</td>";
							contenido = contenido + "<td colspan=\"2\">"
									+ capacidad + " </td>";
							contenido = contenido + "</tr>";

						}

						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";
						contenido += "</div>";

					});

	// Se muestran las mesas libres

	contenido += "<div class=\"row\">";
	contenido += "<span class=\"badge progress-bar-danger\">Mesas libres</span>";
	contenido += "</div>";

	$(item)
			.find('xml')
			.children('detalleMesasLibres')
			.each(
					function() {
						nombreMesa = $.trim($(this).find('nombreMesaLibre')
								.text());
						capacidad = $.trim($(this).find('capacidadMesaLibre')
								.text());
						idMesaLocal = $
								.trim($(this).find('idMesaLibre').text());

						// Se crea el enlace para poder asignar las mesas a las
						// reservas

						enlaceAsignarMesa = "";

						enlaceAsignarMesa += "<button class=\"btn btn-success pull-right btn-sm\" type=\"button\"";
						enlaceAsignarMesa
								+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						enlaceAsignarMesa += "onclick=";
						enlaceAsignarMesa += "doAjax('" + site_url
								+ "/reservas/asignarMesaReserva','idMesaLocal="
								+ idMesaLocal + "&idReserva=" + idReserva
								+ "','datosReservaLocal','post',1)>";
						enlaceAsignarMesa += "<span class=\"glyphicon glyphicon-plus\"></span>";
						enlaceAsignarMesa += "</button>";

						contenido += "<div class=\"well col-md-12\">";
						contenido += "<div class=\"span6\">";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";

						// Se compruba que existen mesas libres para mostrarlas
						if (idMesaLocal != "") {
							contenido = contenido + "<tr>";
							contenido = contenido
									+ "<td class=\"titulo\">Mesa</td>";
							contenido = contenido + "<td>" + nombreMesa
									+ " </td>";
							contenido = contenido + "<td>" + enlaceAsignarMesa
									+ " </td>";
							contenido = contenido + "</tr>";

							contenido = contenido + "<tr>";
							contenido = contenido
									+ "<td class=\"titulo\">Capacidad</td>";
							contenido = contenido + "<td colspan=\"2\">"
									+ capacidad + " </td>";
							contenido = contenido + "</tr>";

							contador++;
						}

						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";
						contenido += "</div>";
					});

	contenido += "</div>";

	$("#detalleReserva").empty();
	$("#detalleReserva").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}
}

function datosReservaRechazadaLocal(item) {
	var idReserva = "";
	var numeroPersonas = "";
	var fecha = "";
	var horaInicio = "";
	var estado = "";
	var nombreUsuario = "";
	var motivo = "";
	var tipoMenu = "";
	var nick = "";
	var idUsuario = "";
	var contenido = "";
	var observaciones = "";
	var nombreEmisor = "";

	idReserva = $.trim($(item).find('idReserva').text());
	fecha = $.trim($(item).find('fecha').text());
	horaInicio = $.trim($(item).find('horaInicio').text());
	numeroPersonas = $.trim($(item).find('numeroPersonas').text());
	estado = $.trim($(item).find('estado').text());
	nombreUsuario = $.trim($(item).find('nombreUsuario').text());
	nick = $.trim($(item).find('nick').text());
	tipoMenu = $.trim($(item).find('tipoMenu').text());
	observaciones = $.trim($(item).find('observaciones').text());
	idUsuario = $.trim($(item).find('idUsuario').text());
	nombreEmisor = $.trim($(item).find('nombreEmisor').text());
	motivo = $.trim($(item).find('motivo').text());

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
	contenido = contenido + "<td class=\"titulo\">A nombre de</td>";
	if (idUsuario == 0) {
		contenido = contenido + "<td>" + nombreEmisor + " </td>";
	} else {
		contenido = contenido + "<td>" + nombreUsuario + " </td>";
	}
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Tipo menu</td>";
	contenido = contenido + "<td>" + tipoMenu + " </td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Observaciones</td>";
	contenido = contenido + "<td>" + observaciones + " </td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Motivo rechazo</td>";
	contenido = contenido + "<td>" + motivo + " </td>";
	contenido = contenido + "</tr>";

	contenido += "</tbody>";
	contenido += "</table>";
	contenido += "</div>";
	contenido += "</div>";
	contenido += "</div>";

	$("#detalleReserva").empty();
	$("#detalleReserva").html(contenido);
}

function actualizarReservas(item) {
	// Se oculta la reserva que se está visualizada
	$("#detalleReserva").empty();

	// Se actualiza la lista de pendientes
	listaReservasPendientesLocal(item);

	// Se actualiza la lista de NO pendientes
	doAjax(site_url + '/reservas/listaReservasAceptadasLocal', '',
			'listaReservasGestionadasLocal', 'post', 1);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

}

function actualizarReservasTratadas(item) {
	// Se oculta la reserva que está visualizada
	$("#detalleReserva").empty();
	$("#reservasDiaLocal").empty();

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

	// Se actualiza la lista de pendientes
	listaReservasGestionadasLocal(item);

	// Se actualiza la lista de NO pendientes
	doAjax(site_url + '/reservas/listaReservasRechazadasLocal', '',
			'listaReservasRechazadasLocal', 'post', 1);

}

function actualizarReservasRechazadas(item) {
	// Se oculta la reserva que se está visualizada
	$("#detalleReserva").empty();

	// Se actualiza la lista de pendientes
	listaReservasPendientesLocal(item);

	// Se actualiza la lista de NO pendientes
	doAjax(site_url + '/reservas/listaReservasRechazadasLocal', '',
			'listaReservasRechazadasLocal', 'post', 1);

}

// Funcion que actualiza la lista de reservas del local pendientes.
function listaReservasPendientesLocal(item) {
	var contenido = "";
	var idReserva = "";
	var numeroPersonas = "";
	var fecha = "";
	var horaInicio = "";
	var estado = "";
	var nombreUsuario = "";
	var nick = "";
	var idUsuario = "";
	var idTipoMenu = "";
	var tipoMenu = "";
	var enlaceVer = "";

	var contador = 0;
	$(item)
			.find('xml')
			.children('reservaUsuario')
			.each(
					function() {
						if (contador == 0) {
							contenido = contenido + "<ul>";
						}
						idReserva = $.trim($(this).find('id_reserva').text());
						fecha = $.trim($(this).find('fecha').text());
						horaInicio = $.trim($(this).find('hora_inicio').text());
						numeroPersonas = $.trim($(this).find('numero_personas')
								.text());
						estado = $.trim($(this).find('estado').text());
						nombreUsuario = $.trim($(this).find('nombreUsuario')
								.text());
						nick = $.trim($(this).find('nick').text());
						tipoMenu = $.trim($(this).find('tipo_menu').text());
						idTipoMenu = $
								.trim($(this).find('id_tipo_Menu').text());
						idUsuario = $.trim($(this).find('id_usuario').text());
						// Se genera el enlace que permite ver la reserva
						enlaceVer = "<a onclick=\"doAjax('" + site_url
								+ "/reservas/mostrarReservaLocal','idReserva="
								+ idReserva
								+ "','datosReservaLocal','post',1)\">Ver</a>";

						contenido = contenido + "<li>";
						contenido = contenido + idReserva + " - " + fecha
								+ " - " + horaInicio + " - " + nombreUsuario
								+ " - " + nick + " - " + enlaceVer;
						contenido = contenido + "</li>";
						contador++;
					});

	if (contador > 0) {
		contenido = contenido + "</ul>";
	}

	$("#listaReservasPendientesLocal").empty();
	$("#listaReservasPendientesLocal").html(contenido);
}

// Funcion que actualiza las ultimas reservas del local no pendientes.
function listaReservasGestionadasLocal(item) {
	var contenido = "";
	var idReserva = "";
	var numeroPersonas = "";
	var fecha = "";
	var horaInicio = "";
	// var estado = "";
	var nombreUsuario = "";
	var nick = "";
	var idUsuario = "";
	var nombreEmisor = "";
	// var idTipoMenu = "";
	var tipoMenu = "";
	var enlaceVer = "";

	var contador = 0;
	$(item)
			.find('xml')
			.children('reservaUsuario')
			.each(
					function() {
						if (contador == 0) {
							contenido = contenido + "<ul>";
						}
						idReserva = $.trim($(this).find('id_reserva').text());
						fecha = $.trim($(this).find('fecha').text());
						horaInicio = $.trim($(this).find('hora_inicio').text());
						numeroPersonas = $.trim($(this).find('numero_personas')
								.text());
						// estado = $.trim($(this).find('estado').text());
						nombreUsuario = $.trim($(this).find('nombreUsuario')
								.text());
						nick = $.trim($(this).find('nick').text());
						tipoMenu = $.trim($(this).find('tipo_menu').text());
						// idTipoMenu =
						// $.trim($(this).find('id_tipo_Menu').text());
						idUsuario = $.trim($(this).find('id_usuario').text());

						enlaceVer = "<a onclick=\"doAjax('" + site_url
								+ "/reservas/mostrarReservaLocal','idReserva="
								+ idReserva
								+ "','datosReservaAceptadaLocal','post',1)\""
								+ "> Ver </a>";

						contenido = contenido + "<li>";
						// Se comprueba el usuario para mostrar el nombre del
						// emisor o el nombre.
						if (idUsuario == 0) {
							contenido = contenido + idReserva + " - " + fecha
									+ " - " + horaInicio + " - " + nombreEmisor;
						} else {
							contenido = contenido + idReserva + " - " + fecha
									+ " - " + horaInicio + " - "
									+ nombreUsuario + " - " + nick;
						}
						contenido += enlaceVer;

						contenido = contenido + "</li>";
						contador++;
					});

	if (contador > 0) {
		contenido = contenido + "</ul>";
	}

	$("#listaReservasAceptadasLocal").empty();
	$("#listaReservasAceptadasLocal").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

	resetFormularios();
}

// Funcion que actualiza las ultimas reservas del local no pendientes.
function listaReservasRechazadasLocal(item) {
	var contenido = "";
	var idReserva = "";
	var numeroPersonas = "";
	var fecha = "";
	var horaInicio = "";
	// var estado = "";
	var nombreUsuario = "";
	var nick = "";
	var idUsuario = "";
	var nombreEmisor = "";
	// var idTipoMenu = "";
	var tipoMenu = "";
	var enlaceVer = "";

	var contador = 0;
	$(item)
			.find('xml')
			.children('reservaUsuario')
			.each(
					function() {
						if (contador == 0) {
							contenido = contenido + "<ul>";
						}
						idReserva = $.trim($(this).find('id_reserva').text());
						fecha = $.trim($(this).find('fecha').text());
						horaInicio = $.trim($(this).find('hora_inicio').text());
						numeroPersonas = $.trim($(this).find('numero_personas')
								.text());
						// estado = $.trim($(this).find('estado').text());
						nombreUsuario = $.trim($(this).find('nombreUsuario')
								.text());
						nick = $.trim($(this).find('nick').text());
						tipoMenu = $.trim($(this).find('tipo_menu').text());
						// idTipoMenu =
						// $.trim($(this).find('id_tipo_Menu').text());
						idUsuario = $.trim($(this).find('id_usuario').text());

						enlaceVer = "<a onclick=\"doAjax('" + site_url
								+ "/reservas/mostrarReservaLocal','idReserva="
								+ idReserva
								+ "','datosReservaRechazadaLocal','post',1)\""
								+ "> Ver </a>";

						contenido = contenido + "<li>";
						// Se comprueba el usuario para mostrar el nombre del
						// emisor o el nombre.
						if (idUsuario == 0) {
							contenido = contenido + idReserva + " - " + fecha
									+ " - " + horaInicio + " - " + nombreEmisor;
						} else {
							contenido = contenido + idReserva + " - " + fecha
									+ " - " + horaInicio + " - "
									+ nombreUsuario + " - " + nick;
						}

						contenido += enlaceVer + "</li>";
						contador++;
					});

	if (contador > 0) {
		contenido = contenido + "</ul>";
	}

	$("#listaReservasRechazadasLocal").empty();
	$("#listaReservasRechazadasLocal").html(contenido);
}

// Funcion que muestra las reservas de un dia de un local
function listaReservasDia(item) {
	var contenido = "";
	var idReserva = "";
	var fecha = "";
	var horaInicio = "";
	var nombreUsuario = "";
	var nick = "";
	var nombreEmisor = "";
	var idTipoMenu = "";
	var tipoMenu = "";
	var enlaceVer = "";
	var idUsuario = 0;
	var reservasAbiertas;

	fecha = $.trim($(item).find('fecha').text());
	tipoMenu = $.trim($(item).find('tipoMenu').text());
	idTipoMenu = $.trim($(item).find('idTipoMenu').text());
	reservasAbiertas = $.trim($(item).find('reservasAbiertas').text());

	enlaceCerrarReservas = "";
	// Enlace cerrar
	enlaceCerrarReservas += "<button class=\"btn btn-danger pull-right\" type=\"button\"";
	enlaceCerrarReservas
			+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
	enlaceCerrarReservas += "onclick=";
	enlaceCerrarReservas += "doAjax('" + site_url
			+ "/reservas/cerrarReservaDia','fecha=" + fecha + "&idTipoMenu="
			+ idTipoMenu + "','actualizarReservasDiaLocal','post',1)" +
					" title=\"Cerrar reservas del dia\">";
	enlaceCerrarReservas += "<i class=\"fa fa-lock\"></i>";
	enlaceCerrarReservas += "</button>";

	enlaceAbrirReservas = "";
	// Enlace abrir
	enlaceAbrirReservas += "<button class=\"btn btn-success pull-right\" type=\"button\"";
	enlaceAbrirReservas
			+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
	enlaceAbrirReservas += "onclick=";
	enlaceAbrirReservas += "doAjax('" + site_url
			+ "/reservas/abrirReservaDia','fecha=" + fecha + "&idTipoMenu="
			+ idTipoMenu + "','actualizarReservasDiaLocal','post',1)" +
					" title=\"Abrir reservas del dia\">";
	enlaceAbrirReservas += "<i class=\"fa fa-unlock\"></i>";
	enlaceAbrirReservas += "</button>";

	// Se muestra la fecha y el tipo de comida
	// contenido = contenido + "<h4>" + fecha + " - " + tipoMenu + "</h4>";
	contenido += "<h3>";
	contenido += "<span class=\"label label-default\">" + fecha + " / "
			+ tipoMenu + "</span>";
	contenido += "</h3>";

	var contador = 0;
	$(item)
			.find('detalleReservasDia')
			.each(
					function() {
						idReserva = $.trim($(this).find('idReserva').text());
						if (idReserva !== "") {

							horaInicio = $.trim($(this).find('horaInicio')
									.text());
							nombreUsuario = $.trim($(this)
									.find('nombreUsuario').text());
							nick = $.trim($(this).find('nick').text());
							nombreEmisor = $.trim($(this).find('nombreEmisor')
									.text());
							idUsuario = $
									.trim($(this).find('idUsuario').text());

							enlaceVer = "";

							// Se genera el enlace que permite ver la reserva
							enlaceVer += "<button class=\"btn btn-default pull-right btn-sm\" type=\"button\"";
							enlaceVer
									+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
							enlaceVer += "onclick=";
							enlaceVer += "doAjax('"
									+ site_url
									+ "/reservas/mostrarReservaLocal','idReserva="
									+ idReserva
									+ "','datosReservaAceptadaLocal','post',1)>";
							enlaceVer += "<span class=\"glyphicon glyphicon-eye-open\"></span>";
							enlaceVer += "</button>";

							contenido += "<div class=\"col-md-12 list-div\">";
							contenido += "<table class=\"table\">";
							contenido += "<tbody>";

							contenido += "<tr>";
							contenido += "<td>";
							contenido += "Reserva " + idReserva;
							contenido += "</td>";
							contenido += "<td>";
							contenido += enlaceVer;
							contenido += "</td>";
							contenido += "</tr>";

							contenido += "<tr>";
							contenido += "<td>";
							if (idUsuario == 0) {
								contenido += nombreEmisor;
							} else {
								contenido += nombreUsuario;
							}
							contenido += " <i class=\"fa fa-user\"></td>";
							contenido += "<td>";
							contenido += fecha;
							contenido += " <i class=\"fa fa-calendar\"></td>";
							contenido += "</tr>";

							contenido += "</tbody>";
							contenido += "</table>";
							contenido += "</div>";
						}
					});

	// Meto el enlace para abrir o cerrar las reservas del dia
	if (reservasAbiertas == 1) {
		contenido += enlaceCerrarReservas;
	} else {
		contenido += enlaceAbrirReservas;
	}

	$("#reservasDiaLocal").empty();
	$("#reservasDiaLocal").html(contenido);
}

function datosReservaAceptadaLocal(item) {
	var idReserva = "";
	var numeroPersonas = "";
	var fecha = "";
	var horaInicio = "";
	var estado = "";
	var nombreUsuario = "";
	var observaciones = "";
	var tipoMenu = "";
	var nick = "";
	var idUsuario = "";
	var nombreEmisor = "";
	var contenido = "";
	var enlaceAsignarMesa = "";
	var enlaceBorrarMesaAsignada = "";
	var enlaceAnularReserva = "";

	idReserva = $.trim($(item).find('idReserva').text());
	fecha = $.trim($(item).find('fecha').text());
	horaInicio = $.trim($(item).find('horaInicio').text());
	numeroPersonas = $.trim($(item).find('numeroPersonas').text());
	estado = $.trim($(item).find('estado').text());
	nombreUsuario = $.trim($(item).find('nombreUsuario').text());
	nick = $.trim($(item).find('nick').text());
	tipoMenu = $.trim($(item).find('tipoMenu').text());
	observaciones = $.trim($(item).find('observaciones').text());
	idUsuario = $.trim($(item).find('idUsuario').text());
	nombreEmisor = $.trim($(item).find('nombreEmisor').text());

	// Se crea el enlace para poder anular la reserva
	/*
	 * enlaceAnularReserva = "<a onclick='mostrarVentanaAnularReserva(" +
	 * idReserva + ")' data-toggle='modal' >Anular reserva</a>";
	 */

	enlaceAnularReserva += "<button class=\"btn btn-danger pull-right\" type=\"button\"";
	enlaceAnularReserva
			+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
	enlaceAnularReserva += "onclick=";
	enlaceAnularReserva += "'mostrarVentanaAnularReserva(" + idReserva + ")'>"
	enlaceAnularReserva += "<span class=\"glyphicon glyphicon-remove\"></span>";
	enlaceAnularReserva += "</button>";

	contenido += "<div class=\"col-md-6\">";
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

	/*
	 * Si el idUsuario es 0 se pone el nombre del emisor y no el nombre del
	 * usuario
	 */

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">A nombre de</td>";
	if (idUsuario == 0) {
		contenido = contenido + "<td>" + nombreEmisor + " </td>";
	} else {
		contenido = contenido + "<td>" + nombreUsuario + " </td>";
	}
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Tipo menu</td>";
	contenido = contenido + "<td>" + tipoMenu + " </td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Observaciones</td>";
	contenido = contenido + "<td>" + observaciones + " </td>";
	contenido = contenido + "</tr>";

	contenido += "</tbody>";
	contenido += "</table>";
	contenido += enlaceAnularReserva;
	contenido += "</div>";
	contenido += "</div>";
	contenido += "</div>";

	var nombreMesa = "";
	var capacidad = "";
	var idMesaLocal = "";
	var idReservaMesa = "";

	contenido += "<div class=\"col-md-6\">";
	contenido += "<div class=\"row\">";
	contenido += "<span class=\"badge progress-bar-danger\">Mesas asignadas</span>";
	contenido += "</div>";

	// Se muestran las mesas asignadas a la reserva.
	var contador = 0;
	$(item)
			.find('xml')
			.children('detalleMesasReserva')
			.each(
					function() {
						nombreMesa = $.trim($(this).find('nombreMesaReserva')
								.text());
						capacidad = $.trim($(this).find('capacidadMesaReserva')
								.text());
						idReservaMesa = $.trim($(this).find('idReservaMesa')
								.text());
						idMesaLocal = $
								.trim($(this).find('idMesaLocal').text());

						enlaceBorrarMesaAsignada = "";

						enlaceBorrarMesaAsignada += "<button class=\"btn btn-danger pull-right btn-sm\" type=\"button\"";
						enlaceBorrarMesaAsignada
								+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						enlaceBorrarMesaAsignada += "onclick=";
						enlaceBorrarMesaAsignada += "doAjax('"
								+ site_url
								+ "/reservas/borrarMesaReserva','idReservaMesa="
								+ idReservaMesa + "&idReserva=" + idReserva
								+ "','datosReservaLocal','post',1)>";
						enlaceBorrarMesaAsignada += "<span class=\"glyphicon glyphicon-remove\"></span>";
						enlaceBorrarMesaAsignada += "</button>";

						contenido += "<div class=\"well col-md-12\">";
						contenido += "<div class=\"span6\">";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";

						// Se compruba que existen mesas asignadas para
						// mostrarlas
						if (idMesaLocal != "") {

							contenido = contenido + "<tr>";
							contenido = contenido
									+ "<td class=\"titulo\">Mesa</td>";
							contenido = contenido + "<td>" + nombreMesa
									+ " </td>";
							contenido = contenido + "<td>"
									+ enlaceBorrarMesaAsignada + " </td>";
							contenido = contenido + "</tr>";

							contenido = contenido + "<tr>";
							contenido = contenido
									+ "<td class=\"titulo\">Capacidad</td>";
							contenido = contenido + "<td colspan=\"2\">"
									+ capacidad + " </td>";
							contenido = contenido + "</tr>";
						}

						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";
						contenido += "</div>";

					});

	// Se muestran las mesas libres
	contenido += "<div class=\"row\">";
	contenido += "<span class=\"badge progress-bar-danger\">Mesas libres</span>";
	contenido += "</div>";

	contador = 0;
	$(item)
			.find('xml')
			.children('detalleMesasLibres')
			.each(
					function() {
						nombreMesa = $.trim($(this).find('nombreMesaLibre')
								.text());
						capacidad = $.trim($(this).find('capacidadMesaLibre')
								.text());
						idMesaLocal = $
								.trim($(this).find('idMesaLibre').text());
						// Se crea el enlace para poder asignar las mesas a las
						// reservas

						enlaceAsignarMesa = "";

						enlaceAsignarMesa += "<button class=\"btn btn-success pull-right btn-sm\" type=\"button\"";
						enlaceAsignarMesa
								+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						enlaceAsignarMesa += "onclick=";
						enlaceAsignarMesa += "doAjax('" + site_url
								+ "/reservas/asignarMesaReserva','idMesaLocal="
								+ idMesaLocal + "&idReserva=" + idReserva
								+ "','datosReservaLocal','post',1)>";
						enlaceAsignarMesa += "<span class=\"glyphicon glyphicon-plus\"></span>";
						enlaceAsignarMesa += "</button>";

						contenido += "<div class=\"well col-md-12\">";
						contenido += "<div class=\"span6\">";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";

						// Se compruba que existen mesas libres para mostrarlas
						if (idMesaLocal != "") {

							contenido = contenido + "<tr>";
							contenido = contenido
									+ "<td class=\"titulo\">Mesa</td>";
							contenido = contenido + "<td>" + nombreMesa
									+ " </td>";
							contenido = contenido + "<td>" + enlaceAsignarMesa
									+ " </td>";
							contenido = contenido + "</tr>";

							contenido = contenido + "<tr>";
							contenido = contenido
									+ "<td class=\"titulo\">Capacidad</td>";
							contenido = contenido + "<td colspan=\"2\">"
									+ capacidad + " </td>";
							contenido = contenido + "</tr>";

						}

						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";
						contenido += "</div>";
					});
	contenido += "</div>";

	$("#detalleReserva").empty();
	$("#detalleReserva").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}
}

function actualizarCalendarioReservas(item) {
	var calendario = "";
	calendario = $.trim($(item).find('calendarioReservas').text());
	$("#calendarioReservasLocal").empty();
	$("#calendarioReservasLocal").html(calendario);
}

function actualizarReservasDiaLocal(item) {
	$("#reservasDiaLocal").empty();
}

/*
 * function vaciarDetalleReservas(item) { $("#detalleReserva").empty();
 * $("#reservasDiaLocal").empty(); }
 */

function listaMesasLibres(item) {

	// <input type="checkbox" name="ingrediente[]" value="<? echo
	// $linea->id_ingrediente; ?>"/>
	var idMesaLocal = 0;
	var nombreMesa = "";
	var capacidad = 0;
	var contenido = "";

	if ($(item).find("mesaLibre").size() == 0) {
		contenido = "(No hay mesas libres)";
	}

	var contenidoCheckbox = "";
	contenidoCheckbox += "<div class=\"checkbox\">";
	contenidoCheckbox += "</div>";
	$(item)
			.find("mesaLibre")
			.each(
					function() {
						nombreMesa = $.trim($(this).find('nombre_mesa').text());
						idMesaLocal = $.trim($(this).find('id_mesa_local')
								.text());
						capacidad = $.trim($(this).find('capacidad').text());
						contenidoCheckbox += "<div class=\"checkbox\">";
						contenidoCheckbox += "<input type=\"checkbox\" name=\"mesas[]\" ";
						contenidoCheckbox += "value=\"" + idMesaLocal + "\"/>";
						contenidoCheckbox += "Mesa " + nombreMesa;
						contenidoCheckbox += " [" + capacidad
								+ " <i class=\"fa fa-users\"></i>]";
						contenidoCheckbox += "</div>";
					});

	$("#listaMesasLibres").empty();
	$("#listaMesasLibres").html(contenidoCheckbox);
}

function mostrarVentanaRechazarReserva(idReserva) {
	/*
	 * Ventana modal rechazar reserva
	 */
	$("#dialogRechazarReserva").dialog(
			{
				width : 600,
				modal : true,
				buttons : {
					"Aceptar" : function() {
						// Se envia el formulario que acutaliza el estado
						enviarFormulario(site_url
								+ '/reservas/rechazarReservaLocal',
								'formRechazarReserva',
								'actualizarReservasRechazadas', 1);

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
	$('#idReservaFormRechazarReserva').val(idReserva);
	$('#dialogRechazarReserva').dialog('open');
	return false;
}

function mostrarVentanaAnularReserva(idReserva) {
	/*
	 * Ventana modal anular reserva
	 */
	$("#dialogAnularReservaLocal").dialog(
			{
				width : 600,
				modal : true,
				buttons : {
					"Aceptar" : function() {
						// Se envia el formulario que acutaliza el estado
						enviarFormulario(site_url
								+ '/reservas/anularReservaLocal',
								'formAnularReservaLocal',
								'actualizarReservasTratadas', 1);

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
	$('#idReservaFormAnularReservaLocal').val(idReserva);
	$('#dialogAnularReservaLocal').dialog('open');
	return false;
}

$(document).ready(function() {
	$("#datepickerReservas").datepicker();
	$("#datepickerReservas").datepicker("option", "dateFormat", "yy-mm-dd");

	/*
	 * $('.enlaceAnularReservaLocal').click(function() {
	 * $("#dialogAnularReservaLocal").dialog({ width: 600, modal: true, buttons: {
	 * "Aceptar": function() { //Se envia el formulario que acutaliza el estado
	 * enviarFormulario(site_url + '/reservas/anularReservaLocal' ,
	 * 'formAnularReservaLocal', 'vaciarDetalleReservas', 1);
	 * 
	 * //Se cierra el dialogo $(this).dialog("close"); }, Cancel: function() {
	 * //Se cierra el dialogo $(this).dialog("close"); } }, close:
	 * function(event, ui) { //Se cierra el dialogo $(this).dialog("close"); }
	 * }); /* Se añade al campo oculto el id del pedido
	 */
	/*
	 * $('#idReservaFormAnularReservaLocal').val($(this).data('id'));
	 * $('#dialogAnularReservaLocal').dialog('open'); return false; });
	 */

});
