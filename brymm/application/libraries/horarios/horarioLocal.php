<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/horarios/diaSemana.php';

class HorarioLocal{
	const FIELD_HORARIOS_LOCAL = "horariosLocal";
	const FIELD_HORARIO_LOCAL = "horarioLocal";
	const FIELD_ID_HORARIO_LOCAL = "idHorarioLocal";
	const FIELD_DIA = "dia";
	const FIELD_HORA_INICIO = "horaInicio";
	const FIELD_HORA_FIN = "horaFin";

	public $idHorarioLocal;
	public $dia;
	public $horaInicio;
	public $horaFin;

	public function __construct($idHorarioLocal,
			DiaSemana $dia,
			$horaInicio,
			$horaFin) {
		$this->idHorarioLocal = $idHorarioLocal;
		$this->dia = $dia;
		$this->horaInicio = $horaInicio;
		$this->horaFin = $horaFin;
	}

	public static function withID($idHorarioLocal) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('locales/Locales_model');
		$datosHorarioLocal = $CI->Locales_model->obtenerHorarioLocalId($idHorarioLocal)->row();

		$diaSemana = DiaSemana::withID($datosHorarioLocal->id_dia);
		
		$instance = new self( $datosHorarioLocal->id_horario_local
				,$diaSemana
				,$datosHorarioLocal->hora_inicio
				,$datosHorarioLocal->hora_fin);

		return $instance;
	}
}