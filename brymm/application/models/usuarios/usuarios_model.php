<?php

require_once APPPATH . '/libraries/usuario/Direccion.php';

class Usuarios_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	function insertUsuario($datos, $password) {

		// Guardar usuario en BD
		$sql = "INSERT INTO usuarios VALUES('',?,?,?,?,?,?,?,?,?,?)";
		$this->db->query($sql, array($datos['nick'], $datos['nombre'], $datos['apellido'],
				$datos['email'], date('Y-m-d'), $password,
				$datos['localidad'], $datos['provincia'], $datos['codigoPostal'],
				$datos['telefono']
		));
		
		return $this->db->insert_id();
	}

	function modificarUsuario($datos,$idUsuario) {
		// Guardar usuario en BD
		$sql = "UPDATE usuarios SET nombre = ?, apellido= ? , email= ? ,
				localidad= ? , provincia= ? , cod_postal= ? , telefono =?
				WHERE id_usuario = ?";

		$this->db->query($sql, array( $datos['nombre'], $datos['apellido'],
				$datos['email'],
				$datos['localidad'], $datos['provincia'], $datos['codigoPostal'],
				$datos['telefono'],$idUsuario
		));
	}

	function comprobarUsuarioNick($nick) {

		// Consulta en la tabla usuarios con el nick
		$sql = "SELECT * FROM usuarios WHERE nick = ?";
		$result = $this->db->query($sql, array($nick));

		return $result;
	}

	function comprobarUsuarioLogin($nick, $password) {

		// Consulta en la tabla usuarios con el nick
		$sql = "SELECT * FROM usuarios WHERE nick = ? AND password = ?";
		$result = $this->db->query($sql, array($nick, $password));

		return $result;
	}

	public function insertDireccionEnvio
	($nombre, $idUsuario, $direccion, $poblacion, $provincia) {
		$sql = "INSERT INTO direccion_envio
				(nombre,id_usuario,direccion,poblacion,provincia)" .
				"VALUES (?,?,?,?,?)";

		$this->db->query($sql, array($nombre, $idUsuario, $direccion
				, $poblacion, $provincia));

		return $this->db->insert_id();
	}

	public function insertDireccionEnvioObject(Direccion $direccion) {
		$sql = "INSERT INTO direccion_envio
				(nombre,id_usuario,direccion,poblacion,provincia)" .
				"VALUES (?,?,?,?,?)";

		$this->db->query($sql, array($direccion->nombre, $direccion->idUsuario
				, $direccion->direccion, $direccion->poblacion, $direccion->provincia));

		return $this->db->insert_id();
	}

	function obtenerDirecciones($idUsuario, $activo = 1) {

		// Consulta en la tabla usuarios con el nick
		$sql = "SELECT * FROM direccion_envio WHERE id_usuario = ? AND activo = ?";
		$result = $this->db->query($sql, array($idUsuario, $activo));

		return $result;
	}

	function comprobarDireccion($idUsuario, $nombre, $activo = 1) {

		// Consulta en la tabla usuarios con el nick
		$sql = "SELECT * FROM direccion_envio WHERE id_usuario = ?  AND nombre = ?
				AND activo = ?";
		$result = $this->db->query($sql, array($idUsuario, $nombre, $activo));

		return $result;
	}

	function obtenerDireccionEnvio($idDireccion) {

		// Consulta en la tabla usuarios con el nick
		$sql = "SELECT * FROM direccion_envio WHERE id_direccion_envio = ?";
		$result = $this->db->query($sql, array($idDireccion));

		return $result;
	}

	function borrarDireccionEnvio($idDireccion) {
		$sql = "DELETE FROM direccion_envio
				WHERE id_direccion_envio = ?";

		$this->db->query($sql, array($idDireccion));
	}

	function anularDireccionEnvio($idDireccion, $activo = 0) {
		$sql = "UPDATE direccion_envio SET activo = ?
				WHERE id_direccion_envio = ?";

		$this->db->query($sql, array($activo, $idDireccion));
	}

	function modificarDireccionEnvio(Direccion $direccion) {
		$sql = "UPDATE direccion_envio SET nombre = ?, direccion = ?,
				poblacion = ?, provincia = ?
				WHERE id_direccion_envio = ?";

		$this->db->query($sql, array($direccion->nombre, $direccion->direccion,
				$direccion->poblacion, $direccion->provincia
				, $direccion->id_direccion_envio));
	}

	function comprobarDireccionPedidos($idDireccion) {
		$sql = "SELECT * FROM pedido  WHERE id_direccion_envio = ?";

		$result = $this->db->query($sql, array($idDireccion));

		return $result;
	}

	function obtenerUsuario($idUsuario) {

		// Consulta en la tabla usuarios con el nick
		$sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
		$result = $this->db->query($sql, array($idUsuario));

		return $result;
	}

}
