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
require_once APPPATH . '/libraries/horarios/diaSemana.php';
require_once APPPATH . '/libraries/horarios/horarioLocal.php';
require_once APPPATH . '/libraries/horarios/horarioPedido.php';
require_once APPPATH . '/libraries/horarios/diaCierre.php';
require_once APPPATH . '/libraries/menus/tipoMenu.php';
require_once APPPATH . '/libraries/menus/tipoPlato.php';
require_once APPPATH . '/libraries/menus/plato.php';
require_once APPPATH . '/libraries/menus/menu.php';
require_once APPPATH . '/libraries/menus/menuDia.php';
require_once APPPATH . '/libraries/reservas/reservaLocal.php';
require_once APPPATH . '/libraries/reservas/diaCierreReserva.php';
require_once APPPATH . '/libraries/comandas/tipoComanda.php';
require_once APPPATH . '/libraries/comandas/camarero.php';
require_once APPPATH . '/libraries/comandas/comanda.php';
require_once APPPATH . '/libraries/comandas/detalleComanda.php';
require_once APPPATH . '/libraries/comandas/menuComanda.php';
require_once APPPATH . '/libraries/comandas/platoComanda.php';

class Locales extends REST_Controller {

	const CODE_OK = 200;
	const CODE_KO = 404;
	const CODE_NO_DATA = 400;

	//Campos recibidos
	const FIELD_ID_LOCAL = "idLocal";
	const FIELD_ID_USUARIO = "idUsuario";

