/**
 * Use this ScriptDoc file to manage the documentation for the corresponding
 * namespace in your JavaScript library.
 * 
 * @author Mikel
 */

function enviarArticuloComanda(url, query, inputid, callback, getxml) {
	var cantidad = $("#" + inputid).get(0).value;
	var sepCampos;
	sepCampos = "&";
	query = query + sepCampos + "cantidad=" + cantidad;
	doAjax(url, query, callback, 'post', getxml);
}

function mostrarComanda(item) {

	var contenido = "<ul>";
	var contenidoMenu = "";
	var existeMenu = false;
	var existeCarta = false;
	var existeArticulo = false;
	var existeArticuloPer = false;
	var contenidoArticulo = "";
	var contenidoArticuloPer = "";
	var contenidoCarta = "";
	var contenidoTemporal = "";
	var existeComanda = 0;
	var funcionBorrar = "";
	var detalleMenu = "";
	var detalleArticuloPer = "";
	var rowid = "";
	var tipoArticulo = "";
	var precioTotal;
	// Vacio el div donde se muestra la comanda
	$("#mostrarComanda").empty();
	$(item).find('pedido').children().each(
			function() {

				funcionBorrar = "";
				contenidoTemporal = "";
				detalleMenu = "";
				detalleArticuloPer = ""

				// Se obtienen los valores del xml
				var nombre = $.trim($(this).find('name').text());
				var cantidad = $.trim($(this).find('qty').text());
				var precio = $.trim($(this).find('price').text());
				var id = $.trim($(this).find('id').text());
				var tipoComanda = $.trim($(this).find('tipoComanda').text());
				var idTipoComanda = $
						.trim($(this).find('idTipoComanda').text());
				var tipoArticulo = $.trim($(this).find('tipoArticulo').text());
				rowid = $.trim($(this).find('rowid').text());
				// Si el campo nombre no esta informado no escribimos nada, se
				// trata del total
				if (nombre != "") {
					existeComanda = 1;
					funcionBorrar = "doAjax('" + site_url
							+ "/comandas/borrarArticuloComanda','rowid="
							+ rowid
					funcionBorrar = funcionBorrar
							+ "','mostrarComanda','post',1)";
					contenidoTemporal = contenidoTemporal + "<li>" + nombre
							+ " - " + cantidad + " - " + precio;
					contenidoTemporal = contenidoTemporal + "<a onclick="
							+ funcionBorrar + "> X </a>";
					contenidoTemporal = contenidoTemporal + "</li>";
					if (idTipoComanda == 1) {
						// Articulo
						if (!existeArticulo) {
							contenidoArticulo = "<h4>" + tipoComanda + "</h4>";
						}
						existeArticulo = true;
						contenidoArticulo = contenidoArticulo
								+ contenidoTemporal;
					} else if (idTipoComanda == 2) {
						// Articulo personalizado
						// Si es el primer articulo personalizado se muestra el
						// titulo
						if (!existeArticuloPer) {
							contenidoArticuloPer = "<h4>" + tipoComanda
									+ "</h4>";
						}
						existeArticuloPer = true;
						detalleArticuloPer = mostrarDetalleArticuloPer($(this)
								.find('options'), tipoArticulo);
						contenidoArticuloPer = contenidoArticuloPer
								+ contenidoTemporal + detalleArticuloPer;
					} else if (idTipoComanda == 3) {
						// Menu
						// Si es el primer menu se muestra el titulo
						if (!existeMenu) {
							contenidoMenu = "<h4>" + tipoComanda + "</h4>";
						}
						existeMenu = true;
						detalleMenu = mostrarDetalleMenu($(this)
								.find('options'));
						contenidoMenu = contenidoMenu + contenidoTemporal
								+ detalleMenu;
					} else {
						// Carta
						if (!existeCarta) {
							contenidoCarta = "<h4>" + tipoComanda + "</h4>";
						}
						existeCarta = true;
						contenidoCarta = contenidoCarta + contenidoTemporal;
					}
				} else {
					precioTotal = "Total : "
							+ $.trim($(item).find('total').text()) + "<br>";
				}
			});

	// Si hay algo en el pedido se muestra el contenido
	if (existeComanda == 1) {
		contenido = contenido + contenidoArticulo + contenidoArticuloPer
				+ contenidoMenu + contenidoCarta + "</ul>";
		contenido = contenido + precioTotal

		contenido = contenido + "<a onclick=\"doAjax('" + site_url
				+ "/comandas/cancelarComanda','','mostrarComanda','post',1)\">";
		contenido = contenido + "Cancelar";
		contenido = contenido + "</a>";
	}

	// Se habilita el boton de aceptar comanda
	$("#butAceptarComanda").removeAttr("disabled");
	$("#butAnadirComanda").removeAttr("disabled");
	$("#mostrarComanda").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}
}

function mostrarDetalleMenu(item) {
	var detalleMenu = "<ul>";
	$(item).find('platosMenu').each(
			function() {
				var platoMenu = $.trim($(this).find('nombrePlato').text());
				var platoCantidad = $
						.trim($(this).find('platoCantidad').text());
				detalleMenu = detalleMenu + "<li>" + platoMenu + "-"
						+ platoCantidad + "</li>";
			});
	detalleMenu = detalleMenu + "</ul>";
	return detalleMenu;
}

function mostrarDetalleArticuloPer(item, tipoArticulo) {
	var detalleArticuloPer = tipoArticulo;
	var i = 0;
	$(item).find('ingredientes').each(function() {
		var ingrediente = $.trim($(this).find('ingrediente').text());
		if (i == 0) {
			detalleArticuloPer = detalleArticuloPer + " - " + ingrediente;
		} else {
			detalleArticuloPer = detalleArticuloPer + " , " + ingrediente;
		}

		i++;
	});
	detalleArticuloPer = detalleArticuloPer + "";
	return detalleArticuloPer;
}

