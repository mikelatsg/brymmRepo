function createREQ() {
    try {
        req = new XMLHttpRequest(); /* p.e. Firefox */
    } catch (err1) {
        try {
            req = new ActiveXObject('Msxml2.XMLHTTP'); /* algunas versiones IE */
        } catch (err2) {
            try {
                req = new ActiveXObject("Microsoft.XMLHTTP"); /* algunas versiones IE */
            } catch (err3) {
                req = false;
            }
        }
    }
    return req;
}
function requestGET(url, query, req) {
    //alert(query);
    myRand = parseInt(Math.random() * 99999999);
    req.open("GET", url + '?' + 'query' + '&rand=' + myRand, true);
    req.send(null);
}
function requestPOST(url, query, req) {
    //alert(query);
    req.open("POST", url, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(query);
}
function doCallback(callback, item) {
    //alert(callback);
    eval(callback + '( item )');
}

function doAjax(url, query, callback, reqtype, getxml) {
    // crea la instancia del objeto XMLHTTPRequest 
    //alert('doAjax');
    //alert(url);
    //alert(query);
    //alert(callback);
    var myreq = createREQ();
    myreq.onreadystatechange = function() {
        if (myreq.readyState == 4) {
            //alert(myreq.status);
            if (myreq.status == 200) {
                var item = myreq.responseText;
                if (getxml == 1) {
                    item = myreq.responseXML;
                }
                doCallback(callback, item);
            }
        }
    }
    if (reqtype == 'post') {
        requestPOST(url, query, myreq);
    }
    else {
        requestGET(url, query, myreq);
    }
}

/*function enviarFormulario(url, formid,callback,getxml){
 
 var formulario = document.getElementById(formid);
 var cadenaFormulario = "";
 var sepCampos;
 sepCampos = "";
 for (var i = 0; i <= formulario.elements.length - 1; i++) {
 if (formulario.elements[i].type == "checkbox"){
 if (formulario.elements[i].checked ){
 cadenaFormulario += sepCampos + formulario.elements[i].name + '=' + encodeURI(formulario.elements[i].value);
 }
 }else{
 cadenaFormulario += sepCampos + formulario.elements[i].name + '=' + encodeURI(formulario.elements[i].value);
 }
 
 sepCampos = "&";
 }
 doAjax(url,cadenaFormulario,callback,'post',getxml);
 
 }*/

function enviarFormulario(url, formid, callback, getxml) {

    var formulario = document.getElementById(formid);
    var cadenaFormulario = "";
    var sepCampos;
    sepCampos = "";
    for (var i = 0; i <= formulario.elements.length - 1; i++) {
        if (formulario.elements[i].type == "checkbox") {
            if (formulario.elements[i].checked) {
                cadenaFormulario += sepCampos + formulario.elements[i].name + '=' + encodeURI(formulario.elements[i].value);
            }
        } else if (formulario.elements[i].type == "radio") {
            if (formulario.elements[i].checked) {
                cadenaFormulario += sepCampos + formulario.elements[i].name + '=' + encodeURI(formulario.elements[i].value);
            }
        }
        else {
            cadenaFormulario += sepCampos + formulario.elements[i].name + '=' + encodeURI(formulario.elements[i].value);
        }

        sepCampos = "&";
    }
    doAjax(url, cadenaFormulario, callback, 'post', getxml);

}


function enviarArticuloPedido(url, query, inputid, callback, getxml) {
    var cantidad = $("#" + inputid).get(0).value;
    var sepCampos;
    sepCampos = "&";
    query = query + sepCampos + "cantidad=" + cantidad;
    doAjax(url, query, callback, 'post', getxml);

}

