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
require_once APPPATH . '/libraries/articulos/articuloPedido.php';
require_once APPPATH . '/libraries/articulos/articuloPersonalizadoPedido.php';
require_once APPPATH . '/libraries/pedidos/pedido.php';
require_once APPPATH . '/libraries/constantes/Code.php';

class Pedidos extends REST_Controller {

	const CODE_OK = 200;
	const CODE_KO = 404;
	const CODE_NO_DATA = 400;
	const FIELD_ID_LOCAL = "idLocal";

	//Campos enviados con JSON
	const JSON_PEDIDO_OK = "pedidoOK";
	const JSON_MENSAJE = "mensaje";
	const JSON_PEDIDO = "pedido";


	//Constantes
	const CONST_SERVICIOS = "servicios";
	const CONST_LOCAL = "local";
	const CONST_POBLACION = "poblacion";
	const CONST_CALLE = "calle";
	const CONST_CODIGO_POSTAL = "codigoPostal";
	const CONST_ID_TIPO_COMIDA = "idTipoComida";

	public function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		//Se carga el modelo de usuarios
		$this->load->model('pedidos/Pedidos_model');
	}

	function nuevoPedido_post() {
		//Se recogen los datos recibidos en formato json
		$pedido = $this->post();

		$articulo = null;
		$articulos = array();
		$observaciones = $pedido['observaciones'];
		$envioPedido = false;
		$idDireccion = 0;
		if (isset($pedido['idDireccion'])) {
			$idDireccion = $pedido['idDireccion'];
			$envioPedido = true;
		}
		if (isset($pedido['fechaPedido'])) {
			list( $fecha,$hora) = explode(' ', $pedido['fechaPedido']);
			list( $ano,$mes,$dia) = explode('-', $fecha);
			$fechaPedido = new DateTime($ano . '-'
					. $mes . '-' . $dia . ' ' . $hora . ':00');
		} else {
			$fechaPedido = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
		}
		$idLocal = $pedido['idLocal'];
		$idUsuario = $pedido['idUsuario'];

		$precioTotal = 0;
		foreach ($pedido['articulos'] as $articulo) {
			if (isset($articulo['idArticulo'])) {
				//Articulo "normal"
				$articulo = new ArticuloPedido($articulo['idArticulo'], $articulo['cantidad']);
			} else {
				$ingredientes = array();
				foreach ($articulo['ingredientes'] as $ingrediente) {
					$ingredientes[] = $ingrediente['idIngrediente'];
				}

				$articulo = new ArticuloPersonalizadoPedido($articulo['cantidad']
						, $ingredientes, $articulo['tipoArticulo']['idTipoArticulo']);
			}

			$precioTotal += $articulo->getPrecio();

			$articulos[] = $articulo;
		}

		//Se carga el modelo de locales
		$this->load->model('locales/Locales_model');

		//Se comprueba si el local está abierto
		$localAbierto =
		$this->Locales_model->comprobarLocalAbierto($idLocal
				, $fechaPedido);

		if (!$localAbierto) {
			$mensaje = 'El local está cerrado el día indicado';
			$datosRespuesta = array(Pedidos::JSON_PEDIDO_OK => '0',
					Pedidos::JSON_MENSAJE => $mensaje);
			$this->response($datosRespuesta, 200);
		}

		//Se comprueba si se llega al importe minimo
		if ($envioPedido) {
			//Se carga el modelo de servicios
			$this->load->model('servicios/Servicios_model');

			$servicioLocal = $this->Servicios_model->obtenerServicioLocal($idLocal, 2)->row();

			//Se comprueba si se ha llegado al importe minimo
			if ($servicioLocal->importe_minimo > $precioTotal) {
				$mensaje = "No has llegado al importe minimo";
				$datosRespuesta = array(Pedidos::JSON_PEDIDO_OK => '0',
						Pedidos::JSON_MENSAJE => $mensaje);
				$this->response($datosRespuesta, 200);
			}
		}

		$idPedido = $this->Pedidos_model->insertPedidoApi
		($idUsuario, $articulos, $observaciones
				, $idDireccion, $idLocal
				, $precioTotal, $envioPedido, $fechaPedido);


		//Se comprueba si se ha insertado ok el pedido
		if ($idPedido < 0) {
			$mensaje = "Error generando el pedido";
			$datosRespuesta = array(Pedidos::JSON_PEDIDO_OK => '0',
					Pedidos::JSON_MENSAJE => $mensaje);
			$this->response($datosRespuesta, 200);
		}

		$pedido = $this->Pedidos_model->obtenerPedido($idPedido);

		$mensaje = "Pedido realizado correctamente";
		$datosRespuesta = array(Pedidos::JSON_PEDIDO_OK => '1',
				Pedidos::JSON_MENSAJE => $mensaje,
				Pedidos::JSON_PEDIDO => $pedido);


		$this->response($datosRespuesta, 200);
	}

	function terminarPedido_get() {
		if (!$this->get(Pedido::FIELD_ID_PEDIDO)||
		!$this->get(Pedido::FIELD_ID_ESTADO)) {
			$msg = "Error modificando el estado del pedido";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idPedido = $this->get(Pedido::FIELD_ID_PEDIDO);
		$idEstado = $this->get(Pedido::FIELD_ID_ESTADO);

		$msg = "Estado del pedido modificado correctamente.";

		//Se actualiza el estado del pedido
		$this->Pedidos_model->actualizarEstadoPedido($idPedido, $idEstado);

		$pedido = $this->Pedidos_model->obtenerPedidoObject($idPedido);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				Pedido::FIELD_PEDIDO => $pedido
		);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function aceptarPedido_post(){
		//Se recogen los datos recibidos en formato json
		$datosPedido = $this->post();

		$idPedido = $datosPedido[Pedido::FIELD_ID_PEDIDO];
		$idEstado = $datosPedido[Pedido::FIELD_ESTADO];
		$fechaEntrega = $datosPedido[Pedido::FIELD_FECHA_ENTREGA];

		$fechaEntrega = DateTime::createFromFormat('Y-m-d H:i:s', $fechaEntrega
				.':00');

		//Se actualiza el estado del pedido
		$this->Pedidos_model->actualizarEstadoPedido($idPedido
				, $idEstado, $fechaEntrega);

		$pedido = $this->Pedidos_model->obtenerPedidoObject($idPedido);

		$msg = "Estado del pedido modificado correctamente.";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				Pedido::FIELD_PEDIDO => $pedido
		);
		$this->response($datosRespuesta, Code::CODE_OK);

	}

	function rechazarPedido_post(){
		//Se recogen los datos recibidos en formato json
		$datosPedido = $this->post();

		$idPedido = $datosPedido[Pedido::FIELD_ID_PEDIDO];
		$idEstado = $datosPedido[Pedido::FIELD_ESTADO];
		$motivoRechazo = $datosPedido[Pedido::FIELD_MOTIVO_RECHAZO];

		//Se actualiza el estado del pedido
		$this->Pedidos_model->actualizarEstadoPedido($idPedido
				, $idEstado, '',$motivoRechazo);

		$pedido = $this->Pedidos_model->obtenerPedidoObject($idPedido);

		$msg = "Estado del pedido modificado correctamente.";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				Pedido::FIELD_PEDIDO => $pedido
		);
		$this->response($datosRespuesta, Code::CODE_OK);

	}
}