function mostrarComandaRealizada(item) {

	var contenido = "";
	var contenidoArt = "";
	var contenidoArtPer = "";
	var contenidoMenu = "";
	var contenidoCarta = "";
	var precioTotal = "";
	var destino = ""
	var observaciones = "";
	var nombreMesa = "";
	var nombreCamarero = "";
	var fechaComanda = "";
	var idMesa = "";
	var idComanda = "";
	var detalleComanda = "";
	var estadoComanda = "";
	// Detalle comanda
	var cantidadDetalleComanda = 0;
	var precioDetalleComanda = 0;
	var idTipoComanda = 0;
	var estadoDetalle = "";
	// Se obtienen los datos de la comanda
	$(item).find('datosComanda').each(function() {
		idComanda = $.trim($(this).find('id_comanda').text());
		precioTotal = $.trim($(this).find('precio').text());
		destino = $.trim($(this).find('destino').text());
		observaciones = $.trim($(this).find('observaciones').text());
		idMesa = $.trim($(this).find('id_mesa').text());
		nombreMesa = $.trim($(this).find('nombreMesa').text());
		nombreCamarero = $.trim($(this).find('nombreCamarero').text());
		fechaComanda = $.trim($(this).find('fecha_alta').text());
		estadoComanda = $.trim($(this).find('estado').text());
	});

	contenido += "<div class=\"col-md-6\">";
	contenido += "<div class=\"pedido col-md-12\">";
	contenido += "<span class=\"badge pull-left\">Comanda " + idComanda
			+ "</span>";
	contenido += "</div>";
	contenido += "<div class=\"well col-md-12\">";
	contenido += "<div class=\"span6\">";
	contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
	contenido += "<tbody>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Destino</td>";
	contenido = contenido + "<td>" + destino + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Mesa</td>";
	contenido = contenido + "<td>" + nombreMesa + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Camarero</td>";
	contenido = contenido + "<td>" + nombreCamarero + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Precio</td>";
	contenido = contenido + "<td>" + precioTotal
			+ " <i class=\"fa fa-euro\"></i></td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Fecha comanda</td>";
	contenido = contenido + "<td>" + fechaComanda + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Estado</td>";
	contenido = contenido + "<td>" + estadoComanda + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Observaciones</td>";
	contenido = contenido + "<td>" + observaciones + "</td>";
	contenido = contenido + "</tr>";

	contenido += "</tbody>";
	contenido += "</table>";
	contenido += "</div>";
	contenido += "</div>";
	contenido += "</div>";

	contenido += "<div class=\"col-md-6\">";
	contenidoArt += "<div class=\"well col-md-12\">";
	contenidoArt += "<div class=\"span6\">";
	contenidoArt += "<table class=\"table table-condensed table-responsive table-user-information\">";
	contenidoArt += "<tbody>";

	contenidoArtPer = contenidoArt;
	contenidoMenu = contenidoArt;
	contenidoCarta = contenidoArt;

	contenidoArtCab = "";
	contenidoArtPerCab = "";
	contenidoMenuCab = "";
	contenidoCartaCab = "";

	/*
	 * contenido += idComanda + " - " + destino + " - " + nombreMesa + " - " +
	 * nombreCamarero + " - " + precioTotal + " - " + fechaComanda + " - " +
	 * estadoComanda + "<br>" + observaciones + "<ul>";
	 */
	// Se obtienen el detalle de la comanda
	$(item)
			.find('detalleComanda')
			.each(
					function() {
						var datosEspecificos = "";
						var tipoComanda = "";
						tipoComanda = $
								.trim($(this).find('tipoComanda').text())

						$(this).find('detalleComandaArticulo').each(
								function() {
									cantidadDetalleComanda = $.trim($(this)
											.find('cantidad').text());
									precioDetalleComanda = $.trim($(this).find(
											'precio').text());
									idTipoComanda = $.trim($(this).find(
											'id_tipo_comanda').text());
									estadoDetalle = $.trim($(this).find(
											'estado').text());
								});
						switch (parseInt(idTipoComanda)) {
						case 1:
							// Articulo
							datosEspecificos = obtenerDetalleArticuloComandaRealizada($(this))

							// En el primer detalle del tipo de comanda se
							// añade cual es
							if (contenidoArtCab == "") {
								contenidoArtCab += "<div class=\"row\">";
								contenidoArtCab += "<span class=\"badge progress-bar-danger\">"
										+ tipoComanda + "</span>";
								contenidoArtCab += "</div>";
							}

							contenidoArt += datosEspecificos;

							contenidoArt += "<tr>";
							contenidoArt += "<td class=\"titulo\">Cantidad</td>";
							contenidoArt += "<td>" + cantidadDetalleComanda
									+ "</td>";
							contenidoArt += "</tr>";

							contenidoArt += "<tr>";
							contenidoArt += "<td class=\"titulo\">Precio total</td>";
							contenidoArt += "<td>" + precioDetalleComanda
									+ " <i class=\"fa fa-euro\"></i></td>";
							contenidoArt += "</tr>";

							contenidoArt += "<tr>";
							contenidoArt += "<td class=\"titulo separadorArticulo\">Estado</td>";
							contenidoArt += "<td class=\"separadorArticulo\">"
									+ estadoDetalle + "</td>";
							contenidoArt += "</tr>";
							// En el primer detalle del tipo de comanda se
							// añade cual es
							/*
							 * if (contenidoArt == "") { contenidoArt +=
							 * tipoComanda; } contenidoArt += "<li>" +
							 * cantidadDetalleComanda + " - " +
							 * precioDetalleComanda + " - " + estadoDetalle + "</li>" +
							 * datosEspecificos;
							 */
							break;
						case 2:
							// Articulo personalizado
							datosEspecificos = obtenerDetalleArticuloPerComandaRealizada($(this));

							// En el primer detalle del tipo de comanda se
							// añade cual es
							if (contenidoArtPerCab == "") {
								contenidoArtPerCab += "<div class=\"row\">";
								contenidoArtPerCab += "<span class=\"badge progress-bar-danger\">"
										+ tipoComanda + "</span>";
								contenidoArtPerCab += "</div>";
							}

							contenidoArtPer += datosEspecificos;

							contenidoArtPer += "<tr>";
							contenidoArtPer += "<td class=\"titulo\">Cantidad</td>";
							contenidoArtPer += "<td>" + cantidadDetalleComanda
									+ "</td>";
							contenidoArtPer += "</tr>";

							contenidoArtPer += "<tr>";
							contenidoArtPer += "<td class=\"titulo\">Precio</td>";
							contenidoArtPer += "<td>" + precioDetalleComanda
									+ " <i class=\"fa fa-euro\"></i></td>";
							contenidoArtPer += "</tr>";

							contenidoArtPer += "<tr>";
							contenidoArtPer += "<td class=\"titulo separadorArticulo\">Estado</td>";
							contenidoArtPer += "<td class=\"separadorArticulo\">"
									+ estadoDetalle + "</td>";
							contenidoArtPer += "</tr>";
							// En el primer detalle del tipo de comanda se
							// añade cual es
							/*
							 * if (contenidoArtPer == "") { contenidoArtPer +=
							 * tipoComanda; }
							 * 
							 * contenidoArtPer += "<li>" +
							 * cantidadDetalleComanda + " - " +
							 * precioDetalleComanda + " - " + estadoDetalle + "</li>" +
							 * datosEspecificos;
							 */
							break;
						case 3:
							// Menu
							datosEspecificos = obtenerDetalleMenuComandaRealizada($(this));

							// En el primer detalle del tipo de comanda se
							// añade cual es
							if (contenidoMenuCab == "") {
								// contenidoMenu += tipoComanda;
								contenidoMenuCab += "<div class=\"row\">";
								contenidoMenuCab += "<span class=\"badge progress-bar-danger\">"
										+ tipoComanda + "</span>";
								contenidoMenuCab += "</div>";
							}

							contenidoMenu += "<tr>";
							contenidoMenu += "<td class=\"titulo\">Precio</td>";
							contenidoMenu += "<td>" + precioDetalleComanda
									+ " <i class=\"fa fa-euro\"></i></td>";
							contenidoMenu += "</tr>";

							contenidoMenu += "<tr>";
							contenidoMenu += "<td class=\"titulo\">Cantidad</td>";
							contenidoMenu += "<td>" + cantidadDetalleComanda
									+ "</td>";
							contenidoMenu += "</tr>";

							contenidoMenu += "<tr>";
							contenidoMenu += "<td class=\"titulo\">Estado</td>";
							contenidoMenu += "<td>" + estadoDetalle + "</td>";
							contenidoMenu += "</tr>";

							contenidoMenu += datosEspecificos;
							// En el primer detalle del tipo de comanda se
							// añade cual es
							/*
							 * if (contenidoMenu == "") { contenidoMenu +=
							 * tipoComanda; }
							 * 
							 * contenidoMenu += "<li>" +
							 * cantidadDetalleComanda + " - " +
							 * precioDetalleComanda + " - " + estadoDetalle + "</li>" +
							 * datosEspecificos;
							 */
							break;
						case 4:
							// Carta
							datosEspecificos = obtenerDetalleCartaComandaRealizada($(this));

							// En el primer detalle del tipo de comanda se
							// añade cual es
							if (contenidoCartaCab == "") {
								// contenidoCarta += tipoComanda;
								contenidoCartaCab += "<div class=\"row\">";
								contenidoCartaCab += "<span class=\"badge progress-bar-danger\">"
										+ tipoComanda + "</span>";
								contenidoCartaCab += "</div>";
							}

							contenidoCarta += datosEspecificos;

							contenidoCarta += "<tr>";
							contenidoCarta += "<td class=\"titulo\">Cantidad</td>";
							contenidoCarta += "<td>" + cantidadDetalleComanda
									+ "</td>";
							contenidoCarta += "</tr>";

							contenidoCarta += "<tr>";
							contenidoCarta += "<td class=\"titulo\">Precio total</td>";
							contenidoCarta += "<td>" + precioDetalleComanda
									+ " <i class=\"fa fa-euro\"></i></td>";
							contenidoCarta += "</tr>";

							contenidoCarta += "<tr>";
							contenidoCarta += "<td class=\"titulo separadorPlato\">Estado</td>";
							contenidoCarta += "<td class=\"separadorPlato\">"
									+ estadoDetalle + "</td>";
							contenidoCarta += "</tr>";

							// En el primer detalle del tipo de comanda se
							// añade cual es
							/*
							 * if (contenidoCarta == "") { contenidoCarta +=
							 * tipoComanda; }
							 * 
							 * contenidoCarta += "<li>" + datosEspecificos + " - " +
							 * cantidadDetalleComanda + " - " +
							 * precioDetalleComanda + " - " + estadoDetalle + "</li>";
							 */
							break;
						}

					});

	cerrarElementos = "";
	cerrarElementos += "</tbody>";
	cerrarElementos += "</table>";
	cerrarElementos += "</div>";
	cerrarElementos += "</div>";

	contenidoArt += cerrarElementos;
	contenidoArtPer += cerrarElementos;
	contenidoMenu += cerrarElementos;
	contenidoCarta += cerrarElementos;

	// Articulos
	if (contenidoArtCab != "") {
		contenido += contenidoArtCab + contenidoArt;
	}

	// Articulos personalizados
	if (contenidoArtPerCab != "") {
		contenido += contenidoArtPerCab + contenidoArtPer;
	}

	// Menus
	if (contenidoMenuCab != "") {
		contenido += contenidoMenuCab + contenidoMenu;
	}

	// Menus
	if (contenidoCartaCab != "") {
		contenido += contenidoCartaCab + contenidoCarta;
	}

	contenido += "</div>";

	/*
	 * contenido += contenidoArt + contenidoArtPer + contenidoMenu +
	 * contenidoCarta + "</ul>";
	 */

	// Se desabilita el boton de aceptar comanda
	$("#butAceptarComanda").attr("disabled", "disabled");
	$("#butAnadirComanda").attr("disabled", "disabled");
	// Vacio el div donde se muestra la comanda
	$("#mostrarComanda").empty();
	// Se muestra el contenido
	$("#mostrarComanda").html(contenido);
}

