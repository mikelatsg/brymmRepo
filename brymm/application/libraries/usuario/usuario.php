<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Usuario {

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

	public $idUsuario;
	public $nick;
	public $nombre;
	public $apellido;
	public $email;
	public $localidad;
	public $provincia;
	public $codPostal;
	public $telefono;

	public function __construct( $idUsuario,
			$nick,
			$nombre,
			$apellido,
			$email,
			$localidad,
			$provincia,
			$codPostal,
			$telefono='') {

		$this->idUsuario = $idUsuario;
		$this->nick = $nick;
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->email = $email;
		$this->localidad = $localidad;
		$this->provincia = $provincia;
		$this->codPostal = $codPostal;
		$this->telefono = $telefono;

	}

	public static function withID($idUsuario) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('usuarios/usuarios_model');
		$datosUsuario = $CI->usuarios_model->obtenerUsuario($idUsuario);

		if ($datosUsuario->num_rows()){
			$datosUsuario = $datosUsuario->row();
			$instance = new self(
					$datosUsuario->id_usuario,
					$datosUsuario->nick,
					$datosUsuario->nombre,
					$datosUsuario->apellido,
					$datosUsuario->email,
					$datosUsuario->localidad,
					$datosUsuario->provincia,
					$datosUsuario->cod_postal,
					$datosUsuario->telefono);
		}else{
			$instance = new self(
					0,
					"",
					"",
					"",
					"",
					"",
					"",
					0,
					"");
		}

		return $instance;
	}


}
