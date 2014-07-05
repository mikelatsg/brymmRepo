<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/articulos/tipoArticulo.php';
require_once APPPATH . '/libraries/usuario/Direccion.php';
require_once APPPATH . '/libraries/usuario/usuario.php';

class Pedido{
	const FIELD_PEDIDO = "pedido";
	const FIELD_ID_PEDIDO = "idPedido";
	const FIELD_ID_ESTADO = "idEstado";
	const FIELD_ESTADO = "estado";
	const FIELD_FECHA_ENTREGA = "fechaEntrega";
	const FIELD_MOTIVO_RECHAZO = "motivoRechazo";
	
	public $idPedido;
	public $usuario;
	public $fecha;
	public $fechaEntrega;
	public $estado;
	public $precio;
	public $observaciones;
	public $direccion;
	public $motivoRechazo;
	public $articulos;

	public function __construct(  $idPedido,
			Usuario $usuario,
			$fecha,
			$fechaEntrega,
			$estado,
			$precio,
			$observaciones,
			Direccion $direccion = null,
			$motivoRechazo,
			$articulos = array()) {

		$this->idPedido = $idPedido;
		$this->usuario = $usuario;
		$this->fecha = $fecha;
		$this->fechaEntrega = $fechaEntrega;
		$this->estado = $estado;
		$this->precio = $precio;
		$this->observaciones = $observaciones;
		$this->direccion = $direccion;
		$this->motivoRechazo = $motivoRechazo;
		$this->articulos = $articulos;
	}
}