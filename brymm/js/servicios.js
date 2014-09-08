/**
 * Use this ScriptDoc file to manage the documentation for the corresponding namespace in your JavaScript library.
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
    $(item).find('servicioLocal').each(function() {
        if (contador == 0) {
            contenido = contenido + "<ul>";
        }

        //Se obtienen los valores del xml
        servicio = $.trim($(this).find('servicio').text());
        importeMinimo = $.trim($(this).find('importe_minimo').text());
        precio = $.trim($(this).find('precio').text());
        idServicioLocal = $.trim($(this).find('id_servicio_local').text());
        idTipoServicioLocal = $.trim($(this).find('id_tipo_servicio_local').text());
        activo = $.trim($(this).find('activo').text());

        //Se crea el enlace para poder borrar los platos del local
        enlaceBorrar = "<a onclick=\"doAjax('" + site_url
                + "/servicios/borrarServicio','idServicioLocal="
                + idServicioLocal + "','listaServiciosLocal','post',1)\">B</a>";

        //Se crea el enlace para poder modificar el articulo
        enlaceModificar = "<a href=\"javascript:llenarFormularioModificarServicio('"
                + idTipoServicioLocal + "','" + importeMinimo + "','" + precio + "','"
                + idServicioLocal + "')\"> M </a>";

        if (activo == 1) {
            //Se crea el enlace para poder desactivar el servicio
            enlaceActivarDesactivar = "<a onclick=\"doAjax('" + site_url
                    + "/servicios/desactivarServicio','idServicioLocal="
                    + idServicioLocal + "','listaServiciosLocal','post',1)\">"
                    + " Desactivar </a>";
        } else {
            //Se crea el enlace para poder activar el servicio
            enlaceActivarDesactivar = "<a onclick=\"doAjax('" + site_url
                    + "/servicios/activarServicio','idServicioLocal="
                    + idServicioLocal + "','listaServiciosLocal','post',1)\">"
                    + " Activar </a>";
        }

        //Se genera el contenido de cada articulo
        contenido = contenido + "<li>";
        contenido = contenido + servicio + " - " + importeMinimo + " - "
                + precio + " - " + enlaceBorrar + enlaceModificar
                + enlaceActivarDesactivar;
        contenido = contenido + "</li>";

        contador++;
    });
    if (contador > 0) {
        contenido = contenido + "</ul>";
    }

    //Se vacia la lista para rellenar con el contenido
    $("#listaServicioLocal").empty();
    $("#listaServicioLocal").html(contenido);
    
    //Se muestra el mensaje
    var mensaje = $.trim($(item).find('mensaje').text());
    mostrarMensaje(mensaje);

    //Se resetean todos los formularios
    resetFormularios();
}

function llenarFormularioModificarServicio(idTipoServicioLocal, importeMinimo
        , precio, idServicioLocal) {
    //Se rellenan los campos del formulario.
    $("#formModificarServicioLocal").find('select[name="idTipoServicioLocal"]').val(idTipoServicioLocal);
    $("#formModificarServicioLocal").find('input[name="importeMinimo"]').val(importeMinimo);
    $("#formModificarServicioLocal").find('input[name="precio"]').val(precio);
    $("#formModificarServicioLocal").find('input[name="idServicioLocal"]').val(idServicioLocal);
}


