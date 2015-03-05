<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
 * Funcion que comprueba si el local tiene todo lo necesario para poder
* dar el servicio de pedidos.
*/

function estadosReserva($idEstado) {

	$textoEstado = "";

	switch ($idEstado) {
		case "P":
			$textoEstado ="Pendiente";
			break;
		case "AL":
			$textoEstado ="Aceptada";
			break;
		case "AU":
			$textoEstado ="Anulada usuario";
			break;
		case "RL":
			$textoEstado ="Rechazada";
			break;
	}
	
	return $textoEstado;
}




