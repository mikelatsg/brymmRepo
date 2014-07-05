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
class Direccion {

    public $id_direccion_envio;
    public $nombre;
    public $direccion;
    public $poblacion;
    public $provincia;
    public $idUsuario;
    private $CI;

    /* public function __construct($idDireccion) {
      $this->idDireccion = $idDireccion;

      // Set the super object to a local variable for use later
      $this->CI = & get_instance();

      $this->CI->load->model('usuarios/usuarios_model');

      $this->datosDireccion = $this->CI->usuarios_model->obtenerDireccionEnvio($this->idDireccion)->row();
      } */

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('usuarios/usuarios_model');
    }

    public static function withID($idDireccion) {
        $instance = new self();
        $instance->idDireccion = $idDireccion;
        $datosDireccion = $instance->CI->usuarios_model->obtenerDireccionEnvio($instance->idDireccion)->row();
        $instance->fill($datosDireccion->nombre, $datosDireccion - direccion
                , $datosDireccion->poblacion, $datosDireccion->provincia
                , $datosDireccion->idUsuario);
        return $instance;
    }

    public static function withData($nombre, $direccion, $poblacion, $provincia
    , $idUsuario, $idDireccion = 0) {
        $instance = new self();
        $instance->fill($nombre, $direccion, $poblacion, $provincia, $idUsuario
                , $idDireccion);
        return $instance;
    }

    protected function fill($nombre, $direccion, $poblacion, $provincia
    , $idUsuario, $idDireccion) {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->poblacion = $poblacion;
        $this->provincia = $provincia;
        $this->idUsuario = $idUsuario;
        $this->id_direccion_envio = $idDireccion;
    }

}
