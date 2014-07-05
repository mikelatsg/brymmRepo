<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Shopping Cart Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Shopping Cart
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/cart.html
 */
class Reserva {

    public $id_reserva;
    public $id_local;
    public $numero_personas;
    public $fecha;
    public $hora_inicio;
    public $estado;
    public $idUsuario;
    public $motivo;
    public $observaciones;
    public $nombreLocal;
    public $tipoMenu;
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('reservas/Reservas_model');
    }

    public static function withID($idReserva) {
        $instance = new self();
        $instance->id_reserva = $idReserva;
        $datosReserva = $instance->CI->Reservas_model->obtenerDatosReservaUsuario($instance->id_reserva)->row();
        $instance->fill($datosReserva->id_local
                , $datosReserva->numero_personas
                , $datosReserva->fecha
                , $datosReserva->hora_inicio
                , $datosReserva->estado
                , $datosReserva->id_usuario
                , $datosReserva->motivo
                , $datosReserva->observaciones
                , $datosReserva->nombreLocal
                , $datosReserva->tipo_menu);
        return $instance;
    }

    protected function fill($idLocal, $numero_personas, $fecha, $hora_inicio
    , $estado, $idUsuario, $motivo, $observaciones, $nombreLocal, $tipoMenu) {
        $this->id_local = $idLocal;
        $this->numero_personas = $numero_personas;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->estado = $estado;
        $this->idUsuario = $idUsuario;
        $this->motivo = $motivo;
        $this->observaciones = $observaciones;
        $this->nombreLocal = $nombreLocal;
        $this->tipoMenu = $tipoMenu;
    }

}
