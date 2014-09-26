<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Menu{
	const FIELD_ID_MENU = "idMenu";
	const FIELD_PRECIO = "precio";
	const FIELD_NOMBRE = "nombre";
	const FIELD_CARTA = "carta";
	const FIELD_MENU = "menu";
	const FIELD_MENUS = "menus";

	var $idMenu;
	var $nombre;
	var $precio;
	var $carta;
	var $tipoMenu;

	public function __construct($idMenu, $nombre,$precio,$carta,TipoMenu $tipoMenu) {
		$this->idMenu = $idMenu;
		$this->nombre = $nombre;
		$this->precio = $precio;
		$this->carta = $carta;
		$this->tipoMenu = $tipoMenu;
	}

	public static function withID($idMenu) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('menus/menus_model');		
		$datosMenu = $CI->Menus_model->obtenerTipoMenuLocal($idMenu)->row();

		$tipoMenu = TipoMenu::withID($datosMenu->id_tipo_menu);

		$instance = new self( $datosMenu->id_tipo_menu_local
				,$datosMenu->nombre_menu
				,$datosMenu->precio_menu
				,$datosMenu->es_carta
				,$tipoMenu);

		return $instance;
	}
}