<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class DetalleComanda{
	const FIELD_ID_DETALLE_COMANDA = "idDetalleComanda";
	const FIELD_CANTIDAD = "cantidad";
	const FIELD_PRECIO = "precio";
	const FIELD_ESTADO = "estado";
	const FIELD_DETALLE_COMANDA = "detalleComanda";
	const FIELD_DETALLES_COMANDA = "detallesComanda";

	var $idDetalleComanda;
	var $tipoComanda;
	var $cantidad;
	var $precio;
	var $estado;
	var $articuloCantidad;
	var $menuComanda;

	public function __construct( $idDetalleComanda,
			TipoComanda $tipoComanda,
			$cantidad,
			$precio,
			$estado,
			$articuloCantidad,
			MenuComanda $menuComanda = null ) {
		$this->idDetalleComanda = $idDetalleComanda;
		$this->tipoComanda = $tipoComanda;
		$this->cantidad = $cantidad;
		$this->precio = $precio;
		$this->estado = $estado;
		$this->articuloCantidad = $articuloCantidad;
		$this->menuComanda = $menuComanda;
	}

	public static function withID($idDetalleComanda) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('comandas/Comandas_model');
		$CI->load->model('articulos/Articulos_model');
		$datosDetalleComanda = $CI->Comandas_model->obtenerDetalleComanda($idDetalleComanda)->row();

		$menuComanda = null;
		$articuloCantidad = null;

		//Compruebo el tipo de comanda
		$tipoComanda = TipoComanda::withID($datosDetalleComanda->id_tipo_comanda);

		switch ($tipoComanda->idTipoComanda){
			case 1:
				$articuloCantidad = $CI->Articulos_model->obtenerArticuloLocalObject
				($datosDetalleComanda->id_articulo);
				break;
			case 2:
				$ingredientes =
				$CI->Comandas_model->obtenerListaIngredientesComandaPerObject
				($datosDetalleComanda->id_detalle_comanda);

				$tipoArticulo = TipoArticulo::withID($datosDetalleComanda->id_articulo);

				$articuloCantidad = new ArticuloCantidad(0,
						$tipoArticulo,
						'Articulo per',
						'Articulo per',
						$datosDetalleComanda->precio,
						0,
						$datosDetalleComanda->cantidad,
						$ingredientes);
				break;
			case 3:
				$menuComanda = MenuComanda::withID($datosDetalleComanda->id_detalle_comanda);
				break;
			case 4:
				$menuComanda = MenuComanda::withID($datosDetalleComanda->id_detalle_comanda);
				break;
		}


		$instance = new self( $datosDetalleComanda->id_detalle_comanda,
				$tipoComanda,
				$datosDetalleComanda->cantidad,
				$datosDetalleComanda->precio,
				$datosDetalleComanda->estado,
				$articuloCantidad,
				$menuComanda);

		return $instance;
	}
}