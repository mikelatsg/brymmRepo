/**
 * Use this ScriptDoc file to manage the documentation for the corresponding
 * namespace in your JavaScript library.
 * 
 * @author Mikel
 */
function listaCamareros(item) {
	var nombre = "";
	var idCamarero = "";
	var controlTotal = "";
	var enlaceBorrar = "";
	var enlaceModificar = "";
	var enlaceIniciarSesion = "";
	var contenido = "";
	var contador = 0;
	$(item)
			.find('xml')
			.children('camareroLocal')
			.each(
					function() {
						if (contador == 0) {
							contenido = contenido + "<ul>";
						}

						// Se obtienen los valores del xml
						nombre = $.trim($(this).find('nombre').text());
						idCamarero = $.trim($(this).find('id_camarero').text());
						controlTotal = $.trim($(this).find('control_total')
								.text());
						// Se crea el enlace para poder borrar los platos del
						// local
						enlaceBorrar = "<a onclick=\"doAjax('" + site_url
								+ "/camareros/borrarCamarero','idCamarero="
								+ idCamarero
								+ "','listaCamareros','post',1)\">B</a>";

						// Se crea el enlace para poder modificar el articulo
						enlaceModificar = "<a href=\"javascript:llenarFormularioModificarCamarero('"
								+ idCamarero
								+ "','"
								+ nombre
								+ "','"
								+ controlTotal + "')\"> M </a>";

						// Se crea el enlace para poder iniciar sesion
						enlaceIniciarSesion = "<a onclick=\"doAjax('"
								+ site_url
								+ "/camareros/iniciarSesionCamarero','idCamarero="
								+ idCamarero
								+ "','sesionCamarero','post',1)\"> Iniciar sesion</a>";

						// Se genera el contenido de cada articulo
						contenido = contenido + "<li>";
						contenido = contenido + nombre + " - " + controlTotal
								+ " - " + enlaceBorrar + enlaceIniciarSesion
								+ enlaceModificar;
						contenido = contenido + "</li>";
						contador++;
					});
	if (contador > 0) {
		contenido = contenido + "</ul>";
	}

	// Se vacia la lista para rellenar con el contenido
	$("#listaCamarerors").empty();
	$("#listaCamarerors").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}

	resetFormularios();
}

function sesionCamarero(item) {
	var contenido = "";
	var idCamarero = "";
	var nombre = "";
	// Se obtienen los valores del xml
	idCamarero = $.trim($(item).find('id_camarero').text());
	if (idCamarero == "") {
		contenido = "No hay ningún camarero activo";
	} else {
		/*
		 * var enlaceCerrarSession = "<a onclick=\"doAjax('" + site_url +
		 * "/camareros/cerrarSesionCamarero','','sesionCamarero','post',1)\">" + "
		 * Cerrar sesion </a>";
		 */
		nombre = $.trim($(item).find('nombre').text());
		contenido = nombre;
	}

	// Se vacia la lista para rellenar con el contenido
	$("#sesionCamarero").empty();
	$("#sesionCamarero").html(contenido);

	// Si hay mensaje se muestra
	if ($(item).find('mensaje').length > 0) {
		var mensaje = $.trim($(item).find('mensaje').text());
		if (mensaje != "") {
			mostrarMensaje(mensaje);
		}
	}
}

function llenarFormularioModificarCamarero(idCamarero, nombre, controlTotal) {
	// Se rellena los campos del formulario.
	$("#formModificarCamarero").find('input[name="idCamarero"]')
			.val(idCamarero);
	$("#formModificarCamarero").find('input[name="nombreCamarero"]')
			.val(nombre);

	$("#formModificarCamarero input:checkbox").attr('checked', false);

	if (controlTotal == "1") {
		$("#formModificarCamarero").find("input:checkbox[name='controlTotal']")
				.click();
	}

}

function mostrarVentanaModificarCamarero(idCamarero, nombre, controlTotal) {
	/*
	 * Ventana modal modificar ingrediente
	 */
	$("#dialogModificarCamareros").dialog(
			{
				width : 600,
				modal : true,
				buttons : {
					"Aceptar" : function() {
						// Se envia el formulario que modifica el servicio
						enviarFormulario(site_url
								+ '/camareros/modificarCamarero',
								'formModificarCamarero', 'listaCamareros', 1)

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

	$('#dialogModificarCamareros').dialog('open');
	// Lleno el formulario
	llenarFormularioModificarCamarero(idCamarero, nombre, controlTotal);
	return false;
}

function ocultarPlatosMenu() {
	// $("div[id^='platosMenu_']").each(alert('uno'));
	$('div[id^="platosMenu_"]').hide();
	$('h3[id^="tituloMenu_"]').hide();
}

function mostrarMenuSeleccionado() {
	var menuSeleccionado = $('select[name=idTipoMenuLocal]').val();
	$('#tituloMenu_' + menuSeleccionado).show();
	$('#platosMenu_' + menuSeleccionado).show();
}

function gestionMenuSeleccionado(){
	ocultarPlatosMenu();
	mostrarMenuSeleccionado();
}

$(document).ready(function() {
	gestionMenuSeleccionado();
})
