<?php

class Valoraciones_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	function insertarValoracionLocal($idLocal, $idUsuario, $nota
			, $observaciones) {
		$sql = "INSERT INTO valoracion_local (id_local,id_usuario,nota
				,observaciones,fecha)
				VALUES (?,?,?,?,?)";

		$this->db->query($sql, array($idLocal, $idUsuario, $nota
				, $observaciones, date('Y-m-d H:i:s')));
	}

	function obtenerValoracionLocal($idLocal) {
		$sql = "SELECT vl.* , u.nick FROM valoracion_local vl, usuarios u
				WHERE u.id_usuario = vl.id_usuario
				AND id_local = ?
				ORDER BY fecha desc";

		return $this->db->query($sql, array($idLocal));
	}

	function insertarValoracionUsuario($idLocal, $idUsuario, $nota
			, $observaciones) {
		$sql = "INSERT INTO valoracion_usuario (id_local,id_usuario,nota
				,observaciones,fecha)
				VALUES (?,?,?,?,?)";

		$this->db->query($sql, array($idLocal, $idUsuario, $nota
				, $observaciones, date('Y-m-d H:i:s')));
	}

	function obtenerValoracionUsuario($idValoracionUsuario) {
		$sql = "SELECT v.*  FROM valoracion_usuario v
				WHERE id_valoracion_usuario = ?";

		return $this->db->query($sql, array($idValoracionUsuario));
	}

	function obtenerValoracionesUsuario($idUsuario,$numRegistros = 5){
		$sql = "SELECT v.*  FROM valoracion_usuario v
				WHERE id_usuario = ?
				ORDER BY id_valoracion_usuario desc
				LIMIT 0,?";

		$valoracionesData = $this->db->query($sql, array($idUsuario,$numRegistros))->result();
		$valoraciones = array();

		foreach ($valoracionesData as $valoracion){
			$valoraciones[] = ValoracionUsuario::withID($valoracion->id_valoracion_usuario);
		}

		return $valoraciones;
	}

}

