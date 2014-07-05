<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ingredientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
        //Se carga el modelo de usuarios
        $this->load->model('ingredientes/Ingredientes_model');
        //Se carga el modelo de sessiones
        $this->load->model('sesiones/Sesiones_model');
    }

    public function anadirIngrediente() {
        $msg = "Ingrediente añadido correctamente";

        if (!$_POST['ingrediente'] == "") {

            if (is_numeric($_POST['precio']) && $_POST['precio'] >= 0) {
                $this->Ingredientes_model->insertIngrediente($_POST, $_SESSION['idLocal']);
            } else {
                $msg = "El valor del precio es incorrecto";
            }
        } else {
            $msg = "Hay que indicar un nombre para el ingrediente";
        }
        $this->listaIngredientes($msg);
    }

    public function modificarIngrediente() {

        $msg = "Ingrediente modificado correctamente";

        if (!$_POST['ingrediente'] == "") {

            if (is_numeric($_POST['precio']) && $_POST['precio'] >= 0) {
                $this->Ingredientes_model->modificarIngrediente($_POST);
            } else {
                $msg = "El valor del precio es incorrecto";
            }
        } else {
            $msg = "Hay que indicar un nombre para el ingrediente";
        }

        $this->listaIngredientes($msg);
    }

    public function borrarIngrediente() {
        //Se carga el modelo de usuarios
        $this->load->model('articulos/Articulos_model');

        //Se comprueba si existe el ingrediente en algun articulo
        $hayIngredienteArticulo = $this->Articulos_model->obtenerArticulosIngrediente($_POST['idIngrediente'])->num_rows();

        if ($hayIngredienteArticulo == 0) {
            $this->Ingredientes_model->borrarIngrediente($_POST['idIngrediente']);
            $msg = "Ingrediente borrado correctamente";
        } else {
            $msg = "No se puede borrar el ingrediente, existe en algún articulo";
        }

        $this->listaIngredientes($msg);
    }

    private function listaIngredientes($mensaje = '') {
        //Se obtienen los articulos del local
        $ingredientes = $this->Ingredientes_model->obtenerIngredientes($_SESSION['idLocal'])->result();

        $params = array('etiqueta' => 'ingrediente', 'mensaje' => $mensaje);
        $this->load->library('objectandxml', $params);

        $var['xml'] = $this->objectandxml->objToXML($ingredientes);

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

}

