<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/servicios/servicioLocal.php';
require_once APPPATH . '/libraries/servicios/tipoServicio.php';
require_once APPPATH . '/libraries/constantes/Code.php';

class Servicios extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		//Se carga el modelo de ingredientes
		$this->load->model('servicios/Servicios_model');
	}

	function nuevoServicio_post() {
		//Se recogen los datos recibidos en formato json
		$datosServicio = $this->post();

		$tipoServicio = new TipoServicio($datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[TipoServicio::FIELD_TIPO_SERVICIO][TipoServicio::FIELD_ID_TIPO_SERVICIO],
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[TipoServicio::FIELD_TIPO_SERVICIO][TipoServicio::FIELD_SERVICIO],
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[TipoServicio::FIELD_TIPO_SERVICIO][TipoServicio::FIELD_ESTADO],
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[TipoServicio::FIELD_TIPO_SERVICIO][TipoServicio::FIELD_MOSTRAR_BUSCADOR]);

		$servicio = new ServicioLocal(
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[ServicioLocal::FIELD_ID_SERVICIO],
				$tipoServicio,
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[ServicioLocal::FIELD_ACTIVO]
				,$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[ServicioLocal::FIELD_IMPORTE_MINIMO],
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[ServicioLocal::FIELD_PRECIO]
		);

		$idLocal = $datosServicio[Code::FIELD_ID_LOCAL];

		$hayError = false;

		//Se comprueba si los precios son numericos
		if (is_numeric($servicio->importeMinimo) && is_numeric($servicio->precio)) {

			//Se compueba si existe el servicio para el local
			$existeServicio = $this->Servicios_model->existeServicioLocal
			($idLocal, $servicio->tipoServicio->idTipoServicio)->num_rows();

			if ($existeServicio == 0) {

				//Si se trata del servicio de envio de pedidos se comprueba si existe el servicio de pedidos
				if ($servicio->tipoServicio->idTipoServicio == '2') {

					$existeServicioPedidos = $this->Servicios_model->existeServicioLocal
					($idLocal, 1)->num_rows();

					if ($existeServicioPedidos > 0) {

						$idServicioLocal = $this->Servicios_model->insertarServicioLocal
						($idLocal, $servicio->tipoServicio->idTipoServicio);
						$servicioInsertado = true;

					} else {
						$msg = "Es necesario tener el servicio \"Pedidos\" para poder añadir el servicio \"Envio de pedidos\"";
						$hayError = true;
					}
				} else {
					$idServicioLocal = $this->Servicios_model->insertarServicioLocal
					($idLocal, $servicio->tipoServicio->idTipoServicio);
					$servicioInsertado = true;
				}


				//Si se ha insertado el servicio se comprueba si se ha pasado un importe minimo o un precio
				if ($servicioInsertado) {

					if ($servicio->importeMinimo > 0 || $servicio->precio > 0) {
						$this->Servicios_model->insertarPrecioServicioLocal
						($idServicioLocal
								, $servicio->importeMinimo
								, $servicio->precio);
					}

					$msg = "Servicio añadido correctamente";
					$servicio = $this->Servicios_model->obtenerServicioLocalObject($idServicioLocal);
				}
			} else {
				$msg = "El servicio ya existe";
				$hayError = true;
			}
		} else {
			$msg = "El valor del precio o del importe minimo no es correcto";
			$hayError = true;
		}

		if (!$hayError){

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					ServicioLocal::FIELD_SERVICIO_LOCAL => $servicio);
		}else{

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function modificarServicio_post() {
		//Se recogen los datos recibidos en formato json
		$datosServicio = $this->post();

		$tipoServicio = new TipoServicio($datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[TipoServicio::FIELD_TIPO_SERVICIO][TipoServicio::FIELD_ID_TIPO_SERVICIO],
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[TipoServicio::FIELD_TIPO_SERVICIO][TipoServicio::FIELD_SERVICIO],
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[TipoServicio::FIELD_TIPO_SERVICIO][TipoServicio::FIELD_ESTADO],
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[TipoServicio::FIELD_TIPO_SERVICIO][TipoServicio::FIELD_MOSTRAR_BUSCADOR]);

		$servicio = new ServicioLocal(
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[ServicioLocal::FIELD_ID_SERVICIO],
				$tipoServicio,
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[ServicioLocal::FIELD_ACTIVO]
				,$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[ServicioLocal::FIELD_IMPORTE_MINIMO],
				$datosServicio[ServicioLocal::FIELD_SERVICIO_LOCAL]
				[ServicioLocal::FIELD_PRECIO]
		);

		$idLocal = $datosServicio[Code::FIELD_ID_LOCAL];

		$hayError = false;

		//Se comprueba si los precios son numericos
		if (is_numeric($servicio->importeMinimo) && is_numeric($$servicio->precio)) {

			if ($servicio->importeMinimo >= 0 && $servicio->precio >= 0) {

				$this->Servicios_model->modificarPrecioServicioLocal
				($servicio->idServicio, $servicio->importeMinimo, $servicio->precio);

				$msg = "Servicio modificado correctamente";

			} else {

				$msg = "El valor del precio o del importe minimo no es correcto";
				$hayError = true;

			}
		} else {

			$msg = "El valor del precio o del importe minimo no es correcto";
			$hayError = true;
		}

		if (!$hayError){

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					ServicioLocal::FIELD_SERVICIO_LOCAL => $servicio);
		}else{

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function borrarServicio_get() {
		if (!$this->get(ServicioLocal::FIELD_ID_SERVICIO)) {
			$msg = "Error borrando servicio";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idServicio = $this->get(ServicioLocal::FIELD_ID_SERVICIO);

		$msg = "Servicio borrado correctamente";

		//Si el servicio que se borra es el de pedidos se borra tambien el envio
		$servicio = $this->Servicios_model->obtenerServicio($idServicio)->row();

		if ($servicio->id_tipo_servicio_local == '1') {
			$this->Servicios_model->borrarServicioLocalTipo(2, $servicio->id_local);    //Envio pedidos
		}

		$this->Servicios_model->borrarServicioLocal($idServicio);


		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function activarServicio_get() {
		if (!$this->get(ServicioLocal::FIELD_ID_SERVICIO)) {
			$msg = "Error activando servicio";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idServicio = $this->get(ServicioLocal::FIELD_ID_SERVICIO);

		//se obtiene el tipo de servicio
		$servicioLocal =
		$this->Servicios_model->obtenerServicio($idServicio)->row();

		$activarServicio = false;

		//Se carga el helper
		$this->load->helper('servicios');

		//Pedidos
		if ($servicioLocal->id_tipo_servicio_local == 1 ||
		$servicioLocal->id_tipo_servicio_local == 5) {
			if (comprobarServicioPedidos($servicioLocal->id_local)) {
				$activarServicio = true;
			} else {
				$msg = "Es necesario tener articulos para activar el sevicio";
			}
			//Pedido personalizados
		} else if ($servicioLocal->id_tipo_servicio_local == 2) {
			if (comprobarServicioPedidoPersonalizado($servicioLocal->id_local)) {
				$activarServicio = true;
			} else {
				$msg =
				"Es necesario tener ingredientes y tipos de articulo para activar el sevicio";
			}
			//Reservas
		} else if ($servicioLocal->id_tipo_servicio_local == 3) {
			if (comprobarServicioReservas($servicioLocal->id_local)) {
				$activarServicio = true;
			} else {
				$msg =
				"Es necesario tener mesas para activar el sevicio";
			}
		} else if ($servicioLocal->id_tipo_servicio_local == 4) {
			if (comprobarServicioMenu($servicioLocal->id_local)) {
				$activarServicio = true;
			} else {
				$msg =
				"Es necesario tener platos y menus para activar el sevicio";
			}
		}


		if ($activarServicio) {
			//Se activa el servicio
			$this->Servicios_model->modificarEstadoServicio($idServicio, 1);

			$msg = "Servicio activado correctamente";
				
			$servicio = $this->Servicios_model->obtenerServicioLocalObject($idServicio);
		}

		if ($activarServicio){

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					ServicioLocal::FIELD_SERVICIO_LOCAL => $servicio);
		}else{

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function desactivarServicio_get() {
		if (!$this->get(ServicioLocal::FIELD_ID_SERVICIO)) {
			$msg = "Error activando servicio";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idServicio = $this->get(ServicioLocal::FIELD_ID_SERVICIO);

		//Se activa el servicio
		$this->Servicios_model->modificarEstadoServicio($idServicio, 0);

		$msg = "Servicio desactivado correctamente";
		
		$servicio = $this->Servicios_model->obtenerServicioLocalObject($idServicio);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				ServicioLocal::FIELD_SERVICIO_LOCAL => $servicio);				

		$this->response($datosRespuesta, Code::CODE_OK);
	}

}