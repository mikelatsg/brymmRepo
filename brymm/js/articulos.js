/**
 * Use this ScriptDoc file to manage the documentation for the corresponding
 * namespace in your JavaScript library.
 * 
 * @author Mikel
 */
function listaArticulos(item) {
	var articulo = "";
	var idArticuloLocal = "";
	var descripcion = "";
	var precio = "";
	var idTipoArticulo = "";
	var validoPedidos = "";
	var tipoArticulo = "";
	var enlaceBorrar = "";
	var enlaceModificar = "";
	var ingrediente = "";
	var contenido = "";
	var idTipoArticuloAnterior = 0;
	var contador = 0;
	$(item)
			.find('articuloLocal')
			.each(
					function() {

						var ingredientes = "";
						// Se obtienen los valores del xml
						articulo = $.trim($(this).find('articulo').text());
						descripcion = $
								.trim($(this).find('descripcion').text());
						precio = $.trim($(this).find('precio').text());
						idTipoArticulo = $.trim($(this)
								.find('id_tipo_articulo').text());
						tipoArticulo = $.trim($(this).find('tipo_articulo')
								.text());
						idArticuloLocal = $.trim($(this).find(
								'id_articulo_local').text());
						validoPedidos = $.trim($(this).find('validoPedidos')
								.text());

						if (idTipoArticulo != idTipoArticuloAnterior) {
							contador = 0;
							contenido += "<div class=\"col-md-12\">";
							contenido += "<h3>";
							contenido += "<span class=\"label label-default\">";
							contenido += tipoArticulo;
							contenido += "</span>";
							contenido += "</h3>";
							contenido += "</div>";
						}

						contador += 1;
						if (contador % 2 != 0) {
							contenido += "<div class=\"col-md-12\">";
						}

						idTipoArticuloAnterior = idTipoArticulo;

						var primeraVuelta = true;
						if ($(this).find('ingredientes').children().length > 0) {
							$(this).find('ingredientes').each(
									function() {
										ingrediente = $.trim($(this).find(
												'ingrediente').text());
										if (!primeraVuelta) {
											ingredientes += ",";
										}
										ingredientes += ingrediente;
										primeraVuelta = false;
									});
						}

						contenido += "<div class=\"well col-md-6\">";
						contenido += "<div class=\"span6\">";
						contenido += "<strong>" + articulo + "</strong><br>";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";
						contenido += "<tr>";
						contenido += "<td>Descripcion</td>";
						contenido += "<td>" + descripcion + "</td>";
						contenido += "</tr>";
						contenido += "<tr>";
						contenido += "<td>Precio</td>";
						contenido += "<td>"
								+ round(precio, 2, 'PHP_ROUND_HALF_EVEN')
								+ "<i class=\"fa fa-euro\"></i></td>";
						contenido += "</tr>";
						// Muestro los ingredientes solo si existen
						if (!primeraVuelta) {
							contenido += "<tr>";
							contenido += "<td>Ingredientes</td>";
							contenido += "<td>";
							contenido += ingredientes;
							contenido += "</td>";
							contenido += "</tr>";
						}
						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";
						contenido += "<span class=\"pull-right\">";
						contenido += "<button class=\"btn btn-warning btn-sm\" type=\"button\"";
						contenido += "data-toggle=\"tooltip\" data-original-title=\"Edit this user\"";
						contenido += "onclick=\"mostrarVentanaModificarArticulo('"
								+ idArticuloLocal
								+ "','"
								+ articulo
								+ "','"
								+ descripcion
								+ "','"
								+ precio
								+ "','"
								+ idTipoArticulo
								+ "','"
								+ validoPedidos
								+ "')\"" + "title=\"Modificar articulo\">";
						contenido += "<span class=\"glyphicon glyphicon-edit\"></span>";
						contenido += "</button> ";
						contenido += "<button class=\"btn btn-danger btn-sm\" type=\"button\"";
						contenido += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						contenido += "onclick=\"doAjax('"
								+ site_url
								+ "/articulos/borrarArticulo','idArticuloLocal="
								+ idArticuloLocal
								+ "','listaArticulos','post',1)\""
								+ " title=\"Eliminar articulo\">";
						contenido += "<span class=\"glyphicon glyphicon-remove\"></span>";
						contenido += "</button>";
						contenido += "</span>";
						contenido += "</div>";
						if (contador % 2 == 0) {
							contenido += "</div>";
						}
						if (idTipoArticulo != idTipoArticuloAnterior) {
							idTipoArticuloAnterior = idTipoArticulo;
						}

						// Se genera el contenido de cada articulo
						/*
						 * contenido = contenido + "<li>"; contenido =
						 * contenido + articulo + " - " + descripcion + " - " +
						 * precio + " - " + enlaceModificar + " - " +
						 * enlaceBorrar; contenido = contenido + "</li>";
						 */
					});

	// Se vacia la lista para rellenar con el contenido
	$("#listaArticulos").empty();
	$("#listaArticulos").html(contenido);

	// Se muestra el mensaje
	var mensaje = $.trim($(item).find('mensaje').text());
	mostrarMensaje(mensaje);

	resetFormularios();
}