	//Campos enviados con JSON
	const JSON_POBLACION = "poblacion";
	const JSON_NOMBRE_LOCAL = "nombreLocal";
	const JSON_CALLE = "calle";
	const JSON_CODIGO_POSTAL = "codigoPostal";
	const JSON_SERVICIOS = "servicios";
	const JSON_TIPO_COMIDA = "tipoComida";
	const JSON_LOCALES = "locales";
	const JSON_INGREDIENTES = "ingredientes";
	const JSON_ARTICULOS = "articulos";
	const JSON_HORARIO_PEDIDOS = "horarioPedidos";
	const JSON_TIPOS_ARTICULO = "tiposArticulo";
	const JSON_TIPOS_ARTICULO_LOCAL = "tiposArticuloLocal";
	const JSON_PEDIDOS_PENDIENTES = "pedidosPendientes";
	const JSON_PEDIDOS_ACEPTADOS = "pedidosAceptados";
	const JSON_PEDIDOS_RECHAZADOS = "pedidosRechazados";
	const JSON_PEDIDOS_TERMINADOS = "pedidosTerminados";
	const JSON_SERVICIOS_LOCAL = "serviciosLocal";
	const JSON_TIPOS_SERVICIO = "tiposServicio";


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
		$this->load->model('locales/Locales_model');
	}

	function datosLocalUsuario_get() {
		if (!$this->get(Locales::FIELD_ID_LOCAL)) {
			$this->response(NULL, Locales::CODE_KO);
		}

		$idLocal = $this->get(Locales::FIELD_ID_LOCAL);

		//Se carga el modelo de articulos
		$this->load->model('articulos/Articulos_model');

		//Se obtienen los articulos diposnibles del local
		$articulos = $this->Articulos_model->obtenerArticulosPedidoLocal
		($idLocal, 1, 1);

		//Se obtienen los tipos articulo del local
		$tiposArticulo = $this->Articulos_model->obtenerTiposArticuloLocal
		($idLocal)->result();

		//Se carga el modelo de ingredientes
		$this->load->model('ingredientes/Ingredientes_model');

		//Se obtienen los ingredientes diposnibles del local
		$ingredientes = $this->Ingredientes_model->obtenerIngredientesDisponibles
		($idLocal, 1)->result();

		$horarioPedidos = $this->Locales_model->obtenerHorarioPedidos($idLocal)->result();

		//Se carga el modelo de servicios
		$this->load->model('servicios/Servicios_model');

		//Se obtienen los servicios del local
		$serviciosLocal =
		$this->Servicios_model->obtenerServiciosActivosLocal($idLocal)->result();

		$datosLocal = array(
				Locales::JSON_ARTICULOS => $articulos,
				Locales::JSON_INGREDIENTES => $ingredientes,
				Locales::JSON_HORARIO_PEDIDOS => $horarioPedidos,
				Locales::JSON_SERVICIOS => $serviciosLocal,
				Locales::JSON_TIPOS_ARTICULO_LOCAL => $tiposArticulo
		);


		$this->response($datosLocal, Locales::CODE_OK);
	}

	function datosLocal_get() {
		if (!$this->get(Locales::FIELD_ID_LOCAL)) {
			$this->response(NULL, Locales::CODE_KO);
		}

		$idLocal = $this->get(Locales::FIELD_ID_LOCAL);

		//Se carga el modelo de articulos
		$this->load->model('articulos/Articulos_model');

		//Se obtienen los articulos del local
		$articulos = $this->Articulos_model->obtenerArticulosLocalObject($idLocal);

		$tiposArticuloLocal = $this->Articulos_model->
		obtenerTiposArticuloLocalObject($idLocal);

		$tiposArticulo = $this->Articulos_model->
		obtenerTiposArticuloObject();

		//Se carga el modelo de ingredientes
		$this->load->model('ingredientes/Ingredientes_model');

		//Se obtienen los ingredientes diposnibles del local
		$ingredientes = $this->Ingredientes_model->obtenerIngredientesObject($idLocal);

		//Se carga el modelo de pedidos
		$this->load->model('pedidos/Pedidos_model');

		//Se obtienen los pedidos pendientes
		$listaPedidosPendientes = $this->Pedidos_model->
		obtenerPedidosLocalObject($idLocal, 'P');

		//Se obtienen los pedidos aceptados
		$listaPedidosAceptados = $this->Pedidos_model->
		obtenerPedidosLocalObject($idLocal, 'A');

		//Se obtienen los pedidos rechazados
		$listaPedidosRechazados = $this->Pedidos_model->
		obtenerPedidosLocalObject($idLocal, 'R');

		//Se obtienen los pedidos terminados
		$listaPedidosTerminados = $this->Pedidos_model->
		obtenerPedidosLocalObject($idLocal, 'T');

		//Se carga el modelo de servicios
		$this->load->model('servicios/Servicios_model');

		//Se obtienen los tipos de servicio
		$tiposServicio = $this->Servicios_model->obtenerTiposServicioObject();

		//Se obtienen los tipos de servicio
		$serviciosLocal = $this->Servicios_model->obtenerServiciosLocalObject($idLocal);

		//Se carga el modelo varios
		$this->load->model('varios/Varios_model');

		$diasSemana = $this->Varios_model->obtenerDiasSemanaObject();

		$horariosLocal = $this->Locales_model->obtenerHorariosLocalObject($idLocal);

		$horariosPedido = $this->Locales_model->obtenerHorariosPedidoObject($idLocal);

		$diasCierre = $this->Locales_model->obtenerDiasCierreLocalObject($idLocal);

		//Se carga el modelo de reservas
		$this->load->model('reservas/Reservas_model');

		$mesas = $this->Reservas_model->obtenerMesasLocalObject($idLocal);
		$reservas = $this->Reservas_model->obtenerReservasLocalObject($idLocal);
		$diasCierreReserva = $this->Reservas_model->obtenerReservaDiasCierreObject($idLocal);

		//Se carga el modelo de menus
		$this->load->model('menus/Menus_model');

		$tiposMenu = $this->Menus_model->obtenerTiposMenuObject();
		$tiposPlato = $this->Menus_model->obtenerTiposPlatosLocalObject();
		$platos = $this->Menus_model->obtenerPlatosLocalObject($idLocal);
		$menus = $this->Menus_model->obtenerTiposMenuLocalObject($idLocal);
		$menusDia = $this->Menus_model->obtenerMenusDiaLocalObject();

		//Se carga el modelo de comandas
		$this->load->model('comandas/Comandas_model');

		$tiposComanda = $this->Comandas_model->obtenerTiposComandaObject();

		//Se carga el model de camareros
		$this->load->model('camareros/Camareros_model');

		$camareros = $this->Camareros_model->obtenerCamarerosLocalObject($idLocal,1);
		$comandasActivas =
		$this->Comandas_model->obtenerComandasActivasObject($idLocal);
		$comandasCerradas =
		$this->Comandas_model->obtenerComandasCerradasObject($idLocal);
		$datosLocal = array(
				Locales::JSON_INGREDIENTES => $ingredientes,
				Locales::JSON_ARTICULOS => $articulos,
				Locales::JSON_TIPOS_ARTICULO_LOCAL => $tiposArticuloLocal,
				Locales::JSON_TIPOS_ARTICULO => $tiposArticulo,
				Locales::JSON_PEDIDOS_PENDIENTES => $listaPedidosPendientes,
				Locales::JSON_PEDIDOS_ACEPTADOS => $listaPedidosAceptados,
				Locales::JSON_PEDIDOS_RECHAZADOS => $listaPedidosRechazados,
				Locales::JSON_PEDIDOS_TERMINADOS => $listaPedidosTerminados,
				Locales::JSON_TIPOS_SERVICIO => $tiposServicio,
				Locales::JSON_SERVICIOS_LOCAL => $serviciosLocal,
				DiaSemana::FIELD_DIAS_SEMANA => $diasSemana,
				HorarioLocal::FIELD_HORARIOS_LOCAL => $horariosLocal,
				HorarioPedido::FIELD_HORARIOS_PEDIDO => $horariosPedido,
				DiaCierre::FIELD_DIAS_CIERRE => $diasCierre,
				Mesa::FIELD_MESAS => $mesas,
				TipoMenu::FIELD_TIPO_MENU => $tiposMenu,
				ReservaLocal::FIELD_RESERVAS => $reservas,
				DiaCierreReserva::FIELD_DIAS_CIERRE_RESERVA => $diasCierreReserva,
				TipoPlato::FIELD_TIPOS_PLATO => $tiposPlato,
				Plato::FIELD_PLATOS => $platos,
				Menu::FIELD_MENUS => $menus,
				MenuDia::FIELD_MENUS_DIA => $menusDia,
				TipoComanda::FIELD_TIPOS_COMANDA => $tiposComanda,
				Camarero::FIELD_CAMAREROS => $camareros,
				Comanda::FIELD_COMANDAS_ACTIVAS => $comandasActivas,
				Comanda::FIELD_COMANDAS_CERRADAS => $comandasCerradas
		);

		$this->response($datosLocal, Locales::CODE_OK); // 200 being the HTTP response code
	}

	function loginLocal_get() {

		if (!$this->get('nombreLocal') || !$this->get('password')) {
			$this->response(NULL, Locales::CODE_KO);
		}

		$nombreLocal = $this->get('nombreLocal');
		$password = $this->get('password');

		//Se comprueba si existe el local
		$result =
		$this->Locales_model->comprobarLocalLogin($nombreLocal
				, md5($password));

		$datosLocal = array('idUsuario' => -1, 'msg' => 'Login KO .Nombre local o password incorrecto');
		$codigoRetorno = Locales::CODE_KO;

		//Se comprueba si existe el local
		if ($result->num_rows() > 0) {

			$lineaLocal = $result->row();

			$datosLocal = array('idLocal' => $lineaLocal->id_local
					, 'msg' => 'Login OK');

			$codigoRetorno = Locales::CODE_OK;
		}

		$this->response($datosLocal, $codigoRetorno);
	}

	function buscar_put() {
		$poblacion = $this->put(Locales::JSON_POBLACION);
		$nombreLocal = $this->put(Locales::JSON_NOMBRE_LOCAL);
		$calle = $this->put(Locales::JSON_CALLE);
		$codigoPostal = $this->put(Locales::JSON_CODIGO_POSTAL);
		$servicios = $this->put(Locales::JSON_SERVICIOS);
		$idTipoComida = $this->put(Locales::JSON_TIPO_COMIDA);

		$datosBusqueda = array(Locales::CONST_SERVICIOS => $servicios,
				Locales::CONST_LOCAL => $nombreLocal,
				Locales::CONST_POBLACION => $poblacion,
				Locales::CONST_CALLE => $calle,
				Locales::CONST_CODIGO_POSTAL => $codigoPostal,
				Locales::CONST_ID_TIPO_COMIDA => $idTipoComida
		);

		//Se obtienen los locales buscados.
		$locales = $this->Locales_model->buscarLocales($datosBusqueda);

		if ($locales->num_rows()) {
			$this->response(array(Locales::JSON_LOCALES => $locales->result())
					, Locales::CODE_OK);
		} else {
			$msg = "No se han encontrado locales";
			$this->response($msg, Locales::CODE_NO_DATA);
		}
	}

}