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

	var contenido = "";
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
	$(item)
			.find('pedido')
			.children()
			.each(
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
						var tipoComanda = $.trim($(this).find('tipoComanda')
								.text());
						var idTipoComanda = $.trim($(this)
								.find('idTipoComanda').text());
						var tipoArticulo = $.trim($(this).find('tipoArticulo')
								.text());
						rowid = $.trim($(this).find('rowid').text());
						// Si el campo nombre no esta informado no escribimos
						// nada, se
						// trata del total
						if (nombre != "") {
							existeComanda = 1;
							funcionBorrar = "doAjax('"
									+ site_url
									+ "/comandas/borrarArticuloComanda','rowid="
									+ rowid;

							botonBorrar = "<button class=\"btn btn-danger btn-sm pull-right\""
									+ "type=\"button\" data-toggle=\"tooltip\""
									+ "data-original-title=\"Remove this user\" onclick=\""
									+ "doAjax('"
									+ site_url
									+ "/comandas/borrarArticuloComanda','rowid="
									+ rowid
									+ "','mostrarComanda','post',1)\">"
									+ "<span class=\"glyphicon glyphicon-remove\"></span>"
									+ "</button>";

							if (idTipoComanda == 1) {
								// Articulo
								if (!existeArticulo) {

									contenidoArticulo = "<span class=\"col-md-12\">";
									contenidoArticulo += "<span class=\"badge progress-bar-danger\">"
											+ tipoComanda + "</span>";
									contenidoArticulo += "</span>";
									contenidoArticulo += "<div class=\"well col-md-12\">";
									contenidoArticulo += "<table class=\"table table-condensed table-responsive table-user-information\">";
									contenidoArticulo += "<tbody>";
								}
								existeArticulo = true;
								contenidoArticulo += "<tr>";
								contenidoArticulo += "<td class=\"titulo\">";
								contenidoArticulo += "Nombre";
								contenidoArticulo += "</td>";
								contenidoArticulo += "<td class=\"titulo\">";
								contenidoArticulo += nombre;
								contenidoArticulo += "</td>";
								contenidoArticulo += "<td>";
								contenidoArticulo += botonBorrar;
								contenidoArticulo += "</td>";
								contenidoArticulo += "</tr>";

								contenidoArticulo += "<tr>";
								contenidoArticulo += "<td class=\"titulo\">";
								contenidoArticulo += "Cantidad";
								contenidoArticulo += "</td>";
								contenidoArticulo += "<td colspan=\"2\">";
								contenidoArticulo += cantidad;
								contenidoArticulo += "</td>";
								contenidoArticulo += "</tr>";

								contenidoArticulo += "<tr>";
								contenidoArticulo += "<td class=\"separadorArticulo titulo\">";
								contenidoArticulo += "Precio";
								contenidoArticulo += "</td>";
								contenidoArticulo += "<td class=\"separadorArticulo\" colspan=\"2\">";
								contenidoArticulo += precio;
								contenidoArticulo += "<i class=\"fa fa-euro\"></i>";
								contenidoArticulo += "</td>";
								contenidoArticulo += "</tr>";

							} else if (idTipoComanda == 2) {
								// Articulo personalizado
								// Si es el primer articulo personalizado se
								// muestra el
								// titulo
								if (!existeArticuloPer) {
									contenidoArticuloPer = "<span class=\"col-md-12\">";
									contenidoArticuloPer += "<span class=\"badge progress-bar-danger\">"
											+ tipoComanda + "</span>";
									contenidoArticuloPer += "</span>";
									contenidoArticuloPer += "<div class=\"well col-md-12\">";
									contenidoArticuloPer += "<table class=\"table table-condensed table-responsive table-user-information\">";
									contenidoArticuloPer += "<tbody>";
								}
								existeArticuloPer = true;
								detalleArticuloPer = mostrarDetalleArticuloPer(
										$(this).find('options'), tipoArticulo);

								contenidoArticuloPer += "<tr>";
								contenidoArticuloPer += "<td class=\"titulo\">";
								contenidoArticuloPer += "Nombre";
								contenidoArticuloPer += "</td>";
								contenidoArticuloPer += "<td class=\"titulo\">";
								contenidoArticuloPer += nombre;
								contenidoArticuloPer += "</td>";
								contenidoArticuloPer += "<td>";
								contenidoArticuloPer += botonBorrar;
								contenidoArticuloPer += "</td>";
								contenidoArticuloPer += "</tr>";

								contenidoArticuloPer += "<tr>";
								contenidoArticuloPer += "<td class=\"titulo\">";
								contenidoArticuloPer += "Cantidad";
								contenidoArticuloPer += "</td>";
								contenidoArticuloPer += "<td>";
								contenidoArticuloPer += cantidad;
								contenidoArticuloPer += "</td>";
								contenidoArticuloPer += "</tr>";

								contenidoArticuloPer += "<tr>";
								contenidoArticuloPer += "<td class=\"titulo\">";
								contenidoArticuloPer += "Precio";
								contenidoArticuloPer += "</td>";
								contenidoArticuloPer += "<td>";
								contenidoArticuloPer += precio;
								contenidoArticuloPer += "<i class=\"fa fa-euro\"></i>";
								contenidoArticuloPer += "</td>";
								contenidoArticuloPer += "</tr>";

								contenidoArticuloPer += detalleArticuloPer;

							} else if (idTipoComanda == 3) {
								// Menu
								// Si es el primer menu se muestra el titulo
								if (!existeMenu) {

									contenidoMenu = "<span class=\"col-md-12\">";
									contenidoMenu += "<span class=\"badge progress-bar-danger\">"
											+ tipoComanda + "</span>";
									contenidoMenu += "</span>";
									contenidoMenu += "<div class=\"well col-md-12\">";
									contenidoMenu += "<table class=\"table table-condensed table-responsive table-user-information\">";
									contenidoMenu += "<tbody>";
								}

								contenidoMenu += "<tr>";
								contenidoMenu += "<td class=\"titulo\">";
								contenidoMenu += "Nombre";
								contenidoMenu += "</td>";
								contenidoMenu += "<td class=\"titulo\">";
								contenidoMenu += nombre;
								contenidoMenu += "</td>";
								contenidoMenu += "<td>";
								contenidoMenu += botonBorrar;
								contenidoMenu += "</td>";
								contenidoMenu += "</tr>";

								contenidoMenu += "<tr>";
								contenidoMenu += "<td class=\"titulo\">";
								contenidoMenu += "Cantidad";
								contenidoMenu += "</td>";
								contenidoMenu += "<td colspan=\"2\">";
								contenidoMenu += cantidad;
								contenidoMenu += "</td>";
								contenidoMenu += "</tr>";

								contenidoMenu += "<tr>";
								contenidoMenu += "<td class=\"separadorMenuPlato titulo\">";
								contenidoMenu += "Precio";
								contenidoMenu += "</td>";
								contenidoMenu += "<td class=\"separadorMenuPlato\" colspan=\"2\">";
								contenidoMenu += precio;
								contenidoMenu += "<i class=\"fa fa-euro\"></i>";
								contenidoMenu += "</td>";
								contenidoMenu += "</tr>";

								existeMenu = true;
								detalleMenu = mostrarDetalleMenu($(this).find(
										'options'));

								contenidoMenu += detalleMenu;
								/*
								 * contenidoMenu = contenidoMenu +
								 * contenidoTemporal + detalleMenu;
								 */

							} else {
								// Carta
								if (!existeCarta) {

									contenidoCarta = "<span class=\"col-md-12\">";
									contenidoCarta += "<span class=\"badge progress-bar-danger\">"
											+ tipoComanda + "</span>";
									contenidoCarta += "</span>";
									contenidoCarta += "<div class=\"well col-md-12\">";
									contenidoCarta += "<table class=\"table table-condensed table-responsive table-user-information\">";
									contenidoCarta += "<tbody>";
								}
								existeCarta = true;

								contenidoCarta += "<tr>";
								contenidoCarta += "<td class=\"titulo\">";
								contenidoCarta += "Plato";
								contenidoCarta += "</td>";
								contenidoCarta += "<td class=\"titulo\">";
								contenidoCarta += nombre;
								contenidoCarta += "</td>";
								contenidoCarta += "<td>";
								contenidoCarta += botonBorrar;
								contenidoCarta += "</td>";
								contenidoCarta += "</tr>";

								contenidoCarta += "<tr>";
								contenidoCarta += "<td class=\"titulo\">";
								contenidoCarta += "Cantidad";
								contenidoCarta += "</td>";
								contenidoCarta += "<td>";
								contenidoCarta += cantidad;
								contenidoCarta += "</td>";
								contenidoCarta += "</tr>";

								contenidoCarta += "<tr>";
								contenidoCarta += "<td class=\"separadorPlato titulo\">";
								contenidoCarta += "Precio";
								contenidoCarta += "</td>";
								contenidoCarta += "<td class=\"separadorPlato\" colspan=\"2\">";
								contenidoCarta += precio;
								contenidoCarta += "<i class=\"fa fa-euro\"></i>";
								contenidoCarta += "</td>";
								contenidoCarta += "</tr>";

							}
						} else {
							precioTotal = "<div class=\"well col-md-12\">";
							precioTotal += "<table class=\"table table-condensed table-responsive table-user-information\">";
							precioTotal += "<tbody>";
							precioTotal += "<td class=\"titulo\"> ";
							precioTotal += "Total";
							precioTotal += "</td> ";
							precioTotal += "<td> ";
							precioTotal += $.trim($(item).find('total').text());
							precioTotal += "<i class=\"fa fa-euro\"></i> ";
							precioTotal += "</td> ";
							precioTotal += "<td> ";
							precioTotal += "<button class=\"btn btn-danger btn-sm pull-right\""
									+ "type=\"button\" data-toggle=\"tooltip\""
									+ "data-original-title=\"Remove this user\""
									+ "onclick=\"doAjax('"
									+ site_url
									+ "/comandas/cancelarComanda','','mostrarComanda','post',1)\">"
									+ "<span class=\"glyphicon glyphicon-remove\"></span>"
									+ "</button>";
							precioTotal += "</td> ";
							precioTotal += "</tr> ";
							precioTotal += "</tbody>";
							precioTotal += "</table>";
							precioTotal += "</div>";

						}
					});

	// Cierro la tabla si existe articulo
	if (existeArticulo) {
		contenidoArticulo += "</tbody>";
		contenidoArticulo += "</table>";
		contenidoArticulo += "</div>";
	}

	if (existeArticuloPer) {
		contenidoArticuloPer += "</tbody>";
		contenidoArticuloPer += "</table>";
		contenidoArticuloPer += "</div>";
	}

	if (existeMenu) {
		contenidoMenu += "</tbody>";
		contenidoMenu += "</table>";
		contenidoMenu += "</div>";
	}

	if (existeCarta) {
		contenidoCarta += "</tbody>";
		contenidoCarta += "</table>";
		contenidoCarta += "</div>";
	}

	// Si hay algo en el pedido se muestra el contenido
	if (existeComanda == 1) {
		contenido += "<div class=\"col-md-8\">";
		contenido = contenido + contenidoArticulo + contenidoArticuloPer
				+ contenidoMenu + contenidoCarta;
		contenido = contenido + precioTotal

	}

	// Se habilita el boton de aceptar comanda
	$("#mostrarComanda").html(contenido);

	// Muestro u oculto el formulario de la comanda
	gestionFormularioComanda();

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}
}

