<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/articulos/tipoArticulo.php';

class Articulo{
	const FIELD_ARTICULO = "articulo";
	const FIELD_ID_ARTICULO = "idArticulo";
	const FIELD_VALIDO_PEDIDOS = "validoPedidos";
	const FIELD_INGREDIENTES = "ingredientes";
	const FIELD_DESCRIPCION = "descripcion";
	const FIELD_PRECIO = "precio";
	const FIELD_TIPO_ARTICULO = "tipoArticulo";
	const FIELD_NOMBRE = "nombre";
	
	var $idArticulo;
	var $tipoArticulo;
	var $nombre;
	var $descripcion;
	var $precio;
	var $validoPedidos;
	var $ingredientes = array();

	public function __construct( $idArticulo,
			TipoArticulo $tipoArticulo,
			$nombre,
			$descripcion,
			$precio,
			$validoPedidos,
			$ingredientes = array()) {

		$this->idArticulo = $idArticulo;
		$this->tipoArticulo = $tipoArticulo;
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->precio = $precio;
		$this->validoPedidos = $validoPedidos;
		$this->ingredientes = $ingredientes;
	}
}