function llenarFormularioModificar(articulo, descripcion, precio,
		idArticuloLocal, idTipoArticulo, validoPedidos) {
	// Se rellenan los campos del formulario.
	$("#dialogModificarArticulo").find('input[name="articulo"]').val(articulo);
	$("#dialogModificarArticulo").find('input[name="descripcion"]').val(
			descripcion);
	$("#dialogModificarArticulo").find('input[name="precio"]').val(precio);
	$("#dialogModificarArticulo").find('input[name="idArticuloLocal"]').val(
			idArticuloLocal);
	$("#dialogModificarArticulo").find('select[name="tipoArticulo"]').val(
			idTipoArticulo);

	$("#dialogModificarArticulo input:checkbox").attr('checked', false);

	// Se marca el check de valido para pedidos o no
	if (validoPedidos > 0) {
		$("#dialogModificarArticulo").find(
				'input:checkbox[name="validoPedidos"]').click();
	}

	doAjax(site_url + "/articulos/obtenerIngredientesArticulo",
			"idArticuloLocal=" + idArticuloLocal, "checkIngredientes", 'post',
			1)
}

function checkIngredientes(item) {
	var idIngrediente = "";
	$(item).find('xml').children('articuloLocal').each(
			function() {
				idIngrediente = $(this).find('id_ingrediente').text();
				$("#dialogModificarArticulo").find(
						"input:checkbox[name='ingrediente[]'][value="
								+ idIngrediente + "]").click();
			});
}

function llenarFormularioModificarIngrediente(ingrediente, descripcion, precio,
		idIngrediente) {
	// Se rellena los campos del formulario.
	$("#dialogModificarIngrediente").find('input[name="ingrediente"]').val(
			ingrediente);
	$("#dialogModificarIngrediente").find('input[name="descripcion"]').val(
			descripcion);
	$("#dialogModificarIngrediente").find('input[name="precio"]').val(precio);
	$("#dialogModificarIngrediente").find('input[name="idIngrediente"]').val(
			idIngrediente);
}

