<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/horarios/diaSemana.php';

class HorarioPedido{
	const FIELD_HORARIOS_PEDIDO = "horariosPedido";
	const FIELD_HORARIO_PEDIDO = "horarioPedido";
	const FIELD_ID_HORARIO_PEDIDO = "idHorarioPedido";
	const FIELD_DIA = "dia";
	const FIELD_HORA_INICIO = "horaInicio";
	const FIELD_HORA_FIN = "horaFin";

	public $idHorarioPedido;
	public $dia;
	public $horaInicio;
	public $horaFin;

	public function __construct($idHorarioPedido,
			DiaSemana $dia,
			$horaInicio,
			$horaFin) {
		$this->idHorarioPedido = $idHorarioPedido;
		$this->dia = $dia;
		$this->horaInicio = $horaInicio;
		$this->horaFin = $horaFin;
	}

	public static function withID($idHorarioPedido) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('locales/Locales_model');
		$datosHorarioPedido = $CI->Locales_model->obtenerHorarioPedido($idHorarioPedido)->row();

		$diaSemana = DiaSemana::withID($datosHorarioPedido->id_dia);
		
		$instance = new self( $datosHorarioPedido->id_horario_pedido
				,$diaSemana
				,$datosHorarioPedido->hora_inicio
				,$datosHorarioPedido->hora_fin);

		return $instance;
	}
}