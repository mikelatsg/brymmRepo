<?php

require_once APPPATH . '/libraries/horarios/horarioLocal.php';
require_once APPPATH . '/libraries/horarios/horarioPedido.php';
require_once APPPATH . '/libraries/horarios/diaCierre.php';

class Locales_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
		$this->load->library('encrypt');
	}

	function insertLocal($datos) {

		// Guardar usuario en BD -- $this->encrypt->encode()
		$sql = "INSERT INTO locales (id_local,nombre,password,localidad,provincia,direccion,"
				. "cod_postal,fecha_alta,email,estado_local,id_tipo_comida,telefono)"
						. "VALUES('',?,?,?,?,?,?,?,?,?,?,?)";
		$this->db->query($sql, array($datos['nombre'], md5($_POST['password']),
				$datos['localidad'], $datos['provincia'],
				$datos['direccion'], $datos['codigoPostal'], date('Y-m-d'), $datos['email'],
				1, $datos['idTipoComida'], $datos['telefono']));

		return $this->db->insert_id();
	}

	function modificarLocal($datos,$idLocal) {

		$sql = "UPDATE locales SET localidad = ?, provincia = ?,direccion = ?,"
				. "cod_postal = ? , email = ?,id_tipo_comida = ?,telefono = ? "
						. " WHERE id_local = ?";
		$this->db->query($sql, array(
				$datos['localidad'], $datos['provincia'],
				$datos['direccion'], $datos['codigoPostal'],  $datos['email'],
				$datos['idTipoComida'], $datos['telefono'], $idLocal));
	}

	function comprobarLocal($nombre) {

		// Consulta en la tabla locales con el nombre
		$sql = "SELECT * FROM locales WHERE nombre = ?";
		$result = $this->db->query($sql, array($nombre));

		return $result;
	}

	function comprobarLocalLogin($nombre, $password) {

		// Consulta en la tabla locales con el nombre
		$sql = "SELECT * FROM locales WHERE nombre = ?
				AND password = ?";
		$result = $this->db->query($sql, array($nombre, $password));

		return $result;
	}

	/* function comprobarLocalAbierto($idLocal, $fecha) {
	 $sql = "SELECT * FROM dias_cierre_local
	WHERE id_local = ?
	AND fecha = ?";

	$result = $this->db->query($sql, array($idLocal, $fecha));

	return $result;
	} */

	function comprobarLocalAbierto($idLocal, $fecha) {

		//Se comprueba si el local esta cerrado expresamente ese dia
		$sql = "SELECT * FROM dias_cierre_local
				WHERE id_local = ?
				AND fecha = ?";

		$result = $this->db->query($sql, array($idLocal, $fecha->format('Y-m-d')));

		if ($result->num_rows()) {
			return false;
		}

		//Se comprueba si el local abre ese dia habitualmente
		$sql = "SELECT * FROM horarios_local
				WHERE id_local = ?
				AND id_dia = ?";

		$result = $this->db->query($sql, array($idLocal, $fecha->format('N')));

		if (!$result->num_rows()) {
			return false;
		}

		return true;
	}

	function obtenerDatosLocal($idLocal) {
		// Consulta en la tabla usuarios con el nick
		$sql = "SELECT l.*,tc.tipo_comida FROM locales l, tipos_comida tc
				WHERE l.id_tipo_comida =  tc.id_tipo_comida
				AND id_local = ?";
		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function modificarEstadoLocal($estadoLocal, $idLocal) {
		$sql = "UPDATE locales SET estado_local = ? WHERE id_local = ?";
		$result = $this->db->query($sql, array($estadoLocal, $idLocal));
	}

	function insertHorarioLocal($idLocal, $idDia, $horaInicio, $horaFin) {
		$sql = "INSERT INTO horarios_local (id_horario_local,id_local,id_dia,hora_inicio,hora_fin)"
				. " VALUES ('',?,?,?,?)";

		$this->db->query($sql, array($idLocal, $idDia, $horaInicio, $horaFin));

		$idHorarioLocal = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(21, $idLocal,  $idHorarioLocal);
	}

	function insertHorarioLocalObject($idLocal, HorarioLocal $horarioLocal) {
		$sql = "INSERT INTO horarios_local (id_horario_local,id_local,id_dia,hora_inicio,hora_fin)"
				. " VALUES ('',?,?,?,?)";

		$this->db->query($sql, array($idLocal, $horarioLocal->dia->idDia
				, $horarioLocal->horaInicio
				, $horarioLocal->horaFin));

		$idHorarioLocal = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(21, $idLocal,  $idHorarioLocal);

		return $idHorarioLocal;
	}

	function insertHorarioPedido($idLocal, $idDia, $horaInicio, $horaFin) {
		$sql = "INSERT INTO horarios_pedidos (id_horario_pedido,id_local,id_dia,hora_inicio,hora_fin)"
				. " VALUES ('',?,?,?,?)";

		$this->db->query($sql, array($idLocal, $idDia, $horaInicio, $horaFin));

		$idHorarioPedido = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(23, $idLocal,  $idHorarioPedido);
	}

	function insertHorarioPedidoObject($idLocal, HorarioPedido $horarioPedido) {
		$sql = "INSERT INTO horarios_pedidos (id_horario_pedido,id_local,id_dia,hora_inicio,hora_fin)"
				. " VALUES ('',?,?,?,?)";

		$this->db->query($sql, array($idLocal, $horarioPedido->dia->idDia
				, $horarioPedido->horaInicio
				, $horarioPedido->horaFin));

		$idHorarioPedido = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(23, $idLocal,  $idHorarioPedido);

		return $idHorarioPedido;
	}

	function obtenerHorarioLocal($idLocal) {
		//Se obtienen los horarios de pedido para un local
		$sql = "SELECT hl.*,ds.dia FROM horarios_local hl,dias_semana ds
				WHERE hl.id_dia = ds.id_dia
				AND hl.id_local = ?";

		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function obtenerHorariosLocalObject($idLocal) {
		//Se obtienen los horarios de pedido para un local
		$sql = "SELECT hl.* FROM horarios_local hl
				WHERE hl.id_local = ?";

		$result = $this->db->query($sql, array($idLocal))->result();
			
		$horariosLocal = array();
			
		foreach ($result as $row){
			$horariosLocal[] = HorarioLocal::withID($row->id_horario_local);
		}

		return $horariosLocal;
	}

	function obtenerHorarioLocalId($idHorarioLocal) {
		//Se obtienen los horarios de pedido para un local
		$sql = "SELECT hl.*,ds.dia FROM horarios_local hl,dias_semana ds
				WHERE hl.id_dia = ds.id_dia
				AND hl.id_horario_local = ?";

		$result = $this->db->query($sql, array($idHorarioLocal));

		return $result;
	}

	function obtenerHorarioPedidos($idLocal) {

		//Se obtienen los horarios de pedido para un local
		$sql = "SELECT hp.*,ds.dia FROM horarios_pedidos hp,dias_semana ds
				WHERE hp.id_dia = ds.id_dia
				AND hp.id_local = ?";

		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function obtenerHorariosPedidoObject($idLocal) {

		$result = $this->obtenerHorarioPedidos($idLocal)->result();

		$horariosPedido = array();

		foreach ($result as $row){
			$horariosPedido[] = HorarioPedido::withID($row->id_horario_pedido);
		}

		return $horariosPedido;
	}

	function obtenerHorarioPedido($idHorarioPedido) {

		//Se obtienen los horarios de pedido para un local
		$sql = "SELECT hp.*,ds.dia FROM horarios_pedidos hp,dias_semana ds
				WHERE hp.id_dia = ds.id_dia
				AND hp.id_horario_pedido = ?";

		$result = $this->db->query($sql, array($idHorarioPedido));

		return $result;
	}

	function obtenerTiposComida() {
		$sql = "SELECT * FROM tipos_comida";

		$result = $this->db->query($sql);

		return $result;
	}

	function obtenerTiposComidaObject() {
		$sql = "SELECT * FROM tipos_comida";

		$result = $this->db->query($sql)->result();

		$tiposComida= array();

		foreach ($result as $row){
			$tiposComida[] = TipoComida::withID($row->id_tipo_comida);
		}

		return $tiposComida;
	}

	function obtenerTipoComida($idTipoComida) {
		$sql = "SELECT * FROM tipos_comida
				WHERE id_tipo_comida = ?";

		$result = $this->db->query($sql,array($idTipoComida));

		return $result;
	}

	function borrarHorarioLocal($idHorarioLocal) {
		//Obtengo el local antes de borrar
		$idLocal = $this->obtenerHorarioLocalId($idHorarioLocal)->row()->id_local;

		$sql = "DELETE FROM horarios_local WHERE id_horario_local = ?";

		$result = $this->db->query($sql, array($idHorarioLocal));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(22, $idLocal,  $idHorarioLocal);
	}

	function borrarHorarioPedido($idHorarioPedido) {
		//Obtengo el local
		$idLocal = $this->obtenerHorarioPedido($idHorarioPedido)->row()->id_local;

		$sql = "DELETE FROM horarios_pedidos WHERE id_horario_pedido = ?";

		$result = $this->db->query($sql, array($idHorarioPedido));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(24, $idLocal,  $idHorarioPedido);
	}

	function obtenerServiciosLocal($idLocal) {
		$sql = "SELECT loc.*,sl.id_servicio_local,tsl.servicio,tsl.id_tipo_servicio_local
				FROM locales loc, servicios_local sl,tipos_servicios_local tsl
				WHERE loc.id_local = sl.id_local
				AND sl.id_tipo_servicio_local = tsl.id_tipo_servicio_local
				AND loc.id_local = ?";

		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function obtenerServicios() {
		$sql = "SELECT tsl.*
				FROM  tipos_servicios_local tsl";

		$result = $this->db->query($sql);

		return $result;
	}

	function buscarLocales($datos) {
		$contadorServicios = 0;
		$parametros = array();
		$existeWhere = false;
		$sql = "SELECT l.id_local, l.nombre, l.id_tipo_comida,
				l.localidad, l.provincia, l.direccion, l.cod_postal,
				l.fecha_alta, l.email, l.estado_local, l.telefono,
				tc.tipo_comida
				FROM  locales l, tipos_comida tc";

		if (isset($datos['servicios'])) {
			if ($datos['servicios']) {
				$sql = $sql . " ,servicios_local sl";
				$sql = $sql . " WHERE l.id_local = sl.id_local ";
				$sql = $sql . " AND l.id_tipo_comida = tc.id_tipo_comida ";
				$sql = $sql . " AND sl.id_tipo_servicio_local in ( ";
				foreach ($datos['servicios'] as $servicio) {
					if ($contadorServicios == 0) {
						$sql = $sql . " ? ";
					} else {
						$sql = $sql . ", ? ";
					}

					$contadorServicios = $contadorServicios + 1;
					$parametros[] = $servicio;
				}
				$sql = $sql . ") ";
				$sql = $sql . " AND sl.activo = 1";
				$existeWhere = true;
			} else {
				$sql = $sql . " WHERE l.id_tipo_comida = tc.id_tipo_comida ";
			}
		} else {
			$sql = $sql . " WHERE l.id_tipo_comida = tc.id_tipo_comida ";
		}

		if ($datos['local']) {
			//if ($existeWhere) {
			$sql = $sql . " AND nombre like ?";
			$parametros[] = $datos['local'];
			/* } else {
			 $sql = $sql . " WHERE nombre like ?";
			$parametros[] = $datos['local'];
			$existeWhere = true;
			} */
		}

		if ($datos['poblacion']) {
			//if ($existeWhere) {
			$sql = $sql . " AND localidad like ?";
			$parametros[] = $datos['poblacion'];
			/* } else {
			 $sql = $sql . " WHERE localidad like ?";
			$parametros[] = $datos['poblacion'];
			$existeWhere = true;
			} */
		}
		if ($datos['calle']) {
			//if ($existeWhere) {
			$sql = $sql . " AND direccion like ?";
			$parametros[] = $datos['calle'];
			/* } else {
			 $sql = $sql . " WHERE direccion like ?";
			$parametros[] = $datos['calle'];
			$existeWhere = true;
			} */
		}
		if ($datos['codigoPostal']) {
			//if ($existeWhere) {
			$sql = $sql . " AND cod_postal like ?";
			$parametros[] = $datos['codigoPostal'];
			/* } else {
			 $sql = $sql . " WHERE cod_postal like ?";
			$parametros[] = $datos['codigoPostal'];
			$existeWhere = true;
			} */
		}

		if ($datos['idTipoComida'] != 0) {
			//if ($existeWhere) {
			$sql = $sql . " AND l.id_tipo_comida like ?";
			$parametros[] = $datos['idTipoComida'];
			/* } else {
			 $sql = $sql . " WHERE id_tipo_comida like ?";
			$parametros[] = $datos['idTipoComida'];
			$existeWhere = true;
			} */
		}

		$sql = $sql . " GROUP BY l.id_local ";

		/* if ($existeWhere) {
		 $result = $this->db->query($sql, $parametros);
		} else {
		$result = $this->db->query($sql);
		} */
		if (sizeof($parametros)) {
			$result = $this->db->query($sql, $parametros);
		} else {
			$result = $this->db->query($sql);
		}

		return $result;
	}

	function insertLocalFavoritos($idLocal, $idUsuario) {
		$sql = "INSERT INTO locales_favoritos (id_locales_favoritos,id_local,id_usuario,fecha_creacion)"
				. " VALUES ('',?,?,?)";

		$this->db->query($sql, array($idLocal, $idUsuario, date('Y-m-d')));
	}

	function deleteLocalFavoritos($idLocal, $idUsuario) {
		$sql = "DELETE FROM locales_favoritos
				WHERE id_local = ?
				AND id_usuario = ? ";

		$this->db->query($sql, array($idLocal, $idUsuario));
	}

	function obtenerLocalFavoritos($idLocal, $idUsuario) {
		/*$sql = "SELECT * FROM locales_favoritos
		 WHERE id_local = ?
		AND id_usuario = ? ";*/

		$sql = "SELECT l.*,tc.tipo_comida, lf.id_locales_favoritos
				FROM locales_favoritos lf,locales l,tipos_comida tc
				WHERE lf.id_local = l.id_local
				AND tc.id_tipo_comida = l.id_tipo_comida
				AND lf.id_local = ?
				AND id_usuario = ? ";

		$result = $this->db->query($sql, array($idLocal, $idUsuario));

		return $result;
	}

	function obtenerLocalesFavoritos($idUsuario) {
		$sql = "SELECT l.*,tc.tipo_comida, lf.id_locales_favoritos
				FROM locales_favoritos lf,locales l,tipos_comida tc
				WHERE lf.id_local = l.id_local
				AND tc.id_tipo_comida = l.id_tipo_comida
				AND id_usuario = ? ";

		$result = $this->db->query($sql, array($idUsuario));

		return $result;
	}

	function insertarDiaCierreLocal($fecha, $idLocal) {
		$sql = "INSERT INTO dias_cierre_local (id_local,fecha,fecha_alta)"
				. " VALUES (?,?,?)";

		$this->db->query($sql, array($idLocal, $fecha, date('Y-m-d H:i:s')));

		$idDiaCierreLocal = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(25, $idLocal,  $idDiaCierreLocal);

		return $idDiaCierreLocal;


	}

	function comprobarDiaCierreLocal($fecha, $idLocal) {
		$sql = "SELECT * FROM dias_cierre_local
				WHERE id_local = ?
				AND fecha = ? ";

		$result = $this->db->query($sql, array($idLocal, $fecha));

		return $result;
	}

	function obtenerDiasCierreLocal($idLocal) {
		$sql = "SELECT * FROM dias_cierre_local
				WHERE id_local = ?
				AND fecha >= ? ";

		$result = $this->db->query($sql, array($idLocal, date('Y-m-d')));

		return $result;
	}

	function obtenerDiasCierreLocalObject($idLocal) {
		$sql = "SELECT * FROM dias_cierre_local
				WHERE id_local = ?
				AND fecha >= ? ";

		$result = $this->db->query($sql, array($idLocal, date('Y-m-d')))->result();

		$diasCierre = array();
		foreach ($result as $row){
			$diasCierre[] = DiaCierre::withID($row->id_dia_cierre_local);
		}

		return $diasCierre;
	}

	function obtenerDiaCierreLocal($idDiaCierre) {
		$sql = "SELECT * FROM dias_cierre_local
				WHERE id_dia_cierre_local = ?
				AND fecha >= ? ";

		$result = $this->db->query($sql, array($idDiaCierre, date('Y-m-d')));

		return $result;
	}

	function borrarDiaCierreLocal($idDiaCierreLocal) {
		//Obtengo el local
		$idLocal = $this->obtenerDiaCierreLocal($idDiaCierreLocal)->row()->id_local;

		$sql = "DELETE FROM dias_cierre_local
				WHERE id_dia_cierre_local = ? ";

		$this->db->query($sql, array($idDiaCierreLocal));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(26, $idLocal,  $idDiaCierreLocal);
	}

}
