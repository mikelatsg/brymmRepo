<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class PlatoComanda{
	const FIELD_ID_COMANDA_MENU = "idComandaMenu";
	const FIELD_ESTADO = "estado";
	const FIELD_CANTIDAD = "cantidad";
	const FIELD_PLATO_COMANDA = "platoComanda";
	const FIELD_PLATOS_COMANDA = "platosComanda";

	var $idComandaMenu;
	var $estado;
	var $cantidad;
	var $plato;

	public function __construct($idComandaMenu, $estado , $cantidad, Plato $plato) {
		$this->idComandaMenu = $idComandaMenu;
		$this->estado= $estado;
		$this->cantidad= $cantidad;
		$this->plato = $plato;
	}

	public static function withID($idComandaMenu) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('comandas/Comandas_model');
		$datosPlatoComanda = $CI->Comandas_model->obtenerPlatoComanda($idComandaMenu)->row();

		$plato = Plato::withID($datosPlatoComanda->id_plato);
			
		$instance = new self($datosPlatoComanda->id_comanda_menu,$datosPlatoComanda->estado,
				$datosPlatoComanda->cantidad,$plato);

		return $instance;
	}
}