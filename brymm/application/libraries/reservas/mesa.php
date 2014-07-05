<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Mesa{
	const FIELD_ID_MESA = "idMesa";
	const FIELD_NOMBRE = "nombre";
	const FIELD_CAPACIDAD = "capacidad";
	const FIELD_MESA = "mesa";
	const FIELD_MESAS = "mesas";

	var $idMesa;
	var $capacidad;
	var $nombre;

	public function __construct($idMesa, $nombre,$capacidad) {
		$this->idMesa = $idMesa;
		$this->nombre = $nombre;
		$this->capacidad = $capacidad;
	}

	public static function withID($idMesa) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('reservas/Reservas_model');
		$datosMesa = $CI->Reservas_model->obtenerMesaLocal($idMesa)->row();

		$instance = new self( $datosMesa->id_mesa_local
				,$datosMesa->nombre_mesa
				,$datosMesa->capacidad);

		return $instance;
	}
}