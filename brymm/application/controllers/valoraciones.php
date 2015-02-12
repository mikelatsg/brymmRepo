<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


require_once APPPATH . '/libraries/usuario/usuario.php';
require_once APPPATH . '/libraries/usuario/valoracion.php';
require_once APPPATH . '/libraries/local/local.php';
require_once APPPATH . '/libraries/local/tipoComida.php';

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

	public function anadirValoracionUsuario() {

		$this->Valoraciones_model->insertarValoracionUsuario( $_SESSION['idLocal'],$_POST['idUsuario']
				, $_POST['nota']
				, $_POST['observaciones']);

		$mensaje = 'Valoración añadida correctamente';

		$this->listaValoracionesUsuario($_POST['idUsuario'], $mensaje);
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

	private function listaValoracionesUsuario($idUsuario, $mensaje = '') {
		//Se obtienen las valoraciones
		$valoraciones =
		$this->Valoraciones_model->obtenerValoracionesUsuario($idUsuario);
		
		//Se genera el json		
		echo json_encode($valoraciones);		

	}

}

