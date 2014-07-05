<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class TipoArticulo{
	public $idTipoArticulo;
	public $tipoArticulo;
	public $descripcion;	

	public function __construct( $idTipoArticulo,
			$tipoArticulo,$descripcion) {
		$this->idTipoArticulo = $idTipoArticulo;
		$this->tipoArticulo = $tipoArticulo;
		$this->descripcion = $descripcion;		
	}

	public static function withID($idTipoArticulo) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('articulos/articulos_model');
		$datosTipoArticulo = $CI->articulos_model->obtenerTipoArticulo($idTipoArticulo)->row();

		$instance = new self( $datosTipoArticulo->id_tipo_articulo,
				$datosTipoArticulo->tipo_articulo,
				$datosTipoArticulo->descripcion);

		return $instance;
	}
}