<?php

class Alertas_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	function insertAlertaLocal($idMotivoAlerta, $idLocal, $idObjeto) {
		// Consulta en la tabla tipos_articulo
		$sql = "INSERT INTO alertas_local
				(id_motivo_alerta, id_local, id_objeto, fecha,id_camarero)
				VALUES (?,?,?,?,?)";

		$this->db->query($sql, array($idMotivoAlerta, $idLocal
				, $idObjeto, date('Y-m-d H:i:s'), 0));
	}

	function insertAlertaCamarero($idMotivoAlerta, $idLocal, $idObjeto
			, $idCamarero) {
		// Consulta en la tabla tipos_articulo
		$sql = "INSERT INTO alertas_local
				(id_motivo_alerta, id_local, id_objeto, fecha,id_camarero)
				VALUES (?,?,?,?,?)";

		$this->db->query($sql, array($idMotivoAlerta, $idLocal
				, $idObjeto, date('Y-m-d H:i:s'), $idCamarero));
	}

	function insertAlertaUsuario($idMotivoAlerta, $idUsuario, $idObjeto) {
		// Consulta en la tabla tipos_articulo
		$sql = "INSERT INTO alertas_usuario
				(id_motivo_alerta, id_usuario, id_objeto, fecha)
				VALUES (?,?,?,?)";

		$this->db->query($sql, array($idMotivoAlerta, $idUsuario
				, $idObjeto, date('Y-m-d H:i:s')));
	}

	function hayAlertasNuevasLocal($idLocal, $fecha) {

		// Consulta en la tabla de alertas
		$sql = "SELECT * FROM alertas_local al , motivo_alerta ma
				WHERE al.id_motivo_alerta = ma.id_motivo_alerta
				AND id_local = ?
				AND fecha >= ?
				AND ma.aplicable = ?";

		$result = $this->db->query($sql, array($idLocal, $fecha,Alerta::FIELD_LOCAL));
			
		if ($result->num_rows() > 0){
			return true;
		}
			
		return false;
	}

	function hayAlertasNuevasUsuario($idUsuario, $fecha) {

		// Consulta en la tabla de alertas
		$sql = "SELECT * FROM alertas_usuario au , motivo_alerta ma
				WHERE au.id_motivo_alerta = ma.id_motivo_alerta
				AND id_usuario = ?
				AND fecha >= ?
				AND ma.aplicable = ?";

		$result = $this->db->query($sql, array($idUsuario, $fecha,Alerta::FIELD_USUARIO));
			
		if ($result->num_rows() > 0){
			return true;
		}
			
		return false;
	}

	function hayAlertasNuevasCamarero($idLocal, $fecha) {

		// Consulta en la tabla de alertas
		$sql = "SELECT * FROM alertas_local al , motivo_alerta ma
				WHERE al.id_motivo_alerta = ma.id_motivo_alerta
				AND id_local = ?
				AND fecha >= ?
				AND ma.aplicable in ( ?,?)";

		$result = $this->db->query($sql, array($idLocal, $fecha,Alerta::FIELD_LOCAL,Alerta::FIELD_CAMARERO));
			
		if ($result->num_rows() > 0){
			return true;
		}
			
		return false;
	}

	function obtenerAlertasLocal($idLocal, $fecha, $soyCamarero = false){
			
		if ($soyCamarero){
			// Consulta en la tabla de alertas
			$sql = "SELECT * FROM alertas_local al, motivo_alerta ma
					WHERE  al.id_motivo_alerta = ma.id_motivo_alerta
					AND id_local = ?
					AND fecha >= ?
					AND ma.aplicable in ( ?,?)
					ORDER BY al.id_alerta_local";

			$result = $this->db->query($sql, array($idLocal, $fecha, Alerta::FIELD_LOCAL
					,Alerta::FIELD_CAMARERO ))->result();
		}else{
			// Consulta en la tabla de alertas
			$sql = "SELECT * FROM alertas_local al, motivo_alerta ma
					WHERE  al.id_motivo_alerta = ma.id_motivo_alerta
					AND id_local = ?
					AND fecha >= ?
					AND ma.aplicable = ?
					ORDER BY al.id_alerta_local";

			$result = $this->db->query($sql, array($idLocal, $fecha, Alerta::FIELD_LOCAL))->result();
		}

			

			
		$alertas = array();
			
		foreach ($result as $row){
			$objeto = null;
			switch ($row->tipo_objeto){
				case Comanda::FIELD_COMANDA:
					$objeto = Comanda::withID($row->id_objeto);
					break;
				case ReservaLocal::FIELD_RESERVA:
					$objeto = ReservaLocal::withID($row->id_objeto);
					break;
				case Pedido::FIELD_PEDIDO:
					$objeto = Pedido::withID($row->id_objeto);
					break;
				case Articulo::FIELD_ARTICULO:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(Articulo::FIELD_ID_ARTICULO => $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = Articulo::withID($row->id_objeto);
						}
					}
					break;
				case Ingrediente::FIELD_INGREDIENTE:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(Ingrediente::FIELD_ID_INGREDIENTE => $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = Ingrediente::withID($row->id_objeto);
						}
					}
					break;
				case TipoArticuloLocal::FIELD_TIPO_ARTICULO_LOCAL:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(TipoArticuloLocal::FIELD_ID_TIPO_ARTICULO_LOCAL=> $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = TipoArticuloLocal::withID($row->id_objeto);
						}
					}
					break;
				case HorarioLocal::FIELD_HORARIO_LOCAL:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(HorarioLocal::FIELD_ID_HORARIO_LOCAL=> $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = HorarioLocal::withID($row->id_objeto);
						}
					}
					break;
				case HorarioPedido::FIELD_HORARIO_PEDIDO:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(HorarioPedido::FIELD_ID_HORARIO_PEDIDO=> $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = HorarioPedido::withID($row->id_objeto);
						}
					}
					break;
				case DiaCierre::FIELD_DIA_CIERRE:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(DiaCierre::FIELD_ID_DIA_CIERRE=> $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = DiaCierre::withID($row->id_objeto);
						}
					}
					break;
				case Mesa::FIELD_MESA:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(Mesa::FIELD_ID_MESA=> $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = Mesa::withID($row->id_objeto);
						}
					}
					break;
				case Menu::FIELD_MENU:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(Menu::FIELD_ID_MENU=> $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = Menu::withID($row->id_objeto);
						}
					}
					break;
				case MenuDia::FIELD_MENU_DIA:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(MenuDia::FIELD_ID_MENU_DIA=> $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior, o el mismo objeto
						//modificado
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR) && !$this->hayAlertaFutura($row->tipo_objeto,
										$row->fecha,$row->id_objeto,
										$idLocal,Alerta::ACTUALIZAR)){
							$objeto = MenuDia::withID($row->id_objeto);
						}
					}
					break;
				case Plato::FIELD_PLATO:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(Plato::FIELD_ID_PLATO=> $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = Plato::withID($row->id_objeto);
						}
					}
					break;
				case Camarero::FIELD_CAMARERO:
					//Diferencio si es un borrado de articulo
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(Camarero::FIELD_ID_CAMARERO => $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = Camarero::withID($row->id_objeto);
						}
					}
					break;
				case DiaCierreReserva::FIELD_DIA_CIERRE_RESERVA:
					//Diferencio si es un borrado de dia cierre
					if ($row->accion == Alerta::BORRAR){
						$objeto = array(DiaCierreReserva::FIELD_ID_DIA_CIERRE_RESERVA => $row->id_objeto);
					}else{
						//Compruebo si hay un borrado del mismo objeto posterior
						if (!$this->hayAlertaFutura($row->tipo_objeto,
								$row->fecha,$row->id_objeto,
								$idLocal,Alerta::BORRAR)){
							$objeto = DiaCierreReserva::withID($row->id_objeto);
						}
					}
					break;
			}


			if ($objeto!=null){
				$alertas[] = new Alerta($row->notificacion,$row->tipo_objeto,$objeto, $row->accion);
			}
		}

		return $alertas;
	}

	function obtenerAlertasUsuario($idUsuario, $fecha){
			
		
		
		// Consulta en la tabla de alertas
		$sql = "SELECT * FROM alertas_usuario au, motivo_alerta ma
				WHERE  au.id_motivo_alerta = ma.id_motivo_alerta
				AND id_usuario = ?
				AND fecha >= ?
				AND ma.aplicable = ?
				ORDER BY au.id_alerta_usuario";			
			
		$result = $this->db->query($sql, array($idLocal, $fecha, Alerta::FIELD_LOCAL))->result();
			
		$alertas = array();
			
		$this->load->model('pedidos/Pedidos_model');
		$this->load->model('reservas/Reservas_model');

		foreach ($result as $row){
			$objeto = null;
			switch ($row->tipo_objeto){
				case ReservaLocal::FIELD_RESERVA:
					$objeto = $this->Reservas_model->obtenerReservaUsuario($row->id_objeto);
					break;
				case Pedido::FIELD_PEDIDO:
					$objeto =  $this->Pedidos_model->obtenerPedido($row->id_objeto);
					break;
			}

			if ($objeto!=null){
				$alertas[] = new Alerta($row->notificacion,$row->tipo_objeto,$objeto, $row->accion);
			}
		}

		return $alertas;
	}

	function hayAlertaFutura($tipoObjeto, $fecha,$idObjeto,$idLocal,$accion){
		$sql = "SELECT * FROM alertas_local al, motivo_alerta ma
				WHERE  al.id_motivo_alerta = ma.id_motivo_alerta
				AND id_local = ?
				AND al.fecha > ?
				AND ma.tipo_objeto = ?
				AND al.id_objeto = ?
				AND ma.accion = ?";

		$result = $this->db->query($sql,
				array($idLocal, $fecha,$tipoObjeto,$idObjeto,$accion));

		if ($result->num_rows() > 0){
			return true;
		}
		return false;
	}

}
