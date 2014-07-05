<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class TipoMenu{
	const FIELD_ID_TIPO_MENU = "idTipoMenu";
	const FIELD_DESCRIPCION = "descripcion";
	const FIELD_TIPO_MENU = "tipoMenu";
	const FIELD_TIPOS_MENU = "tiposMenu";

	var $idTipoMenu;
	var $descripcion;

	public function __construct($idTipoMenu, $descripcion) {
		$this->idTipoMenu = $idTipoMenu;
		$this->descripcion= $descripcion;
	}

	public static function withID($idTipoMenu) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('menus/Menus_model');
		$datosTipoMenu = $CI->Menus_model->obtenerTipoMenu($idTipoMenu)->row();

		$instance = new self( $datosTipoMenu->id_tipo_menu
				,$datosTipoMenu->descripcion);

		return $instance;
	}
}