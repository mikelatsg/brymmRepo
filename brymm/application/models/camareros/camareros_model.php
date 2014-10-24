<?php

class Camareros_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	function insertarCamarero($idLocal, $nombreCamarero, $password
			, $controlTotal, $activo) {
		$sql = "INSERT INTO camareros (id_local,nombre,fecha_alta
				,password,control_total,activo)
				VALUES (?,?,?,?,?,?)";

		$this->db->query($sql, array($idLocal, $nombreCamarero, date('Y-m-d H:i:s')
				, $password, $controlTotal, $activo));
		
		$idCamarero = $this->db->insert_id();
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(35, $idLocal, $idCamarero);
	}

	function modificarCamarero($idCamarero, $nombreCamarero, $password
			, $controlTotal) {
		
		$idLocal = $this->obtenerDatosCamarero2($idCamarero)->row()->id_local;
		
		$sql = "UPDATE camareros
				SET nombre = ?, password = ?, control_total = ?
				WHERE id_camarero = ?";

		$this->db->query($sql, array($nombreCamarero, $password, $controlTotal
				, $idCamarero));
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(35, $idLocal, $idCamarero);
	}

	function obtenerCamarerosLocal($idLocal, $activo) {
		$sql = "SELECT id_camarero, id_local, nombre, fecha_alta, activo, password, control_total
				FROM camareros
				WHERE id_local = ?
				AND activo = ?";

		$result = $this->db->query($sql, array($idLocal, $activo));

		return $result;
	}

	function obtenerCamarerosLocalObject($idLocal, $activo) {
		$sql = "SELECT id_camarero, id_local, nombre, fecha_alta, activo, password, control_total
				FROM camareros
				WHERE id_local = ?
				AND activo = ?";

		$result = $this->db->query($sql, array($idLocal, $activo))->result();
		 
		$camareros = array();
		 
		foreach($result as $row){
			$camareros[] = new Camarero($row->id_camarero,$row->nombre,$row->activo,$row->control_total);
		}

		return $camareros;
	}

	function comprobarCamareroLocal($idLocal, $nombreCamarero, $activo) {
		$sql = "SELECT * FROM camareros
				WHERE id_local = ?
				AND nombre = ?
				AND activo = ?";

		$result = $this->db->query($sql, array($idLocal, $nombreCamarero, $activo));

		return $result;
	}

	function comprobarCamareroNombreLocal($nombreCamarero, $password
			, $nombreLocal, $activo) {
		$sql = "SELECT c.*, l.nombre nombreLocal FROM camareros c, locales l
				WHERE c.id_local = l.id_local
				AND c.nombre = ?
				AND c.password = ?
				AND l.nombre = ?
				AND c.activo = ?";

		$result = $this->db->query($sql, array($nombreCamarero, $password
				, $nombreLocal, $activo));

		return $result;
	}

	function borrarCamareroLocal($idCamarero) {
		
		$idLocal = $this->obtenerDatosCamarero2($idCamarero)->row()->id_local;
		
		$sql = "UPDATE camareros
				SET activo = ?
				WHERE id_camarero = ?";

		$this->db->query($sql, array(0, $idCamarero));
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(36, $idLocal, $idCamarero);
	}

	function obtenerDatosCamarero($idCamarero, $activo) {
		$sql = "SELECT id_camarero, id_local,nombre, fecha_alta, control_total
				FROM camareros
				WHERE id_camarero = ?
				AND activo = ?";

		$result = $this->db->query($sql, array($idCamarero, $activo));

		return $result;
	}

	function obtenerDatosCamarero2($idCamarero) {
		$sql = "SELECT *
				FROM camareros
				WHERE id_camarero = ?";

		$result = $this->db->query($sql, array($idCamarero));

		return $result;
	}

}

