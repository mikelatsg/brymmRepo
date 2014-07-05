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
class ArticuloPedido {

    var $idArticulo;
    var $cantidad;
    var $CI;
    var $datosArticulo;

    public function __construct($idArticulo, $cantidad) {
        $this->idArticulo = $idArticulo;
        $this->cantidad = $cantidad;

// Set the super object to a local variable for use later
        $this->CI = & get_instance();

        $this->CI->load->model('articulos/articulos_model');

        $this->datosArticulo = $this->CI->articulos_model->obtenerArticuloLocal($this->idArticulo)->row();
    }

    public function getPrecio() {
        return $this->datosArticulo->precio * $this->cantidad;
    }
    
    public function getPrecioArticulo() {
        return $this->datosArticulo->precio;
    }

    public function getIdArticulo() {
        return $this->idArticulo;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getIdTipoArticulo() {
        return $this->datosArticulo->id_tipo_articulo;
    }

    public function isPersonalizado() {
        return false;
    }

}