function mostrarDetalleMenu(item) {
	var detalleMenu = "";
	$(item).find('platosMenu').each(function() {
		var platoMenu = $.trim($(this).find('nombrePlato').text());
		var platoCantidad = $.trim($(this).find('platoCantidad').text());

		detalleMenu += "<tr>";
		detalleMenu += "<td>";
		detalleMenu += "Plato";
		detalleMenu += "</td>";
		detalleMenu += "<td>";
		detalleMenu += platoMenu;
		detalleMenu += "</td>";
		detalleMenu += "</tr>";

		detalleMenu += "<tr>";
		detalleMenu += "<td class=\"separadorPlato\">";
		detalleMenu += "Cantidad";
		detalleMenu += "</td>";
		detalleMenu += "<td class=\"separadorPlato\" colspan=\"2\">";
		detalleMenu += platoCantidad;
		detalleMenu += "</td>";
		detalleMenu += "</tr>";

		/*
		 * detalleMenu = detalleMenu + "<li>" + platoMenu + "-" +
		 * platoCantidad + "</li>";
		 */
	});
	// detalleMenu = detalleMenu + "</ul>";
	return detalleMenu;
}

function mostrarDetalleArticuloPer(item, tipoArticulo) {
	var detalleArticuloPer = "";// tipoArticulo;
	var i = 0;

	detalleArticuloPer += "<tr>";
	detalleArticuloPer += "<td>";
	detalleArticuloPer += "Tipo de articulo";
	detalleArticuloPer += "</td>";
	detalleArticuloPer += "<td>";
	detalleArticuloPer += tipoArticulo;
	detalleArticuloPer += "</td>";
	detalleArticuloPer += "</tr>";

	var ingredientes = "";
	$(item).find('ingredientes').each(function() {
		var ingrediente = $.trim($(this).find('ingrediente').text());
		if (i == 0) {
			ingredientes += ingrediente;
		} else {
			ingredientes += " , " + ingrediente;
		}

		i++;
	});
	// detalleArticuloPer = detalleArticuloPer + "";
	detalleArticuloPer += "<tr>";
	detalleArticuloPer += "<td class=\"separadorArticulo\">";
	detalleArticuloPer += "Ingredientes";
	detalleArticuloPer += "</td>";
	detalleArticuloPer += "<td class=\"separadorArticulo\" colspan=\"2\">";
	detalleArticuloPer += ingredientes;
	detalleArticuloPer += "</td>";
	detalleArticuloPer += "</tr>";

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
	contenido = contenido + "<td>" + estadosComanda(estadoComanda) + "</td>";
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
									+ estadosComanda(estadoDetalle) + "</td>";
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
									+ estadosComanda(estadoDetalle) + "</td>";
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
							contenidoMenu += "<td>"
									+ estadosComanda(estadoDetalle) + "</td>";
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
									+ estadosComanda(estadoDetalle) + "</td>";
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
	// $("#butAceptarComanda").attr("disabled", "disabled");
	// $("#butAnadirComanda").attr("disabled", "disabled");
	// Vacio el div donde se muestra la comanda
	$("#mostrarComanda").empty();

	gestionFormularioComanda();

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
	contenido = contenido + "<td>" + estadosComanda(estadoComanda) + "</td>";
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
							funcionTerminarDetalleComanda += "<button class=\"btn btn-success btn-sm pull-right\" type=\"button\"";
							funcionTerminarDetalleComanda
									+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
							funcionTerminarDetalleComanda += "onclick=";
							funcionTerminarDetalleComanda += "doAjax('"
									+ site_url
									+ "/comandas/terminarDetalleComanda','idDetalleComanda="
									+ idDetalleComanda
									+ "&idComanda="
									+ idComanda
									+ "','mostrarComandaRealizadaCocina','post',1)"
									+ " title=\"Terminar articulo\">";
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
	// $("#butAceptarComanda").attr("disabled", "disabled");
	// $("#butAnadirComanda").attr("disabled", "disabled");
	// Vacio el div donde se muestra la comanda
	$("#mostrarComanda").empty();

	// No muestro el formulario
	gestionFormularioComanda();

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
							funcionTerminarPlatoMenu += "<button class=\"btn btn-success btn-sm pull-right\" type=\"button\"";
							funcionTerminarPlatoMenu
									+ "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
							funcionTerminarPlatoMenu += "onclick=";
							funcionTerminarPlatoMenu += "doAjax('"
									+ site_url
									+ "/comandas/terminarPlatoMenu','idComandaMenu="
									+ idComandaMenu
									+ "&idComanda="
									+ idComanda
									+ "','mostrarComandaRealizadaCocina','post',1)"
									+ " title=\"Terminar articulo\">";
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

					/*contenidoComandasActivas += "<li>" + idComanda + " - "
							+ destino + " - " + nombreCamarero + " - "
							+ precioTotal + " - " + estadoComanda + " - "
							+ fechaComanda + funcionCerrar + funcionCancelar
							+ funcionVer + "</li>";*/
				} else {
					// Se genera el contenido del combo de comandas activas
					contenidoCmbComandasActivas += idComanda + " - "
							+ nombreMesa;

					/*contenidoComandasActivas += "<li>" + idComanda + " - "
							+ nombreMesa + " - " + nombreCamarero + " - "
							+ precioTotal + " - " + estadoComanda + " - "
							+ fechaComanda + funcionCerrar + funcionCancelar
							+ funcionVer + "</li>";*/
				}

				// Se genera el contenido del combo de comandas activas
				contenidoCmbComandasActivas += "</option>";
				
				contenidoComandasActivas += generarContenidoComandaActivaCamarero(idComanda, nombreCamarero,
						idMesa, destino, nombreMesa, estadoComanda, precioTotal);

			});

	// Vacio el div donde se muestra las comandas activas y el combo
	$("#listaComandasActivas").empty();
	$("#cmbComandasActivas").empty();

	// Se cierra la lista si hay contenido y se añade al div
	if (comandasActivas) {		
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

		// No muestro el formulario
		gestionFormularioComanda();
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
		contenidoComandasActivas = "";
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

						// Si la comanda es para enviar se muestra el destino,
						// si no la mesa.
						// if (idMesa == "0") {
						// Se genera la lista
						contenidoComandasActivas += generarContenidoComandaActivaCocina(
								idComanda, nombreCamarero, idMesa, destino,
								nombreMesa, estadoComanda, precioTotal);
						/*
						 * } else {
						 *  // Se genera la lista contenidoComandasActivas +=
						 * generarContenidoComandaActivaCocina( idComanda,
						 * nombreCamarero, idMesa, destino, nombreMesa,
						 * estadoComanda, precioTotal); }
						 */

					});

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
		contenidoComandasCerradas = "";
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

							contenidoComandasCerradas += generarContenidoComandaCerradaCocina(
									idComanda, nombreCamarero, idMesa, destino,
									nombreMesa, estadoComanda, precioTotal)
						});

	}

	// Vacio el div donde se muestra las comandas activas
	$("#listaComandasCerradas").empty();
	// Se muestra el contenido
	$("#listaComandasCerradas").html(contenidoComandasCerradas);
}