function mostrarComandaRealizadaCocina(item) {

	var contenido = "";
	var contenidoArt = "";
	var contenidoArtPer = "";
	var contenidoMenu = "";
	var contenidoCarta = "";
	var precioTotal = "";
	var destino = ""
	var observaciones = "";
	var nombreMesa = "";
	var nombreCamarero = "";
	var fechaComanda = "";
	var idMesa = "";
	var idComanda = "";
	var detalleComanda = "";
	var estadoComanda = "";
	// Detalle comanda
	var cantidadDetalleComanda = 0;
	var precioDetalleComanda = 0;
	var idTipoComanda = 0;
	var idDetalleComanda = 0;
	var estadoDetalle = "";
	// Se obtienen los datos de la comanda
	$(item).find('datosComanda').each(function() {
		idComanda = $.trim($(this).find('id_comanda').text());
		precioTotal = $.trim($(this).find('precio').text());
		destino = $.trim($(this).find('destino').text());
		observaciones = $.trim($(this).find('observaciones').text());
		idMesa = $.trim($(this).find('id_mesa').text());
		nombreMesa = $.trim($(this).find('nombreMesa').text());
		nombreCamarero = $.trim($(this).find('nombreCamarero').text());
		fechaComanda = $.trim($(this).find('fecha_alta').text());
		estadoComanda = $.trim($(this).find('estado').text());
	});

	contenido += "<div class=\"col-md-6\">";
	contenido += "<div class=\"pedido col-md-12\">";
	contenido += "<span class=\"badge pull-left\">Comanda " + idComanda
			+ "</span>";
	contenido += "</div>";
	contenido += "<div class=\"well col-md-12\">";
	contenido += "<div class=\"span6\">";
	contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
	contenido += "<tbody>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Destino</td>";
	contenido = contenido + "<td>" + destino + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Mesa</td>";
	contenido = contenido + "<td>" + nombreMesa + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Camarero</td>";
	contenido = contenido + "<td>" + nombreCamarero + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Precio</td>";
	contenido = contenido + "<td>" + precioTotal
			+ " <i class=\"fa fa-euro\"></i></td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Fecha comanda</td>";
	contenido = contenido + "<td>" + fechaComanda + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Estado</td>";
	contenido = contenido + "<td>" + estadoComanda + "</td>";
	contenido = contenido + "</tr>";

	contenido = contenido + "<tr>";
	contenido = contenido + "<td class=\"titulo\">Observaciones</td>";
	contenido = contenido + "<td>" + observaciones + "</td>";
	contenido = contenido + "</tr>";

	contenido += "</tbody>";
	contenido += "</table>";
	contenido += "</div>";
	contenido += "</div>";
	contenido += "</div>";

	contenido += "<div class=\"col-md-6\">";
	contenidoArt += "<div class=\"well col-md-12\">";
	contenidoArt += "<div class=\"span6\">";
	contenidoArt += "<table class=\"table table-condensed table-responsive table-user-information\">";
	contenidoArt += "<tbody>";

	contenidoArtPer = contenidoArt;
	contenidoMenu = contenidoArt;
	contenidoCarta = contenidoArt;

	contenidoArtCab = "";
	contenidoArtPerCab = "";
	contenidoMenuCab = "";
	contenidoCartaCab = "";

	// Se obtienen el detalle de la comanda
	$(item)
			.find('detalleComanda')
			.each(
					function() {
						var datosEspecificos = "";
						var funcionTerminarDetalleComanda = "";
						var tipoComanda = "";
						tipoComanda = $
								.trim($(this).find('tipoComanda').text())

						$(this).find('detalleComandaArticulo').each(
								function() {
									cantidadDetalleComanda = $.trim($(this)
											.find('cantidad').text());
									precioDetalleComanda = $.trim($(this).find(
											'precio').text());
									idTipoComanda = $.trim($(this).find(
											'id_tipo_comanda').text());
									idDetalleComanda = $.trim($(this).find(
											'id_detalle_comanda').text());
									estadoDetalle = $.trim($(this).find(
											'estado').text());
								});

						// Si el estado es diferente de terminado se da la
						// opcion de terminar
						if (estadoDetalle !== "TC") {
							// Se generan los enlaces
							funcionTerminarDetalleComanda += "<button class=\"btn btn-success pull-right\" type=\"button\"";
							funcionTerminarDetalleComanda
									+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
							funcionTerminarDetalleComanda += "onclick=";
							funcionTerminarDetalleComanda += "doAjax('"
									+ site_url
									+ "/comandas/terminarDetalleComanda','idDetalleComanda="
									+ idDetalleComanda
									+ "&idComanda="
									+ idComanda
									+ "','mostrarComandaRealizadaCocina','post',1)>";
							funcionTerminarDetalleComanda += "<span class=\"glyphicon glyphicon-ok\"></span>";
							funcionTerminarDetalleComanda += "</button>";
						}

						switch (parseInt(idTipoComanda)) {
						case 1:
							// Articulo
							datosEspecificos = obtenerDetalleArticuloComandaRealizada(
									$(this), funcionTerminarDetalleComanda)

							// En el primer detalle del tipo de comanda se
							// añade cual es
							if (contenidoArtCab == "") {
								contenidoArtCab += "<div class=\"row\">";
								contenidoArtCab += "<span class=\"badge progress-bar-danger\">"
										+ tipoComanda + "</span>";
								contenidoArtCab += "</div>";
							}

							contenidoArt += datosEspecificos;

							contenidoArt += "<tr>";
							contenidoArt += "<td class=\"titulo\">Cantidad</td>";
							contenidoArt += "<td>" + cantidadDetalleComanda
									+ "</td>";
							contenidoArt += "</tr>";

							contenidoArt += "<tr>";
							contenidoArt += "<td class=\"titulo\">Precio total</td>";
							contenidoArt += "<td>" + precioDetalleComanda
									+ " <i class=\"fa fa-euro\"></i></td>";
							contenidoArt += "</tr>";

							contenidoArt += "<tr>";
							contenidoArt += "<td class=\"titulo separadorArticulo\">Estado</td>";
							contenidoArt += "<td class=\"separadorArticulo\">"
									+ estadoDetalle + "</td>";
							contenidoArt += "</tr>";

							break;
						case 2:
							// Articulo personalizado
							datosEspecificos = obtenerDetalleArticuloPerComandaRealizada(
									$(this), funcionTerminarDetalleComanda);

							// En el primer detalle del tipo de comanda se
							// añade cual es
							if (contenidoArtPerCab == "") {
								contenidoArtPerCab += "<div class=\"row\">";
								contenidoArtPerCab += "<span class=\"badge progress-bar-danger\">"
										+ tipoComanda + "</span>";
								contenidoArtPerCab += "</div>";
							}

							contenidoArtPer += datosEspecificos;

							contenidoArtPer += "<tr>";
							contenidoArtPer += "<td class=\"titulo\">Cantidad</td>";
							contenidoArtPer += "<td>" + cantidadDetalleComanda
									+ "</td>";
							contenidoArtPer += "</tr>";

							contenidoArtPer += "<tr>";
							contenidoArtPer += "<td class=\"titulo\">Precio</td>";
							contenidoArtPer += "<td>" + precioDetalleComanda
									+ " <i class=\"fa fa-euro\"></i></td>";
							contenidoArtPer += "</tr>";

							contenidoArtPer += "<tr>";
							contenidoArtPer += "<td class=\"titulo separadorArticulo\">Estado</td>";
							contenidoArtPer += "<td class=\"separadorArticulo\">"
									+ estadoDetalle + "</td>";
							contenidoArtPer += "</tr>";
							break;
						case 3:
							// Menu
							datosEspecificos = obtenerDetalleMenuComandaRealizadaCocina(
									$(this), idComanda);
							// En el primer detalle del tipo de comanda se
							// añade cual es
							if (contenidoMenuCab == "") {
								// contenidoMenu += tipoComanda;
								contenidoMenuCab += "<div class=\"row\">";
								contenidoMenuCab += "<span class=\"badge progress-bar-danger\">"
										+ tipoComanda + "</span>";
								contenidoMenuCab += "</div>";
							}

							contenidoMenu += "<tr>";
							contenidoMenu += "<td class=\"titulo\">Precio</td>";
							contenidoMenu += "<td>" + precioDetalleComanda
									+ funcionTerminarDetalleComanda
									+ " <i class=\"fa fa-euro\"></i></td>";
							contenidoMenu += "</tr>";

							contenidoMenu += "<tr>";
							contenidoMenu += "<td class=\"titulo\">Cantidad</td>";
							contenidoMenu += "<td>" + cantidadDetalleComanda
									+ "</td>";
							contenidoMenu += "</tr>";

							contenidoMenu += "<tr>";
							contenidoMenu += "<td class=\"titulo\">Estado</td>";
							contenidoMenu += "<td>" + estadoDetalle + "</td>";
							contenidoMenu += "</tr>";

							contenidoMenu += datosEspecificos;

							break;
						case 4:
							// Carta
							datosEspecificos = obtenerDetalleCartaComandaRealizada(
									$(this), funcionTerminarDetalleComanda);
							// En el primer detalle del tipo de comanda se
							// añade cual es
							if (contenidoCartaCab == "") {
								// contenidoCarta += tipoComanda;
								contenidoCartaCab += "<div class=\"row\">";
								contenidoCartaCab += "<span class=\"badge progress-bar-danger\">"
										+ tipoComanda + "</span>";
								contenidoCartaCab += "</div>";
							}

							contenidoCarta += datosEspecificos;

							contenidoCarta += "<tr>";
							contenidoCarta += "<td class=\"titulo\">Cantidad</td>";
							contenidoCarta += "<td>" + cantidadDetalleComanda
									+ "</td>";
							contenidoCarta += "</tr>";

							contenidoCarta += "<tr>";
							contenidoCarta += "<td class=\"titulo\">Precio total</td>";
							contenidoCarta += "<td>" + precioDetalleComanda
									+ " <i class=\"fa fa-euro\"></i></td>";
							contenidoCarta += "</tr>";

							contenidoCarta += "<tr>";
							contenidoCarta += "<td class=\"titulo separadorPlato\">Estado</td>";
							contenidoCarta += "<td class=\"separadorPlato\">"
									+ estadoDetalle + "</td>";
							contenidoCarta += "</tr>";

							break;
						}

					});

	cerrarElementos = "";
	cerrarElementos += "</tbody>";
	cerrarElementos += "</table>";
	cerrarElementos += "</div>";
	cerrarElementos += "</div>";

	contenidoArt += cerrarElementos;
	contenidoArtPer += cerrarElementos;
	contenidoMenu += cerrarElementos;
	contenidoCarta += cerrarElementos;

	// Articulos
	if (contenidoArtCab != "") {
		contenido += contenidoArtCab + contenidoArt;
	}

	// Articulos personalizados
	if (contenidoArtPerCab != "") {
		contenido += contenidoArtPerCab + contenidoArtPer;
	}

	// Menus
	if (contenidoMenuCab != "") {
		contenido += contenidoMenuCab + contenidoMenu;
	}

	// Menus
	if (contenidoCartaCab != "") {
		contenido += contenidoCartaCab + contenidoCarta;
	}

	contenido += "</div>";

	// Se desabilita el boton de aceptar comanda
	$("#butAceptarComanda").attr("disabled", "disabled");
	$("#butAnadirComanda").attr("disabled", "disabled");
	// Vacio el div donde se muestra la comanda
	$("#mostrarComanda").empty();
	// Se muestra el contenido
	$("#mostrarComanda").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

}

