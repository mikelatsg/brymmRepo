<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Camarero{
	const FIELD_ID_CAMARERO = "idCamarero";
	const FIELD_NOMBRE = "nombre";
	const FIELD_ACTIVO = "activo";
	const FIELD_CONTROL_TOTAL = "controlTotal";
	const FIELD_CAMARERO = "camarero";
	const FIELD_CAMAREROS = "camareros";

	var $idCamarero;
	var $nombre;
	var $activo;
	var $controlTotal;

	public function __construct($idCamarero, $nombre,$activo,$controlTotal) {
		$this->idCamarero = $idCamarero;
		$this->nombre= $nombre;
		$this->activo= $activo;
		$this->controlTotal= $controlTotal;
	}

	public static function withID($idCamarero) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('menus/Camareros_model');
		$datosCamarero = $CI->Menus_model->obtenerDatosCamarero2($idCamarero)->row();

		$instance = new self( $datosCamarero->id_camarero
				,$datosCamarero->nombre
				,$datosCamarero->activo
				,$datosCamarero->control_total);

		return $instance;
	}
}