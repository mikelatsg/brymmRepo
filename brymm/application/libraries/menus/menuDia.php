<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MenuDia{
	const FIELD_MENU_DIA = "menuDia";
	const FIELD_MENUS_DIA = "menusDia";
	const FIELD_FECHA = "fecha";
	const FIELD_ID_MENU_DIA = "idMenuDia";

	var $menu;
	var $platos;
	var $fecha;
	var $idMenuDia;

	public function __construct($idMenuDia, Menu $menu,$fecha,$platos = array()) {
		$this->idMenuDia = $idMenuDia;
		$this->menu = $menu;
		$this->platos = $platos;
		$this->fecha = $fecha;
	}

	public static function withID($idMenuDia) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('menus/menus_model');
		$datosMenu = $CI->menus_model->obtenerDatosMenuDia($idMenuDia)->row();

		$menu = Menu::withID($datosMenu->id_tipo_menu_local);

		$platos = $CI->menus_model->obtenerPlatosMenuDiaObject($idMenuDia);

		$instance = new self( $datosMenu->id_menu_local
				,$menu
				,$datosMenu->fecha_menu
				,$platos);

		return $instance;
	}
}