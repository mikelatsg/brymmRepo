<?php

require_once APPPATH . '/libraries/servicios/tipoServicio.php';
require_once APPPATH . '/libraries/servicios/servicioLocal.php';

class Servicios_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
		$this->load->library('encrypt');
	}

	function obtenerServiciosLocal($idLocal) {

		$sql = "SELECT tsl.*, sl.id_servicio_local, sl.id_local,
				sl.activo,ifnull(psl.importe_minimo,0) importe_minimo
				,ifnull(psl.precio,0) precio
				FROM tipos_servicios_local tsl INNER JOIN servicios_local sl
				ON (tsl.id_tipo_servicio_local = sl.id_tipo_servicio_local)
				LEFT JOIN precio_servicio_local psl
				ON (sl.id_servicio_local = psl.id_servicio_local)
				WHERE sl.id_local =?";

		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function obtenerServiciosLocalObject($idLocal) {

		$sql = "SELECT tsl.*, sl.id_servicio_local, sl.id_local,
				sl.activo,ifnull(psl.importe_minimo,0) importe_minimo
				,ifnull(psl.precio,0) precio
				FROM tipos_servicios_local tsl INNER JOIN servicios_local sl
				ON (tsl.id_tipo_servicio_local = sl.id_tipo_servicio_local)
				LEFT JOIN precio_servicio_local psl
				ON (sl.id_servicio_local = psl.id_servicio_local)
				WHERE sl.id_local =?";

		$result = $this->db->query($sql, array($idLocal))->result();

		$servicios = array();

		foreach ($result as $row){

			$tipoServicio = $this->obtenerTipoServicioObject($row->id_tipo_servicio_local);

			$servicios[] = new ServicioLocal(  $row->id_servicio_local,
					$tipoServicio,
					$row->activo,$row->importe_minimo,$row->precio);
		}

		return $servicios;
	}

	function obtenerServicioLocalObject($idServicio) {

		$sql = "SELECT tsl.*, sl.id_servicio_local, sl.id_local,
				sl.activo,ifnull(psl.importe_minimo,0) importe_minimo
				,ifnull(psl.precio,0) precio
				FROM tipos_servicios_local tsl INNER JOIN servicios_local sl
				ON (tsl.id_tipo_servicio_local = sl.id_tipo_servicio_local)
				LEFT JOIN precio_servicio_local psl
				ON (sl.id_servicio_local = psl.id_servicio_local)
				WHERE sl.id_servicio_local =?";

		$row = $this->db->query($sql, array($idServicio))->row();

		$tipoServicio = $this->obtenerTipoServicioObject($row->id_tipo_servicio_local);

		$servicio = new ServicioLocal(  $row->id_servicio_local,
				$tipoServicio,
				$row->activo,$row->importe_minimo,$row->precio);

		return $servicio;
	}

	function obtenerServiciosActivosLocal($idLocal) {

		$sql = "SELECT tsl.*, sl.id_servicio_local, sl.id_local,
				sl.activo,ifnull(psl.importe_minimo,0) importe_minimo
				,ifnull(psl.precio,0) precio
				FROM tipos_servicios_local tsl INNER JOIN servicios_local sl
				ON (tsl.id_tipo_servicio_local = sl.id_tipo_servicio_local)
				LEFT JOIN precio_servicio_local psl
				ON (sl.id_servicio_local = psl.id_servicio_local)
				WHERE sl.id_local =?
				AND sl.activo = ?";

		$result = $this->db->query($sql, array($idLocal, 1));

		return $result;
	}

	function obtenerServicioLocal($idLocal, $idTipoServicioLocal) {
		$sql = "SELECT tsl.*, sl.id_servicio_local, sl.id_local,psl.importe_minimo,psl.precio
				FROM tipos_servicios_local tsl INNER JOIN servicios_local sl
				ON (tsl.id_tipo_servicio_local = sl.id_tipo_servicio_local)
				LEFT JOIN precio_servicio_local psl
				ON (sl.id_servicio_local = psl.id_servicio_local)
				WHERE sl.id_local = ?
				AND sl.id_tipo_servicio_local= ? ";

		$result = $this->db->query($sql, array($idLocal, $idTipoServicioLocal));

		return $result;
	}

	function obtenerServicios() {
		$sql = "SELECT tsl.*
				FROM  tipos_servicios_local tsl";

		$result = $this->db->query($sql);

		return $result;
	}

	function obtenerTiposServicioObject() {
		$sql = "SELECT tsl.*
				FROM  tipos_servicios_local tsl";

		$result = $this->db->query($sql)->result();
			
		$tiposServicios = array();
			
		foreach ($result as $row){
			$tiposServicios[] = new TipoServicio($row->id_tipo_servicio_local,
					$row->servicio,
					$row->descripcion,
					$row->mostrar_buscador);
		}

		return $tiposServicios;
	}

	function obtenerTipoServicioObject($idTipoServicio) {
		$sql = "SELECT tsl.*
				FROM  tipos_servicios_local tsl
				WHERE id_tipo_servicio_local = ?";

		$row = $this->db->query($sql,array($idTipoServicio))->row();
			
		$tipoServicio = new TipoServicio($row->id_tipo_servicio_local,
				$row->servicio,
				$row->descripcion,
				$row->mostrar_buscador);

		return $tipoServicio;
	}

	function obtenerServicio($idServicioLocal) {
		$sql = "SELECT tsl.*
				FROM  servicios_local tsl
				WHERE id_servicio_local = ?";

		$result = $this->db->query($sql, array($idServicioLocal));

		return $result;
	}

	function insertarServicioLocal($idLocal, $idTipoServicioLocal) {
		$sql = "INSERT INTO servicios_local (id_local,id_tipo_servicio_local)
				VALUES (?,?)";

		$this->db->query($sql, array($idLocal, $idTipoServicioLocal));

		return $this->db->insert_id();
	}

	function borrarServicioLocal($idServicioLocal) {
		$sql = "DELETE FROM servicios_local
				WHERE id_servicio_local = ?";

		$this->db->query($sql, array($idServicioLocal));

		//Se borran el precio del servicio
		$sql = "DELETE FROM precio_servicio_local
				WHERE id_servicio_local = ?";

		$this->db->query($sql, array($idServicioLocal));
	}

	function borrarServicioLocalTipo($idTipoServicioLocal, $idLocal) {
		$servicio = $this->existeServicioLocal
		($idLocal, $idTipoServicioLocal);
		
		if ($servicio->num_rows()> 0){
			$idServicioLocal = $servicio->row()->id_servicio_local;

			$sql = "DELETE FROM servicios_local
					WHERE id_tipo_servicio_local = ?
					AND id_local = ?";

			$this->db->query($sql, array($idTipoServicioLocal, $idLocal));

			//Se borran el precio del servicio
			$sql = "DELETE FROM precio_servicio_local
					WHERE id_servicio_local = ?";

			$this->db->query($sql, array($idServicioLocal));
		}
	}

	function existeServicioLocal($idLocal, $idTipoServicioLocal) {
		$sql = "SELECT sl.*
				FROM servicios_local sl
				WHERE id_local = ?
				AND id_tipo_servicio_local = ?";

		$result = $this->db->query($sql, array($idLocal, $idTipoServicioLocal));

		return $result;
	}

	function servicioLocalActivo($idLocal, $idTipoServicioLocal) {
		$sql = "SELECT sl.*
				FROM servicios_local sl
				WHERE id_local = ?
				AND id_tipo_servicio_local = ?
				AND activo = ?";

		$result = $this->db->query($sql, array($idLocal, $idTipoServicioLocal, 1));

		return $result;
	}

	function insertarPrecioServicioLocal($idServicioLocal, $importeMinimo, $precio) {
		$sql = "INSERT INTO precio_servicio_local (id_servicio_local,importe_minimo,precio)
				VALUES (?,?,?)";

		$this->db->query($sql, array($idServicioLocal, $importeMinimo, $precio));
	}

	function modificarPrecioServicioLocal($idServicioLocal, $importeMinimo, $precio) {
		$sql = "UPDATE precio_servicio_local
				SET importe_minimo = ?, precio = ?
				WHERE id_servicio_local = ?";

		$this->db->query($sql, array($importeMinimo, $precio, $idServicioLocal));
	}

	public function obtenerPrecioServicio($idServicioLocal) {
		$sql = "SELECT psl.*
				FROM precio_servicio_local psl
				WHERE id_servicio_local = ?";

		$result = $this->db->query($sql, array($idServicioLocal));

		return $result;
	}

	public function modificarEstadoServicio($idServicioLocal, $activo) {


		$sql = "UPDATE servicios_local
				SET activo = ?
				WHERE id_servicio_local = ?";

		$this->db->query($sql, array($activo, $idServicioLocal));
	}

}
