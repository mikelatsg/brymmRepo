<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Comanda{
	const FIELD_ID_COMANDA = "idComanda";
	const FIELD_DESTINO = "destino";
	const FIELD_CAMARERO = "camarero";
	const FIELD_ESTADO = "estado";
	const FIELD_PRECIO = "precio";
	const FIELD_OBSERVACIONES = "observaciones";
	const FIELD_FECHA = "fecha";
	const FIELD_COMANDA = "comanda";
	const FIELD_COMANDAS = "comandas";

	var $idComanda;
	var $destino;
	var $camarero;
	var $estado;
	var $precio;
	var $mesa;
	var $fecha;
	var $observaciones;
	var $detallesComanda;

	public function __construct( $idComanda,
			$destino,
			Camarero $camarero,
			$estado,
			$precio,
			Mesa $mesa,
			$fecha,
			$observaciones,
			$detallesComanda = array()) {
		$this->idComanda = $idComanda;
		$this->destino = $destino;
		$this->camarero = $camarero;
		$this->estado = $estado;
		$this->precio = $precio;
		$this->mesa = $mesa;
		$this->fecha = $fecha;
		$this->observaciones = $observaciones;
		$this->detallesComanda = $detallesComanda;
	}

	public static function withID($idComanda) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('comandas/Comandas_model');
		$datosComanda = $CI->Comandas_model->obtenerDatosComanda($idComanda)->row();

		$detallesComanda = $CI->Comandas_model->obtenerDetallesComandaObject($idComanda);

		$mesa = null;
		//Si es una mesa la obtengo
		if ($datosComanda->id_mesa > 0 ){
			$mesa = Mesa::withID($datosComanda->id_mesa);
		}

		$camarero = Camarero::withID($datosComanda->id_camarero);

		$instance = new self( $idComanda,
				$datosComanda->destino,
				$camarero,
				$datosComanda->estado,
				$datosComanda->precio,
				$mesa,
				$datosComanda->fecha_alta,
				$datosComanda->observaciones,
				$detallesComanda);

		return $instance;
	}
}