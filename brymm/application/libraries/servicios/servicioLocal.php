<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/servicios/tipoServicio.php';

class ServicioLocal{
	const FIELD_SERVICIO_LOCAL = "servicioLocal";
	const FIELD_ID_SERVICIO = "idServicio";
	const FIELD_ACTIVO = "activo";
	const FIELD_IMPORTE_MINIMO = "importeMinimo";
	const FIELD_PRECIO = "precio";

	public $idServicio;
	public $tipoServicio;
	public $activo;
	public $importeMinimo;
	public $precio;

	public function __construct(  $idServicio,
			TipoServicio $tipoServicio,
			$activo,$importeMinimo,$precio) {

		$this->idServicio = $idServicio;
		$this->tipoServicio = $tipoServicio;
		$this->activo = $activo;
		$this->importeMinimo = $importeMinimo;
		$this->precio = $precio;

	}
	
}