function gestionFormularioComanda() {
	if ($('#mostrarComanda').text().trim() == "") {
		$('#formularioAceptarComanda').hide();
	} else {
		$('#formularioAceptarComanda').show();
	}
}

function comprobarAlertasComandas() {
	// Obtengo la fecha actual
	var d = new Date();
	var month = d.getMonth() + 1;
	var day = d.getDate();
	var hours = d.getHours();
	var minutes = d.getMinutes();
	var seconds = d.getSeconds();
	if (seconds < 10) {
		seconds = "0" + seconds;
	}
	if (minutes < 10) {
		minutes = "0" + minutes;
	}
	if (hours < 10) {
		hours = "0" + hours;
	}
	var output = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-'
			+ (day < 10 ? '0' : '') + day + ' ' + hours + ':' + minutes + ':'
			+ seconds;

	doAjax(site_url + "/comandas/comprobarAlertaComanda", "fecha=" + output,
			'obtenerListaComandasActivas', 'post', 0);
}

function obtenerListaComandasActivas(data) {
	var json = $.parseJSON(data);
	var hayAlertaComanda = json.hayAlertaComanda;

	if (hayAlertaComanda) {
		// Si hay pedidos nuevos cargo la lista de pedidos pendientes.
		doAjax(site_url + "/comandas/obtenerComandasActivas", '',
				'listaComandasActivas', 'post', 0);
	}
}

