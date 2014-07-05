<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/articulos/tipoArticulo.php';

class TipoArticuloLocal extends TipoArticulo{
	public $idTipoArticuloLocal;
	public $precio;
	public $personalizar;

	public function __construct( $idTipoArticulo,
			$tipoArticulo,$descripcion,$precio,$personalizar,$idTipoArticuloLocal) {
		parent::__construct($idTipoArticulo,
				$tipoArticulo,
				$descripcion);
		$this->precio = $precio;
		$this->personalizar = $personalizar;
		$this->idTipoArticuloLocal = $idTipoArticuloLocal;
	}

	public static function withID($idTipoArticuloLocal) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('articulos/articulos_model');
		$datosTipoArticulo = $CI->articulos_model->obtenerTipoArticuloLocal($idTipoArticuloLocal)->row();

		$instance = new self( $datosTipoArticulo->id_tipo_articulo,
				$datosTipoArticulo->tipo_articulo,
				$datosTipoArticulo->descripcion,
				$datosTipoArticulo->precio,
				$datosTipoArticulo->personalizar,
				$idTipoArticuloLocal);

		return $instance;
	}
}