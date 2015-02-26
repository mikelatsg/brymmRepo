/**
 * Use this ScriptDoc file to manage the documentation for the corresponding
 * namespace in your JavaScript library.
 * 
 * @author Mikel
 */
function mostrarPedido(item) {
	var formPedido = $('#formPedido').html();
	$("#detallePedido").empty();
	var contenido = "";
	var existePedido = 0;
	var funcionBorrar = "";
	var rowid = "";
	var precioTotal;
	$(item)
			.find('pedido')
			.children()
			.each(
					function() {
						if (existePedido == 0) {
							contenido += "<div class=\"col-md-12 well\">";
							contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
							contenido += "<tbody>";
						}
						existePedido = 1;
						funcionBorrar = "";
						// Se obtienen los valores del xml
						var nombre = $.trim($(this).find('name').text());
						var cantidad = $.trim($(this).find('qty').text());
						var precio = $.trim($(this).find('price').text());
						var idArticulo = $.trim($(this).find('id').text());
						var tipoArticulo = $.trim($(this).find('tipoArticulo')
								.text());
						rowid = $.trim($(this).find('rowid').text());
						funcionBorrar = "doAjax('" + site_url
								+ "/pedidos/borrarArticulo','rowid=" + rowid
						funcionBorrar = funcionBorrar
								+ "','mostrarPedido','post',1)";

						botonBorrar = "<button class=\"btn btn-danger btn-sm pull-right\""
								+ "type=\"button\" data-toggle=\"tooltip\""
								+ "data-original-title=\"Remove this user\" onclick=\""
								+ "doAjax('"
								+ site_url
								+ "/pedidos/borrarArticulo','rowid="
								+ rowid
								+ "','mostrarPedido','post',1)\""
								+ " title=\"Eliminar articulo del pedido\" >"
								+ "<span class=\"glyphicon glyphicon-remove\"></span>"
								+ "</button>";

						contenido += "<tr>";
						contenido += "<td class=\"titulo text-center\" colspan=\"2\">";
						contenido += nombre;
						contenido += "</td>";
						contenido += "<td>";
						contenido += botonBorrar;
						contenido += "</td>";
						contenido += "</tr>";

						contenido += "<tr>";
						contenido += "<td class=\"titulo\">";
						contenido += "Cantidad";
						contenido += "</td>";
						contenido += "<td>";
						contenido += cantidad;
						contenido += "</td>";
						contenido += "<td>";
						contenido += "</td>";
						contenido += "</tr>";

						ingredientes = "";
						hayIngredientes = false;
						$(this).find('ingredientes').each(
								function() {
									var ingrediente = $.trim($(this).find(
											'ingrediente').text());
									if (hayIngredientes) {
										ingredientes += ", ";
									}
									ingredientes += ingrediente;
									hayIngredientes = true;
								});

						/*
						 * contenido = contenido + "<li>" + nombre + " - " +
						 * cantidad + " - " + precio; contenido = contenido + "<a
						 * onclick=" + funcionBorrar + "> X </a>"; contenido =
						 * contenido + "<br> " + tipoArticulo;
						 */
						if (hayIngredientes) {
							contenido += "<tr>";
							contenido += "<td class=\"titulo\">";
							contenido += "Precio";
							contenido += "</td>";
							contenido += "<td>";
							contenido += round(precio, 2, 'PHP_ROUND_HALF_EVEN');
							contenido += "<i class=\"fa fa-euro\"></i></td>";
							contenido += "<td>";
							contenido += "</td>";
							contenido += "</tr>";

							contenido += "<tr>";
							contenido += "<td class=\"titulo\">";
							contenido += "Tipo articulo";
							contenido += "</td>";
							contenido += "<td>";
							contenido += tipoArticulo;
							contenido += "</td>";
							contenido += "<td>";
							contenido += "</td>";
							contenido += "</tr>";

							contenido += "<tr>";
							contenido += "<td class=\"titulo separadorArticulo\">";
							contenido += "Ingredientes";
							contenido += "</td>";
							contenido += "<td class=\"separadorArticulo\">";
							contenido += ingredientes;
							contenido += "</td>";
							contenido += "<td class=\"separadorArticulo\">";
							contenido += "</td>";
							contenido += "</tr>";
						} else {
							contenido += "<tr>";
							contenido += "<td class=\"titulo separadorArticulo\">";
							contenido += "Precio";
							contenido += "</td>";
							contenido += "<td class=\"separadorArticulo\">";
							contenido += round(precio, 2, 'PHP_ROUND_HALF_EVEN');
							contenido += "<i class=\"fa fa-euro\"></i></td>";
							contenido += "<td class=\"separadorArticulo\">";
							contenido += "</td>";
							contenido += "</tr>";

						}
						// contenido = contenido + "</li>";
					});
	// Se obtiene el total
	precioTotal = $.trim($(item).find('total').text());

	// Se añade la opción de cancelar si hay algo en el pedido
	if (existePedido == 1) {
		contenido += "</tbody>";
		contenido += "</table>";
		contenido += "</div>";

		// Se muestra el total
		botonCancelar = "<button class=\"btn btn-danger pull-right\""
				+ "type=\"button\" data-toggle=\"tooltip\""
				+ "data-original-title=\"Remove this user\" onclick=\""
				+ "doAjax('" + site_url
				+ "/pedidos/cancelarPedido','','mostrarPedido','post',1)\""
				+ " title=\"Eliminar pedido\" >"
				+ "<span class=\"glyphicon glyphicon-remove\"></span>"
				+ "</button>";

		contenido += "<div class=\"col-md-12 well\">";
		contenido += "<div class=\"titulo col-md-5 text-left\">";
		contenido += "Total";
		contenido += "</div>";
		contenido += "<div class=\"titulo col-md-5 text-left\">";
		contenido += round(precioTotal, 2, 'PHP_ROUND_HALF_EVEN');
		contenido += "<i class=\"fa fa-euro\"></i></div>";
		contenido += "<div class=\"col-md-2\">";
		contenido += botonCancelar;
		contenido += "</div>";
		contenido += "</div>";

		// contenido = contenido + "<a href=\"" + site_url +
		// "/pedidos/confirmarPedido/1\">Confirmar</a>";
		// Pongo el formulario del pedido
		contenido += "<div id=\"formPedido\" class=\"col-md-12 well\">";
		contenido += formPedido;
		contenido += "</div>";

	}

	$("#detallePedido").html(contenido);

	if (existePedido == 1) {
		$('#formPedido').show();
	} else {
		$('#formPedido').hide();
	}
	// Si hay mensaje se muestra
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
	var estadoAbrv = $.trim($(item).find("estadoAbrv").text());
	var motivoRechazo = $.trim($(item).find("motivoRechazo").text());
	var clase = "";
	$("#estadoPedido").empty();
	$("#estadoPedido").text(estado);
	if (estadoAbrv == "R") {
		$("#progresoEstado").css("width", "13%");
		clase = "progress-bar-danger";
	} else if (estadoAbrv == "P") {
		$("#progresoEstado").css("width", "37%");
		clase = "progress-bar-warning";
	} else if (estadoAbrv == "A") {
		$("#progresoEstado").css("width", "63%");
		clase = "progress-bar-primary";
	} else if (estadoAbrv == "T") {
		$("#progresoEstado").css("width", "87%");
		clase = "progress-bar-success";
	}

	if ($("#progresoEstado").hasClass("progress-bar-danger")) {
		$("#progresoEstado").toggleClass('progress-bar-danger ' + clase);
	} else if ($("#progresoEstado").hasClass("progress-bar-warning")) {
		$("#progresoEstado").toggleClass('progress-bar-warning ' + clase);
	} else if ($("#progresoEstado").hasClass("progress-bar-primary")) {
		$("#progresoEstado").toggleClass('progress-bar-primary ' + clase);
	} else if ($("#progresoEstado").hasClass("progress-bar-success")) {
		$("#progresoEstado").toggleClass('progress-bar-success ' + clase);
	}

	// Muestro el motivo del rechazo si existe en el xml y no existe ya en la
	// vista
	if (!$('#lineaMotivoRechazo').length) {
		var contenido = "";
		if (motivoRechazo.length) {
			contenido += "<tr id=\"lineaMotivoRechazo\">";
			contenido += "<td class=\"titulo\">Motivo rechazo</td>";
			contenido += "<td colspan=\"3\">" + motivoRechazo;
			contenido += "</td>";
			contenido += "</tr>";
		}

		$(contenido).appendTo("#cabeceraPedido");
	}
}

