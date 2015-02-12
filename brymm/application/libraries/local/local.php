<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Local {

	const FIELD_ID_USUARIO = "idUsuario";
	const FIELD_NICK = "nick";
	const FIELD_NOMBRE = "nombre";
	const FIELD_APELLIDO = "apelllido";
	const FIELD_EMAIL = "email";
	const FIELD_LOCALIDAD = "localidad";
	const FIELD_PROVINCIA = "provincia";
	const FIELD_COD_POSTAL = "codPostal";
	const FIELD_TELEFONO = "telefono";
	const FIELD_USUARIO = "usuario";

	public $idLocal;
	public $nombre;
	public $tipoComida;
	public $localidad;
	public $provincia;
	public $direccion;
	public $codPostal;
	public $telefono;
	public $email;
	public $estado;

	public function __construct( $idLocal,
			$nombre,
			TipoComida $tipoComida,
			$localidad,
			$provincia,
			$direccion,
			$codPostal,
			$telefono,
			$email,
			$estado) {

		$this->idLocal = $idLocal;
		$this->nombre = $nombre;
		$this->tipoComida = $tipoComida;
		$this->localidad =$localidad;
		$this->provincia = $provincia ;
		$this->direccion =$direccion;
		$this->codPostal =$codPostal;
		$this->telefono =$telefono;
		$this->email =$email;
		$this->estado =$estado;

	}

	public static function withID($idLocal) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('locales/locales_model');
		$datosLocal = $CI->locales_model->obtenerDatosLocal($idLocal);

		if ($datosLocal->num_rows()){
			$datosLocal = $datosLocal->row();
			$tipoComida = TipoComida::withID($datosLocal->id_tipo_comida);
			$instance = new self(
					$datosLocal->id_local,
					$datosLocal->nombre,
					$tipoComida,
					$datosLocal->localidad,
					$datosLocal->provincia,
					$datosLocal->direccion,
					$datosLocal->cod_postal,
					$datosLocal->telefono,
					$datosLocal->email,
					$datosLocal->estado_local);
		}

		return $instance;
	}


}
