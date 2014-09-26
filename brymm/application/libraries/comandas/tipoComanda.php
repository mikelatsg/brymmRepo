<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class TipoComanda{
	const FIELD_ID_TIPO_COMANDA = "idTipoComanda";
	const FIELD_DESCRIPCION = "descripcion";
	const FIELD_TIPO_COMANDA = "tipoComanda";
	const FIELD_TIPOS_COMANDA = "tiposComanda";

	var $idTipoComanda;
	var $descripcion;

	public function __construct($idTipoComanda, $descripcion) {
		$this->idTipoComanda = $idTipoComanda;
		$this->descripcion= $descripcion;
	}

	public static function withID($idTipoComanda) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('comandas/Comandas_model');
		$datosTipoComanda = $CI->Comandas_model->obtenerTipoComanda($idTipoComanda)->row();

		$instance = new self( $datosTipoComanda->id_tipo_comanda
				,$datosTipoComanda->tipo_comanda);

		return $instance;
	}
}