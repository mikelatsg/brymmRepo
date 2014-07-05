<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Plato{
	const FIELD_ID_PLATO = "idPlato";
	const FIELD_PRECIO = "precio";
	const FIELD_NOMBRE = "nombre";
	const FIELD_PLATO = "plato";
	const FIELD_PLATOS = "platos";

	var $idPlato;
	var $nombre;
	var $precio;
	var $tipoPlato;

	public function __construct($idPlato, $nombre,$precio,TipoPlato $tipoPlato) {
		$this->idPlato = $idPlato;
		$this->nombre = $nombre;
		$this->precio = $precio;
		$this->tipoPlato = $tipoPlato;
	}

	public static function withID($idPlato) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('menus/menus_model');
		$datosPlato = $CI->menus_model->obtenerPlatoLocal($idPlato)->row();

		$tipoPlato = TipoPlato::withID($datosPlato->id_tipo_plato);

		$instance = new self( $datosPlato->id_plato_local
				,$datosPlato->nombre
				,$datosPlato->precio
				,$tipoPlato);

		return $instance;
	}
}