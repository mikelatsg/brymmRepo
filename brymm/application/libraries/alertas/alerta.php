<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Alerta{
	
	const FIELD_ALERTA = "alerta";
	const FIELD_ALERTAS = "alertas";
	const FIELD_LOCAL = "local";
	const FIELD_USUARIO = "usuario";
	const FIELD_CAMARERO = "camarero";
	const ACTUALIZAR = "ACT";
	const BORRAR = "BOR";
	
	public $crearNotificacion;
	public $tipoObjeto;
	public $objeto;
	public $accion;

	public function __construct( $crearNotificacion,
			$tipoObjeto,$objeto,$accion = Alerta::ACTUALIZAR) {
		$this->crearNotificacion = $crearNotificacion;
		$this->tipoObjeto = $tipoObjeto;
		$this->objeto = $objeto;		
		$this->accion = $accion;
	}
}