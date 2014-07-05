<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/usuario/usuario.php';
require_once APPPATH . '/libraries/menus/tipoMenu.php';

class ReservaLocal{
	
	const FIELD_ID_RESERVA = "idReserva";
	const FIELD_NUMERO_PERSONAS = "numeroPersonas";
	const FIELD_FECHA = "fecha";
	const FIELD_HORA_INICIO = "horaInicio";
	const FIELD_HORA_FIN = "horaFin";
	const FIELD_ESTADO = "estado";
	const FIELD_MOTIVO = "motivo";
	const FIELD_OBSERVACIONES = "observaciones";
	const FIELD_NOMBRE_EMISOR = "nombreEmisor";
	const FIELD_RESERVA = "reserva";
	const FIELD_RESERVAS = "reservas";

	var $idReserva;
	var $usuario;
	var $numeroPersonas;
	var $fecha;
	var $tipoMenu;
	var $horaInicio;
	var $horaFin;
	var $estado;
	var $motivo;
	var $observaciones;
	var $nombreEmisor;
	var $mesas;

	public function __construct( $idReserva,
						 Usuario $usuario,
						 $numeroPersonas,
						 $fecha,
						 TipoMenu $tipoMenu,
						 $horaInicio,
						 $horaFin,
						 $estado,
						 $motivo,
						 $observaciones,
						 $nombreEmisor,
						 $mesas = array()) {
		$this->idReserva = $idReserva;
		$this->usuario = $usuario;
		$this->numeroPersonas = $numeroPersonas;
		$this->fecha = $fecha;
		$this->tipoMenu = $tipoMenu;
		$this->horaInicio = $horaInicio;
		$this->horaFin = $horaFin;
		$this->estado = $estado;
		$this->motivo = $motivo;
		$this->observaciones = $observaciones;
		$this->nombreEmisor = $nombreEmisor;
		$this->mesas = $mesas;
	}
	
	public static function withID($idReserva) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('reservas/Reservas_model');
		$datosReserva = $CI->Reservas_model->obtenerDatosReservaLocal($idReserva)->row();
		
		$usuario = Usuario::withID($datosReserva->id_usuario);
		$tipoMenu = TipoMenu::withID($datosReserva->id_tipo_menu);
		
		$datosMesas = $CI->Reservas_model->obtenerMesasReserva($idReserva)->result();
		
		$mesas = array();
		
		foreach ($datosMesas as $datosMesa){
			$mesas[] = new Mesa($datosMesa->id_mesa_local
				,$datosMesa->nombre_mesa
				,$datosMesa->capacidad);
		}
	
		$instance = new self( $idReserva,
						 $usuario,
						 $datosReserva->numero_personas,
						 $datosReserva->fecha,
						 $tipoMenu,
						 $datosReserva->hora_inicio,
						 $datosReserva->hora_fin,
						 $datosReserva->estado,
						 $datosReserva->motivo,
						 $datosReserva->observaciones,
						 $datosReserva->nombre_emisor,
						 $mesas);
	
		return $instance;
	}

}