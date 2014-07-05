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

}
