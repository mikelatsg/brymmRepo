<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Valoraciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
        //Se carga el modelo de valoraciones
        $this->load->model('valoraciones/Valoraciones_model');
        //Se carga el modelo de sessiones
        $this->load->model('sesiones/Sesiones_model');
        //Se carga la libreria cart
        $this->load->library('my_cart');
    }

    public function anadirValoracionLocal() {

        $this->Valoraciones_model->insertarValoracionLocal($_POST['idLocal'], $_SESSION['idUsuario']
                , $_POST['nota']
                , $_POST['observaciones']);

        $mensaje = 'Valoración añadida correctamente';

        $this->listaValoraciones($_POST['idLocal'], $mensaje);
    }

    private function listaValoraciones($idLocal, $mensaje = '') {
        //Se obtienen las valoraciones
        $datosValoraciones =
                $this->Valoraciones_model->obtenerValoracionLocal($idLocal)->result();

        $params = array('etiqueta' => 'valoracionLocal', 'mensaje' => $mensaje);
        $this->load->library('objectandxml', $params);
        $var['xml'] = $this->objectandxml->objToXML($datosValoraciones);

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

}

