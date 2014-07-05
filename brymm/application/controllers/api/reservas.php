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
require_once APPPATH . '/libraries/usuario/Reserva.php';
require_once APPPATH . '/libraries/reservas/mesa.php';
require_once APPPATH . '/libraries/reservas/reservaLocal.php';
require_once APPPATH . '/libraries/reservas/diaCierreReserva.php';
require_once APPPATH . '/libraries/constantes/Code.php';

class Reservas extends REST_Controller {

	const CODE_OK = 200;
	const CODE_KO = 404;
	const CODE_NO_DATA = 400;
	//Campos enviados con JSON
	const JSON_OPERACION_OK = "operacionOK";
	const JSON_MENSAJE = "mensaje";
	const JSON_RESERVA = "reserva";
	//Datos recibidos
	const FIELD_ID_TIPO_MENU = "tipoMenu";
	const FIELD_ID_LOCAL = "id_local";
	const FIELD_ID_USUARIO = "idUsuario";
	const FIELD_NUMERO_PERSONAS = "numero_personas";
	const FIELD_FECHA = "fecha";
	const FIELD_OBSERVACIONES = "observaciones";
	const FIELD_ID_RESERVA = "idReserva";
	//Constantes
	const CONST_SERVICIOS = "servicios";
	//Estados
	const ACEPTADA_LOCAL = "AL";
	const RECHAZADO_LOCAL = "RL";