function listaIngredientes(item) {

	var ingrediente = "";
	var idIngrediente = "";
	var descripcion = "";
	var precio = "";
	var enlaceBorrar = "";
	var enlaceModificar = "";
	var contenido = "";
	var contenidoIngredientes = "";
	var contador = 0;
	$(item)
			.find('xml')
			.children('ingrediente')
			.each(
					function() {

						// Se obtienen los valores del xml
						ingrediente = $
								.trim($(this).find('ingrediente').text());
						descripcion = $
								.trim($(this).find('descripcion').text());
						precio = $.trim($(this).find('precio').text());
						idIngrediente = $.trim($(this).find('id_ingrediente')
								.text());

						// Se crea el enlace para poder modificar el ingrediente
						enlaceModificar = "<a onclick=\"mostrarVentanaModificarIngrediente('"
								+ ingrediente
								+ "','"
								+ descripcion
								+ "','"
								+ precio
								+ "','"
								+ idIngrediente
								+ "')\" data-toggle=\'modal\'> M </a>";

						// Se crea el enlace para poder borrar los platos del
						// local
						enlaceBorrar = "<a onclick=\"doAjax('"
								+ site_url
								+ "/ingredientes/borrarIngrediente','idIngrediente="
								+ idIngrediente
								+ "','listaIngredientes','post',1)\">B</a>";

						contador += 1;
						if (contador % 2 != 0) {
							contenido += "<div class=\"col-md-12\">";
						}

						contenido += "<div class=\"well col-md-6\">";
						contenido += "<div class=\"span6\">";
						contenido += "<strong>" + ingrediente + "</strong><br>";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";
						contenido += "<tr>";
						contenido += "<td>Descripcion</td>";
						contenido += "<td>" + descripcion + "</td>";
						contenido += "</tr>";
						contenido += "<tr>";
						contenido += "<td>Precio</td>";
						contenido += "<td>"
								+ round(precio, 2, 'PHP_ROUND_HALF_EVEN')
								+ "<i class=\"fa fa-euro\"></i></td>";
						contenido += "</tr>";
						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";
						contenido += "<span class=\"pull-right\">";
						contenido += "<button class=\"btn btn-warning btn-sm\" type=\"button\"";
						contenido += "data-toggle=\"tooltip\" data-original-title=\"Edit this user\"";
						contenido += "onclick=\"mostrarVentanaModificarIngrediente('"
								+ ingrediente
								+ "','"
								+ descripcion
								+ "','"
								+ precio
								+ "','"
								+ idIngrediente
								+ "')\""
								+ "title=\"Modificar ingrediente\">";
						contenido += "<span class=\"glyphicon glyphicon-edit\"></span>";
						contenido += "</button> ";
						contenido += "<button class=\"btn btn-danger btn-sm\" type=\"button\"";
						contenido += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						contenido += "onclick=\"doAjax('"
								+ site_url
								+ "/ingredientes/borrarIngrediente','idIngrediente="
								+ idIngrediente
								+ "','listaIngredientes','post',1)\""
								+ " title=\"Eliminar ingrediente\">";
						contenido += "<span class=\"glyphicon glyphicon-remove\"></span>";
						contenido += "</button>";
						contenido += "</span>";
						contenido += "</div>";
						if (contador % 2 == 0) {
							contenido += "</div>";
						}

						// Checkbox de los formularios
						if (contador == 1){
							contenidoIngredientes += "<div class=\"form-group listaIngredientesArticulo\">";
							contenidoIngredientes += "<label for=\"precioArticulo\" class=\"col-sm-4 control-label\">Ingredientes</label>";
							contenidoIngredientes += "<div class=\"col-sm-offset-4 col-sm-8\">";
							contenidoIngredientes += "<div class=\"checkbox\">";
							contenidoIngredientes += "<label class=\"pull-left\"><input name=\"ingrediente[]\"";
							contenidoIngredientes += "type=\"checkbox\" value=\""
									+ idIngrediente + "\">";
							contenidoIngredientes += ingrediente + "</label>";
							contenidoIngredientes += "</div>";
							contenidoIngredientes += "</div>";
							contenidoIngredientes += "</div>";
						}else{
							contenidoIngredientes += "<div class=\"form-group listaIngredientesArticulo\">";
							contenidoIngredientes += "<div class=\"col-sm-offset-4 col-sm-8\">";
							contenidoIngredientes += "<div class=\"checkbox\">";
							contenidoIngredientes += "<label class=\"pull-left\"><input name=\"ingrediente[]\"";
							contenidoIngredientes += "type=\"checkbox\" value=\""
									+ idIngrediente + "\">";
							contenidoIngredientes += ingrediente + "</label>";
							contenidoIngredientes += "</div>";
							contenidoIngredientes += "</div>";
							contenidoIngredientes += "</div>";
						}
												
						

						// Se genera el contenido de cada articulo
						/*
						 * contenido = contenido + "<li>"; contenido =
						 * contenido + ingrediente + " - " + descripcion + " - " +
						 * precio + " - " + enlaceModificar + " - " +
						 * enlaceBorrar; contenido = contenido + "</li>"; //
						 * Checkbox de los formularios contenidoIngredientes =
						 * contenidoIngredientes + "<tr class=\"listaIngredientesArticulo\">";
						 * contenidoIngredientes = contenidoIngredientes + "<td></td><td>";
						 * contenidoIngredientes = contenidoIngredientes + "<input
						 * type = \"checkbox\" "; contenidoIngredientes =
						 * contenidoIngredientes + "name = \"ingrediente[]\" ";
						 * contenidoIngredientes = contenidoIngredientes +
						 * "value = \"" + idIngrediente + "\" / >";
						 * contenidoIngredientes = contenidoIngredientes +
						 * ingrediente; contenidoIngredientes =
						 * contenidoIngredientes + "</td></tr>";
						 */
					});
	// Se modifican los formularios de articulos
	listaIngredientesArticulo(contenidoIngredientes);

	// Se vacia la lista para rellenar con el contenido
	$("#listaIngredientes").empty();
	$("#listaIngredientes").html(contenido);

	// Se muestra el mensaje
	var mensaje = $.trim($(item).find('mensaje').text());
	mostrarMensaje(mensaje);

	// Se resetean todos los formularios
	resetFormularios();
}

function listaIngredientesArticulo(contenidoIngredientes) {
	// Se vacia la lista para rellenar con el contenido
	$(".listaIngredientesArticulo").remove();
	$(".listaIngredientesArticuloMod").remove();// Formulario modificar	
	$("#formAltaArticulo").append(contenidoIngredientes);
	// Formulario modificar
	$("#formModificarArticulo").append(contenidoIngredientes);
}

