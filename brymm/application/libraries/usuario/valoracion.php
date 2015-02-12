<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ValoracionUsuario {

	const FIELD_ID_VALORACION = "idValoracion";
	const FIELD_OBSERVACIONES = "observaciones";
	const FIELD_NOTA = "nota";
	const FIELD_FECHA = "fecha";
	const FIELD_VALORACIONES = "valoraciones";
	const FIELD_VALORACION = "valoracion";

	public $idValoracion;
	public $usuario;
	public $local;
	public $nota;
	public $observaciones;
	public $fecha;

	public function __construct( $idValoracion,
			Usuario $usuario,
			Local $local,
			$nota,
			$observaciones,
			$fecha) {

		$this->idValoracion = $idValoracion;
		$this->usuario = $usuario;
		$this->local = $local;
		$this->nota = $nota;
		$this->observaciones = $observaciones;
		$this->fecha = $fecha;
	}

	public static function withID($idValoracionUsuario) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('valoraciones/valoraciones_model');
		$datosValoracion = $CI->valoraciones_model->obtenerValoracionUsuario($idValoracionUsuario);

		if ($datosValoracion->num_rows()){
			$datosValoracion = $datosValoracion->row();
			$usuario = Usuario::withID($datosValoracion->id_usuario);
			$local = Local::withID($datosValoracion->id_local);
			$instance = new self(
					$datosValoracion->id_usuario,
					$usuario,
					$local,
					$datosValoracion->nota,
					$datosValoracion->observaciones,
					$datosValoracion->fecha);
		}

		return $instance;
	}


}
