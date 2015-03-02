/**
 * Use this ScriptDoc file to manage the documentation for the corresponding
 * namespace in your JavaScript library.
 * 
 * @author Mikel
 */
function listaServiciosLocal(item) {

	var servicio = "";
	var importeMinimo = "";
	var precio = "";
	var idServicioLocal = "";
	var enlaceBorrar = "";
	var contenido = "";
	var contador = 0;
	var enlaceActivarDesactivar = "";
	var activo = 0;
	var enlaceModificar = "";
	var idTipoServicioLocal = "";
	$(item)
			.find('servicioLocal')
			.each(
					function() {

						// Se obtienen los valores del xml
						servicio = $.trim($(this).find('servicio').text());
						importeMinimo = $.trim($(this).find('importe_minimo')
								.text());
						precio = $.trim($(this).find('precio').text());
						idServicioLocal = $.trim($(this).find(
								'id_servicio_local').text());
						idTipoServicioLocal = $.trim($(this).find(
								'id_tipo_servicio_local').text());
						activo = $.trim($(this).find('activo').text());

						// Se crea el enlace para poder borrar los platos del
						// local
						/*
						 * enlaceBorrar = "<a onclick=\"doAjax('" + site_url +
						 * "/servicios/borrarServicio','idServicioLocal=" +
						 * idServicioLocal +
						 * "','listaServiciosLocal','post',1)\">B</a>";
						 */

						enlaceBorrar = "<button class=\"btn btn-danger btn-sm\" type=\"button\"";
						enlaceBorrar += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						enlaceBorrar += "onclick=\"doAjax('"
								+ site_url
								+ "/servicios/borrarServicio','idServicioLocal="
								+ idServicioLocal
								+ "','listaServiciosLocal','post',1)\""
								+ " title=\"Eliminar horario\">";
						enlaceBorrar += "<span class=\"glyphicon glyphicon-remove\"></span>";
						enlaceBorrar += "</button> ";

						// Se crea el enlace para poder modificar el articulo
						/*
						 * enlaceModificar = "<a
						 * onclick=\"mostrarVentanaModificarServicio('" +
						 * idTipoServicioLocal + "','" + importeMinimo + "','" +
						 * precio + "','" + idServicioLocal + "')\"> M </a>";
						 */
						enlaceModificar = "<button class=\"btn btn-warning btn-sm\" type=\"button\"";
						enlaceModificar += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
						enlaceModificar += "onclick=\"mostrarVentanaModificarServicio('"
								+ idTipoServicioLocal
								+ "','"
								+ importeMinimo
								+ "','"
								+ precio
								+ "','"
								+ idServicioLocal
								+ "')\"" + " title=\"Modificar servicio\">";
						enlaceModificar += "<span class=\"glyphicon glyphicon-remove\"></span>";
						enlaceModificar += "</button> ";

						if (activo == 1) {
							// Se crea el enlace para poder desactivar el
							// servicio
							/*
							 * enlaceActivarDesactivar = "<a
							 * onclick=\"doAjax('" + site_url +
							 * "/servicios/desactivarServicio','idServicioLocal=" +
							 * idServicioLocal +
							 * "','listaServiciosLocal','post',1)\">" + "
							 * Desactivar </a>";
							 */
							enlaceActivarDesactivar = "<button class=\"btn btn-danger btn-sm\" type=\"button\"";
							enlaceActivarDesactivar += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
							enlaceActivarDesactivar += "onclick=\"doAjax('"
									+ site_url
									+ "/servicios/desactivarServicio','idServicioLocal="
									+ idServicioLocal
									+ "','listaServiciosLocal','post',1)\""
									+ " title=\"Eliminar horario\">";
							enlaceActivarDesactivar += "<span class=\"glyphicon glyphicon-off\"></span>";
							enlaceActivarDesactivar += "</button> ";
						} else {
							// Se crea el enlace para poder activar el servicio
							/*
							 * enlaceActivarDesactivar = "<a
							 * onclick=\"doAjax('" + site_url +
							 * "/servicios/activarServicio','idServicioLocal=" +
							 * idServicioLocal +
							 * "','listaServiciosLocal','post',1)\">" + "
							 * Activar </a>";
							 */
							enlaceActivarDesactivar = "<button class=\"btn btn-success btn-sm\" type=\"button\"";
							enlaceActivarDesactivar += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
							enlaceActivarDesactivar += "onclick=\"doAjax('"
									+ site_url
									+ "/servicios/activarServicio','idServicioLocal="
									+ idServicioLocal
									+ "','listaServiciosLocal','post',1)\""
									+ " title=\"Eliminar horario\">";
							enlaceActivarDesactivar += "<span class=\"glyphicon glyphicon-off\"></span>";
							enlaceActivarDesactivar += "</button> ";
						}

						contador += 1;
						if (contador % 2 != 0) {
							contenido += "<div class=\"col-md-12\">";
						}

						contenido += "<div class=\"well col-md-6\">";
						contenido += "<div class=\"span6\">";
						contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
						contenido += "<tbody>";
						contenido += "<tr>";
						contenido += "<td>Servicio</td>";
						contenido += "<td>" + servicio + "</td>";
						contenido += "</tr>";
						contenido += "<tr>";
						contenido += "<td>Importe minimo</td>";
						contenido += "<td>"
								+ round(importeMinimo, 2, 'PHP_ROUND_HALF_EVEN')
								+ " <i class=\"fa fa-euro\"></i></td>";
						contenido += "</tr>";
						contenido += "<tr>";
						contenido += "<td>Precio</td>";
						contenido += "<td>"
								+ round(precio, 2, 'PHP_ROUND_HALF_EVEN')
								+ " <i class=\"fa fa-euro\"></td>";
						contenido += "</tr>";
						contenido += "</tbody>";
						contenido += "</table>";
						contenido += "</div>";
						contenido += "<span class=\"pull-right\">";
						contenido += enlaceBorrar;
						contenido += enlaceActivarDesactivar;
						contenido += enlaceModificar;
						contenido += "</span>";
						contenido += "</div>";
						if (contador % 2 == 0) {
							contenido += "</div>";
						}

						// Se genera el contenido de cada articulo
						/*
						 * contenido = contenido + "<li>"; contenido =
						 * contenido + servicio + " - " + importeMinimo + " - " +
						 * precio + " - " + enlaceBorrar + enlaceModificar +
						 * enlaceActivarDesactivar; contenido = contenido + "</li>";
						 * 
						 * contador++;
						 */
					});

	// Se vacia la lista para rellenar con el contenido
	$("#listaServicioLocal").empty();
	$("#listaServicioLocal").html(contenido);

	// Se muestra el mensaje
	var mensaje = $.trim($(item).find('mensaje').text());
	mostrarMensaje(mensaje);

	// Se resetean todos los formularios
	resetFormularios();
}