function obtenerDetalleCartaComandaRealizada(item,
		funcionTerminarDetalleComanda) {
	var contenidoCarta = "";
	$(item).find('datosPlato').each(
			function() {
				var nombrePlato = $.trim($(this).find('nombre').text());
				var precioPlato = $.trim($(this).find('precio').text());

				contenidoCarta += "<tr>";
				contenidoCarta += "<td class=\"titulo\">Plato</td>";
				contenidoCarta += "<td>" + nombrePlato;
				if (typeof funcionTerminarDetalleComanda != "undefined") {
					contenidoCarta += funcionTerminarDetalleComanda;
				}
				contenidoCarta += "</td>";
				contenidoCarta += "</tr>";

				contenidoCarta += "<tr>";
				contenidoCarta += "<td class=\"titulo\">Precio plato</td>";
				contenidoCarta += "<td>" + precioPlato
						+ " <i class=\"fa fa-euro\"></i></td>";
				contenidoCarta += "</tr>";

				// contenidoCarta = nombrePlato + " - " + precioPlato + " €";
			});
	return contenidoCarta;
}

function obtenerDetalleMenuComandaRealizada(item) {
	var contenidoMenu = "<ul>";
	var idTipoPlatoAnterior = 0;
	$(item)
			.find('detalleMenu')
			.each(
					function() {
						var nombrePlato = $.trim($(this).find('nombrePlato')
								.text());
						var cantidadPlato = $.trim($(this).find('cantidad')
								.text());
						var tipoPlato = $
								.trim($(this).find('tipoPlato').text());
						var idTipoPlato = $.trim($(this).find('idTipoPlato')
								.text());
						var estado = $.trim($(this).find('estado').text());
						// Si se cambio de tipo de plato se muestra el tipo de
						// plato
						// (1er plato ...)						
						if (idTipoPlatoAnterior != idTipoPlato) { 
							contenidoMenu += "<tr>";
							contenidoMenu += "<td colspan=2 class=\"titulo cabeceraPlato\">"
									+ tipoPlato + "</td>";
							contenidoMenu += "</tr>";
						}

						contenidoMenu += "<tr>";
						contenidoMenu += "<td class=\"titulo\">Plato</td>";
						contenidoMenu += "<td>" + nombrePlato + "</td>";
						contenidoMenu += "</tr>";

						contenidoMenu += "<tr>";
						contenidoMenu += "<td class=\"titulo\">Cantidad</td>";
						contenidoMenu += "<td>" + cantidadPlato + "</td>";
						contenidoMenu += "</tr>";

						contenidoMenu += "<tr>";
						contenidoMenu += "<td class=\"titulo separadorPlato\">Estado</td>";
						contenidoMenu += "<td class=\"separadorPlato\">"
								+ estado + "</td>";
						contenidoMenu += "</tr>";						
						idTipoPlatoAnterior = idTipoPlato;
					});
	contenidoMenu += "</ul>";
	return contenidoMenu;
}

