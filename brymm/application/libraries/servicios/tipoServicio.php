<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class TipoServicio{
	const FIELD_TIPO_SERVICIO = "tipoServicio";
	const FIELD_ID_TIPO_SERVICIO = "idTipoServicio";
	const FIELD_SERVICIO = "servicio";
	const FIELD_ESTADO = "descripcion";
	const FIELD_MOSTRAR_BUSCADOR = "mostrarBuscador";

	public $idTipoServicio;
	public $servicio;
	public $descripcion;
	public $mostrarBuscador;

	public function __construct(  $idTipoServicio,
			$servicio,
			$descripcion,
			$mostrarBuscador) {

		$this->idTipoServicio = $idTipoServicio;
		$this->servicio = $servicio;
		$this->descripcion = $descripcion;
		$this->mostrarBuscador = $mostrarBuscador;
		
	}
	
	public static function withID($idTipoServicio) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('servicios/Servicios_model');
		$instance = $CI->Servicios_model->obtenerTipoServicioObject($idTipoServicio);	
	
		return $instance;
	}
}