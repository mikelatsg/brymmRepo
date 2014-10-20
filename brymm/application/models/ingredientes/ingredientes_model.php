<?php

require_once APPPATH . '/libraries/ingredientes/ingrediente.php';

class Ingredientes_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	function insertIngrediente($datos, $idLocal) {
		$sql = "INSERT INTO ingredientes (id_ingrediente,id_local,ingrediente"
				. ",descripcion,disponible,precio,fecha_alta)"
						. " VALUES ('',?,?,?,?,?,?)";

		$this->db->query($sql, array($idLocal, $datos['ingrediente'], $datos['descripcion']
				, 1, $datos['precio'], date('Y-m-d')));
		
		$idIngrediente = $this->db->insert_id();
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(17, $idLocal,  $idIngrediente);
	}
	
	function insertIngredienteObject(Ingrediente $ingrediente, $idLocal) {
		$sql = "INSERT INTO ingredientes (id_ingrediente,id_local,ingrediente"
				. ",descripcion,disponible,precio,fecha_alta)"
						. " VALUES ('',?,?,?,?,?,?)";
	
		$this->db->query($sql, array($idLocal, $ingrediente->nombre, $ingrediente->descripcion
				, 1, $ingrediente->precio, date('Y-m-d')));
		
		$idIngrediente = $this->db->insert_id();
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(17, $idLocal,  $idIngrediente);
		
		return $idIngrediente;
	}

	function obtenerIngredientes($idLocal) {
		$sql = "SELECT * FROM ingredientes "
				. "WHERE id_local = ?";
		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function obtenerIngredientesObject($idLocal) {
		$sql = "SELECT * FROM ingredientes "
				. "WHERE id_local = ?";
		$result = $this->db->query($sql, array($idLocal))->result();

		$ingredientes = array();
			
		foreach ($result as $row){
			$ingrediente = new Ingrediente($row->id_ingrediente
					,$row->ingrediente
					,$row->descripcion
					,$row->precio);

			$ingredientes[] = $ingrediente;
		}
			
		return $ingredientes;
	}

	function obtenerIngredientesDisponibles($idLocal, $disponible = 1) {
		$sql = "SELECT * FROM ingredientes
				WHERE id_local = ?
				AND disponible = ?";
		$result = $this->db->query($sql, array($idLocal, $disponible));

		return $result;
	}

	function modificarIngrediente($datos) {
		$sql = "UPDATE ingredientes SET ingrediente = ?"
				. ",descripcion = ?,precio = ?"
						. " WHERE id_ingrediente = ?";

		$this->db->query($sql, array($datos['ingrediente'], $datos['descripcion']
				, $datos['precio'], $datos['idIngrediente']));
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(17, $idLocal,  $datos['idIngrediente']);
	}
	
	function modificarIngredienteObject(Ingrediente $ingrediente) {
		$sql = "UPDATE ingredientes SET ingrediente = ?"
				. ",descripcion = ?,precio = ?"
						. " WHERE id_ingrediente = ?";
	
		$this->db->query($sql, array($ingrediente->nombre, $ingrediente->descripcion
				, $ingrediente->precio, $ingrediente->idIngrediente));	

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(17, $idLocal,  $ingrediente->idIngrediente);
	}

	function borrarIngrediente($idIngrediente) {
		//Obtengo el local antes de borrar
		$idLocal = $this->obtenerIngrediente($idIngrediente)->row()->id_local;
		
		$sql = "DELETE FROM ingredientes WHERE id_ingrediente = ?";

		$this->db->query($sql, array($idIngrediente));
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(18, $idLocal,  $idIngrediente);
	}

	function obtenerIngrediente($idIngrediente) {
		$sql = "SELECT * FROM ingredientes "
				. "WHERE id_ingrediente = ?";
		$result = $this->db->query($sql, array($idIngrediente));

		return $result;
	}

}
