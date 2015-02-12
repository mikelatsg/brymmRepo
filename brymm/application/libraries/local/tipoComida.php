<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class TipoComida{
	
	const FIELD_ID_TIPO_COMIDA = "idTipoComida";
	const FIELD_TIPO_COMIDA= "tipoComida";
	
	public $idTipoComida;
	public $tipoComida;
	public $descripcion;	

	public function __construct( $idTipoComida,
			$tipoComida,$descripcion) {
		$this->idTipoComida = $idTipoComida;
		$this->tipoComida = $tipoComida;
		$this->descripcion = $descripcion;		
	}

	public static function withID($idTipoComida) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('locales/locales_model');
		$datosTipoComida = $CI->locales_model->obtenerTipoComida($idTipoComida)->row();

		$instance = new self( $datosTipoComida->id_tipo_comida,
				$datosTipoComida->tipo_comida,
				$datosTipoComida->descripcion);

		return $instance;
	}
}