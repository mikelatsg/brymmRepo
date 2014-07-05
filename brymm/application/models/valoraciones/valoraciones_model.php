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

}

