<?php

require_once APPPATH . '/libraries/reservas/mesa.php';
require_once APPPATH . '/libraries/reservas/reservaLocal.php';

class Reservas_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	function insertarMesaLocal($nombreMesa, $capacidad, $idLocal) {

		$sql = "INSERT INTO mesas_local (nombre_mesa,capacidad,
				id_local,fecha_alta) VALUES (?,?,?,?)";

		$this->db->query($sql, array($nombreMesa, $capacidad
				, $idLocal, date('Y-m-d H:i:s')));

		$idMesa = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(27, $idLocal, $idMesa);

		return $idMesa;
	}

	function modificarMesaLocal($idMesaLocal,$nombreMesa,$capacidad){
		$sql = "UPDATE mesas_local SET nombre_mesa = ? ,capacidad = ?
				WHERE id_mesa_local = ?";
			
		$this->db->query($sql, array($nombreMesa, $capacidad
				, $idMesaLocal));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(27, $idLocal, $idMesaLocal);
	}

	function obtenerMesasLocal($idLocal) {

		$sql = "SELECT * FROM mesas_local WHERE id_local = ?";

		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function obtenerMesasLocalObject($idLocal) {

		$sql = "SELECT * FROM mesas_local WHERE id_local = ?";

		$result = $this->db->query($sql, array($idLocal))->result();
			
		$mesas = array();
			
		foreach ($result as $row){
			$mesas[] = Mesa::withID($row->id_mesa_local);
		}

		return $mesas;
	}

	function obtenerMesaLocal($idMesa) {

		$sql = "SELECT * FROM mesas_local WHERE id_mesa_local = ?";

		$result = $this->db->query($sql, array($idMesa));

		return $result;
	}

	function borrarMesaLocal($idMesaLocal) {

		//Obtengo el idLocal
		$idLocal = $this->obtenerMesaLocal($idMesaLocal)->row()->id_local;

		$sql = "DELETE FROM mesas_local WHERE id_mesa_local = ?";

		$this->db->query($sql, array($idMesaLocal));

		$sql = "DELETE FROM reserva_mesa WHERE id_mesa_local = ?";

		$this->db->query($sql, array($idMesaLocal));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(28, $idLocal, $idMesaLocal);
	}

	function comprobarNombreMesaLocal($idLocal, $nombreMesa) {

		$sql = "SELECT * FROM mesas_local WHERE id_local = ?
				AND nombre_mesa = ?";

		$result = $this->db->query($sql, array($idLocal, $nombreMesa));

		return $result;
	}

	function obtenerReservasUsuario($idUsuario) {

		$sql = "SELECT r.*, l.nombre nombreLocal FROM reservas r, locales l
				WHERE r.id_local = l.id_local
				AND id_usuario = ?
				ORDER BY r.fecha";

		$result = $this->db->query($sql, array($idUsuario));

		return $result;
	}

	function obtenerActualesReservasUsuario($idUsuario) {

		$sql = "SELECT r.*, l.nombre nombreLocal FROM reservas r, locales l
				WHERE r.id_local = l.id_local
				AND id_usuario = ?
				AND r.fecha >= ?
				ORDER BY r.fecha";

		$result = $this->db->query($sql, array($idUsuario, date('Y-m-d', strtotime(' -3 day'))));

		return $result;
	}

	function obtenerUltimasReservasUsuario($idUsuario, $numeroReservas = 5) {

		$sql = "SELECT r.*, l.nombre nombreLocal, tm.descripcion tipoMenu
				FROM reservas r, locales l,tipo_menu tm
				WHERE r.id_local = l.id_local
				AND r.id_tipo_menu = tm.id_tipo_menu
				AND id_usuario = ?
				ORDER BY r.fecha DESC
				LIMIT 0,?";

		$result = $this->db->query($sql, array($idUsuario, $numeroReservas));

		return $result;
	}

	function insertarReservaUsuario($idUsuario, $idLocal, $numeroPersonas
			, $fecha, $idTipoMenu, $horaInicio, $horaFin
			, $observaciones = '') {

		$ahora = new DateTime('NOW');

		$sql = "INSERT INTO reservas (id_usuario,id_local,
				numero_personas,fecha,id_tipo_menu,hora_inicio,hora_fin,fecha_alta,
				estado,observaciones) VALUES (?,?,?,?,?,?,?,?,?,?)";

		$this->db->query($sql, array($idUsuario, $idLocal, $numeroPersonas,
				$fecha->format('Y-m-d'), $idTipoMenu, $horaInicio, $horaFin
				, $ahora->format(DateTime::W3C), 'P', $observaciones));

		$idReserva = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(2, $idLocal, $idReserva);

		return $idReserva;
	}

	function insertarReservaLocal($idUsuario, $idLocal, $numeroPersonas
			, $fecha, $idTipoMenu, $horaInicio, $horaFin
			, $observaciones, $nombreEmisor, $mesas) {

		try {
			//Se inicia la transaccion
			$this->db->trans_begin();

			$ahora = new DateTime('NOW');

			$sql = "INSERT INTO reservas (id_usuario,id_local,
					numero_personas,fecha,id_tipo_menu,hora_inicio,hora_fin,fecha_alta,
					estado,observaciones,nombre_emisor)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)";

			$this->db->query($sql, array($idUsuario, $idLocal, $numeroPersonas,
					$fecha->format('Y-m-d'), $idTipoMenu, $horaInicio, $horaFin
					, $ahora->format(DateTime::W3C), 'AL', $observaciones, $nombreEmisor));

			$idReserva = $this->db->insert_id();


			if ($mesas) {
				foreach ($mesas as $mesa) {
					//Se inserta las mesas asignadas a la reserva
					$this->Reservas_model->insertarMesaReserva($mesa, $idReserva);
				}
			}
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return false;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();
		return true;
	}

	function insertarReservaLocal2( $idLocal, $numeroPersonas
			, $fecha, $idTipoMenu, $horaInicio, $horaFin
			, $observaciones, $nombreEmisor, $mesas) {

		try {
			//Se inicia la transaccion
			$this->db->trans_begin();

			$ahora = new DateTime('NOW');

			$sql = "INSERT INTO reservas (id_usuario,id_local,
					numero_personas,fecha,id_tipo_menu,hora_inicio,hora_fin,fecha_alta,
					estado,observaciones,nombre_emisor)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)";

			$this->db->query($sql, array(0, $idLocal, $numeroPersonas,
					$fecha->format('Y-m-d'), $idTipoMenu, $horaInicio, $horaFin
					, $ahora->format(DateTime::W3C), 'AL', $observaciones, $nombreEmisor));

			$idReserva = $this->db->insert_id();


			if ($mesas) {
				foreach ($mesas as $mesa) {
					//Se inserta las mesas asignadas a la reserva
					$this->Reservas_model->insertarMesaReserva($mesa[Mesa::FIELD_ID_MESA], $idReserva);
				}
			}
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return -1;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return -1;
		}
		$this->db->trans_commit();
		return $idReserva;
	}

	function modificarEstadoReserva($idReserva, $estado, $motivo = '') {
		$sql = "UPDATE reservas SET estado = ?, motivo = ?, fecha_actualizacion = ?
				WHERE id_reserva = ?";

		$this->db->query($sql, array($estado, $motivo, date('Y-m-d H:i:s'), $idReserva));

		/*
		 * Se inserta una alerta si se trata de una anulación de reserva
		* hecha por el usuario.
		*/
		if ($estado == 'AU') {
			$idLocal = $this->obtenerDatosReservaLocal($idReserva)->row()->id_local;

			//Se carga el modelo de alertas
			$this->load->model('alertas/Alertas_model');

			//Se inserta la alerta
			$this->Alertas_model->insertAlertaLocal
			(3, $idLocal, $idReserva);
		} else if ($estado == 'AL') {
			/*
			 * Alerta usuario cuando se acepta una reserva
			*/
			$idUsuario = $this->obtenerDatosReservaLocal($idReserva)->row()->id_usuario;

			//Se carga el modelo de alertas
			$this->load->model('alertas/Alertas_model');

			//Se inserta la alerta
			$this->Alertas_model->insertAlertaUsuario
			(8, $idUsuario, $idReserva);
		}else if ($estado == 'RL') {
			/*
			 * Alerta usuario cuando se rechaza una reserva por parte del local
			*/
			$idUsuario = $this->obtenerDatosReservaLocal($idReserva)->row()->id_usuario;

			//Se carga el modelo de alertas
			$this->load->model('alertas/Alertas_model');

			//Se inserta la alerta
			$this->Alertas_model->insertAlertaUsuario
			(9, $idUsuario, $idReserva);
		}
	}

	function obtenerReservasLocal($idLocal, $estado) {

		$sql = "SELECT r.*, u.nombre nombreUsuario,u.nick nick,u.apellido
				, tm.descripcion tipo_menu
				FROM reservas r
				LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario
				, tipo_menu tm
				WHERE r.id_tipo_menu = tm.id_tipo_menu
				AND id_local = ?
				AND r.fecha >= ?
				AND r.estado = ?
				ORDER BY r.fecha_actualizacion DESC ,r.fecha DESC";

		$result = $this->db->query($sql, array($idLocal
				, date('Y-m-d', strtotime(' -7 day')), $estado));

		return $result;
	}

	function obtenerReservasLocalObject($idLocal) {

		$sql = "SELECT r.*
				FROM reservas r
				WHERE r.id_local = ?
				AND r.fecha >= ?
				ORDER BY r.fecha_actualizacion DESC ,r.fecha DESC";

		$result = $this->db->query($sql, array($idLocal
				, date('Y-m-d', strtotime(' -7 day'))))->result();

		$reservas = array();

		foreach ($result as $row){
			$reservas[] = ReservaLocal::withID($row->id_reserva);
		}

		return $reservas;
	}

	function obtenerDatosReservaLocal($idReserva) {
		$sql = "SELECT r.*, u.nombre nombreUsuario,u.nick nick
				,u.apellido,tm.descripcion tipo_menu
				FROM reservas r
				LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario
				, tipo_menu tm
				WHERE r.id_tipo_menu = tm.id_tipo_menu
				AND id_reserva = ?";

		$result = $this->db->query($sql, array($idReserva));

		return $result;
	}

	function obtenerDatosReservaUsuario($idReserva) {
		$sql = "SELECT r.*,l.nombre nombreLocal, tm.descripcion tipo_menu
				FROM reservas r , locales l
				, tipo_menu tm
				WHERE r.id_tipo_menu = tm.id_tipo_menu
				AND r.id_local = l.id_local
				AND id_reserva = ?";

		$result = $this->db->query($sql, array($idReserva));

		return $result;
	}

	function obtenerMesasReserva($idReserva) {
		$sql = "SELECT rm.*, ml.nombre_mesa, ml.capacidad
				FROM reserva_mesa rm, mesas_local ml
				WHERE rm.id_mesa_local = ml.id_mesa_local
				AND id_reserva = ?";

		$result = $this->db->query($sql, array($idReserva));

		return $result;
	}

	function obtenerMesasLibresLocal($idLocal, $fecha, $idTipoMenu) {
		$sql = "SELECT * FROM mesas_local
				WHERE id_local = ? AND id_mesa_local not in (
				SELECT id_mesa_local
				FROM reserva_mesa
				WHERE id_reserva in (
				SELECT id_reserva
				FROM reservas
				WHERE fecha = ?
				AND id_tipo_menu = ?))";

		$result = $this->db->query($sql, array($idLocal, $fecha, $idTipoMenu));

		return $result;
	}

	function insertarMesaReserva($idMesaLocal, $idReserva) {
		$sql = "INSERT INTO reserva_mesa (id_mesa_local, id_reserva,fecha_alta)
				VALUES (?,?,?)";

		$this->db->query($sql, array($idMesaLocal, $idReserva, date('Y-m-d H:i:s')));
	}

	function borrarMesaReserva($idReservaMesa) {
		$sql = "DELETE FROM reserva_mesa WHERE id_reserva_mesa = ?";

		$this->db->query($sql, array($idReservaMesa));
	}

	function borrarMesaReserva2($idMesa,$idReserva) {
		$sql = "DELETE FROM reserva_mesa
				WHERE id_mesa_local = ?
				AND id_reserva = ? ";

		$this->db->query($sql, array($idMesa,$idReserva));
	}

	function borrarMesasReserva($idReserva) {
		$sql = "DELETE FROM reserva_mesa WHERE id_reserva = ?";

		$this->db->query($sql, array($idReserva));
	}

	function obtenerReservas2EstadosLocal($idLocal, $estado1, $estado2) {

		$sql = "SELECT r.*, u.nombre nombreUsuario,u.nick nick,u.apellido
				, tm.descripcion tipo_menu
				FROM reservas r
				LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario
				, tipo_menu tm
				WHERE r.id_tipo_menu = tm.id_tipo_menu
				AND id_local = ?
				AND (r.estado = ? OR r.estado = ?)
				ORDER BY r.fecha_actualizacion DESC,r.fecha DESC";

		$result = $this->db->query($sql, array($idLocal, $estado1, $estado2));

		return $result;
	}

	public function generarCalendarioReservas($idLocal, $mes = 0, $ano = 0) {

		if ($mes == 0 || $ano == 0) {
			$ano = date("Y");
			$mes = date("m");
		}

		$mesSiguiente = $mes + 1;
		$anoSiguiente = $ano;
		$mesAnterior = $mes - 1;
		$anoAnterior = $ano;

		if ($mes == 12) {
			$mesSiguiente = 1;
			$anoSiguiente = $ano + 1;
		}

		if ($mes == 1) {
			$mesAnterior = 12;
			$anoAnterior = $ano - 1;
		}

		$prefs = array(
				'start_day' => 'monday',
				'month_type' => 'long',
				'day_type' => 'short',
				'show_next_prev' => TRUE,
				'next_url' => "doAjax('" . site_url() . "/reservas/mostrarCalendarioReservas','mes=" .
				$mesSiguiente . "&ano=" . $anoSiguiente
				. "','actualizarCalendarioReservas','post',1)",
				'prev_url' => "doAjax('" . site_url() . "/reservas/mostrarCalendarioReservas','mes=" .
				$mesAnterior . "&ano=" . $anoAnterior
				. "','actualizarCalendarioReservas','post',1)"
		);

		$prefs['template'] = '
		{table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}

		{heading_row_start}<tr>{/heading_row_start}

		{heading_previous_cell}<th><a onclick="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
		{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
		{heading_next_cell}<th><a onclick="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

		{heading_row_end}</tr>{/heading_row_end}

		{week_row_start}<tr>{/week_row_start}
		{week_day_cell}<td>{week_day}</td>{/week_day_cell}
		{week_row_end}</tr>{/week_row_end}

		{cal_row_start}<tr>{/cal_row_start}
		{cal_cell_start}<td>{/cal_cell_start}

		{cal_cell_content}<a onclick="{content}">{day}</a><a onclick="{enlaceComida}"><img src="{imagenComida}"></a><a onclick="{enlaceCena}"><img src="{imagenCena}"></a>{/cal_cell_content}
		{cal_cell_content_today}<div class="highlight"><a onclick="{content}">{day}</a><a onclick="{enlaceComida}"><img src="{imagenComida}"></a><a onclick="{enlaceCena}"><img src="{imagenCena}"></a></div>{/cal_cell_content_today}

		{cal_cell_no_content}{day}{/cal_cell_no_content}
		{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

		{cal_cell_blank}&nbsp;{/cal_cell_blank}

		{cal_cell_end}</td>{/cal_cell_end}
		{cal_row_end}</tr>{/cal_row_end}

		{table_close}</table>{/table_close}
				';

		//Se carga la libreria que genera el calendario de menus para usuarios.
		$this->load->library('calendarioreservas', $prefs);

		$this->load->library('gestionfechas');
		$numDiasMes = $this->gestionfechas->ultimoDia($ano, $mes);

		$dias = array();
		$imagenComida = array();
		$imagenCena = array();
		$enlaceComida = array();
		$enlaceCena = array();

		for ($i = 1; $i <= $numDiasMes; $i++) {
			//Se crean los enlaces
			$dias[$i] = "";
			$enlaceComida[$i] = "doAjax('" . site_url() . "/reservas/obtenerReservasDia','dia=" . $i
			. "&mes=" . $mes . "&ano=" . $ano . "&idTipoMenu=2"
					. "','listaReservasDia','post',1)";
			$enlaceCena[$i] = "doAjax('" . site_url() . "/reservas/obtenerReservasDia','dia=" . $i
			. "&mes=" . $mes . "&ano=" . $ano . "&idTipoMenu=3"
					. "','listaReservasDia','post',1)";

			//Se comprueba si están cerradas las reservas para obtener las imagenes
			//Comida
			$reservaCerrada = $this->comprobarReservaCerrada($_SESSION['idLocal']
					, $ano . "-" . $mes . "-" . $i, 2)->num_rows();
			if ($reservaCerrada == 0) {
				$imagenComida[$i] = "img/dialogclean.png";
			} else {
				$imagenComida[$i] = "img/dialogerror.png";
			}

			//Cena
			$reservaCerrada = $this->comprobarReservaCerrada($_SESSION['idLocal']
					, $ano . "-" . $mes . "-" . $i, 3)->num_rows();

			if ($reservaCerrada == 0) {
				$imagenCena[$i] = "img/dialogclean.png";
			} else {
				$imagenCena[$i] = "img/dialogerror.png";
			}
		}

		$data['dias'] = $dias;
		$data['imagenComida'] = $imagenComida;
		$data['imagenCena'] = $imagenCena;
		$data['enlaceComida'] = $enlaceComida;
		$data['enlaceCena'] = $enlaceCena;

		$calendario = $this->calendarioreservas->generate($ano, $mes, $data);

		return $calendario;
	}

	function obtenerReservasDiaTipoMenu($idLocal, $fechaReservas, $idTipoMenu, $estado) {
		//Se obtienen las reservas
		$sql = "SELECT r.*, u.nombre nombreUsuario,u.nick nick,u.apellido
				, tm.descripcion tipo_menu
				FROM reservas r
				LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario
				, tipo_menu tm
				WHERE r.id_tipo_menu = tm.id_tipo_menu
				AND id_local = ?
				AND r.fecha = ?
				AND r.estado = ?
				AND r.id_tipo_menu = ?
				ORDER BY r.fecha";

		$result = $this->db->query($sql, array($idLocal, $fechaReservas->format('Y-m-d')
				, $estado, $idTipoMenu));

		return $result;
	}

	function insertarCerrarReserva($idLocal, $fecha, $idTipoMenu) {

		$sql = "INSERT INTO reservas_dias_cerrados (id_local,dia,
				id_tipo_menu,fecha_alta) VALUES (?,?,?,?)";

		$result = $this->db->query($sql, array($idLocal, $fecha, $idTipoMenu, date('Y-m-d H:i:s')));

		$idDiaCierre = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(37, $idLocal, $idDiaCierre);

		return $idDiaCierre;
	}

	function comprobarReservaCerrada($idLocal, $fecha, $idTipoMenu) {
		$sql = "SELECT * FROM reservas_dias_cerrados
				WHERE id_local = ?
				AND dia = ?
				AND id_tipo_menu = ?";

		$result = $this->db->query($sql, array($idLocal, $fecha, $idTipoMenu));

		return $result;
	}

	function borrarReservaCerrada($idLocal, $fecha, $idTipoMenu) {

		$sql = "SELECT * FROM reservas_dias_cerrados
				WHERE id_local = ?
				AND dia = ?
				AND id_tipo_menu = ?";

		$idDiaCerrado = $this->db->query($sql, array($idLocal, $fecha, $idTipoMenu))
		->row()->id_reserva_dia_cerrado;


		$sql = "DELETE FROM reservas_dias_cerrados
				WHERE id_local = ?
				AND dia = ?
				AND id_tipo_menu = ?";

		$this->db->query($sql, array($idLocal, $fecha, $idTipoMenu));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(38, $idLocal, $idDiaCerrado);
	}

	function obtenerReservaDiasCierreObject($idLocal){
		$sql = "SELECT * FROM reservas_dias_cerrados
				WHERE id_local = ?";

		$result = $this->db->query($sql, array($idLocal))->result();

		$diasCierreReserva = array();

		foreach ($result as $row){
			$diasCierreReserva[] = DiaCierreReserva::withID($row->id_reserva_dia_cerrado);
		}

		return $diasCierreReserva;
	}

	function obtenerReservaDiaCierre($idResevaDiaCierre){
		$sql = "SELECT * FROM reservas_dias_cerrados
				WHERE id_reserva_dia_cerrado = ?";

		$result = $this->db->query($sql, array($idResevaDiaCierre));

		return $result;
	}

}
