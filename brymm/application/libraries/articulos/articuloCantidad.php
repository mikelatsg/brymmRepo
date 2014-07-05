<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/articulos/articulo.php';

class ArticuloCantidad extends Articulo{
	public $cantidad;

	public function __construct( $idArticulo,
			TipoArticulo $tipoArticulo,
			$nombre,
			$descripcion,
			$precio,
			$validoPedidos,
			$cantidad,
			$ingredientes = array()) {

		parent::__construct( $idArticulo,
				$tipoArticulo,
				$nombre,
				$descripcion,
				$precio,
				$validoPedidos,
				$ingredientes);
			
		$this->cantidad = $cantidad;
	}
}