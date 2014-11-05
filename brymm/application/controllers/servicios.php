<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Servicios extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		//Se carga el modelo de usuarios
		$this->load->model('servicios/Servicios_model');
		//Se carga el modelo de sessiones
		$this->load->model('sesiones/Sesiones_model');
	}

	public function gestionServicios() {
		//Se obtienen todos los servicios
		$var['servicios'] = $this->Servicios_model->obtenerServicios()->result();

		//Se obtienen los servicios del local
		$var['serviciosLocal'] = $this->Servicios_model->obtenerServiciosLocal($_SESSION['idLocal'])->result();

		$header['javascript'] = array('miajaxlib', 'jquery/jquery'
				, 'jquery/jquery-ui-1.10.3.custom', 'jquery/jquery-ui-1.10.3.custom.min'
				, 'servicios', 'mensajes' , 'js/bootstrap.min');
		
		$header['estilos'] = array('bootstrap-3.2.0-dist/css/bootstrap.min.css','buscador.css');

		$this->load->view('base/cabecera', $header);
		$this->load->view('base/page_top');
		$this->load->view('servicios/gestionServicios', $var);
		$this->load->view('base/page_bottom');
	}

	public function anadirServicioLocal() {

		//Se recogen los datos del formulario
		$idTipoServicioLocal = $_POST['idTipoServicioLocal'];

		$servicioInsertado = false;

		//Se comprueba si los precios son numericos
		if (is_numeric($_POST['importeMinimo']) && is_numeric($_POST['precio'])) {

			//Se compueba si existe el servicio para el local
			$existeServicio = $this->Servicios_model->existeServicioLocal
			($_SESSION['idLocal'], $idTipoServicioLocal)->num_rows();
			if ($existeServicio == 0) {
				//Si se trata del servicio de envio de pedidos se comprueba si existe el servicio de pedidos
				if ($idTipoServicioLocal == '2') {
					$existeServicioPedidos = $this->Servicios_model->existeServicioLocal
					($_SESSION['idLocal'], 1)->num_rows();
					if ($existeServicioPedidos > 0) {
						$idServicioLocal = $this->Servicios_model->insertarServicioLocal
						($_SESSION['idLocal'], $idTipoServicioLocal);
						$servicioInsertado = true;
					} else {
						$mensaje = "Es necesario tener el servicio \"Pedidos\" para poder añadir el servicio \"Envio de pedidos\"";
					}
				} else {
					$idServicioLocal = $this->Servicios_model->insertarServicioLocal
					($_SESSION['idLocal'], $idTipoServicioLocal);
					$servicioInsertado = true;
				}


				//Si se ha insertado el servicio se comprueba si se ha pasado un importe minimo o un precio
				if ($servicioInsertado) {
					if ($_POST['importeMinimo'] > 0 || $_POST['precio'] > 0) {
						$this->Servicios_model->insertarPrecioServicioLocal
						($idServicioLocal, $_POST['importeMinimo'], $_POST['precio']);
					}
					$mensaje = "Servicio añadido correctamente";					
				}
			} else {
				$mensaje = "El servicio ya existe";
			}
		} else {
			$mensaje = "El valor del precio o del importe minimo no es correcto";
		}

		$this->listaServiciosLocal($mensaje);
	}

	public function modificarServicioLocal() {
		//Se recogen los datos del formulario
		$idServicioLocal = $_POST['idServicioLocal'];

		//Se comprueba si los precios son numericos
		if (is_numeric($_POST['importeMinimo']) && is_numeric($_POST['precio'])) {

			if ($_POST['importeMinimo'] >= 0 && $_POST['precio'] >= 0) {
				$this->Servicios_model->modificarPrecioServicioLocal
				($idServicioLocal, $_POST['importeMinimo'], $_POST['precio']);

				$mensaje = "Servicio modificado correctamente";
			} else {

				$mensaje = "El valor del precio o del importe minimo no es correcto";
			}
		} else {
			$mensaje = "El valor del precio o del importe minimo no es correcto";
		}

		$this->listaServiciosLocal($mensaje);
	}

	public function borrarServicio() {
		//Se recogen los datos del formulario
		$idServicioLocal = $_POST['idServicioLocal'];

		//Si el servicio que se borra es el de pedidos se borra tambien el envio
		$servicio = $this->Servicios_model->obtenerServicio($idServicioLocal)->row();

		if ($servicio->id_tipo_servicio_local == '1') {
			$this->Servicios_model->borrarServicioLocalTipo(2, $_SESSION['idLocal']);    //Envio pedidos
		}

		$this->Servicios_model->borrarServicioLocal($idServicioLocal);

		$mensaje = "Servicio borrado correctamente";

		$this->listaServiciosLocal($mensaje);
	}

	private function listaServiciosLocal($mensaje = '') {

		//Se obtienen los servicios del local
		$serviciosLocal = $this->Servicios_model->obtenerServiciosLocal($_SESSION['idLocal'])->result();

		$params = array('etiqueta' => 'servicioLocal', 'mensaje' => $mensaje);
		$this->load->library('objectandxml', $params);
		$var['xml'] = $this->objectandxml->objToXML($serviciosLocal);

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function desactivarServicio() {

		//Se activa el servicio
		$this->Servicios_model->modificarEstadoServicio($_POST['idServicioLocal'], 0);

		$mensaje = "Servicio desactivado correctamente";


		$this->listaServiciosLocal($mensaje);
	}

	public function activarServicio() {
		//se obtiene el tipo de servicio
		$servicioLocal =
		$this->Servicios_model->obtenerServicio($_POST['idServicioLocal'])->row();

		$activarServicio = false;

		//Se carga el helper
		$this->load->helper('servicios');
		
		//Pedidos
		if ($servicioLocal->id_tipo_servicio_local == 1 ||
		$servicioLocal->id_tipo_servicio_local == 5) {
			if (comprobarServicioPedidos($_SESSION['idLocal'])) {
				$activarServicio = true;
			} else {
				$mensaje = "Es necesario tener articulos para activar el sevicio";
			}
			//Pedido personalizados
		} else if ($servicioLocal->id_tipo_servicio_local == 2) {
			if (comprobarServicioPedidoPersonalizado($_SESSION['idLocal'])) {
				$activarServicio = true;
			} else {
				$mensaje =
				"Es necesario tener ingredientes y tipos de articulo para activar el sevicio";
			}
			//Reservas
		} else if ($servicioLocal->id_tipo_servicio_local == 3) {
			if (comprobarServicioReservas($_SESSION['idLocal'])) {
				$activarServicio = true;
			} else {
				$mensaje =
				"Es necesario tener mesas para activar el sevicio";
			}
		} else if ($servicioLocal->id_tipo_servicio_local == 4) {
			if (comprobarServicioMenu($_SESSION['idLocal'])) {
				$activarServicio = true;
			} else {
				$mensaje =
				"Es necesario tener platos y menus para activar el sevicio";
			}
		}


		if ($activarServicio) {
			//Se activa el servicio
			$this->Servicios_model->modificarEstadoServicio($servicioLocal->id_servicio_local, 1);

			$mensaje = "Servicio activado correctamente";
		}

		$this->listaServiciosLocal($mensaje);
	}	

}