function listaComandasActivas(data) {
	var json = $.parseJSON(data);
	var jsonComandas = json.comandasActivas;
	var contenido = "";
	$.each(jsonComandas, function(key, value) {
		var idComanda = value.idComanda;
		var estado = value.estado;
		var precio = value.precio;
		var nombreCamarero = value.camarero.nombre;
		var idMesa = value.mesa.idMesa;
		var destino = value.destino;
		var nombreMesa = "";
		if (idMesa != 0) {
			nombreMesa = value.mesa.nombre;
		}

		contenido += generarContenidoComandaActivaCocina(idComanda,
				nombreCamarero, idMesa, destino, nombreMesa, estado, precio);

	});

	// muestro el contenido
	$('#listaComandasActivas').empty();
	$('#listaComandasActivas').html(contenido);
}

function generarContenidoComandaActivaCocina(idComanda, nombreCamarero, idMesa,
		destino, nombreMesa, estado, precio) {
	var contenido = "";
	contenido += "<div class=\"col-md-12 list-div\">";
	contenido += "<table class=\"table\">";
	contenido += "<tbody>";
	contenido += "<tr>";
	contenido += "<td class=\"titulo\" colspan=\"3\">Comanda ";
	contenido += idComanda;
	if (estado == "EC") {
		contenido += "<button class=\"btn btn-success btn-sm pull-right\" type=\"button\" ";
		contenido += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\" ";
		contenido += "onclick=\"";
		contenido += "doAjax('" + site_url
				+ "/comandas/terminarComandaCocina','idComanda=";
		contenido += idComanda + "','listaComandasCocina','post',1)\" ";
		contenido += "title=\"Terminar comanda\">";
		contenido += "<span class=\"glyphicon glyphicon-ok\"></span>";
		contenido += "</button>";
	}
	contenido += "<button class=\"btn btn-default btn-sm pull-right\" type=\"button\" ";
	contenido += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\" ";
	contenido += "onclick=\"";
	contenido += "doAjax('" + site_url
			+ "/comandas/verComandaCamarero','idComanda=";
	contenido += idComanda + "','mostrarComandaRealizadaCocina','post',1)\"";
	contenido += "title=\"Ver comanda\">";
	contenido += "<span class=\"glyphicon glyphicon-eye-open\"></span>";
	contenido += "</button>";
	contenido += "</td>";
	contenido += "</tr>";
	contenido += "<tr>";
	contenido += "<td>" + nombreCamarero;
	contenido += "<i class=\"fa fa-user\"></i></td>";
	contenido += "<td>" + precio
			+ "<span class=\"glyphicon glyphicon-euro\"></span></td>";
	contenido += "<td>";
	if (idMesa == 0) {
		contenido += destino;
		contenido += "<i class=\"fa fa-flag\" title=\"Destinatario\"></i>";
	} else {
		contenido += nombreMesa;
		contenido += "<i class=\"fa fa-flag\" title=\"Mesa\"></i>";
	}
	contenido += "</td>";
	contenido += "</tr>";
	contenido += "</tbody>";
	contenido += "</table>";
	contenido += "</div>";

	return contenido;
}

