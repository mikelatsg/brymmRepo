<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class DiaSemana{
	const FIELD_ID_DIA = "idDia";
	const FIELD_DIA = "dia";
	const FIELD_DIA_SEMANA = "diaSemana";
	const FIELD_DIAS_SEMANA = "diasSemana";

	var $idDia;
	var $dia;

	public function __construct($idDia, $dia) {
		$this->idDia = $idDia;
		$this->dia = $dia;
	}

	public static function withID($idDia) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('varios/Varios_model');
		$datosDia = $CI->Varios_model->obtenerDiaSemana($idDia)->row();

		$instance = new self( $datosDia->id_dia
				,$datosDia->dia);

		return $instance;
	}
}