function obtenerDetalleMenuComandaRealizadaCocina(item, idComanda) {
	var contenidoMenu = "<ul>";
	var idTipoPlatoAnterior = 0;
	$(item)
			.find('detalleMenu')
			.each(
					function() {
						var funcionTerminarPlatoMenu = "";
						var nombrePlato = $.trim($(this).find('nombrePlato')
								.text());
						var idComandaMenu = $.trim($(this).find(
								'id_comanda_menu').text());
						var cantidadPlato = $.trim($(this).find('cantidad')
								.text());
						var tipoPlato = $
								.trim($(this).find('tipoPlato').text());
						var idTipoPlato = $.trim($(this).find('idTipoPlato')
								.text());
						var estadoPlatoMenu = $.trim($(this).find('estado')
								.text());

						// Si el estado es diferente de terminado se da la
						// opcion de terminar
						if (estadoPlatoMenu !== "TC") {
							// Se generan los enlaces
							funcionTerminarPlatoMenu += "<button class=\"btn btn-success pull-right\" type=\"button\"";
							funcionTerminarPlatoMenu
									+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
							funcionTerminarPlatoMenu += "onclick=";
							funcionTerminarPlatoMenu += "doAjax('"
									+ site_url
									+ "/comandas/terminarPlatoMenu','idComandaMenu="
									+ idComandaMenu
									+ "&idComanda="
									+ idComanda
									+ "','mostrarComandaRealizadaCocina','post',1)>";
							funcionTerminarPlatoMenu += "<span class=\"glyphicon glyphicon-ok\"></span>";
							funcionTerminarPlatoMenu += "</button>";

						}

						// Si se cambio de tipo de plato se muestra el tipo de
						// plato (1er plato ...)
						if (idTipoPlatoAnterior != idTipoPlato) {
							// contenidoMenu += tipoPlato;
							contenidoMenu += "<tr>";
							contenidoMenu += "<td colspan=2 class=\"titulo cabeceraPlato\">"
									+ tipoPlato + "</td>";
							contenidoMenu += "</tr>";
						}

						contenidoMenu += "<tr>";
						contenidoMenu += "<td class=\"titulo\">Plato</td>";
						contenidoMenu += "<td>" + nombrePlato
								+ funcionTerminarPlatoMenu + "</td>";
						contenidoMenu += "</tr>";

						contenidoMenu += "<tr>";
						contenidoMenu += "<td class=\"titulo\">Cantidad</td>";
						contenidoMenu += "<td>" + cantidadPlato + "</td>";
						contenidoMenu += "</tr>";

						contenidoMenu += "<tr>";
						contenidoMenu += "<td class=\"titulo separadorPlato\">Estado</td>";
						contenidoMenu += "<td class=\"separadorPlato\">"
								+ estadoPlatoMenu + "</td>";
						contenidoMenu += "</tr>";

						idTipoPlatoAnterior = idTipoPlato;
					});
	contenidoMenu += "</ul>";
	return contenidoMenu;
}

