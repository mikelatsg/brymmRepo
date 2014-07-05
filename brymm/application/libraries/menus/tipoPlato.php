<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class TipoPlato{
	const FIELD_ID_TIPO_PLATO = "idTipoPlato";
	const FIELD_DESCRIPCION = "descripcion";
	const FIELD_TIPO_PLATO = "tipoPlato";
	const FIELD_TIPOS_PLATO = "tiposPlato";

	var $idTipoPlato;
	var $descripcion;

	public function __construct($idTipoPlato, $descripcion) {
		$this->idTipoPlato = $idTipoPlato;
		$this->descripcion= $descripcion;
	}

	public static function withID($idTipoPlato) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('menus/Menus_model');
		$datosTipoPlato = $CI->Menus_model->obtenerTipoPlato($idTipoPlato)->row();

		$instance = new self( $datosTipoPlato->id_tipo_plato
				,$datosTipoPlato->descripcion);

		return $instance;
	}
}