function llenarFormularioModificarServicio(idTipoServicioLocal, importeMinimo,
		precio, idServicioLocal) {
	// Se rellenan los campos del formulario.
	$("#dialogModificarServicios").find('select[name="idTipoServicioLocal"]')
			.val(idTipoServicioLocal);
	$("#dialogModificarServicios").find('input[name="importeMinimo"]').val(
			importeMinimo);
	$("#dialogModificarServicios").find('input[name="precio"]').val(precio);
	$("#dialogModificarServicios").find('input[name="idServicioLocal"]').val(
			idServicioLocal);
}

function mostrarVentanaModificarServicio(idTipoServicioLocal, importeMinimo,
		precio, idServicioLocal) {
	/*
	 * Ventana modal modificar ingrediente
	 */
	$("#dialogModificarServicios").dialog(
			{
				width : 600,
				modal : true,
				buttons : {
					"Aceptar" : function() {
						// Se envia el formulario que modifica el servicio
						enviarFormulario(site_url
								+ '/servicios/modificarServicioLocal',
								'formModificarServicioLocal',
								'listaServiciosLocal', 1)

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

	$('#dialogModificarServicios').dialog('open');
	// Lleno el formulario
	llenarFormularioModificarServicio(idTipoServicioLocal, importeMinimo,
			precio, idServicioLocal);
	return false;
}
