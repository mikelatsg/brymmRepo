<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ingrediente{
	const FIELD_ID_INGREDIENTE = "idIngrediente";
	const FIELD_DESCRIPCION = "descripcion";
	const FIELD_NOMBRE = "nombre";
	const FIELD_PRECIO = "precio";
	const FIELD_INGREDIENTE = "ingrediente";
	const FIELD_INGREDIENTES = "ingredientes";
	
	var $idIngrediente;
	var $nombre;
	var $descripcion;
	var $precio;

	public function __construct($idIngrediente, $nombre,$descripcion,$precio) {
		$this->idIngrediente = $idIngrediente;
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->precio = $precio;
	}

	public static function withID($idIngrediente) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('ingredientes/ingredientes_model');
		$datosIngrediente = $CI->ingredientes_model->obtenerIngrediente($idIngrediente)->row();

		$instance = new self( $datosIngrediente->id_ingrediente
				,$datosIngrediente->ingrediente
				,$datosIngrediente->descripcion
				,$datosIngrediente->precio);

		return $instance;
	}
}