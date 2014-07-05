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
    }

    function modificarCamarero($idCamarero, $nombreCamarero, $password
    , $controlTotal) {
        $sql = "UPDATE camareros 
            SET nombre = ?, password = ?, control_total = ? 
            WHERE id_camarero = ?";

        $this->db->query($sql, array($nombreCamarero, $password, $controlTotal
            , $idCamarero));
    }

    function obtenerCamarerosLocal($idLocal, $activo) {
        $sql = "SELECT id_camarero, id_local, nombre, fecha_alta, activo, password, control_total 
            FROM camareros 
            WHERE id_local = ?
            AND activo = ?";

        $result = $this->db->query($sql, array($idLocal, $activo));

        return $result;
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
        $sql = "UPDATE camareros 
            SET activo = ?
            WHERE id_camarero = ?";

        $this->db->query($sql, array(0, $idCamarero));
    }

    function obtenerDatosCamarero($idCamarero, $activo) {
        $sql = "SELECT id_camarero, id_local,nombre, fecha_alta, control_total 
            FROM camareros 
            WHERE id_camarero = ?
            AND activo = ?";

        $result = $this->db->query($sql, array($idCamarero, $activo));

        return $result;
    }

}