function listaTiposArticulo(item) {

	var tipoArticulo = "";
	var idTipoArticuloLocal = "";
	var idTipoArticulo = "";
	var personalizar = "";
	var precio = "";
	var enlaceBorrar = "";
	var enlaceModificar = "";
	var contenido = "";
	var contenidoTiposArticulo = "";
	var contador = 0;
	// Se desactiva el boton para añadir articulos por si acaso no hay tipos de
	// articulo
	$("#formAltaArticulo").find('input[type="button"]').attr("disabled",
			"enabled");
	$(item)
			.find('xml')
			.children('tipoArticuloLocal')
			.each(
					function() {
						if (contador == 0) {
							// Se activa el boton para añadir articulos
							$("#formAltaArticulo").find('input[type="button"]')
									.removeAttr('disabled');
						}

						// Se obtienen los valores del xml
						tipoArticulo = $.trim($(this).find('tipo_articulo')
								.text());
						personalizar = $.trim($(this).find('personalizar')
								.text());
						precio = $.trim($(this).find('precio').text());
						idTipoArticuloLocal = $.trim($(this).find(
								'id_tipo_articulo_local').text());
						idTipoArticulo = $.trim($(this)
								.find('id_tipo_articulo').text());

						// Se crea el enlace para poder borrar los platos del
						// local
						enlaceBorrar = "<a onclick=\"doAjax('"
								+ site_url
								+ "/articulos/borrarTipoArticuloLocal','idTipoArticuloLocal="
								+ idTipoArticuloLocal
								+ "','listaTiposArticulo','post',1)\">B</a>";

						// Se crea el enlace para poder modificar el articulo
						enlaceModificar = "<a onclick=\"mostrarVentanaModificarTipoArticulo('"
								+ idTipoArticuloLocal
								+ "','"
								+ idTipoArticulo
								+ "','"
								+ personalizar
								+ "','"
								+ precio
								+ "')\"> M </a>";

						contador += 1;
						if (contador % 2 != 0) {
							contenido += "<div class=\"col-md-12\">";
						}

						contenido += "<div class=\"well col-md-6\">";
						contenido += "<div class=\"span6\">";
						contenido += "<strong>" + tipoArticulo
								+ "</strong><br>";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";
						contenido += "<tr>";
						contenido += "<td>Personalizable</td>";
						if (personalizar == 0) {
							contenido += "<td>No</td>";
						} else {
							contenido += "<td>Si</td>";
						}
						contenido += "</tr>";
						contenido += "<tr>";
						contenido += "<td>Precio</td>";
						contenido += "<td>"
								+ round(precio, 2, 'PHP_ROUND_HALF_EVEN')
								+ "<i class=\"fa fa-euro\"></i></td>";
						contenido += "</tr>";
						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";
						contenido += "<span class=\"pull-right\">";
						contenido += "<button class=\"btn btn-warning btn-sm\" type=\"button\"";
						contenido += "data-toggle=\"tooltip\" data-original-title=\"Edit this user\"";
						contenido += "onclick=\"mostrarVentanaModificarTipoArticulo('"
								+ idTipoArticuloLocal
								+ "','"
								+ idTipoArticulo
								+ "','"
								+ personalizar
								+ "','"
								+ precio
								+ "')\"" + "title=\"Modificar tipo articulo\">";
						contenido += "<span class=\"glyphicon glyphicon-edit\"></span>";
						contenido += "</button> ";
						contenido += "<button class=\"btn btn-danger btn-sm\" type=\"button\"";
						contenido += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						contenido += "onclick=\"doAjax('"
								+ site_url
								+ "/articulos/borrarTipoArticuloLocal','idTipoArticuloLocal="
								+ idTipoArticuloLocal
								+ "','listaTiposArticulo','post',1)\""
								+ " title=\"Eliminar tipo articulo\">";
						contenido += "<span class=\"glyphicon glyphicon-remove\"></span>";
						contenido += "</button>";
						contenido += "</span>";
						contenido += "</div>";
						if (contador % 2 == 0) {
							contenido += "</div>";
						}

						// Se genera el contenido de los formularios de los //

						contenidoTiposArticulo = contenidoTiposArticulo
								+ "<option class=\"form-control\" value=";
						contenidoTiposArticulo = contenidoTiposArticulo + "\""
								+ idTipoArticulo + "\"";
						contenidoTiposArticulo = contenidoTiposArticulo + ">"
								+ tipoArticulo + "</option>";

						// Se genera el contenido de cada articulo
						/*
						 * contenido = contenido + "<li>"; contenido =
						 * contenido + tipoArticulo + " - " + personalizar + " - " +
						 * precio + " - " + enlaceBorrar + enlaceModificar;
						 * contenido = contenido + "</li>"; // Se genera el
						 * contenido de los formularios de los // articulos
						 * contenidoTiposArticulo = contenidoTiposArticulo + "<option
						 * value="; contenidoTiposArticulo =
						 * contenidoTiposArticulo + "\"" + idTipoArticulo +
						 * "\""; contenidoTiposArticulo = contenidoTiposArticulo +
						 * ">" + tipoArticulo + "</option>";
						 */
					});
	// Se modifican los formularios de articulos
	listaTiposArticuloArticulo(contenidoTiposArticulo)

	// Se vacia la lista para rellenar con el contenido
	$("#listaTipoArticulos").empty();
	$("#listaTipoArticulos").html(contenido);

	// Se muestra el mensaje
	var mensaje = $.trim($(item).find('mensaje').text());
	mostrarMensaje(mensaje);

	// Se resetean todos los formularios
	resetFormularios();
}

