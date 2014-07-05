<?php

require_once APPPATH . '/libraries/horarios/diaSemana.php';

class Varios_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function obtenerDiasSemana() {

        $sql = "SELECT * FROM dias_semana ";
        $result = $this->db->query($sql);

        return $result;
    }
    
    function obtenerDiasSemanaObject() {
    
    	$sql = "SELECT * FROM dias_semana ";
    	$result = $this->db->query($sql)->result();
    
    	$diasSemana = array();
    	
    	foreach ($result as $row){
    		$diasSemana[] = DiaSemana::withID($row->id_dia);
    	}
    	
    	return $diasSemana;
    }
    
    function obtenerDiaSemana($idDia) {
    
    	$sql = "SELECT * FROM dias_semana 
    			WHERE id_dia = ?";
    	
    	$result = $this->db->query($sql,array($idDia));
    
    	return $result;
    }

}
