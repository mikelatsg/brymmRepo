/**
 * Use this ScriptDoc file to manage the documentation for the corresponding namespace in your JavaScript library.
 *
 * @author Mikel
 */
function listaHorarioPedido(item) {

    var dia = "";
    var horaInicio = "";
    var horaFin = "";
    var idHorarioPedido = "";
    var enlaceBorrar = "";
    var contenido = "";
    var contador = 0;
    var idTipoArticuloAnterior = 0;
    $(item).find('xml').children('horarioPedido').each(function() {
        if (contador == 0) {
            contenido = contenido + "<ul>";
        }

        //Se obtienen los valores del xml
        dia = $.trim($(this).find('dia').text());
        horaInicio = $.trim($(this).find('hora_inicio').text());
        horaFin = $.trim($(this).find('hora_fin').text());
        idHorarioPedido = $.trim($(this).find('id_horario_pedido').text());

        //Se crea el enlace para poder borrar los platos del local
        enlaceBorrar = "<a onclick=\"doAjax('" + site_url
                + "/locales/borrarHorarioPedido','idHorarioPedido="
                + idHorarioPedido + "','listaHorarioPedido','post',1)\">B</a>";

        //Se genera el contenido de cada articulo
        contenido = contenido + "<li>";
        contenido = contenido + dia + " - " + horaInicio + " - "
                + horaFin + " - " + enlaceBorrar;
        contenido = contenido + "</li>";

        contador++;
    });
    if (contador > 0) {
        contenido = contenido + "</ul>";
    }

    //Se vacia la lista para rellenar con el contenido
    $("#listaHorarioPedidos").empty();
    $("#listaHorarioPedidos").html(contenido);
    
    //Se muestra el mensaje
    var mensaje = $.trim($(item).find('mensaje').text());
    mostrarMensaje(mensaje);

    //Se resetean todos los formularios
    resetFormularios();
}

function listaHorarioLocal(item) {

    var dia = "";
    var horaInicio = "";
    var horaFin = "";
    var idHorarioLocal = "";
    var enlaceBorrar = "";
    var contenido = "";
    var contador = 0;
    var idTipoArticuloAnterior = 0;
    $(item).find('xml').children('horarioLocal').each(function() {       

        //Se obtienen los valores del xml
        dia = $.trim($(this).find('dia').text());
        horaInicio = $.trim($(this).find('hora_inicio').text());
        horaFin = $.trim($(this).find('hora_fin').text());
        idHorarioLocal = $.trim($(this).find('id_horario_local').text());

        //Se crea el enlace para poder borrar los platos del local
        enlaceBorrar = "<a onclick=\"doAjax('" + site_url
                + "/locales/borrarHorarioLocal','idHorarioLocal="
                + idHorarioLocal + "','listaHorarioLocal','post',1)\">B</a>";

        contador += 1;
		if (contador % 2 != 0) {
			contenido += "<div class=\"col-md-12\">";
		}

		contenido += "<div class=\"well col-md-6\">";
		contenido += "<div class=\"span6\">";
		contenido += "<strong>" + dia + "</strong><br>";
		contenido += "<table class=\"table table-condensed table-responsive table-user-information\">";
		contenido += "<tbody>";
		contenido += "<tr>";
		contenido += "<td>Hora inicio</td>";
		contenido += "<td>" + horaInicio + "</td>";
		contenido += "</tr>";
		contenido += "<tr>";
		contenido += "<td>Hora fin</td>";
		contenido += "<td>"
				+ horaFin
				+ "</td>";
		contenido += "</tr>";
		contenido += "</tbody>";
		contenido += "</table>";
		contenido += "</div>";
		contenido += "<span class=\"pull-right\">";		
		contenido += "<button class=\"btn btn-danger btn-sm\" type=\"button\"";
		contenido += "data-toggle=\"tooltip\" data-original-title=\"Remove this user\"";
		contenido += "onclick=\"doAjax('"
				+ site_url
				+ "/locales/borrarHorarioLocal','idHorarioLocal="
				+ idHorarioLocal
				+ "','listaHorarioLocal','post',1)\""
				+ " title=\"Eliminar horario\">";
		contenido += "<span class=\"glyphicon glyphicon-remove\"></span>";
		contenido += "</button>";
		contenido += "</span>";
		contenido += "</div>";
		if (contador % 2 == 0) {
			contenido += "</div>";
		}
        
        //Se genera el contenido de cada articulo
        /*contenido = contenido + "<li>";
        contenido = contenido + dia + " - " + horaInicio + " - "
                + horaFin + " - " + enlaceBorrar;
        contenido = contenido + "</li>";

        contador++;*/
    });

    //Se vacia la lista para rellenar con el contenido
    $("#listaHorarioLocal").empty();
    $("#listaHorarioLocal").html(contenido);
    
    //Se muestra el mensaje
    var mensaje = $.trim($(item).find('mensaje').text());
    mostrarMensaje(mensaje);

    //Se resetean todos los formularios
    resetFormularios();
}

function listaDiasCierreLocal(item) {

    var fecha = "";
    var idDiaCierreLocal = "";
    var enlaceBorrar = "";
    var contenido = "";
    var contador = 0;
    var idTipoArticuloAnterior = 0;
    $(item).find('xml').children('diaCierreLocal').each(function() {
        if (contador == 0) {
            contenido = contenido + "<ul>";
        }

        //Se obtienen los valores del xml
        fecha = $.trim($(this).find('fecha').text());
        idDiaCierreLocal = $.trim($(this).find('id_dia_cierre_local').text());

        //Se crea el enlace para poder borrar los platos del local
        enlaceBorrar = "<a onclick=\"doAjax('" + site_url
                + "/locales/borrarDiaCierreLocal','idDiaCierreLocal="
                + idDiaCierreLocal + "','listaDiasCierreLocal','post',1)\">B</a>";

        //Se genera el contenido de cada articulo
        contenido = contenido + "<li>";
        contenido = contenido + fecha + " - " + enlaceBorrar;
        contenido = contenido + "</li>";

        contador++;
    });
    if (contador > 0) {
        contenido = contenido + "</ul>";
    }

    //Se vacia la lista para rellenar con el contenido
    $("#listaDiasCierreLocal").empty();
    $("#listaDiasCierreLocal").html(contenido);
    
    //Se muestra el mensaje
    var mensaje = $.trim($(item).find('mensaje').text());
    mostrarMensaje(mensaje);

    //Se resetean todos los formularios
    resetFormularios();
}

$(document).ready(function() {
    $("#datepickerDiasCierre").datepicker();
    $("#datepickerDiasCierre").datepicker("option", "dateFormat", "yy-mm-dd");
});

