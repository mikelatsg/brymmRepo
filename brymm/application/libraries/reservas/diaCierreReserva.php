<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class DiaCierreReserva{
	const FIELD_ID_DIA_CIERRE_RESERVA = "idDiaCierreReserva";
	const FIELD_FECHA = "fecha";
	const FIELD_DIA_CIERRE_RESERVA = "diaCierreReserva";
	const FIELD_DIAS_CIERRE_RESERVA = "diasCierreReserva";

	var $idDiaCierreReserva;
	var $fecha;
	var $tipoMenu;

	public function __construct($idDiaCierreReserva, $fecha,TipoMenu $tipoMenu) {
		$this->idDiaCierreReserva = $idDiaCierreReserva;
		$this->fecha= $fecha;
		$this->tipoMenu = $tipoMenu;
	}

	public static function withID($idDiaCierreReserva) {
		$CI;
		$CI = & get_instance();
		$CI->load->model('reservas/reservas_model');
		$datosDia = $CI->Reservas_model->obtenerReservaDiaCierre($idDiaCierreReserva)->row();

		$tipoMenu = TipoMenu::withID($datosDia->id_tipo_menu);

		$instance = new self( $datosDia->id_reserva_dia_cerrado
				,$datosDia->dia,$tipoMenu);

		return $instance;
	}
}