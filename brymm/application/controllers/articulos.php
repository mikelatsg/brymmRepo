<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Articulos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('encrypt');
        //Se carga el modelo de articulos
        $this->load->model('articulos/Articulos_model');
        //Se carga el modelo de sessiones
        $this->load->model('sesiones/Sesiones_model');
    }

    public function gestionArticulos() {

        //Se obtienen los articulos del local
        $var['articulosLocal'] = $this->Articulos_model->obtenerArticulosLocal($_SESSION['idLocal']);

        //Se obtienen los tipos de articulo del local
        $var['tiposArticuloLocal'] = $this->Articulos_model->obtenerTiposArticuloLocal($_SESSION['idLocal'])->result();

        //Se obtienen los tipos de articulo
        $var2['tiposArticulo'] = $this->Articulos_model->obtenerTiposArticulo()->result();

        //Se carga el modelo de ingredientes
        $this->load->model('ingredientes/Ingredientes_model');

        //Se obtienen los ingredientes del local
        $var['ingredientes'] = $this->Ingredientes_model->obtenerIngredientes($_SESSION['idLocal'])->result();

        $header['javascript'] = array('miajaxlib', '/jquery/jquery'
            , 'jquery/jquery-ui-1.10.3.custom', 'jquery/jquery-ui-1.10.3.custom.min'
            , 'articulos' , 'mensajes','js/bootstrap.min');
        
        $header['estilos'] = array('bootstrap-3.2.0-dist/css/bootstrap.min.css','buscador.css');

        $msg = "";

        //Se carga el siguiente paso del alta
        $this->load->view('base/cabecera', $header);
        $this->load->view('base/page_top', $msg);
        $this->load->view('articulos/gestionArticulos', $var);
        $this->load->view('articulos/gestionTiposArticulos', $var2);
        $this->load->view('base/page_bottom');
    }

    public function anadirArticulo() {

        $msg = "Articulo añadido correctamente";

        if (!$_POST['articulo'] == "") {

            if (is_numeric($_POST['precio']) && $_POST['precio'] >= 0) {

                $this->Articulos_model->insertArticuloLocal($_POST, $_SESSION['idLocal']);
            } else {
                $msg = "El valor del precio es incorrecto";
            }
        } else {
            $msg = "Hay que indicar un nombre para el articulo";
        }

        $this->listaArticulos($msg);
    }

    public function modificarArticulo() {

        $msg = "Articulo modificado correctamente";

        if (!$_POST['articulo'] == "") {

            if (is_numeric($_POST['precio']) && $_POST['precio'] >= 0) {

                $this->Articulos_model->modificarArticuloLocal($_POST);
            } else {
                $msg = "El valor del precio es incorrecto";
            }
        } else {
            $msg = "Hay que indicar un nombre para el articulo";
        }

        $this->listaArticulos($msg);
    }

    public function borrarArticulo() {
        //Se carga el modelo de pedidos
        $this->load->model('pedidos/Pedidos_model');

        /*
         * Se comprueba si el articulo está siendo utilizado en algun pedido 
         * pendiente o aceptado
         */
        $mensaje = "El articulo esta siendo utilizado en pedidos activos";

        $existeArticuloPedidoPendiente = $this->Pedidos_model->obtenerPedidosArticuloEstado
                        ($_SESSION['idLocal'], $_POST['idArticuloLocal'], 'P')->num_rows();

        if (!$existeArticuloPedidoPendiente) {
            $existeArticuloPedidoAceptado = $this->Pedidos_model->obtenerPedidosArticuloEstado
                            ($_SESSION['idLocal'], $_POST['idArticuloLocal'], 'A')->num_rows();
            if (!$existeArticuloPedidoAceptado) {
                $this->Articulos_model->borrarArticuloLocal($_POST['idArticuloLocal']);

                $mensaje = "Articulo borrado correctamente";
            }
        }

        $this->listaArticulos($mensaje);
    }

    private function listaArticulos($mensaje = '') {

        //Se obtienen los articulos del local
        $articulosLocal = $this->Articulos_model->obtenerArticulosLocal($_SESSION['idLocal']);

        $articulosLocal ['mensaje'] = $mensaje;

        $params = array('etiqueta' => 'articuloLocal');
        $this->load->library('arraytoxml', $params);

        $var['xml'] = $this->arraytoxml->convertArrayToXml($articulosLocal, 'xml');

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    public function obtenerIngredientesArticulo() {

        $ingredientesArticulo = $this->Articulos_model->obtenerIngedientesArticulo($_POST['idArticuloLocal'])->result();

        $params = array('etiqueta' => 'articuloLocal');
        $this->load->library('objectandxml', $params);
        $var['xml'] = $this->objectandxml->objToXML($ingredientesArticulo);
        
        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
        
        //Se carga la vista que genera el xml
        /*$this->load->view('xml/cabecera');
        $this->load->view('articulos/xml/ingredientesArticulo', $var);
        $this->load->view('xml/final');*/
    }

    public function anadirTipoArticulo() {

        $msg = "Tipo de articulo añadido correctamente";

        //Se comprueba si el local tiene el tipo articulo
        $existe = $this->Articulos_model->comprobarTipoArticuloLocal($_POST['tipoArticulo'], $_SESSION['idLocal'])->num_rows();

        if (!$existe) {
            if (is_numeric($_POST['precioBase']) && $_POST['precioBase'] >= 0) {
                $this->Articulos_model->insertTipoArticuloLocal
                        ($_POST['tipoArticulo'], $_SESSION['idLocal']
                        , $_POST['personalizar'], $_POST['precioBase']);
            } else {
                $msg = "El valor del precio no es correcto";
            }
        } else {
            $msg = "Ya existe el tipo de articulo";
        }

        $this->listaTiposArticulos($msg);
    }

    public function modificarTipoArticulo() {

        $msg = "Tipo de articulo modificado correctamente";

        if (is_numeric($_POST['precioBase']) && $_POST['precioBase'] >= 0) {
            $this->Articulos_model->modificarTipoArticuloLocal
                    ($_POST['idTipoArticuloLocal']
                    , $_POST['personalizar'], $_POST['precioBase']);
        } else {
            $msg = "El valor del precio no es correcto";
        }


        $this->listaTiposArticulos($msg);
    }

    public function borrarTipoArticuloLocal() {
        /*
         * Se comprueba si hay algun articulo para el tipo articulo, de haberlo
         * no se borra
         */
        $idTipoArticulo =
                $this->Articulos_model->obtenerTipoArticuloLocal
                        ($_POST['idTipoArticuloLocal'])->row()->id_tipo_articulo;

        $hayArticulo =
                $this->Articulos_model->comprobarHayArticuloTipoArticulo
                        ($_SESSION['idLocal'], $idTipoArticulo)->num_rows();

        if ($hayArticulo) {
            $mensaje = 'No se puede borrar el tipo de articulo, existen '
                    . 'articulos asociados al mismo';
        } else {
            $this->Articulos_model->borrarTipoArticuloLocal($_POST['idTipoArticuloLocal']);
            $mensaje = 'Tipo de articulo borrado correctamente';
        }

        $this->listaTiposArticulos($mensaje);
    }

    private function listaTiposArticulos($mensaje = '') {

        //Se obtienen los articulos del local
        $tiposArticuloLocal = $this->Articulos_model->obtenerTiposArticuloLocal($_SESSION['idLocal'])->result();

        $params = array('etiqueta' => 'tipoArticuloLocal', 'mensaje' => $mensaje);
        $this->load->library('objectandxml', $params);
        $var['xml'] = $this->objectandxml->objToXML($tiposArticuloLocal);

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

}