function obtenerDetalleArticuloPerComandaRealizada(item,
		funcionTerminarDetalleComanda) {
	var contenidoPer = "";
	var tipoArticulo = "";
	tipoArticulo = $.trim($(item).find('tipoArticulo').text());
	// contenidoPer += tipoArticulo;
	var contador = 0;

	contenidoPer += "<tr>";
	contenidoPer += "<td class=\"titulo\">TipoArticulo</td>";
	contenidoPer += "<td>" + tipoArticulo;
	if (typeof funcionTerminarDetalleComanda != "undefined") {
		contenidoPer += funcionTerminarDetalleComanda;
	}
	contenidoPer += "</td>";
	contenidoPer += "</tr>";

	ingredientes = "";
	$(item).find('detalleArticuloPer').each(
			function() {
				var ingrediente = $.trim($(this).find('ingrediente').text());
				var precioIngrediente = $.trim($(this).find('precio').text());

				if (contador != 0) {
					ingredientes += ", ";
				}
				/*
				 * contenidoPer += "<li>" + ingrediente + " - " +
				 * precioIngrediente + " €" + "</li>";
				 */
				ingredientes += ingrediente + " (" + precioIngrediente
						+ " <i class=\"fa fa-euro\"></i>)";

				contador++;
			});
	// contenidoPer += "</ul>";

	contenidoPer += "<tr>";
	contenidoPer += "<td class=\"titulo\">Ingredientes</td>";
	contenidoPer += "<td>" + ingredientes + "</td>";
	contenidoPer += "</tr>";

	return contenidoPer;
}

function obtenerDetalleArticuloComandaRealizada(item,
		funcionTerminarDetalleComanda) {
	// var contenidoArt = "<ul>";
	var contenidoArt = "";
	var contador = 0;
	ingredientes = "";

	$(item).find('detalleArticulo').each(function() {
		if ($(this).find('ingrediente').length > 0) {
			if (contador != 0) {
				ingredientes += ", ";
			}
			var ingrediente = $.trim($(this).find('ingrediente').text());
			ingredientes += ingrediente;
			contador++;
		}
	});

	$(item)
			.find('datosArticulo')
			.each(
					function() {
						var articulo = $.trim($(this).find('articulo').text());
						var precioArticulo = $.trim($(this).find('precio')
								.text());
						var tipoArticulo = $.trim($(this).find('tipo_articulo')
								.text());
						/*
						 * contenidoArt += tipoArticulo + " - " + articulo + " - " +
						 * precioArticulo + " €";
						 */

						contenidoArt += "<tr>";
						contenidoArt += "<td class=\"titulo\">Articulo</td>";
						contenidoArt += "<td>" + articulo;
						if (typeof funcionTerminarDetalleComanda != "undefined") {
							contenidoArt += funcionTerminarDetalleComanda
						}
						contenidoArt += "</td>"
						contenidoArt += "</tr>";

						contenidoArt += "<tr>";
						contenidoArt += "<td class=\"titulo\">Tipo articulo</td>";
						contenidoArt += "<td>" + tipoArticulo + "</td>";
						contenidoArt += "</tr>";

						contenidoArt += "<tr>";
						contenidoArt += "<td class=\"titulo\">Precio</td>";
						contenidoArt += "<td>" + precioArticulo
								+ " <i class=\"fa fa-euro\"></i></td>";
						contenidoArt += "</tr>";

					});

	if (contador > 0) {
		// contenidoArt += "</ul>";
		contenidoArt += "<tr>";
		contenidoArt += "<td class=\"titulo\">Ingredientes</td>";
		contenidoArt += "<td>" + ingredientes + "</td>";
		contenidoArt += "</tr>";
	}

	// contenidoArt += "</ul>";

	return contenidoArt;
}

function listaComandas(item) {
	mostrarComandasActivas(item)
	mostrarComandasCerradas(item)

	// Se muestra el mensaje
	var mensaje = $.trim($(item).find('mensaje').text());
	mostrarMensaje(mensaje);

	// Se resetean todos los formularios
	resetFormularios();
}

function listaComandasCocina(item) {
	mostrarComandasActivasCocina(item)
	mostrarComandasCerradas(item)

	// Se muestra el mensaje
	var mensaje = $.trim($(item).find('mensaje').text());
	mostrarMensaje(mensaje);

	// Se resetean todos los formularios
	resetFormularios();
}

