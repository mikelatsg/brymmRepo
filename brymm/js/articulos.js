/**
 * Use this ScriptDoc file to manage the documentation for the corresponding namespace in your JavaScript library.
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
    var contador = 0;
    var idTipoArticuloAnterior = 0;
    $(item).find('articuloLocal').each(function() {
        if (contador == 0) {
            contenido = contenido + "<ul>";
        }

        //Se obtienen los valores del xml
        articulo = $.trim($(this).find('articulo').text());
        descripcion = $.trim($(this).find('descripcion').text());
        precio = $.trim($(this).find('precio').text());
        idTipoArticulo = $.trim($(this).find('id_tipo_articulo').text());
        tipoArticulo = $.trim($(this).find('tipo_articulo').text());
        idArticuloLocal = $.trim($(this).find('id_articulo_local').text());
        validoPedidos = $.trim($(this).find('validoPedidos').text());

        if (idTipoArticulo != idTipoArticuloAnterior) {
            contenido = contenido + tipoArticulo;
        }

        idTipoArticuloAnterior = idTipoArticulo;

        //Se crea el enlace para poder modificar el articulo
        enlaceModificar = "<a href=\"javascript:llenarFormularioModificar('"
                + articulo + "','" + descripcion + "','" + precio + "','"
                + idArticuloLocal + "','" + idTipoArticulo + "','" + validoPedidos
                + "')\"> M </a>";

        //Se crea el enlace para poder borrar los platos del local
        enlaceBorrar = "<a onclick=\"doAjax('" + site_url
                + "/articulos/borrarArticulo','idArticuloLocal="
                + idArticuloLocal + "','listaArticulos','post',1)\">B</a>";

        //Se genera el contenido de cada articulo
        contenido = contenido + "<li>";
        contenido = contenido + articulo + " - " + descripcion + " - "
                + precio + " - " + enlaceModificar + " - " + enlaceBorrar;
        contenido = contenido + "</li>";
        if ($(this).find('ingredientes').children().length > 0) {
            contenido = contenido + "<ul>";
            $(this).find('ingredientes').each(function() {
                ingrediente = $.trim($(this).find('ingrediente').text());
                contenido = contenido + "<li>";
                contenido = contenido + ingrediente;
                contenido = contenido + "</li>";
            });
            contenido = contenido + "</ul>";
        }
        contador++;
    });
    if (contador > 0) {
        contenido = contenido + "</ul>";
    }

    //Se vacia la lista para rellenar con el contenido
    $("#listaArticulos").empty();
    $("#listaArticulos").html(contenido);

    //Se muestra el mensaje
    var mensaje = $.trim($(item).find('mensaje').text());
    mostrarMensaje(mensaje);
    
    resetFormularios();
}

function llenarFormularioModificar(articulo, descripcion, precio, idArticuloLocal
        , idTipoArticulo, validoPedidos) {
    //Se rellenan los campos del formulario.
    $("#modificarArticulo").find('input[name="articulo"]').val(articulo);
    $("#modificarArticulo").find('input[name="descripcion"]').val(descripcion);
    $("#modificarArticulo").find('input[name="precio"]').val(precio);
    $("#modificarArticulo").find('input[name="idArticuloLocal"]').val(idArticuloLocal);
    $("#modificarArticulo").find('select[name="tipoArticulo"]').val(idTipoArticulo);


    $("#modificarArticulo input:checkbox").attr('checked', false);

    //Se marca el check de valido para pedidos o no
    if (validoPedidos > 0) {
        $("#modificarArticulo").find('input:checkbox[name="validoPedidos"]').click();
    }

    doAjax(site_url + "/articulos/obtenerIngredientesArticulo", "idArticuloLocal="
            + idArticuloLocal, "checkIngredientes", 'post', 1)
}

function checkIngredientes(item) {
    var idIngrediente = "";
    $(item).find('xml').children('articuloLocal').each(function() {
        idIngrediente = $(this).find('id_ingrediente').text();
        $("#modificarArticulo").find("input:checkbox[name='ingrediente[]'][value=" + idIngrediente + "]").click();
    });
}

function llenarFormularioModificarIngrediente(ingrediente, descripcion, precio, idIngrediente) {
    //Se rellena los campos del formulario.
    $("#modificarIngrediente").find('input[name="ingrediente"]').val(ingrediente);
    $("#modificarIngrediente").find('input[name="descripcion"]').val(descripcion);
    $("#modificarIngrediente").find('input[name="precio"]').val(precio);
    $("#modificarIngrediente").find('input[name="idIngrediente"]').val(idIngrediente);
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
    $(item).find('xml').children('ingrediente').each(function() {
        if (contador == 0) {
            contenido = contenido + "<ul>";
        }

        //Se obtienen los valores del xml
        ingrediente = $.trim($(this).find('ingrediente').text());
        descripcion = $.trim($(this).find('descripcion').text());
        precio = $.trim($(this).find('precio').text());
        idIngrediente = $.trim($(this).find('id_ingrediente').text());


        //Se crea el enlace para poder modificar el articulo
        enlaceModificar = "<a href=\"javascript:llenarFormularioModificarIngrediente('"
                + ingrediente + "','" + descripcion + "','" + precio + "','"
                + idIngrediente + "')\"> M </a>";

        //Se crea el enlace para poder borrar los platos del local
        enlaceBorrar = "<a onclick=\"doAjax('" + site_url
                + "/ingredientes/borrarIngrediente','idIngrediente="
                + idIngrediente + "','listaIngredientes','post',1)\">B</a>";

        //Se genera el contenido de cada articulo
        contenido = contenido + "<li>";
        contenido = contenido + ingrediente + " - " + descripcion + " - "
                + precio + " - " + enlaceModificar + " - " + enlaceBorrar;
        contenido = contenido + "</li>";

        //Checkbox de los formularios
        contenidoIngredientes = contenidoIngredientes + "<tr class=\"listaIngredientesArticulo\">";
        contenidoIngredientes = contenidoIngredientes + "<td></td><td>";
        contenidoIngredientes = contenidoIngredientes + "<input type = \"checkbox\" ";
        contenidoIngredientes = contenidoIngredientes + "name = \"ingrediente[]\" ";
        contenidoIngredientes = contenidoIngredientes + "value = \"" + idIngrediente + "\" / >";
        contenidoIngredientes = contenidoIngredientes + ingrediente;
        contenidoIngredientes = contenidoIngredientes + "</td></tr>";

        contador++;
    });
    if (contador > 0) {
        contenido = contenido + "</ul>";
    }
    //Se modifican los formularios de articulos
    listaIngredientesArticulo(contenidoIngredientes);

    //Se vacia la lista para rellenar con el contenido
    $("#listaIngredientes").empty();
    $("#listaIngredientes").html(contenido);

    //Se muestra el mensaje
    var mensaje = $.trim($(item).find('mensaje').text());
    mostrarMensaje(mensaje);

    //Se resetean todos los formularios
    resetFormularios();
}

function listaIngredientesArticulo(contenidoIngredientes) {
    //Se vacia la lista para rellenar con el contenido    
    $(".listaIngredientesArticulo").remove();
    $("#tituloIngredientesArticulo").after(contenidoIngredientes);
    //Formulario modificar
    $("#tituloIngredientesArticuloMod").after(contenidoIngredientes);
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
    //Se desactiva el boton para añadir articulos por si acaso no hay tipos de articulo
    $("#formAltaArticulo").find('input[type="button"]').attr("disabled", "enabled");
    $(item).find('xml').children('tipoArticuloLocal').each(function() {
        if (contador == 0) {
            //Se activa el boton para añadir articulos
            $("#formAltaArticulo").find('input[type="button"]').removeAttr('disabled');
            contenido = contenido + "<ul>";
        }

        //Se obtienen los valores del xml
        tipoArticulo = $.trim($(this).find('tipo_articulo').text());
        personalizar = $.trim($(this).find('personalizar').text());
        precio = $.trim($(this).find('precio').text());
        idTipoArticuloLocal = $.trim($(this).find('id_tipo_articulo_local').text());
        idTipoArticulo = $.trim($(this).find('id_tipo_articulo').text());

        //Se crea el enlace para poder borrar los platos del local
        enlaceBorrar = "<a onclick=\"doAjax('" + site_url
                + "/articulos/borrarTipoArticuloLocal','idTipoArticuloLocal="
                + idTipoArticuloLocal + "','listaTiposArticulo','post',1)\">B</a>";

        //Se crea el enlace para poder modificar el articulo
        enlaceModificar = "<a href=\"javascript:llenarFormularioModificarTipoArticulo('"
                + idTipoArticuloLocal + "','" + idTipoArticulo + "','" + personalizar + "','"
                + precio + "')\"> M </a>";

        //Se genera el contenido de cada articulo
        contenido = contenido + "<li>";
        contenido = contenido + tipoArticulo + " - " + personalizar + " - "
                + precio + " - " + enlaceBorrar + enlaceModificar;
        contenido = contenido + "</li>";

        //Se genera el contenido de los formularios de los articulos
        contenidoTiposArticulo = contenidoTiposArticulo + "<option value=";
        contenidoTiposArticulo = contenidoTiposArticulo + "\"" + idTipoArticulo + "\"";
        contenidoTiposArticulo = contenidoTiposArticulo + ">" + tipoArticulo + "</option>";

        contador++;
    });
    if (contador > 0) {
        contenido = contenido + "</ul>";
    }
    //Se modifican los formularios de articulos
    listaTiposArticuloArticulo(contenidoTiposArticulo)

    //Se vacia la lista para rellenar con el contenido
    $("#listaTipoArticulos").empty();
    $("#listaTipoArticulos").html(contenido);

    //Se muestra el mensaje
    var mensaje = $.trim($(item).find('mensaje').text());
    mostrarMensaje(mensaje);

    //Se resetean todos los formularios
    resetFormularios();
}

function listaTiposArticuloArticulo(contenidoTiposArticulo) {
    //Se vacia la lista para rellenar con el contenido    
    $("#listaTiposArticulosArticulo").empty();
    $("#listaTiposArticulosArticulo").append(contenidoTiposArticulo);
    //Formulario modificar
    $("#listaTiposArticulosArticuloMod").empty();
    $("#listaTiposArticulosArticuloMod").append(contenidoTiposArticulo);
}

function llenarFormularioModificarTipoArticulo(idTipoArticuloLocal, idTipoArticulo
        , personalizar, precioBase) {
    //Se rellena los campos del formulario.
    $("#formModificarTipoArticulo").
            find('input[name="idTipoArticuloLocal"]').val(idTipoArticuloLocal);
    $("#formModificarTipoArticulo").
            find('select[name="tipoArticulo"]').val(idTipoArticulo);
    $("#formModificarTipoArticulo").
            find('input[name="precioBase"]').val(precioBase);
    $("#formModificarTipoArticulo").
            find('select[name="personalizar"]').val(personalizar);
}

$(document).ready(function() {


})