	public function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		//Se carga el modelo de usuarios
		$this->load->model('usuarios/Usuarios_model');
		$this->load->model('reservas/Reservas_model');
	}

	function nuevaReserva_post() {
		//Se recogen los datos recibidos en formato json
		$datosReserva = $this->post();

		$hayError = false;
		$msg = "";

		if (!is_numeric($datosReserva[Reservas::FIELD_NUMERO_PERSONAS]) ||
		!$datosReserva[Reservas::FIELD_NUMERO_PERSONAS] > 0) {
			$msg = "El campo numero de personas tiene un valor incorrecto";
			$hayError = true;
		}

		list( $fecha,$hora) = explode(' ', $datosReserva[Reservas::FIELD_FECHA]);
		list($ano, $mes, $dia ) = explode('-', $fecha);
		$fechaReserva = $ano . '-'
				. $mes . '-' . $dia;

		if (DateTime::createFromFormat('Y-m-d', $fecha) && !$hayError) {
			$msg = 'El formato de la fecha es incorrecto';
			$hayError = true;
		}

		$idLocal = $datosReserva[Reservas::FIELD_ID_LOCAL];
		$idTipoMenu = $datosReserva[Reservas::FIELD_ID_TIPO_MENU];
		$observaciones = $datosReserva[Reservas::FIELD_OBSERVACIONES];

		//Se carga el modelo de locales
		$this->load->model('locales/Locales_model');

		if (!$hayError) {

			//Se comprueba si el local está abierto
			$localAbierto = $this->Locales_model->comprobarLocalAbierto($idLocal
					, DateTime::createFromFormat('Y-m-d', $fechaReserva));

			if ($localAbierto) {

				//Se comprueba si las reservas están cerradas el día indicado
				$comprobarReservasCerradas = $this->Reservas_model->comprobarReservaCerrada
				($idLocal
						, $fechaReserva
						, $idTipoMenu)->num_rows();

				if ($comprobarReservasCerradas > 0) {
					$msg = 'No se admiten mas reservas en la fecha indicada.';
					$hayError = true;
				} else {
					$idReserva = $this->Reservas_model->insertarReservaUsuario
					($datosReserva[Reservas::FIELD_ID_USUARIO]
							, $idLocal
							, $datosReserva[Reservas::FIELD_NUMERO_PERSONAS]
							, DateTime::createFromFormat('Y-m-d', $fechaReserva)
							, $idTipoMenu, $hora, '', $observaciones);

					$reserva = Reserva::withID($idReserva);

					$msg = 'Petición realizada correctamente';
				}
			} else {
				$msg = 'El local está cerrado el día indicado';
				$hayError = true;
			}
		}

		if ($hayError) {

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					,Code::JSON_MENSAJE => $msg
			);
		} else {
			$datosRespuesta = array(Reservas::JSON_OPERACION_OK => '1',
					Reservas::JSON_MENSAJE => $msg,
					Reservas::JSON_RESERVA => $reserva);

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK
					,Code::JSON_MENSAJE => $msg
					,Reserva::FIELD_RESERVA => $reserva
			);
		}



		$this->response($datosRespuesta, Code::CODE_OK);

	}

	function anularReserva_get() {
		if (!$this->get(Reservas::FIELD_ID_RESERVA)) {
			$msg = "Error anulando reserva";
			$datosRespuesta = array(Direcciones::JSON_DIRECCION_OK => '0',
					Direcciones::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Reservas::CODE_OK);
		}

		$idReserva = $this->get(Reservas::FIELD_ID_RESERVA);

		//Se modifica el estado de la reserva a anulada usuario (AU)
		$this->Reservas_model->modificarEstadoReserva($idReserva, 'AU');

		//Se borran las posibles mesas asignadas a la reserva para dejarlas libres
		$this->Reservas_model->borrarMesasReserva($idReserva);

		//Si las reservas están cerradas para ese dia se vuelven a abrir.
		$datosReserva = $this->Reservas_model->obtenerDatosReservaLocal($idReserva)->row();

		$this->Reservas_model->borrarReservaCerrada($datosReserva->id_local
				, $datosReserva->fecha, $datosReserva->id_tipo_menu);

		$msg = 'Reserva anulada correctamente';

		$reserva = Reserva::withID($idReserva);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK
				,Code::JSON_MENSAJE => $msg
				,Reserva::FIELD_RESERVA => $reserva
		);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function aceptarReserva_post() {

		$datosReserva = $this->post();

		if (!is_numeric($datosReserva[ReservaLocal::FIELD_ID_RESERVA])) {
			$msg = "Error aceptando reserva";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					,Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idReserva = $datosReserva[ReservaLocal::FIELD_ID_RESERVA];

		//Se modifica el estado de la reserva a aceptada local (AL)
		$this->Reservas_model->modificarEstadoReserva($idReserva,Reservas::ACEPTADA_LOCAL);
		$msg = 'Reserva aceptada correctamente';

		$reserva = ReservaLocal::withID($idReserva);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK
				,Code::JSON_MENSAJE => $msg
				,ReservaLocal::FIELD_RESERVA => $reserva
		);
		$this->response($datosRespuesta, Code::CODE_OK);

	}

	function nuevaReservaLocal_post() {

		$datosRecibidos = $this->post();

		$idLocal = $datosRecibidos[Code::FIELD_ID_LOCAL];
		$datosReserva = $datosRecibidos[ReservaLocal::FIELD_RESERVA];

		//Se comprueban los datos de los campos
		$hayError = false;

		if (!is_numeric($datosReserva[ReservaLocal::FIELD_NUMERO_PERSONAS])){
			$hayError = true;
			$msg = 'El valor del campo numero personas tiene que ser numerico';
		}

		if (!$datosReserva[ReservaLocal::FIELD_NUMERO_PERSONAS] > 0){
			$hayError = true;
			$msg = 'El valor del campo numero personas tiene que ser mayor que 0';
		}

		if ($datosReserva[ReservaLocal::FIELD_FECHA] == ""){
			$hayError = true;
			$msg = 'El campo fecha no puede estar vacio';
		}

		if ($datosReserva[ReservaLocal::FIELD_HORA_INICIO] == ""){
			$hayError = true;
			$msg = 'El campo horan o puede estar vacio';
		}

		if ($datosReserva[ReservaLocal::FIELD_NOMBRE_EMISOR] == ""){
			$hayError = true;
			$msg = 'El campo a nombre de no puede estar vacio';
		}

		if ($hayError) {
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					,Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se carga el modelo de locales
		$this->load->model('locales/Locales_model');

		//Se comprueba si el local está abierto
		$localAbierto =
		$this->Locales_model->comprobarLocalAbierto($idLocal
				, DateTime::createFromFormat('Y-m-d', $datosReserva[ReservaLocal::FIELD_FECHA]));

		if ($localAbierto) {

			//Se comprueba si las reservas están cerradas el día indicado
			$comprobarReservasCerradas =
			$this->Reservas_model->comprobarReservaCerrada($idLocal
					, $datosReserva[ReservaLocal::FIELD_FECHA]
					, $datosReserva[TipoMenu::FIELD_TIPO_MENU][TipoMenu::FIELD_ID_TIPO_MENU])->num_rows();

			if ($comprobarReservasCerradas > 0) {
				$msg = 'No se admiten mas reservas en la fecha indicada.';

				$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
						,Code::JSON_MENSAJE => $msg
				);
				$this->response($datosRespuesta, Code::CODE_OK);
			} else {
				$idReserva = $this->Reservas_model->insertarReservaLocal2($idLocal
						, $datosReserva[ReservaLocal::FIELD_NUMERO_PERSONAS]
						, DateTime::createFromFormat('Y-m-d', $datosReserva[ReservaLocal::FIELD_FECHA])
						, $datosReserva[TipoMenu::FIELD_TIPO_MENU][TipoMenu::FIELD_ID_TIPO_MENU]
						, $datosReserva[ReservaLocal::FIELD_HORA_INICIO]
						, ''
						, $datosReserva[ReservaLocal::FIELD_OBSERVACIONES]
						, $datosReserva[ReservaLocal::FIELD_NOMBRE_EMISOR]
						, $datosReserva[Mesa::FIELD_MESAS]);

				/*
				 * Si el valor de idReserva es negativo ha habido algún error insertando
				la reserva */
				if ($idReserva > 0) {
					$msg = 'Reserva insertada correctamente';
				} else {
					$msg = 'Error insertando reserva';

					$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
							,Code::JSON_MENSAJE => $msg
					);
					$this->response($datosRespuesta, Code::CODE_OK);
				}
			}
		} else {
			$msg = 'El local está cerrado el día indicado';
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					,Code::JSON_MENSAJE => $msg
			);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$reserva = ReservaLocal::withID($idReserva);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK
				,Code::JSON_MENSAJE => $msg
				,ReservaLocal::FIELD_RESERVA => $reserva
		);
		$this->response($datosRespuesta, Code::CODE_OK);

	}

	function rechazarReserva_post() {

		$datosReserva = $this->post();

		if (!is_numeric($datosReserva[ReservaLocal::FIELD_ID_RESERVA])||
		!isset($datosReserva[ReservaLocal::FIELD_MOTIVO])) {
			$msg = "Error rechazando reserva";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					,Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idReserva = $datosReserva[ReservaLocal::FIELD_ID_RESERVA];

		//Se modifica el estado de la reserva a rechazada local (RL)
		$this->Reservas_model->modificarEstadoReserva($idReserva,Reservas::RECHAZADO_LOCAL
				,$datosReserva[ReservaLocal::FIELD_MOTIVO]);

		//Se borran las posibles mesas asignadas a la reserva para dejarlas libres
		$this->Reservas_model->borrarMesasReserva($idReserva);

		$msg = 'Reserva rechazada correctamente';

		$reserva = ReservaLocal::withID($idReserva);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK
				,Code::JSON_MENSAJE => $msg
				,ReservaLocal::FIELD_RESERVA => $reserva
		);
		$this->response($datosRespuesta, Code::CODE_OK);

	}

	public function abrirReservasDia_post() {
		$datosReserva = $this->post();

		//Se comprueban los datos recibidos
		if (!isset($datosReserva[TipoMenu::FIELD_ID_TIPO_MENU])
		||!isset($datosReserva[ReservaLocal::FIELD_FECHA])
		||!isset($datosReserva[Code::FIELD_ID_LOCAL])) {
			$msg = "Error abriendo reservas";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					,Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los datos
		$fecha = $datosReserva[ReservaLocal::FIELD_FECHA];
		$idTipoMenu = $datosReserva[TipoMenu::FIELD_ID_TIPO_MENU];
		$idLocal = $datosReserva[Code::FIELD_ID_LOCAL];

		//Se abren las reservas
		$this->Reservas_model->borrarReservaCerrada($idLocal, $fecha, $idTipoMenu);
		$msg = "Reservas abiertas correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK
				,Code::JSON_MENSAJE => $msg
		);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function cerrarReservasDia_post() {
		$datosReserva = $this->post();

		//Se comprueban los datos recibidos
		if (!isset($datosReserva[TipoMenu::FIELD_ID_TIPO_MENU])
		||!isset($datosReserva[ReservaLocal::FIELD_FECHA])
		||!isset($datosReserva[Code::FIELD_ID_LOCAL])) {
			$msg = "Error cerrando reservas";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					,Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los datos
		$fecha = $datosReserva[ReservaLocal::FIELD_FECHA];
		$idTipoMenu = $datosReserva[TipoMenu::FIELD_ID_TIPO_MENU];
		$idLocal = $datosReserva[Code::FIELD_ID_LOCAL];

		$comprobarReservasCerradas =
		$this->Reservas_model->comprobarReservaCerrada($idLocal, $fecha, $idTipoMenu)->num_rows();

		if ($comprobarReservasCerradas > 0) {
			$msg = "Las reservas ya están cerradas para la fecha indicada";

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					,Code::JSON_MENSAJE => $msg
			);
		} else {
			$idDiaCierreReserva = $this->Reservas_model->insertarCerrarReserva($idLocal, $fecha, $idTipoMenu);
			$msg = "Reservas cerradas correctamente";

			$diaCierreReserva = DiaCierreReserva::withID($idDiaCierreReserva);

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK
					,Code::JSON_MENSAJE => $msg
					,DiaCierreReserva::FIELD_DIA_CIERRE_RESERVA => $diaCierreReserva
			);
		}


		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function asignarMesaReserva_post() {

		$datosReserva = $this->post();

		if (!is_numeric($datosReserva[ReservaLocal::FIELD_ID_RESERVA])||
		!is_numeric($datosReserva[Mesa::FIELD_ID_MESA])) {
			$msg = "Error asignando mesa";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					,Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idReserva = $datosReserva[ReservaLocal::FIELD_ID_RESERVA];
		$idMesa = $datosReserva[Mesa::FIELD_ID_MESA];

		//Se inserta la mesa
		$this->Reservas_model->insertarMesaReserva($idMesa, $idReserva);

		$msg = 'Mesa asignada a la reserva';

		$reserva = ReservaLocal::withID($idReserva);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK
				,Code::JSON_MENSAJE => $msg
				,ReservaLocal::FIELD_RESERVA => $reserva
		);
		$this->response($datosRespuesta, Code::CODE_OK);

	}

	function desasignarMesaReserva_post() {

		$datosReserva = $this->post();

		if (!is_numeric($datosReserva[ReservaLocal::FIELD_ID_RESERVA])||
		!is_numeric($datosReserva[Mesa::FIELD_ID_MESA])) {
			$msg = "Error desasignando mesa";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					,Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idReserva = $datosReserva[ReservaLocal::FIELD_ID_RESERVA];
		$idMesa = $datosReserva[Mesa::FIELD_ID_MESA];

		//Se borra la mesa
		$this->Reservas_model->borrarMesaReserva2($idMesa,$idReserva);

		$msg = 'Mesa desasignada de la reserva';

		$reserva = ReservaLocal::withID($idReserva);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK
				,Code::JSON_MENSAJE => $msg
				,ReservaLocal::FIELD_RESERVA => $reserva
		);
		$this->response($datosRespuesta, Code::CODE_OK);

	}

	function nuevaMesa_post(){
		//Se recogen los datos recibidos en formato json
		$datosMesa = $this->post();

		$mesa = new Mesa($datosMesa[Mesa::FIELD_MESA][Mesa::FIELD_ID_MESA],
				$datosMesa[Mesa::FIELD_MESA][Mesa::FIELD_NOMBRE],
				$datosMesa[Mesa::FIELD_MESA][Mesa::FIELD_CAPACIDAD]);

		$idLocal = $datosMesa[Code::FIELD_ID_LOCAL];

		$hayError = false;

		//Se comprueba que el nombre no está vacio
		if ($mesa->nombre == '') {

			$msg = 'El campo nombre no puede estar vacio';
			$hayError = true;

		} else {
			//Se comprueba si la capacidad es un numerico
			if (!is_numeric($mesa->capacidad) || $mesa->capacidad <= 0) {

				$msg = 'Valor de capacidad incorrecto!';
				$hayError = true;

			} else {

				//Comprobar existe mesa con este nombre
				$existeMesa = $this->Reservas_model->comprobarNombreMesaLocal
				($idLocal, $mesa->nombre)->num_rows();

				if ($existeMesa > 0) {

					$msg = 'Ya existe una mesa con este nombre';
					$hayError = true;

				} else {
					//Se inserta la linea en la tabla
					$idMesa = $this->Reservas_model->insertarMesaLocal($mesa->nombre, $mesa->capacidad
							, $idLocal);
					$msg = 'Mesa creada correctamente.';

					$mesa = Mesa::withID($idMesa);
				}
			}
		}

		if ($hayError){
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}else{
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Mesa::FIELD_MESA => $mesa);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function borrarMesa_get() {
		if (!$this->get(Mesa::FIELD_ID_MESA)) {
			$msg = "Error borrando mesa";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idMesa = $this->get(Mesa::FIELD_ID_MESA);

		//Se borra la linea en la tabla
		$this->Reservas_model->borrarMesaLocal($idMesa);

		$msg = "Mesa borrada correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function modificarMesa_post(){
		//Se recogen los datos recibidos en formato json
		$datosMesa = $this->post();

		$mesa = new Mesa($datosMesa[Mesa::FIELD_MESA][Mesa::FIELD_ID_MESA],
				$datosMesa[Mesa::FIELD_MESA][Mesa::FIELD_NOMBRE],
				$datosMesa[Mesa::FIELD_MESA][Mesa::FIELD_CAPACIDAD]);

		$idLocal = $datosMesa[Code::FIELD_ID_LOCAL];

		$hayError = false;

		//Se comprueba que el nombre no está vacio
		if ($mesa->nombre == '') {

			$msg = 'El campo nombre no puede estar vacio';
			$hayError = true;

		} else {
			//Se comprueba si la capacidad es un numerico
			if (!is_numeric($mesa->capacidad) || $mesa->capacidad <= 0) {

				$msg = 'Valor de capacidad incorrecto!';
				$hayError = true;

			} else {

				//Comprobar existe mesa con este nombre
				$existeMesa = $this->Reservas_model->comprobarNombreMesaLocal
				($idLocal, $mesa->nombre);

				if ($existeMesa->num_rows() > 0) {

					/*
					 * Si la mesa que existe con el mismo nombre es la que vamos a
					* modificar se modifica sino no
					*/

					if ($existeMesa->row()->id_mesa_local == $mesa->idMesa){

						//Se modifica la linea en la tabla
						$this->Reservas_model->modificarMesaLocal(
								$mesa->idMesa,
								$mesa->nombre,
								$mesa->capacidad);

						$msg = 'Mesa modificada correctamente.';

						$mesa = Mesa::withID($mesa->idMesa);
					}else{
						$msg = 'Ya existe una mesa con este nombre';
						$hayError = true;
					}

				} else {
					//Se modifica la linea en la tabla
					$this->Reservas_model->modificarMesaLocal(
							$mesa->idMesa,
							$mesa->nombre,
							$mesa->capacidad);

					$msg = 'Mesa modificada correctamente.';

					$mesa = Mesa::withID($mesa->idMesa);
				}
			}
		}

		if ($hayError){
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}else{
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Mesa::FIELD_MESA => $mesa);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}



}
