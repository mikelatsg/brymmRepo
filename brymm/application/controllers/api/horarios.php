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
require_once APPPATH . '/libraries/horarios/horarioLocal.php';
require_once APPPATH . '/libraries/horarios/horarioPedido.php';
require_once APPPATH . '/libraries/horarios/diaCierre.php';
require_once APPPATH . '/libraries/horarios/diaSemana.php';
require_once APPPATH . '/libraries/constantes/Code.php';

class Horarios extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		//Se carga el modelo de ingredientes
		$this->load->model('locales/Locales_model');
	}

	function nuevoHorarioLocal_post() {
		//Se recogen los datos recibidos en formato json
		$datosHorarioLocal = $this->post();

		if (strlen ($datosHorarioLocal[HorarioLocal::FIELD_HORARIO_LOCAL]
				[HorarioLocal::FIELD_HORA_INICIO])< 4 ||
				strlen ($datosHorarioLocal[HorarioLocal::FIELD_HORARIO_LOCAL]
						[HorarioLocal::FIELD_HORA_FIN])<4){

			$msg = "Los campos de hora no pueden estar vacios";

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);

			$this->response($datosRespuesta, Code::CODE_OK);

		}

		$diaSemana = new DiaSemana($datosHorarioLocal[HorarioLocal::FIELD_HORARIO_LOCAL]
				[HorarioLocal::FIELD_DIA][DiaSemana::FIELD_ID_DIA]
				,$datosHorarioLocal[HorarioLocal::FIELD_HORARIO_LOCAL]
				[HorarioLocal::FIELD_DIA][DiaSemana::FIELD_DIA]);


		$horarioLocal = new HorarioLocal($datosHorarioLocal[HorarioLocal::FIELD_HORARIO_LOCAL]
				[HorarioLocal::FIELD_ID_HORARIO_LOCAL],
				$diaSemana,
				$datosHorarioLocal[HorarioLocal::FIELD_HORARIO_LOCAL]
				[HorarioLocal::FIELD_HORA_INICIO],
				$datosHorarioLocal[HorarioLocal::FIELD_HORARIO_LOCAL]
				[HorarioLocal::FIELD_HORA_FIN]);

		$idLocal = $datosHorarioLocal[Code::FIELD_ID_LOCAL];

		$idHorarioLocal = $this->Locales_model->insertHorarioLocalObject($idLocal
				, $horarioLocal);

		$msg = "Horario añadido correctamente";

		$horarioLocal = HorarioLocal::withID($idHorarioLocal);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				HorarioLocal::FIELD_HORARIO_LOCAL => $horarioLocal);

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function borrarHorarioLocal_get() {
		if (!$this->get(HorarioLocal::FIELD_ID_HORARIO_LOCAL)) {
			$msg = "Error borrando horario";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idHorarioLocal = $this->get(HorarioLocal::FIELD_ID_HORARIO_LOCAL);

		$this->Locales_model->borrarHorarioLocal($idHorarioLocal);

		$msg = "Horario borrado correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function nuevoHorarioPedido_post() {
		//Se recogen los datos recibidos en formato json
		$datosHorarioPedido = $this->post();

		if (strlen ($datosHorarioPedido[HorarioPedido::FIELD_HORARIO_PEDIDO]
				[HorarioPedido::FIELD_HORA_INICIO])< 4 ||
				strlen ($datosHorarioPedido[HorarioPedido::FIELD_HORARIO_PEDIDO]
						[HorarioPedido::FIELD_HORA_FIN])< 4){

			$msg = "Los campos de hora no pueden estar vacios";

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);

			$this->response($datosRespuesta, Code::CODE_OK);

		}

		$diaSemana = new DiaSemana($datosHorarioPedido[HorarioPedido::FIELD_HORARIO_PEDIDO]
				[HorarioPedido::FIELD_DIA][DiaSemana::FIELD_ID_DIA]
				,$datosHorarioPedido[HorarioPedido::FIELD_HORARIO_PEDIDO]
				[HorarioPedido::FIELD_DIA][DiaSemana::FIELD_DIA]);


		$horarioPedido = new HorarioPedido($datosHorarioPedido[HorarioPedido::FIELD_HORARIO_PEDIDO]
				[HorarioPedido::FIELD_ID_HORARIO_PEDIDO],
				$diaSemana,
				$datosHorarioPedido[HorarioPedido::FIELD_HORARIO_PEDIDO]
				[HorarioPedido::FIELD_HORA_INICIO],
				$datosHorarioPedido[HorarioPedido::FIELD_HORARIO_PEDIDO]
				[HorarioPedido::FIELD_HORA_FIN]);

		$idLocal = $datosHorarioPedido[Code::FIELD_ID_LOCAL];

		$idHorarioPedido = $this->Locales_model->insertHorarioPedidoObject($idLocal
				, $horarioPedido);

		$msg = "Horario añadido correctamente";

		$HorarioPedido = HorarioPedido::withID($idHorarioPedido);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				HorarioPedido::FIELD_HORARIO_PEDIDO => $HorarioPedido);

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function borrarHorarioPedido_get() {
		if (!$this->get(HorarioPedido::FIELD_ID_HORARIO_PEDIDO)) {
			$msg = "Error borrando horario";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idHorarioPedido = $this->get(HorarioPedido::FIELD_ID_HORARIO_PEDIDO);

		$this->Locales_model->borrarHorarioPedido($idHorarioPedido);

		$msg = "Horario borrado correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function nuevoDiaCierre_post() {
		//Se recogen los datos recibidos en formato json
		$datosDiaCierre = $this->post();

		if (strlen ($datosDiaCierre[DiaCierre::FIELD_DIA_CIERRE]
				[DiaCierre::FIELD_FECHA])< 4 ){

			$msg = "El campo fecha no puede estar vacio";

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);

			$this->response($datosRespuesta, Code::CODE_OK);

		}

		$diaCierre = new DiaCierre($datosDiaCierre[DiaCierre::FIELD_DIA_CIERRE]
				[DiaCierre::FIELD_ID_DIA_CIERRE],
				$datosDiaCierre[DiaCierre::FIELD_DIA_CIERRE]
				[DiaCierre::FIELD_FECHA]);

		$idLocal = $datosDiaCierre[Code::FIELD_ID_LOCAL];		
		
		$idDiaCierre = $this->Locales_model->insertarDiaCierreLocal($diaCierre->fecha
				,$idLocal
		);

		$msg = "Dia cierre añadido correctamente";

		$diaCierre = DiaCierre::withID($idDiaCierre);

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg,
				DiaCierre::FIELD_DIA_CIERRE => $diaCierre);

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function borrarDiaCierre_get() {
		if (!$this->get(DiaCierre::FIELD_ID_DIA_CIERRE)) {
			$msg = "Error borrando dia cierre";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idDiaCierre = $this->get(DiaCierre::FIELD_ID_DIA_CIERRE);

		$this->Locales_model->borrarDiaCierreLocal($idDiaCierre);

		$msg = "Dia cierre borrado correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

}