function listaTiposArticuloArticulo(contenidoTiposArticulo) {
	// Se vacia la lista para rellenar con el contenido
	$("#listaTiposArticulosArticulo").empty();
	$("#listaTiposArticulosArticulo").append(contenidoTiposArticulo);
	// Formulario modificar
	$("#listaTiposArticulosArticuloMod").empty();
	$("#listaTiposArticulosArticuloMod").append(contenidoTiposArticulo);
}

function llenarFormularioModificarTipoArticulo(idTipoArticuloLocal,
		idTipoArticulo, personalizar, precioBase) {
	// Se rellena los campos del formulario.
	$("#dialogModificarTipoArticulo").find('input[name="idTipoArticuloLocal"]')
			.val(idTipoArticuloLocal);
	$("#dialogModificarTipoArticulo").find('select[name="tipoArticulo"]').val(
			idTipoArticulo);
	$("#dialogModificarTipoArticulo").find('input[name="precioBase"]').val(
			precioBase);
	$("#dialogModificarTipoArticulo").find('select[name="personalizar"]').val(
			personalizar);
}

function mostrarVentanaModificarArticulo(idArticuloLocal, articulo,
		descripcion, precio, idTipoArticulo, validoPedidos) {
	/*
	 * Ventana modal modificar articulo
	 */
	$("#dialogModificarArticulo").dialog(
			{
				width : 600,
				modal : true,
				buttons : {
					"Aceptar" : function() {
						// Se envia el formulario que acutaliza el estado
						enviarFormulario(site_url
								+ '/articulos/modificarArticulo',
								'formModificarArticulo', 'listaArticulos', 1)

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

	$('#dialogModificarArticulo').dialog('open');
	// Lleno el formulario
	llenarFormularioModificar(articulo, descripcion, precio, idArticuloLocal,
			idTipoArticulo, validoPedidos);
	return false;
}

function mostrarVentanaModificarIngrediente(ingrediente, descripcion, precio,
		idIngrediente) {
	/*
	 * Ventana modal modificar ingrediente
	 */
	$("#dialogModificarIngrediente").dialog(
			{
				width : 600,
				modal : true,
				buttons : {
					"Aceptar" : function() {
						// Se envia el formulario que modifica el ingrediente
						enviarFormulario(site_url
								+ '/ingredientes/modificarIngrediente',
								'formModificarIngrediente',
								'listaIngredientes', 1)

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

	$('#dialogModificarIngrediente').dialog('open');
	// Lleno el formulario
	llenarFormularioModificarIngrediente(ingrediente, descripcion, precio,
			idIngrediente);
	return false;
}

function mostrarVentanaModificarTipoArticulo(idTipoArticuloLocal,
		idTipoArticulo, personalizar, precioBase) {
	/*
	 * Ventana modal modificar ingrediente
	 */
	$("#dialogModificarTipoArticulo").dialog(
			{
				width : 600,
				modal : true,
				buttons : {
					"Aceptar" : function() {
						// Se envia el formulario que modifica el tipo de
						// articulo
						enviarFormulario(site_url
								+ '/articulos/modificarTipoArticulo',
								'formModificarTipoArticulo',
								'listaTiposArticulo', 1);

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

	$('#dialogModificarTipoArticulo').dialog('open');
	// Lleno el formulario
	llenarFormularioModificarTipoArticulo(idTipoArticuloLocal, idTipoArticulo,
			personalizar, precioBase);
	return false;
}

$(document).ready(function() {

})
