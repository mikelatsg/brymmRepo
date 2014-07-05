<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class DiaCierre{
	const FIELD_ID_DIA_CIERRE = "idDiaCierre";
	const FIELD_FECHA = "fecha";
	const FIELD_DIA_CIERRE = "diaCierre";
	const FIELD_DIAS_CIERRE = "diasCierre";

	var $idDiaCierre;
	var $fecha;

	public function __construct($idDiaCierre, $fecha) {
		$this->idDiaCierre = $idDiaCierre;
		$this->fecha= $fecha;
	}

	public static function withID($idDiaCierre) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('locales/Locales_model');
		$datosDia = $CI->Locales_model->obtenerDiaCierreLocal($idDiaCierre)->row();

		$instance = new self( $datosDia->id_dia_cierre_local
				,$datosDia->fecha);

		return $instance;
	}
}