function moverPedidoEstado(item) {
	var estado = $.trim($(item).find("estado").text());
	var idPedido = $.trim($(item).find("idPedido").text());
	var estadoAbrv = $.trim($(item).find("estadoAbrv").text());
	// Se vacia el div donde se muestran los pedidos
	$("#mostrarPedido").empty();
	var divDestino = "";
	// Se mueve el pedido al div correspondiente
	if (estadoAbrv == "A") {
		divDestino = "pedidosAceptados";
		$("#pedido_" + idPedido).find('#aceptarPedido').empty();
		funcionTerminar = "<a onclick=";
		funcionTerminar = funcionTerminar + "doAjax('" + site_url
				+ "/pedidos/actualizarEstadoPedido','idPedido=" + idPedido;
		funcionTerminar = funcionTerminar
				+ "&estado=T','moverPedidoEstado','post',1)> Terminar </a>";
		$("#pedido_" + idPedido).find('#aceptarPedido').html(funcionTerminar);
	} else if (estadoAbrv == "T") {
		divDestino = "pedidosTerminados";
		$("#pedido_" + idPedido).find('#modificarEstado').empty();
	} else if (estadoAbrv == "R") {
		divDestino = "pedidosRechazados";
		$("#pedido_" + idPedido).find('#modificarEstado').empty();
	}

	$("#pedido_" + idPedido).appendTo("#" + divDestino);
	// Se muestra el mensaje
	var mensaje = $.trim($(item).find('mensaje').text());
	mostrarMensaje(mensaje);
	// Se resetean todos los formularios
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
	var usuario = $.trim($(item).find('nombreUsuario').text());
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
	$("#mostrarPedido").empty();
	contenido += "<div class=\"col-md-6\">";
	contenido += "<div class=\"pedido col-md-12\">";
	contenido += "<span class=\"badge pull-left\">Pedido " + idPedido
			+ "</span>";
	contenido += "</div>";
	contenido += "<div class=\"well col-md-12\">";
	contenido += "<div class=\"span6\">";
	contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
	contenido += "<tbody>";

	/*
	 * contenido = contenido + "<tr>"; contenido = contenido + "<td>Pedido</td>";
	 * contenido = contenido + "<td>" + idPedido + "</td>"; contenido =
	 * contenido + "</tr>";
	 */

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Usuario</td>";
	contenido = contenido + "<td>" + usuario + "</td>";
	contenido = contenido + "</tr>";

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

	// Se obtiene la direccion
	$(item).find('direccion').first().each(function() {
		direccion = $.trim($(this).find('direccion').text());
	});

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

	/*
	 * Si el pedido esta rechazado se muestra el motivo
	 */

	if (idEstado == "R") {
		contenido += "<tr>";
		contenido += "<td class=\"titulo\">Motivo rechazo</td>";
		contenido += "<td>" + motivoRechazo + "</td>";
		contenido += "</tr>";
	}

	contenido += "</tbody>";
	contenido += "</table>";
	contenido += "</div>";
	contenido += "</div>";
	contenido += "</div>";

	/*
	 * Articulos del pedido
	 */

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

						/* Recorro los ingredientes */

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
									if (ingrediente != "") {
										contadorIngredientes++;
									}
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

	contenido += "</div>";

	/*
	 * contenido = "Pedido : " + idPedido + " - Precio : " + precio + " - Fecha
	 * pedido : " + fechaPedido + " - Fecha entrega : " + fechaEntrega + " -
	 * Estado : " + estado; //Se obtiene la direccion
	 * $(item).find('direccion').first().each(function() { direccion =
	 * $.trim($(this).find('direccion').text()); });
	 * 
	 * if (envioPedido != "0") { contenido += "<br>Direccion envio : " +
	 * direccion; } contenido += "<br>Observaciones : " + observaciones; /* Si
	 * el pedido esta rechazado se muestra el motivo
	 */
	/*
	 * if (idEstado == "R") { contenido += "<br>Motivo rechazo : " +
	 * motivoRechazo; } contenido += "<ul>";
	 * $(item).find('detallePedido').each(function() {
	 * 
	 * articulo = $.trim($(this).find('articulo').text()); precioArticulo =
	 * $.trim($(this).find('precioArticulo').text()); cantidad =
	 * $.trim($(this).find('cantidad').text()); tipoArticulo =
	 * $.trim($(this).find('tipoArticulo').text()); idTipoArticulo =
	 * $.trim($(this).find('idTipoArticulo').text()); ingredientes = "";
	 * contadorIngredientes = 0; $(this).find('detalleArticulo').each(function() {
	 * ingrediente = $.trim($(this).find('ingrediente').text()); if
	 * (contadorIngredientes == 0) { ingredientes += ingrediente; } else {
	 * ingredientes += " - " + ingrediente; } contadorIngredientes++; }); if
	 * (idTipoArticulo != idTipoArticuloAnterior) { contenido += tipoArticulo; }
	 * contenido += "<li>"; contenido += articulo + " - " + precioArticulo + " - " +
	 * cantidad; contenido += "<br>" + ingredientes; contenido += "</li>";
	 * idTipoArticuloAnterior = idTipoArticulo; }); contenido += "</ul>";
	 */
	$("#mostrarPedido").html(contenido);
}

