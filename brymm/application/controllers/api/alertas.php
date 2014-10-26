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
require_once APPPATH . '/libraries/ingredientes/ingrediente.php';
require_once APPPATH . '/libraries/constantes/Code.php';
require_once APPPATH . '/libraries/alertas/alerta.php';
require_once APPPATH . '/libraries/reservas/reservaLocal.php';
require_once APPPATH . '/libraries/pedidos/pedido.php';
require_once APPPATH . '/libraries/articulos/articulo.php';
require_once APPPATH . '/libraries/horarios/horarioLocal.php';
require_once APPPATH . '/libraries/horarios/horarioPedido.php';
require_once APPPATH . '/libraries/horarios/diaCierre.php';
require_once APPPATH . '/libraries/menus/menuDia.php';

class Alertas extends REST_Controller {

	const FIELD_FECHA = "fecha";

	public function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		//Se carga el modelo de articulos
		$this->load->model('alertas/Alertas_model');
	}

	function obtenerAlertasLocal_post() {		
		
		//Se recogen los datos recibidos en formato json
		$datos = $this->post();

		if (!isset($datos[Code::FIELD_ID_LOCAL]) ||
				!isset($datos[Alertas::FIELD_FECHA]) ) {
		$msg = "Error obteniendo alertas";
		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
				, Code::JSON_MENSAJE => $msg);
		$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los parametros enviados
		$fecha = $datos[Alertas::FIELD_FECHA];
		$idLocal = $datos[Code::FIELD_ID_LOCAL];

		/*$fecha = $this->get(Alertas::FIELD_FECHA);
		$idLocal = $this->get(Code::FIELD_ID_LOCAL);*/

		//Se comprueba si hay alertas para el local
		if ($this->Alertas_model->hayAlertasNuevas($idLocal, $fecha)){
			$alertas = $this->Alertas_model->obtenerAlertas($idLocal, $fecha);
				
			$msg="Alertas enviadas";
				
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Alerta::FIELD_ALERTAS => $alertas
			);
			
		}else{
			$msg = "No hay alertas";

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_NO_ALERTAS,
					Code::JSON_MENSAJE => $msg
			);
		}

		$this->response($datosRespuesta, Code::CODE_OK);

	}

}