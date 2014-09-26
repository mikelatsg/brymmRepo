<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MenuComanda{
	const FIELD_MENU_LOCAL = "menuLocal";
	const FIELD_PLATOS_COMANDA = "platosComanda";
	const FIELD_MENU_COMANDA = "menuComanda";
	const FIELD_MENUS_COMANDA = "menusComanda";

	var $menuLocal;
	var $platosComanda;

	public function __construct(Menu $menuLocal,$platosComanda = array() ) {
		$this->menuLocal = $menuLocal;
		$this->platosComanda= $platosComanda;
	}

	public static function withID($idDetalleComanda) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('comandas/Comandas_model');
		$datosDetalleComanda = $CI->Comandas_model->obtenerDetalleComanda($idDetalleComanda)->row();

		$menu = Menu::withID($datosDetalleComanda->id_articulo);

		$platosComanda = $CI->Comandas_model->obtenerPlatosComandaObject($idDetalleComanda);

		$instance = new self( $menu
				,$platosComanda);

		return $instance;
	}
}