function gestionRetrasarPedido() {
	if ($('#retrasarPedido').is(':checked')) {
		$('#contenidoRetrasarPedido').show();
	} else {
		$('#contenidoRetrasarPedido').hide();
	}
}

function gestionEnvioPedido() {
	if ($('#envioPedido').is(':checked')) {
		$('#contenidoDireccionEnvio').show();
	} else {
		$('#contenidoDireccionEnvio').hide();
	}
}

$(document)
		.ready(
				function() {
					var today = new Date();
					var dd = today.getDate();
					var mm = today.getMonth() + 1; // January is 0!

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
					$("#datepickerFechaRecogidaPedido").datepicker("option",
							"dateFormat", "yy-mm-dd");
					$("#datepickerFechaRecogidaPedido").val(today);
					/*
					 * Datepicker fecha entrega pedido (local)
					 */
					$("#datePickerFechaEntregaPedido").datepicker();
					$("#datePickerFechaEntregaPedido").datepicker("option",
							"dateFormat", "yy-mm-dd");
					$("#datePickerFechaEntregaPedido").val(today);
					/*
					 * Ventana modal aceptar pedido
					 */
					$('.enlaceAceptarPedido')
							.click(
									function() {
										$("#dialog")
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
																					+ '/pedidos/actualizarEstadoPedido',
																			'formAceptarPedido',
																			'moverPedidoEstado',
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
										/*
										 * Se añade al campo oculto el id del
										 * pedido
										 */
										$('#idPedidoForm').val(
												$(this).data('id'));
										$('#dialog').dialog('open');
										return false;
									});
					/*
					 * Ventana modal rechazar pedido
					 */
					$('.enlaceRechazarPedido')
							.click(
									function() {
										$("#dialogRechazar")
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
																					+ '/pedidos/actualizarEstadoPedido',
																			'formRechazarPedido',
																			'moverPedidoEstado',
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
										/*
										 * Se añade al campo oculto el id del
										 * pedido
										 */
										$('#idPedidoFormRechazar').val(
												$(this).data('id'));
										$('#dialogRechazar').dialog('open');
										return false;
									});

					// Se gestiona si mostrar los combos para retrasar el pedido
					gestionRetrasarPedido();

					// Se gestiona si mostrar las direcciones para el envio del
					// pedido
					gestionEnvioPedido();

				});