function generarContenidoComandaCerradaCocina(idComanda, nombreCamarero,
		idMesa, destino, nombreMesa, estado, precio) {
	var contenido = "";
	contenido += "<div class=\"col-md-12 list-div\">";
	contenido += "<table class=\"table\">";
	contenido += "<tbody>";
	contenido += "<tr>";
	contenido += "<td class=\"titulo\" colspan=\"3\">Comanda ";
	contenido += idComanda;
	contenido += "<button class=\"btn btn-default btn-sm pull-right\" type=\"button\" ";
	contenido += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\" ";
	contenido += "onclick=\"";
	contenido += "doAjax('" + site_url
			+ "/comandas/verComandaCamarero','idComanda=";
	contenido += idComanda + "','mostrarComandaRealizadaCocina','post',1)\"";
	contenido += "title=\"Ver comanda\">";
	contenido += "<span class=\"glyphicon glyphicon-eye-open\"></span>";
	contenido += "</button>";
	contenido += "</td>";
	contenido += "</tr>";
	contenido += "<tr>";
	contenido += "<td>" + nombreCamarero;
	contenido += "<i class=\"fa fa-user\"></i></td>";
	contenido += "<td>" + precio
			+ "<span class=\"glyphicon glyphicon-euro\"></span></td>";
	contenido += "<td>";
	if (idMesa == 0) {
		contenido += destino;
		contenido += "<i class=\"fa fa-flag\" title=\"Destinatario\"></i>";
	} else {
		contenido += nombreMesa;
		contenido += "<i class=\"fa fa-flag\" title=\"Mesa\"></i>";
	}
	contenido += "</td>";
	contenido += "</tr>";
	contenido += "</tbody>";
	contenido += "</table>";
	contenido += "</div>";

	return contenido;
}