function mostrarComandasActivas(item) {

	var contenidoComandasActivas = "";
	var contenidoCmbComandasActivas = "";
	var precioTotal = "";
	var destino = ""
	var nombreMesa = "";
	var nombreCamarero = "";
	var fechaComanda = "";
	var idMesa = "";
	var idComanda = "";
	var estadoComanda = "";
	var comandasActivas = false;

	// Se obtienen los datos de la comanda
	$(item).find('comandaActiva').each(
			function() {
				var funcionCerrar = "";
				var funcionVer = "";
				var funcionCancelar = "";

				// Si hay comandas activas se genera la lista
				if ($(this).find('id_comanda').size() > 0 && !comandasActivas) {
					contenidoComandasActivas = "<ul>";
					comandasActivas = true;
				}

				idComanda = $.trim($(this).find('id_comanda').text());
				precioTotal = $.trim($(this).find('precio').text());
				destino = $.trim($(this).find('destino').text());
				idMesa = $.trim($(this).find('id_mesa').text());
				nombreMesa = $.trim($(this).find('nombreMesa').text());
				nombreCamarero = $.trim($(this).find('nombreCamarero').text());
				fechaComanda = $.trim($(this).find('fecha_alta').text());
				estadoComanda = $.trim($(this).find('estado').text());

				// Se genera el contenido del combo de comandas activas
				contenidoCmbComandasActivas += "<option value=\"" + idComanda
						+ "\">";

				// Se generan los enlaces
				funcionCerrar = "<a onclick=\"doAjax('" + site_url
						+ "/comandas/cerrarComandaCamarero','idComanda="
						+ idComanda
						+ "','listaComandas','post',1)\"> Cerrar </a>"

				funcionCancelar = "<a onclick=\"doAjax('" + site_url
						+ "/comandas/cancelarComandaCamarero','idComanda="
						+ idComanda
						+ "','listaComandas','post',1)\"> Cancelar </a>"

				funcionVer = "<a onclick=\"doAjax('" + site_url
						+ "/comandas/verComandaCamarero','idComanda="
						+ idComanda
						+ "','mostrarComandaRealizada','post',1)\"> Ver </a>"

				// Si la comanda es para enviar se muestra el destino, si no la
				// mesa.
				if (idMesa == "0") {
					// Se genera el contenido del combo de comandas activas
					contenidoCmbComandasActivas += idComanda + " - " + destino;

					contenidoComandasActivas += "<li>" + idComanda + " - "
							+ destino + " - " + nombreCamarero + " - "
							+ precioTotal + " - " + estadoComanda + " - "
							+ fechaComanda + funcionCerrar + funcionCancelar
							+ funcionVer + "</li>";
				} else {
					// Se genera el contenido del combo de comandas activas
					contenidoCmbComandasActivas += idComanda + " - "
							+ nombreMesa;

					contenidoComandasActivas += "<li>" + idComanda + " - "
							+ nombreMesa + " - " + nombreCamarero + " - "
							+ precioTotal + " - " + estadoComanda + " - "
							+ fechaComanda + funcionCerrar + funcionCancelar
							+ funcionVer + "</li>";
				}

				// Se genera el contenido del combo de comandas activas
				contenidoCmbComandasActivas += "</option>";

			});

	// Vacio el div donde se muestra las comandas activas y el combo
	$("#listaComandasActivas").empty();
	$("#cmbComandasActivas").empty();

	// Se cierra la lista si hay contenido y se añade al div
	if (comandasActivas) {
		contenidoComandasActivas += "</ul>";
		// Se muestra el contenido
		$("#listaComandasActivas").html(contenidoComandasActivas);

		// Se regenera el combo que contiene las comandas abiertas.
		$("#cmbComandasActivas").html(contenidoCmbComandasActivas);
	}

	// Se comprueba el valor recibido en el xml para saber si hay que vaicar el
	// div
	if ($.trim($(item).find('vaciarDivComanda').text()) == "1") {
		// Se vacia el div donde se muestran las comandas
		$("#mostrarComanda").empty();
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

function mostrarComandasActivasCocina(item) {

	var contenidoComandasActivas = "";
	var contenidoCmbComandasActivas = "";
	var precioTotal = "";
	var destino = ""
	var nombreMesa = "";
	var nombreCamarero = "";
	var fechaComanda = "";
	var idMesa = "";
	var idComanda = "";
	var estadoComanda = "";
	var comandasActivas = false;
	// Si hay comandas activas se genera la lista
	if ($(item).find('comandaActiva').size() > 0) {
		contenidoComandasActivas = "<ul>";
		comandasActivas = true;
	}

	// Se obtienen los datos de la comanda
	$(item)
			.find('comandaActiva')
			.each(
					function() {
						var funcionVer = "";
						var funcionTerminar = "";

						idComanda = $.trim($(this).find('id_comanda').text());
						precioTotal = $.trim($(this).find('precio').text());
						destino = $.trim($(this).find('destino').text());
						idMesa = $.trim($(this).find('id_mesa').text());
						nombreMesa = $.trim($(this).find('nombreMesa').text());
						nombreCamarero = $.trim($(this).find('nombreCamarero')
								.text());
						fechaComanda = $
								.trim($(this).find('fecha_alta').text());
						estadoComanda = $.trim($(this).find('estado').text());

						// Se genera el contenido del combo de comandas activas
						contenidoCmbComandasActivas += "<option value=\""
								+ idComanda + "\">";

						// Se generan los enlaces
						if (estadoComanda == "EC") {
							funcionTerminar = "<a onclick=\"doAjax('"
									+ site_url
									+ "/comandas/terminarComandaCocina','idComanda="
									+ idComanda
									+ "','listaComandasCocina','post',1)\"> Terminar </a>";
						}

						funcionVer = "<a onclick=\"doAjax('"
								+ site_url
								+ "/comandas/verComandaCamarero','idComanda="
								+ idComanda
								+ "','mostrarComandaRealizadaCocina','post',1)\"> Ver </a>";

						// Si la comanda es para enviar se muestra el destino,
						// si no la mesa.
						if (idMesa == "0") {
							// Se genera el contenido del combo de comandas
							// activas
							contenidoCmbComandasActivas += idComanda + " - "
									+ destino;

							contenidoComandasActivas += "<li>" + idComanda
									+ " - " + destino + " - " + nombreCamarero
									+ " - " + precioTotal + " - "
									+ estadoComanda + " - " + fechaComanda
									+ funcionTerminar + funcionVer + "</li>";
						} else {
							// Se genera el contenido del combo de comandas
							// activas
							contenidoCmbComandasActivas += idComanda + " - "
									+ nombreMesa;

							contenidoComandasActivas += "<li>" + idComanda
									+ " - " + nombreMesa + " - "
									+ nombreCamarero + " - " + precioTotal
									+ " - " + estadoComanda + " - "
									+ fechaComanda + funcionTerminar
									+ funcionVer + "</li>";
						}

						// Se genera el contenido del combo de comandas activas
						contenidoCmbComandasActivas += "</option>";

					});

	// Se cierra la lista si hay contenido
	if (comandasActivas) {
		contenidoComandasActivas += "</ul>";

	}

	// Se comprueba el valor recibido en el xml para saber si hay que vaicar el
	// div
	if ($.trim($(item).find('vaciarDivComanda').text()) == "1") {
		// Se vacia el div donde se muestran las comandas
		$("#mostrarComanda").empty();
	}

	// Vacio el div donde se muestra las comandas activas
	$("#listaComandasActivas").empty();

	// Se muestra el contenido
	$("#listaComandasActivas").html(contenidoComandasActivas);

	// Se regenera el combo que contiene las comandas abiertas.
	$("#cmbComandasActivas").empty();
	$("#cmbComandasActivas").html(contenidoCmbComandasActivas);
}

function mostrarComandasCerradas(item) {

	var contenidoComandasCerradas = "";
	var precioTotal = "";
	var destino = ""
	var nombreMesa = "";
	var nombreCamarero = "";
	var fechaComanda = "";
	var idMesa = "";
	var idComanda = "";
	var estadoComanda = "";
	var comandasCerradas = false;

	// Si hay comandas activas se genera la lista
	if ($(item).find('comandaCerrada').children().size() > 0) {
		contenidoComandasCerradas = "<ul>";
		comandasCerradas = true;
	}

	if (comandasCerradas) {
		// Se obtienen los datos de la comanda
		$(item)
				.find('comandaCerrada')
				.each(
						function() {
							var funcionVer = "";
							idComanda = $.trim($(this).find('id_comanda')
									.text());
							precioTotal = $.trim($(this).find('precio').text());
							destino = $.trim($(this).find('destino').text());
							idMesa = $.trim($(this).find('id_mesa').text());
							nombreMesa = $.trim($(this).find('nombreMesa')
									.text());
							nombreCamarero = $.trim($(this).find(
									'nombreCamarero').text());
							fechaComanda = $.trim($(this).find('fecha_alta')
									.text());
							estadoComanda = $.trim($(this).find('estado')
									.text());
							funcionVer = "<a onclick=\"doAjax('"
									+ site_url
									+ "/comandas/verComandaCamarero','idComanda="
									+ idComanda
									+ "','mostrarComandaRealizada','post',1)\"> Ver </a>"

							// Si la comanda es para enviar se muestra el
							// destino, si no la mesa.
							if (idMesa == 0) {
								contenidoComandasCerradas += "<li>" + idComanda
										+ " - " + destino + " - "
										+ nombreCamarero + " - " + precioTotal
										+ " - " + estadoComanda + " - "
										+ fechaComanda + funcionVer + "</li>";
							} else {
								contenidoComandasCerradas += "<li>" + idComanda
										+ " - " + nombreMesa + " - "
										+ nombreCamarero + " - " + precioTotal
										+ " - " + estadoComanda + " - "
										+ fechaComanda + funcionVer + "</li>";
							}

						});

		contenidoComandasCerradas += "</ul>";
	}

	// Vacio el div donde se muestra las comandas activas
	$("#listaComandasCerradas").empty();
	// Se muestra el contenido
	$("#listaComandasCerradas").html(contenidoComandasCerradas);
}

/*
 * function mostrarComandaCocina(item) {
 * 
 * var contenido = ""; var contenidoArt = ""; var contenidoArtPer = ""; var
 * contenidoMenu = ""; var contenidoCarta = ""; var precioTotal = ""; var
 * destino = "" var observaciones = ""; var nombreMesa = ""; var nombreCamarero =
 * ""; var fechaComanda = ""; var idMesa = ""; var idComanda = ""; var
 * detalleComanda = ""; var estadoComanda = ""; //Detalle comanda var
 * cantidadDetalleComanda = 0; var precioDetalleComanda = 0; var idTipoComanda =
 * 0; var estadoDetalle = ""; //Se obtienen los datos de la comanda
 * $(item).find('datosComanda').each(function() { idComanda =
 * $.trim($(this).find('id_comanda').text()); precioTotal =
 * $.trim($(this).find('precio').text()); destino =
 * $.trim($(this).find('destino').text()); observaciones =
 * $.trim($(this).find('observaciones').text()); idMesa =
 * $.trim($(this).find('id_mesa').text()); nombreMesa =
 * $.trim($(this).find('nombreMesa').text()); nombreCamarero =
 * $.trim($(this).find('nombreCamarero').text()); fechaComanda =
 * $.trim($(this).find('fecha_alta').text()); estadoComanda =
 * $.trim($(this).find('estado').text()); }); contenido += idComanda + " - " +
 * destino + " - " + nombreMesa + " - " + nombreCamarero + " - " + precioTotal + " - " +
 * fechaComanda + " - " + estadoComanda + "<br>" + observaciones + "<ul>";
 * //Se obtienen el detalle de la comanda
 * $(item).find('detalleComanda').each(function() { var datosEspecificos = "";
 * var tipoComanda = ""; tipoComanda =
 * $.trim($(this).find('tipoComanda').text())
 * 
 * $(this).find('detalleComandaArticulo').each(function() {
 * cantidadDetalleComanda = $.trim($(this).find('cantidad').text());
 * precioDetalleComanda = $.trim($(this).find('precio').text()); idTipoComanda =
 * $.trim($(this).find('id_tipo_comanda').text()); estadoDetalle =
 * $.trim($(this).find('estado').text()); }); switch (parseInt(idTipoComanda)) {
 * case 1: //Articulo datosEspecificos =
 * obtenerDetalleArticuloComandaRealizada($(this)) //En el primer detalle del
 * tipo de comanda se añade cual es if (contenidoArt == "") { contenidoArt +=
 * tipoComanda; } contenidoArt += "<li>" + cantidadDetalleComanda + " - " +
 * precioDetalleComanda + " - " + estadoDetalle + "</li>" + datosEspecificos;
 * break; case 2: //Articulo personalizado datosEspecificos =
 * obtenerDetalleArticuloPerComandaRealizada($(this)); //En el primer detalle
 * del tipo de comanda se añade cual es if (contenidoArtPer == "") {
 * contenidoArtPer += tipoComanda; }
 * 
 * contenidoArtPer += "<li>" + cantidadDetalleComanda + " - " +
 * precioDetalleComanda + " - " + estadoDetalle + "</li>" + datosEspecificos;
 * break; case 3: //Menu datosEspecificos =
 * obtenerDetalleMenuComandaRealizada($(this)); //En el primer detalle del tipo
 * de comanda se añade cual es if (contenidoMenu == "") { contenidoMenu +=
 * tipoComanda; }
 * 
 * contenidoMenu += "<li>" + cantidadDetalleComanda + " - " +
 * precioDetalleComanda + " - " + estadoDetalle + "</li>" + datosEspecificos;
 * break; case 4: //Carta datosEspecificos =
 * obtenerDetalleCartaComandaRealizada($(this)); //En el primer detalle del tipo
 * de comanda se añade cual es if (contenidoCarta == "") { contenidoCarta +=
 * tipoComanda; }
 * 
 * contenidoCarta += "<li>" + datosEspecificos + " - " +
 * cantidadDetalleComanda + " - " + precioDetalleComanda + " - " + estadoDetalle + "</li>" ;
 * break; }
 * 
 * }); contenido += contenidoArt + contenidoArtPer + contenidoMenu +
 * contenidoCarta + "</ul>"; //Se desabilita el boton de aceptar comanda
 * $("#butAceptarComanda").attr("disabled", "disabled");
 * $("#butAnadirComanda").attr("disabled", "disabled"); //Vacio el div donde se
 * muestra la comanda $("#mostrarComanda").empty(); //Se muestra el contenido
 * $("#mostrarComanda").html(contenido); }
 */

$(document).ready(function() {

})
