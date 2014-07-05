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
class ArticuloPersonalizadoPedido {

    var $ingredientes = array();
    var $cantidad;
    var $CI;
    var $datosTipoArticulo;

    public function __construct($cantidad, $ingredientes, $idTipoArticuloLocal) {
        $this->ingredientes = $ingredientes;
        $this->cantidad = $cantidad;

        // Set the super object to a local variable for use later
        $this->CI = & get_instance();

        $this->CI->load->model('ingredientes/ingredientes_model');
        $this->CI->load->model('articulos/articulos_model');

        $this->datosTipoArticulo = $this->CI->articulos_model->obtenerTipoArticuloLocal($idTipoArticuloLocal)->row();
    }

    public function getPrecio() {
        $total = 0;
        foreach ($this->ingredientes as $idIngrediente) {
            $total += $this->CI->ingredientes_model->obtenerIngrediente
                            ($idIngrediente)->row()->precio;
        }

        $total += $this->datosTipoArticulo->precio;
        $total *= $this->cantidad;
        return $total;
    }
    
    public function getPrecioArticulo() {
        $total = 0;
        foreach ($this->ingredientes as $idIngrediente) {
            $total += $this->CI->ingredientes_model->obtenerIngrediente
                            ($idIngrediente)->row()->precio;
        }

        $total += $this->datosTipoArticulo->precio;
        return $total;
    }
    
    public function getIdArticulo() {
        return 0;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getIdTipoArticulo() {
        return $this->datosTipoArticulo->id_tipo_articulo;
    }

    public function isPersonalizado() {
        return true;
    }
    
    public function getIngredientes() {
        return $this->ingredientes;
    }

}
