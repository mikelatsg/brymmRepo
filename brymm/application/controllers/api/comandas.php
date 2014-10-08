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
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/comandas/platoComanda.php';
require_once APPPATH . '/libraries/comandas/detalleComanda.php';
require_once APPPATH . '/libraries/articulos/articuloCantidad.php';
require_once APPPATH . '/libraries/comandas/tipoComanda.php';
require_once APPPATH . '/libraries/comandas/menuComanda.php';
require_once APPPATH . '/libraries/menus/menu.php';
require_once APPPATH . '/libraries/menus/plato.php';
require_once APPPATH . '/libraries/reservas/mesa.php';
require_once APPPATH . '/libraries/menus/tipoPlato.php';
require_once APPPATH . '/libraries/comandas/comanda.php';
require_once APPPATH . '/libraries/comandas/camarero.php';
require_once APPPATH . '/libraries/constantes/Code.php';

class Comandas extends REST_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		//Se carga el modelo de articulos
		$this->load->model('comandas/Comandas_model');
	}

	function terminarPlatoComanda_post() {

		//Se recogen los datos recibidos en formato json
		$datosComanda = $this->post();

		if (!isset($datosComanda[PlatoComanda::FIELD_ID_COMANDA_MENU]) ) {
			$msg = "Error terminando plato";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los parametros enviados
		$idComandaMenu = $datosComanda[PlatoComanda::FIELD_ID_COMANDA_MENU];
		$idLocal = $datosComanda[Code::FIELD_ID_LOCAL];

		//Se borra el plato del local
		$this->Comandas_model->cambiarEstadoPlatoMenu($idComandaMenu, 'TC');

		$idComanda = $this->Comandas_model->obtenerIdComanda($idComandaMenu);

		$comanda = Comanda::withID($idComanda);

		$msg = "Plato terminado correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				Comanda::FIELD_COMANDA => $comanda
		);

		$this->response($datosRespuesta, Code::CODE_OK);

	}	

	function terminarComandaCocina_post() {

		//Se recogen los datos recibidos en formato json
		$datosComanda = $this->post();

		if (!isset($datosComanda[Comanda::FIELD_ID_COMANDA]) ) {
			$msg = "Error terminando plato";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los parametros enviados
		$idComanda = $datosComanda[Comanda::FIELD_ID_COMANDA];
		$idLocal = $datosComanda[Code::FIELD_ID_LOCAL];

		//Se cambia el estado el estado de la comanda a terminado cocina.
		$this->Comandas_model->cambiarEstadoComanda($idComanda, 'TC');

		$comanda = Comanda::withID($idComanda);	
		
		$msg = "Comanda terminada correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				Comanda::FIELD_COMANDA => $comanda
		);

		$this->response($datosRespuesta, Code::CODE_OK);

	}

	function cancelarComanda_post() {

		//Se recogen los datos recibidos en formato json
		$datosComanda = $this->post();

		if (!isset($datosComanda[Comanda::FIELD_ID_COMANDA]) ) {
			$msg = "Error terminando plato";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los parametros enviados
		$idComanda = $datosComanda[Comanda::FIELD_ID_COMANDA];
		$idLocal = $datosComanda[Code::FIELD_ID_LOCAL];

		//Se cambia el estado el estado de la comanda a terminado cocina.
		$this->Comandas_model->cambiarEstadoComanda($idComanda, 'CW');

		$comanda = Comanda::withID($idComanda);

		$msg = "Comanda cancelada correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				Comanda::FIELD_COMANDA => $comanda
		);

		$this->response($datosRespuesta, Code::CODE_OK);

	}

	function cerrarComandaCamarero_post() {

		//Se recogen los datos recibidos en formato json
		$datosComanda = $this->post();

		if (!isset($datosComanda[Comanda::FIELD_ID_COMANDA]) ) {
			$msg = "Error cerrando comanda";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los parametros enviados
		$idComanda = $datosComanda[Comanda::FIELD_ID_COMANDA];
		$idLocal = $datosComanda[Code::FIELD_ID_LOCAL];

		//Se cambia el estado el estado de la comanda a terminado cocina.
		$this->Comandas_model->cambiarEstadoComanda($idComanda, 'CC');

		$comanda = Comanda::withID($idComanda);

		$msg = "Comanda cerrada correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				Comanda::FIELD_COMANDA => $comanda
		);

		$this->response($datosRespuesta, Code::CODE_OK);

	}

	function terminarDetalleComanda_post() {

		//Se recogen los datos recibidos en formato json
		$datosComanda = $this->post();

		if (!isset($datosComanda[DetalleComanda::FIELD_ID_DETALLE_COMANDA]) ) {
			$msg = "Error terminando detalle comanda";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los parametros enviados
		$idDetalleComanda = $datosComanda[DetalleComanda::FIELD_ID_DETALLE_COMANDA];
		$idLocal = $datosComanda[Code::FIELD_ID_LOCAL];

		//Se cambia el estado el estado de la comanda a terminado cocina.
		$this->Comandas_model->cambiarEstadoDetalleComanda($idDetalleComanda, 'TC');

		$idComanda =
		$this->Comandas_model->obtenerDetalleComanda($idDetalleComanda)->row()->id_comanda;

		$comanda = Comanda::withID($idComanda);

		$msg = "Detalle terminado correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				Comanda::FIELD_COMANDA => $comanda
		);

		$this->response($datosRespuesta, Code::CODE_OK);

	}
}