function generarContenidoComandaActivaCamarero(idComanda, nombreCamarero,
		idMesa, destino, nombreMesa, estado, precio) {
	var contenido = "";
	contenido += "<div class=\"col-md-12 list-div\">";
	contenido += "<table class=\"table\">";
	contenido += "<tbody>";
	contenido += "<tr>";
	contenido += "<td class=\"titulo\" colspan=\"3\">Comanda ";
	contenido += idComanda;

	contenido += "<button class=\"btn btn-danger btn-sm pull-right\" type=\"button\" ";
	contenido += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\" ";
	contenido += "onclick=\"";
	contenido += "doAjax('" + site_url
			+ "/comandas/cancelarComandaCamarero','idComanda=";
	contenido += idComanda + "','listaComandas','post',1)\" ";
	contenido += "title=\"Cancelar comanda\">";
	contenido += "<span class=\"glyphicon glyphicon-remove\"></span>";
	contenido += "</button>";
	
	contenido += "<button class=\"btn btn-warning btn-sm pull-right\" type=\"button\" ";
	contenido += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\" ";
	contenido += "onclick=\"";
	contenido += "doAjax('" + site_url
			+ "/comandas/cerrarComandaCamarero','idComanda=";
	contenido += idComanda + "','listaComandas','post',1)\" ";
	contenido += "title=\"Cancelar comanda\">";
	contenido += "<span class=\"glyphicon glyphicon-edit\"></span>";
	contenido += "</button>";		

	contenido += "<button class=\"btn btn-default btn-sm pull-right\" type=\"button\" ";
	contenido += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\" ";
	contenido += "onclick=\"";
	contenido += "doAjax('" + site_url
			+ "/comandas/verComandaCamarero','idComanda=";
	contenido += idComanda + "','mostrarComandaRealizada','post',1)\"";
	contenido += "title=\"Ver comanda\">";
	contenido += "<span class=\"glyphicon glyphicon-eye-open\"></span>";
	contenido += "</button>";
	contenido += "</td>";
	contenido += "</tr>";
	contenido += "<tr>";
	contenido += "<td>" + nombreCamarero;
	contenido += "<i class=\"fa fa-user\"></i></td>";
	contenido += "<td>" + precio
			+ "<span class=\"glyphicon glyphicon-euro\"></span></td>";
	contenido += "<td>";
	if (idMesa == 0) {
		contenido += destino;
		contenido += "<i class=\"fa fa-flag\" title=\"Destinatario\"></i>";
	} else {
		contenido += nombreMesa;
		contenido += "<i class=\"fa fa-flag\" title=\"Mesa\"></i>";
	}
	contenido += "</td>";
	contenido += "</tr>";
	contenido += "</tbody>";
	contenido += "</table>";
	contenido += "</div>";

	return contenido;
}

$(document).ready(function() {

})
