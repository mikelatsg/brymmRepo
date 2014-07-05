<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of utilities
 *
 * @author mikelats
 */
class GestionFechas {

    function __construct() {
    }

    function ultimoDia($anho, $mes) {
        if (((fmod($anho, 4) == 0) and (fmod($anho, 100) != 0)) or (fmod($anho, 400) == 0)) {
            $dias_febrero = 29;
        } else {
            $dias_febrero = 28;
        }
        switch ($mes) {
            case 01: return 31;
                break;
            case 02: return $dias_febrero;
                break;
            case 03: return 31;
                break;
            case 04: return 30;
                break;
            case 05: return 31;
                break;
            case 06: return 30;
                break;
            case 07: return 31;
                break;
            case 08: return 31;
                break;
            case 8: return 31;
                break;
            case 09: return 30;
                break;
            case 9: return 30;
                break;
            case 10: return 31;
                break;
            case 11: return 30;
                break;
            case 12: return 31;
                break;
        }
    }

}

?>
